<?php
namespace app\common\model;

use \think\Db;
use \think\Model;
use \PDOException;

class Role extends Model
{
    protected $auto = ['status','create_time','update_time'];

    protected $type = [
        'id'          => 'integer',
        'status'      => 'integer',
    ];

    /**
     * 获取状态
     * @author chouchong
     */
    public function getStatusAttr($value, $data)
    {
        $status = [1 => '<span class="label label-success">启用</span>', 0 => '<span class="label label-warning">禁用</span>'];
        return $status[$value];
    }
    /**
     * 多对多关联权限表
     * @author chouchong
     */
    public function rule()
    {
        return $this->belongsToMany('Rule', 'role_rule', 'rule_id', 'role_id');
    }
    /**
     * 用户与角色关系
     * @author chouchong
     */
    public function user()
    {
        return $this->hasMany('User', 'role_id', 'id');
    }
    /**
     * 添加角色
     * @author chouchong
     */
    public function addRole(array $data)
    {
        return Db::transaction(function () use ($data) {

            $roleId = $this->save([
                'name'   => $data['name'],
                'status' => $data['status']
            ]);

            if ($roleId === false) {
                throw new PDOException($this->getError());
            }

            if (isset($data['rules']) && is_array($data['rules']) && !empty($data['rules'])) {
                $roleModel     = $this->find($roleId);
                $data['rules'] = array_map('intval', $data['rules']);
                //插入关联表
                $roleModel->rule()->saveAll($data['rules']);
            }

            return $roleId;
        });
    }
    /**
     * 角色修改
     * @author chouchong
     */
    public function editRole(array $data)
    {
        return Db::transaction(function () use ($data) {
            // 更新
            if ($this->save([
                'status' => $data['status'],
                'name'   => $data['name']
            ], ['id' => $data['id']]) === false) {
                throw new PDOException($this->getError());
            }
            //先删除关联数据
            db('role_rule')->where(['role_id' => $data['id']])->delete();

            if (isset($data['rules']) && is_array($data['rules']) && !empty($data['rules'])) {
                $data['rules'] = array_map('intval', $data['rules']);
                //插入关联表
                $this->rule()->saveAll($data['rules']);
            }

        });
    }
    /**
     * 删除角色
     * @author chouchong
     */
    public function deleteRole($id)
    {
        $roleModel = $this->find($id);
        if ($roleModel == false) {
            return false;
        }
        if ($roleModel->user()->count() > 0) {
            return false;
        }
        return Db::transaction(function () use ($roleModel) {
            // 先删除关联中间表的数据
            db('role_rule')->where('role_id', $roleModel->id)->delete();
            $roleModel->delete();
        });
    }

}
