<?php
namespace app\mobile\controller;

use \think\Controller;
use \think\Request;
use \think\Session;
use \think\Config;
use app\common\tools\YunPianSms;

class Base extends Controller
{

	public function __construct()
	{
		parent::__construct();
		Config::set('default_return_type','json');
		$this->assign('con', model('config')->getConfigs());
	}

	/**
	 * 会员登录
	 * @author chouchong
	 */
	public function login()
	{
		return view('member/login',['url'=>input('param.url','')]);
	}
	/**
	 * 会员注册
	 * @author chouchong
	 */
	public function register()
	{
		return view('member/register');
	}
	/**
	 * 会员忘记密码
	 * @author chouchong
	 */
	public function psd()
	{
		return view('member/psd');
	}
	/**
	 * 会员是否登录
	 * @author chouchong
	 */
	public function isLogin()
	{
		return session('userMember.id')?1:0;
	}
	/**
	 * 会员是否存在
	 * @author chouchong
	 */
	public function isCheckMember($url='')
	{
		if(session('userMember.id') == null){
			$this->redirect('/mobile/base/login?url='.$url);
		}
	}
}