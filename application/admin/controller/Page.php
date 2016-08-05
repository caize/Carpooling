<?php
namespace app\admin\controller;


class Page extends Base
{

	/**
	 * 单页面
	 * @author chouchong
	 */
	public function index()
	{
	  $pages = model('Page')->where('parent_id',0)->paginate(10);
      return view('',['pages'=>$pages]);
	}
    /**
	 * 添加文章
	 * @author chouchong
	 */
	public function add()
	{ 
	  if($this->request->isAjax()){
         if(validate('page')->check(input('post.'))){
            model('Page')->add();
            return ['status'=>1];
         }
         return ['status'=>-1,'msg'=>validate('page')->getError()];
	  }
	  $pages = model('Page')->where('parent_id',0)->select();
      return view('',['pages'=>$pages]);
	}
	/**
	 * 编辑文章
	 * @author chouchong
	 */
	public function edit()
	{
	  if($this->request->isAjax()){
         if(validate('page')->check(input('post.'))){ 
            model('Page')->edit();
            return ['status'=>1];
         }
         return ['status'=>-1,'msg'=>validate('page')->getError()];
	  }
	  $pageCate = model('Page')->where('parent_id',0)->select();
      return view('',['pageCate'=>$pageCate,'page'=>model('Page')->find(input('id'))]);
	}
	/**
	 * 删除文章
	 * @author chouchong
	 */
	public function delete()
	{
	  $page = model('Page')->find(input('id'));
	  if($page->parent()->count()>0){
         return ['status'=>-1,'msg'=>'文章下面有子文章'];
	  }else{
	     if(db('Page')->delete(input('id'))){
	         return ['status'=>1];
	     }
         return ['status'=>-1,'msg'=>'文章删除失败'];
	  }
	}

}
