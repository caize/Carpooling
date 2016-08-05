<?php
namespace app\common\model;

use \think\Model;
use \think\Session;

class Member extends Model
{
	protected $auto = ['update_time','create_time'];
	protected $insert = ['create_time','reg_ip','password'];

	// 获取IP
	protected function setRegIpAttr(){
		return get_client_ip();
	}
	// 密码加密
	protected function setPasswordAttr($value){
		return think_ucenter_md5($value, config('UC_AUTH_KEY'));
	}
	// 会员登录
	public function login($data){
		$map['phone'] = $data['phone'];
		$url = session('url')?session('url'):'';
		/* 获取用户数据 */
		$user = $this->get($map);
		if($user){
			/* 验证用户密码 */
			if(think_ucenter_md5($data['password'], config('UC_AUTH_KEY')) === $user->password){
				Session::set('userMember',$user);
				Session::delete('url');
				return ['status' => $user->id , 'msg' => $user,'url'=>$url]; //返回用户ID
			} else {
				return ['status' => -3, 'msg' => '密码错误'];
			}
		} else {
			return ['status' => -2, 'msg' => '用户不存在或被禁用'];
		}
	}
	public function edit($data){
		return $this->save(['name'=>$data['name'],'auth'=>str_replace('\\','/',DS . 'static'.DS.'member'.DS.date('Ymd').DS.BaseUpload($data['auth'],'member'))],['id'=>session('userMember')->id]);
	}
}