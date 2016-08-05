<?php
namespace app\mobile\controller;

class Order extends Base
{
	/**
   * 预约
   * @author chouchong
   */
  public function index()
	{
		$this->isCheckMember(getUrl());
      if($this->request->isAjax()){
          $a = model('price')->getPrice(input('post.id'));
      	for ($i=0; $i < count($a); $i++) {
      		$a[$i]['from'] = $a[$i]->areaFrom['name'];
      		$a[$i]['to'] = $a[$i]->areaTo['name'];
      		$a[$i]['toId'] = $a[$i]->areaTo['id'];
      	}
          return $a;
      }
		return view('',['area'=>json_encode(model('area')->getArea()),
			            'brand'=>json_encode(model('brand')->select())]);
	}
  /**
   * 订单提交
   * @author chouchong
   */
	public function order()
	{
		$this->isCheckMember();
      if($this->request->isAjax()){
        if(validate('order')->check(input('post.'))){
        	 $data=input('post.');
        	 $data['mid'] = session('userMember')->id;
        	 $data['orderNo'] = 'PC'.time();
        	 $data['create_time'] = time();
           $order = model('order')->insertGetId($data);
           if($order){
             return ['status'=>$order];
           }
           return ['status'=>0,'msg'=>'系统错误'];
        }
      return ['status'=>-1,'msg'=>validate('order')->getError()];
    }
	}
  /**
   * 取消预约
   * @author chouchong
   */
  public function delete(){
      $cid = db('orders')->delete(input('post.'));
      if ($cid === false) {
          return ['status'=>0,'msg'=>'系统错误'];
      }
      return ['status'=>$cid];
  }
  /**
   * 取消预约
   * @author chouchong
   */
  public function confirm(){
      $ok = model('Order')->save(['status'=>2],['id'=>input('post.id')]);
      if ($ok === false) {
          return ['status'=>0,'msg'=>'系统错误'];
      }
      return ['status'=>$ok];
  }
}