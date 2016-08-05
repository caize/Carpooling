<?php
namespace app\common\model;

use think\Model;
use think\Request;

class Page extends Model
{
    protected $autoWriteTimestamp = true;
    /**
     * 关联文章分类表
     * @author chouchong
     */
    public function parent()
    {
        return $this->hasMany('Page','parent_id');
    }
    /**
     * 编辑文章
     * @author chouchong
     */
    public function edit()
    {
       return $this->where('id',input('post.id'))->update(input('post.'));
    }
    /**
     * 添加文章
     * @author chouchong
     */
    public function add()
    {        
       return $this->insert(input('post.'));
    }
  
}
