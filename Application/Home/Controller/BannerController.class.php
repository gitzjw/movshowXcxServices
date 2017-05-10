<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2017/5/10
 * Time: 11:46
 */

namespace Home\Controller;

use Think\Controller;
use Think\Model;

class BannerController extends Controller
{
    /*
 * 首页后台登录界面
 */
    public function index()
    {
        $this->display();
    }
    public function onlog()
    {
        $N = "leepet9552@";
        $P = "pwdsa456@@55";
        $key = md5($N.$P."456413d1fsdgfdgd");
        $name = trim(I('post.username'));
        $password = trim(I('post.password'));
        $userKey = md5($name.$password."456413d1fsdgfdgd");
        if($key == $userKey){
            $sing = md5('dasd'.time());
            COOKIE('sing',$sing);
            session('sing',$sing);
            $this->saveBanner($sing);
        }else{
            $this->assign('ts',"登录失败！");
            $this->display("Banner:index");
        }


    }
    /*
   * banner图幻灯界面
   */
    public function saveBanner($sing){

        if(empty($sing) ){
            $this->assign('ts',"登录失败！");
            $this->display("Banner:index");
        }
        $key = cookie('sing');
        if(empty($key)){
            $this->assign('ts',"登录失败！");
            $this->display("Banner:index");
        }
        if($sing != $key){

            $this->assign('ts',"登录失败！");
            $this->display("Banner:index");
        }
        $list = M('banner')->limit(0,4)->order('id desc')->select();
        $this->assign('ts',"xsdsaff");
        $this->assign('key',"6sa1df32s1f5");
        $this->assign('sing',$sing);
        $this->assign('list',$list);
        $this->display("Banner:banner");


    }

    /*
     * 修改数据图片
     */

    public function doSaveBanner()
    {
        $id = I('post.type');
        $url = I('post.url');
        $tid = I('post.tid');
        $sing = I('post.sing');
        if(empty($sing) ){
            $this->assign('ts',"状态异常请重新登录！");
            $this->display("Banner:index");
        }
        $key = cookie('sing');
        if(empty($key)){
            $this->assign('ts',"状态异常请重新登录！");
            $this->display("Banner:index");
        }
        if($sing != $key){
            $this->assign('ts',"状态异常请重新登录！");
            $this->display("Banner:index");
        }
        $status = M('banner')->where(array('id'=>$id))->save(array('url'=>$url,'tid'=>$tid));
        //echo M('banner')->getLastSql();die;
        if($status){
            $sing = md5('dasd'.time());
            COOKIE('sing',$sing);
            session('sing',$sing);
            $this->saveBanner($sing);
        }else{
            $this->assign('ts',"修改失败！");
            $this->display("Banner:index");
        }
    }
}
?>