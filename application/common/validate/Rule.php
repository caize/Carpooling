<?php
namespace app\common\validate;

use \think\Validate;
use \think\Db;

class Rule extends Validate
{
    protected $rule = [
        'title'=>'require|unique:rule',
    ];

    protected $message = [
        'title.require'=>'名称不能为空',
        'title.unique'=>'名称已经存在了',
    ];
}
