<?php
namespace app\admin\controller;

use \think\Request;
use \think\Session;
use \think\Config;

class Common
{
	/**
	 * 用户登录
	 * @author chouchong
	 */
	public function login()
	{
		Config::set('default_return_type','json');
		$request = Request::instance();
		if($request->isPOST())
		{
			$user = array(
		 		'username' => input('post.usernamelogin'),
		 		'password' => input('post.password'),
		 		);
		 	$validate = validate('User');
			$result = $validate->scene('login')->check($user);
			if ($result !== true) {
	            return ['status' => -1, 'msg' => $validate->getError()];
	        }
	        $data = model('User')->login($user);
			return $data;
		}else{
			return view('auth/login');
		}
	}
	/**
	 * 用户提出
	 * @author chouchong
	 */
	public function logout()
	{
		Config::set('default_return_type','json');
		Session::delete('userInfo');
		return ['status' => 1];
	}
}
?>