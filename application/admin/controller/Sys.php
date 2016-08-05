<?php
namespace app\admin\controller;

class Sys extends Base
{

	/**
	 * 系统商城信息
	 * @author chouchong
	 */
	public function index()
	{
		if($this->request->isPOST()){
			if(model('Config')->editConfigs(input('post.'))>0){
				return ['status' => 1];
			}
			return ['status' => -1, 'msg' => '操作失败'];
		}
		return view('',['configs'=>model('Config')->getList()]);
	}
}
