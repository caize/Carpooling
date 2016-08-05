<?php
namespace app\common\model;

use \think\Model;

class Config extends Model
{
    protected $auto = ['create_time','update_time'];

    /**
     * 获取系统信息
     * @author chouchong
     */
    public function getConfigs()
    {
        $rs = $this->select();
        $configs = [];
        if(count($rs)>0){
            foreach ($rs as $key=>$v){
                $configs[$v['code']] = $v['content'];
            }
        }
        unset($rs);
        return $configs;
    }
    /**
     * 获取系统信息
     * @author chouchong
     */
    public function getList()
    {
        $rs = $this->select();
        $configs = [];
        if(count($rs)>0){
            foreach ($rs as $key=>$v){
                $configs[] = $v;
            }
        }
        unset($rs);
        return $configs;
    }
    /**
     * 修改系统信息
     * @author chouchong
     */
    public function editConfigs($data)
    {
        $rs = $this->select();
        if(count($rs)>0){
            foreach ($rs as $key=>$v){
                $result = db('Config')->where('code',$v['code'])->setField('content',$data[$v['code']]);
                if(false === $result){
                    $rd['status']= -1;
                }
            }
            $rd['status'] = 1;
        }
        return $rd;
    }
}
