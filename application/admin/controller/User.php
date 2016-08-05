<?php
namespace app\admin\controller;

class User extends Base
{
	/**
	 * 管理员列表
	 * @author chouchong
	 */
	public function index()
	{
		$lists = model('User')->paginate(10);
		return view('',['lists'=>$lists]);
	}
	/**
	 * 管理员列表
	 * @author chouchong
	 */
	public function add()
	{
		if($this->request->isPOST())
		{
			$result = validate('User')->scene('add')->check(input('post.'));
			if ($result !== true) {
	            return ['status' => -1, 'msg' => validate('User')->getError()];
	        }
	        $data = model('User')->authSave(input('post.'));
			return $data;
		}else{
			$lists = model('Role')->select();
			return view('',['lists'=>$lists]);
		}
	}
	/**
	 * 管理员删除
	 * @author chouchong
	 */
	public function delete()
	{
		if(model('User')->where('id',input('post.id'))->delete()){
			return ['status' => 1, 'msg' => '删除成功'];
		}
		return ['status' => -1, 'msg' => '删除失败'];
	}
}
?>