<?php
namespace app\admin\controller;

class Rule extends Base
{

	/**
	 * 权限列表
	 * @author chouchong
	 */
	public function index()
	{
        $lists = model('Rule')->where('parent_id', 0)->order('sort', 'asc')->paginate(3);
		return view('',['lists'=>$lists]);
	}
	/**
	 * 权限节点添加
	 * @author chouchong
	 */
	public function add()
	{
		$ruleModel = model('Rule');
		if($this->request->isPOST()){
			if(input('post.id')>0){
				if ($ruleModel->save(input('post.'),['id'=>input('post.id')]) != false) {
	                return ['status' => 1];
	            }
			}else{
            	$ruleId = $ruleModel->validate(true)->save(input('post.'));
				if ($ruleId > 0) {
					return ['status' => $ruleId];
	            }
            }
            return ['status' => -1, 'msg' => $ruleModel->getError()];
		}
		return view('',['ruleRows'=>$ruleModel->getMenusByParentId(0)]);
	}
	/**
	 * 权限节点修改
	 * @author chouchong
	 */
	public function edit()
	{
		$ruleModel = model('Rule');
        return view('',[
        	'rule'=>$ruleModel->find(input('param.id')),
        	'ruleRows'=>$ruleModel->getMenusByParentId(0)]);
	}
	/**
	 * 权限节点删除
	 * @author chouchong
	 */
	public function delete()
	{

        if (model('Rule')->deleteRule(input('post.id')) === false) {
            return ['status' => -1, 'msg' => '删除失败'];
		}
		return ['status' => 1, 'msg' => '删除成功'];
	}
}
