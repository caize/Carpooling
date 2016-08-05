<?php
namespace app\common\model;

use think\Model;
use think\Request;

class Rule extends Model
{
    protected $autoWriteTimestamp = false;

    // 定义自动完成的属性
    protected $auto = ['sort', 'islink'];

    /**
     * [user description]
     * @author chouchong
     */
    public function parent()
    {
        return $this->hasMany('Rule', 'parent_id', 'id');
    }

    /**
     * 获取状态
     * @author chouchong
     */
    public function getIslinkAttr($islink, $data)
    {
        $islinks = [0 => '<span class="label label-success">操作</span>', 1 => '<span class="label label-info">菜单</span>'];
        return $islinks[$islink];
    }

    /**
     * 获取图标
     * @author  chouchong
     */
    public function getIconAttr($islink, $data)
    {
        return ($islink === '') ? '' : '<i class="' . $islink . '"></i>';
    }
    /**
     * 获取排序
     * @author  chouchong
     */
    public function getSortAttr($sort, $data)
    {
        return '<span>' . $sort . '</span>';
    }
    /**
     * 获取用户组所有的权限
     * @author  chouchong
     */
    public function getRulesByRoleId($roleId)
    {
        return db('role_rule')
            ->field('r.id,r.name,r.title')
            ->alias('rr')
            ->join('rule as r', 'rr.rule_id=r.id')
            ->where('rr.role_id', $roleId)
            ->order('r.parent_id ASC , r.sort ASC')
            ->select();
    }

    /**
     * 检查权限
     * @author  chouchong
     */
    public function checkRule($roleId = 0, $name = '')
    {
        // 没有传role_id 获取登陆用户的用户组
        if ($roleId == 0) {
            if (session('userInfo')) {
                $roleId = session("userInfo.role_id");
            }
        }
        // 没有传auth地址获取当前
        if ($name == '') {
            $request = Request::instance();
            $name    = $request->controller() . '/' . $request->action();
            // $name = CONTROLLER_NAME . "/" . ACTION_NAME;
        }

        $rule = db('role_rule')
            ->alias('rr')
            ->join('rule as r', 'rr.rule_id=r.id')
            ->where('rr.role_id', $roleId)
            ->where('r.name', $name)
            ->count('r.id');

        if ($rule > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 通过用户组获取菜单
     * @author chouchong
     */
    public function getMenusByRoleId($roleId)
    {
        $ruleRows = db('role_rule')
            ->field('r.id, r.parent_id,r.name,r.title,r.icon')
            ->alias('rr')
            ->join('rule as r', 'rr.rule_id=r.id')
            ->where('rr.role_id', $roleId)
            ->where('r.islink', 1)
            ->order('r.parent_id ASC , r.sort ASC')
            ->select();

        if (empty($ruleRows)) {
            return [];
        }

        $ruleData = [];
        foreach ($ruleRows as $key => $ruleRow) {
            if ($ruleRow['parent_id'] == 0) {
                if (isset($ruleData[$ruleRow['id']])) {
                    $ruleData[$ruleRow['id']] = array_merge($ruleData[$ruleRow['id']], $ruleRow);
                } else {
                    $ruleData[$ruleRow['id']] = $ruleRow;
                }
            } else {
                $ruleData[$ruleRow['parent_id']]['sub'][$ruleRow['id']] = $ruleRow;
            }
        }

        return $ruleData;
    }

    /**
     * 获取权限
     * @author  chouchong
     */
    public function getAllRule()
    {
        $rules = $this->getMenusByParentId(0, false);

        foreach ($rules as $key => $rule) {
            $rules[$key]['sub'] = $this->getMenusByParentId($rule['id'], false);
        }

        return $rules;
    }

    /**
     * 通过parent_id获取菜单
     * @author  chouchong
     */
    public function getMenusByParentId($parentId = 0, $islink = true)
    {
        if ($islink) {
            $this->where('islink', 1);
        }
        return $this
            ->field('id,title')
            ->where('parent_id', $parentId)
            ->order('parent_id ASC , sort ASC')
            ->select();
    }

    /**
     * 删除权限节点
     * @author  chouchong
     */
    public function deleteRule($id)
    {
        $ruleModel = $this->find($id);
        if ($ruleModel == false) {
            return false;
        }
        if ($ruleModel->parent()->count() > 0) {
            return false;
        }
        return Db::transaction(function () use ($ruleModel) {
            // 先删除关联中间表的数据
            db('role_rule')->where('rule_id', $ruleModel->id)->delete();
            $ruleModel->delete();
        });
    }
}
