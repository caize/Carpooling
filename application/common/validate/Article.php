<?php
namespace app\common\validate;

use \think\Validate;

class Article extends Validate
{
    protected $rule = [
        'category_id'=>'require',
        'title'=>'require',
    ];

    protected $message = [
        'category_id.require'=>'文章分类不能为空',
        'title.require'=>'文章标题不能为空',

    ];
}
