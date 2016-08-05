<?php
namespace app\common\model;

use \think\Model;
use \think\Session;

class User extends Model
{
   	// 定义需要自动写入时间戳格式的字段
    protected $autoTimeField = ['create_time','update_time'];
    // 以上定义需要配合insert、update或者auto才能生效
	protected $auto = ['update_time','status'];
	protected $insert = ['create_time','reg_ip','password'];

	/**
	 * 管理员与角色关系
	 */
	public function role()
    {
        return $this->belongsTo('Role','role_id');
    }

	// 获取IP
	protected function setRegIpAttr(){
		return get_client_ip();
	}
	// 状态
	protected function setStatusAttr(){
		return true;
	}
	// 密码加密
	protected function setPasswordAttr($value){
		return think_ucenter_md5($value, config('UC_AUTH_KEY'));
	}

	/**
	 * 根据配置指定用户状态
	 * @return integer 用户状态
	 */
	protected function getStatus(){
		return true; //TODO: 暂不限制，下一个版本完善
	}
	/**
	 * 用户登录
	 * @param  string $password 用户密码
	 * @param  string $email    用户邮箱
	 * @return integer          注册成功-用户信息，注册失败-错误编号
	 */
	public function authSave($user){
		/* 添加用户 */
		if($uid = $this->save($user)){
			return ['status' => $uid];
		} else {
			return ['status' => -2, 'msg' => '注册失败']; //错误
		}
	}
	/**
	 * 用户登录认证
	 * @param  string  $username 用户名
	 * @param  string  $password 用户密码
	 * @return integer           登录成功-用户ID，登录失败-错误编号
	 */
	public function login($data){
		$map['username'] = $data['username'];
		/* 获取用户数据 */
		$user = $this->get($map);
		if($user){
			/* 验证用户密码 */
			if(think_ucenter_md5($data['password'], config('UC_AUTH_KEY')) === $user->password){
				$this->updateLogin($user->id); //更新用户登录信息
				Session::set('userInfo',$user);
				return ['status' => $user->id , 'msg' => $user]; //返回用户ID
			} else {
				return ['status' => -3, 'msg' => '密码错误'];
			}
		} else {
			return ['status' => -2, 'msg' => '用户不存在或被禁用'];
		}
	}
	/**
	 * 更新用户登录信息
	 * @param  integer $uid 用户ID
	 */
	protected function updateLogin($uid){
		$data = array(
			'id'              => $uid,
			'last_login_time' => time(),
			'last_login_ip'   => get_client_ip(1),
		);
		$this->update($data);
	}
}