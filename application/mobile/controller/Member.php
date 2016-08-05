<?php
namespace app\mobile\controller;

use \think\Session;

class Member extends Base
{
	public function index()
	{
		$this->isCheckMember();
		return view('index',['user'=>model('member')->find(session('userMember')['id'])]);
	}
	/**
	 * 会员注册
	 * @author chouchong
	 */
	public function add()
	{
		if(validate('Member')->scene('add')->check(input('post.')) == false){
	    	return ['status'=> -1,'msg'=>validate('Member')->getError()];
	    }
	    if(model('Member')->save(['phone'=>input('post.phone'),'password'=>input('post.password')])){
	    	return ['status'=> 1,'msg'=>'注册成功'];
	    }
	    return ['status'=> -2,'msg'=>'注册失败'];
	}
	/**
	 * 会员登录
	 * @author chouchong
	 */
	public function login()
	{
		if(validate('Member')->scene('login')->check(input('post.')) == false){
	    	return ['status'=> -1,'msg'=>validate('Member')->getError()];
	    }
	    return model('Member')->login(input('post.'));
	}
	/**
	 * 会员退出
	 * @author chouchong
	 */
	public function lgout()
	{
		Session::delete('userMember');
		$this->redirect(url('/mobile/base/login'));
	}
	/**
	 * 忘记密码
	 * @author chouchong
	 */
	public function psd()
	{
		if(validate('Member')->scene('psd')->check(input('post.')) == false){
	    	return ['status'=> -1,'msg'=>validate('Member')->getError()];
	    }
	    if(model('Member')->save(['password'=>input('post.password')],['phone'=>input('post.phone')])){
	    	return ['status'=> 1,'msg'=>'修改成功'];
	    }
	    return ['status'=> -2,'msg'=>'修改失败'];
	}
	/**
	 * 会员设置
	 * @author chouchong
	 */
	public function setting()
	{
		$this->isCheckMember();
		if($this->request->isPost()){
			if(validate('Member')->scene('auth')->check(input('post.')) == false){
	    		return ['status'=> -1,'msg'=>validate('Member')->getError()];
	    	}
	    	if(model('Member')->edit(input('post.'))){
	    		return ['status'=> 1,'msg'=>'修改成功'];
	    	}
	    	return ['status'=> -2,'msg'=>'修改失败'];
		}
		return view('',['user'=>model('member')->find(session('userMember')['id'])]);
	}
	/**
	 * 我的发布
	 * @author chouchong
	 */
	public function publish()
	{
		$this->isCheckMember();
		if($this->request->isPost()){
	    	return model('car')->getList(input('post.'));
		}
		return view();
	}
	/**
	 * 我的预约
	 * @author chouchong
	 */
	public function book()
	{
		$this->isCheckMember();
		if($this->request->isPost()){
	    	return model('order')->getList(input('post.'));
		}
		return view();
	}
}