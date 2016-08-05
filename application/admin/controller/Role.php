<?php
namespace app\admin\controller;

use \think\Loader;
use \think\Url;

class Role extends Base
{

	/**
	 * 角色列表
	 * @author chouchong
	 */
	public function index()
	{
		$lists = model('Role')->paginate(5);
		return view('',['lists'=>$lists]);
	}
	/**
	 * 角色添加
	 * @author chouchong
	 */
	public function add()
	{
		if($this->request->isPOST()){
			$data = input('post.');
            if (validate('Role')->scene('add')->check($data) === false) {
                return ['status'=>-1,'msg'=>validate('Role')->getError()];
            }
            // 编辑时的添加
            if(input('post.id')>0){
            	$roleRow = model('Role')->find(input('post.id'));
            	if ($roleRow->editRole($data) !== false) {
            		return ['status'=>1];
            	}
            // 直接添加
            }else{
	            if (model('Role')->addRole($data) !== false) {
	                return ['status'=>1];
	            }
            }
            return ['status'=>-2,model('Role')->getError()];
		}
		$ruleModel = model('Rule');
        $lists = $ruleModel->where('parent_id', 0)->order('sort', 'asc')->select();
		return view('',['lists'=>$lists]);
	}
	/**
	 * 编辑添加
	 * @author chouchong
	 */
	public function edit()
	{
		return view('',[
			'role'=>model('Role')->find(input('param.id')),
			'rule'=>implode(',',array_column(model('Rule')->getRulesByRoleId(input('param.id')), 'id')),
			'lists'=>model('Rule')->where('parent_id', 0)->order('sort', 'asc')->select()
			]);
	}
	/**
	 * 角色删除
	 * @author chouchong
	 */
	public function delete()
	{
		if(model('Role')->deleteRole(input('post.id')) === false){
			return ['status' => -1, 'msg' => '删除失败'];
		}
		return ['status' => 1, 'msg' => '删除成功'];
	}
}
