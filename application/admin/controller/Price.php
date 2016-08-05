<?php
namespace app\admin\controller;

class Price extends Base
{

	/**
	 * 行程价格
	 * @author chouchong
	 */
	public function index()
	{
      return view('',['price'=>model('Price')->paginate()]);
	}
	/**
	 * 添加行程
	 * @author chouchong
	 */
	public function add()
	{
		if($this->request->isAjax()){
           if(validate('Price')->check(input('post.'))){
           	   if(model('Price')->add(input('post.'))){
           	   	  return ['status'=>1];
           	   }
               return ['status'=>-1,'msg'=>'添加失败'];
           }
           return ['status'=>-1,'msg'=>validate('Price')->getError()];
		}
	    return view('',['city'=>model('Area')->getArea()]);
	}
	/**
	 * 编辑行程
	 * @author chouchong
	 */
	public function edit()
	{
		if($this->request->isAjax()){
            if(validate('Price')->check(input('post.'))){
            	  if(model('Price')->edit(input('post.'))){
           	   	  return ['status'=>1];
           	   }
               return ['status'=>-1,'msg'=>'添加失败'];
            }
            return ['status'=>-1,'msg'=>validate('Price')->getError()];
		}
	    return view('',['city'=>model('Area')->getArea(),'price'=>model('price')->find(input('id'))]);
	}
	/**
	 * 删除行程
	 * @author chouchong
	 */
	public function delete()
	{
		if(empty(input('post.id'))){
            return;
		}
        else{
        	if(model('price')->del(input('post.id'))){
        	   return ['status'=>1,'msg'=>'删除成功'];	
        	}else{
        	   return ['status'=>-1,'msg'=>'操作失败，请重试！'];
        	}
        }
	}
}
