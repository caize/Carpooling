<?php

namespace app\common\validate;

use \think\Validate;
use \think\Session;

class Member extends Validate
{
    protected $rule = [
        'name'   =>  'require|min:3',
        'phone'  =>  'require|unique:member,phone|checkPhone:',
        'password'  =>  'require|length:6,12',
        'code' => 'require|length:4,4|captcha',
        'codesms' => 'require|length:6,6|checkSms:',
        'auth'=>'require',
    ];

    protected $message = [
        'name.require' => '名称必须填写',
        'name.min'     => '名称至少3个字符',
        'password.require' => '密码必须填写',
        'password.length'  => '密码必须大于6个字符小于12个字符',
        'phone.require' => '号码不能为空',
        'phone.unique' => '号码已经被注册',
        'phone.checkPhone' =>'号码错误',
        'code.require' => '验证码必须填写',
        'code.length' => '验证码必须4个字符',
        'codesms.require' => '短信验证码必须填写',
        'codesms.length' => '短信验证码必须6个字符',
        'code.captcha' => '验证码错误',
        'codesms.checkSms' => '短信验证码错误',
        'auth.require' => '上传头像不能为空',
    ];

    protected $scene = [
        'sms'  =>  ['phone'=>'require|checkPhone:'],
        'login'=>  ['phone'=>'require|checkPhone:','password'],
        'add'  =>  ['phone','password','code','codesms'],
        'psd'  =>  ['phone'=>'require|checkPhone:','password','code','codesms'],
        'auth' =>  ['name','auth'],
    ];
    // 手机号码验证
    protected function checkPhone($value)
    {
        $pattern = "/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{9}$|147[0-9]{8}$/";
        return preg_match($pattern,$value)?true:false;
    }
    // 短信验证码验证
    protected function checkSms($value){
       return Session::get('smscode')==$value?true:false;
    }
}
?>