<?php
namespace app\common\validate;

use \think\Validate;

class Brand extends Validate
{
    protected $rule = [
        'name'=>'require|unique:car_brand',
    ];

    protected $message = [
        'name.require'=>'品牌不能为空',
        'name.unique'=>'品牌重复',
    ];
    protected $scene = [
       'edit'=>['name'=>'require']
    ];
}
