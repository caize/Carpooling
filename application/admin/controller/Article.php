<?php
namespace app\admin\controller;


class Article extends Base
{

	/**
	 * 文章列表
	 * @author chouchong
	 */
	public function index()
	{
	  $articles = model('Article')->paginate(10);
      return view('',['articles'=>$articles]);
	}
	/**
	 * 添加文章
	 * @author chouchong
	 */
	public function add()
	{
		if($this->request->isAjax()){
			if(validate('Article')->check(input('post.'))){
			 	if(model('Article')->add(input('post.')) != false){
			 		return ['status' => 1];
			 	}
			}
		 	return ['status' => -1, 'msg'=>validate('Article')->getError()];
		}
	    return view('',['cates'=>model('ArticleCate')->getCate()]);
	}
	/**
	 * 编辑文章
	 * @author chouchong
	 */
	public function edit()
	{
	    $cates = model('ArticleCate')->getCate();
	    return view('',['cates'=>model('ArticleCate')->getCate(),'article'=>model('Article')->find(input('param.id'))]);
	}
	/**
	 * 删除文章
	 * @author chouchong
	 */
	public function delete(){
        $id = db('Article')->delete(input('post.id'));
        if($id){
        	return ['status' => $id];
        }
        return ['status' => $id,'msg'=>'文章删除失败'];
	}
}
