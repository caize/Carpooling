<?php
namespace app\admin\controller;

class ArticleCate extends Base
{
	/**
	 * 调转到文章分类
	 * @author chouchong
	 */
	public function index()
	{
      $cates = model('ArticleCate')->where('parent_id',0)->paginate(5);
      return view('',['cates'=>$cates]);
	}
    /**
	 * 调转到添加分类
	 * @author chouchong
	 */
	public function add()
	{
      return view('',['cates'=>model('ArticleCate')->getCate()]);
	}
	/**
	 * 添加分类
	 * @author chouchong
	 */
	public function addSave()
	{
	  if($this->request->isAjax()){
	  	if(validate('ArticleCate')->check(input('post.'))){
          $cate = model('ArticleCate')->insert(input('post.'));
          return ['status' => $cate];
	  	}
          return ['status' => -1, 'msg' => validate('ArticleCate')->getError()];

	  }else{
          return ['status' => -1];
	  }
	}
	/**
	 * 调转到编辑分类
	 * @author chouchong
	 */
	public function edit()
	{
      return view('',['cates'=>$this->getCate(),'ArticleCate'=>model('ArticleCate')->find(input('id'))]);
	}
	/**
	 * 编辑分类
	 * @author chouchong
	 */
	public function editSave()
	{
		// return input('post.');
      if($this->request->isAjax()){
	  	if(validate('ArticleCate')->scene('edit')->check(input('post.'))){
          $cate = model('ArticleCate')->where('id',input('id'))->update(input('post.'));
          return ['status' => $cate];
	  	}
          return ['status' => -1, 'msg' => validate('ArticleCate')->getError()];

	  }else{
          return ['status' => -1];
	  }
	}
	/**
	 * 删除分类
	 * @author chouchong
	 */
	public function delete()
	{
	   $cate = model('ArticleCate')->find(input('post.id'));
	   if($cate){
		   if($cate->parent()->count()>0){
	          return ['status' => -1, 'msg' =>'该分类下有子分类'];
		   }else{
		   	if($cate->article()->count()>0){
              return ['status' => -1, 'msg' =>'该分类下有文章'];
		   	}else{
              model('ArticleCate')->where('id',input('post.id'))->delete();
              return ['status' => 1, 'msg' =>'删除成功'];
		   	}
		   }
	   }
	}

}
