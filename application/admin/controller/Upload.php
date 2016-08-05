<?php
namespace app\admin\controller;

use app\common\tools\Strings;

class Upload extends Base
{
    /**
     * dan图片上传界面
     * @author chouchong
     */
    public function index($id = 'compete')
    {
        if ($this->request->isPost()) {
            $optput = ['error' => '上传失败'];

            $file = request()->file('imgFile');
            $info = $file->move(STATIC_PATH . DS . $id . DS);
            if ($info) {
                $optput['file']  = Strings::fileWebLink($info->getLinkTarget());
                $optput['error'] = null;
            } else {
                $optput['error'] = $file->getError();
            }
            $optput['data'] = count($file);
            return $optput;
        }
        return view('',['id'=>$id]);
    }
    /**
     * dan图片上传界面
     * @author chouchong
     */
    public function upload($id = 'editor')
    {
        if ($this->request->isPost()) {
            $optput = ['error' => '上传失败'];

            $files = request()->file('imgFile');
            // $files = request()->file('image');
            foreach($files as $file){
                $info = $file->move(STATIC_PATH . DS . $id . DS);
                if ($info) {
                    $optput[]['file']  = Strings::fileWebLink($info->getLinkTarget());
                    $optput['error'] = null;
                } else {
                    $optput['error'] = $file->getError();
                }
                $optput['data'] = count($file);
            }
            return $optput;
        }
        return view('',['id'=>$id]);
    }
    public function delete()
    {
        return true;
    }
}
