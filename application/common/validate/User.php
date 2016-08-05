<?php

namespace app\common\validate;

use \think\Validate;

class User extends Validate
{
    protected $rule = [
        'username'  =>  'require|max:25',
        'email'     =>  'email',
        'password'  =>  'require|length:4,25',
        'username_login' => 'require|username',
        'role_id' => 'require',
    ];

    protected $message = [
        'username.require' => '名称必须填写',
        'username.unique'  => '用户名已存在',
        'username.max'     => '名称最多不能超过25个字符',
        'password.require' => '密码必须填写',
        'password.length'  => '密码必须大于4个字符小于25个字符',
        'email'            => '邮箱格式错误',
        'role_id.require' => '管理员角色必须选择',
    ];

    protected $scene = [
        'add'    =>  ['username'=>'require|unique:user,username|max:25','password','role_id'],
        'login'  =>  ['username','password'],
    ];
}
?>