<?php
namespace app\common\validate;

use \think\Validate;

class Order extends Validate
{
    protected $rule = [
        'phone'=>'require|checkPhone:',
        'name'=>'require',
        'from'=>'require',
        'to'=>'require',
        'go_time'=>'require',
    ];

    protected $message = [
        'phone.require'=>'联系电话不能为空',
        'phone.checkPhone'=>'联系电话不正确',
        'name.require'=>'约车人姓名不能为空',
        'from.require'=>'出发地不能为空',
        'to.require'=>'目的的不能为空',
        'go_time.require'=>'出发时间不能为空',
    ];
    protected $scene = [

    ];
     //手机号正则验证
    public function checkPhone($value){
        if(preg_match("/^1[34578]\d{9}$/",$value)){
          return true;
        }
        return false;
    }
}
