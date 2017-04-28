<?php

/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2017/4/14
 * Time: 15:04
 */
namespace Home\Model;
use Think\Model;
class testModel  extends Model
{
    protected $tableName = 'member';
    public function test(){
        return "9999999999";
        //echo M('forum_forum')->getLastSql();  打印sql
    }
}