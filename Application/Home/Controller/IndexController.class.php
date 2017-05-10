<?php
namespace Home\Controller;

use Think\Controller;
use Think\Model;

class IndexController extends Controller
{

    /*
     * 首页后台登录界面
     */
    public function index()
    {
        $this->display('Banner:index');
    }

    #【以下小程序接口】#
    /*
     * banner图幻灯
     */
    public function bannerUrls()
    {
       $list = M('banner')->limit(0,4)->order('id desc')->select();
        printJson(true,200,"成功",$list);
    }

    /*
     * 圈子列表[写死]
     */
    public function forumList()
    {

        $oobjet = new \Home\Model\forumModel();
        $data = $oobjet->index();
        if (empty($data)) {
            printJson(false, 404, '失败', $data);
        } else {
            printJson(true, 200, '成功', $data);
        }
    }

    /*
     * 发帖圈子列表[写死]
     */
    public function forumPostList()
    {

        $oobjet = new \Home\Model\forumModel();
        $data = $oobjet->forum();
        if (empty($data)) {
            printJson(false, 404, '失败', $data);
        } else {
            printJson(true, 200, '成功', $data);
        }
    }

    /**
     * @name  首页精华贴子列表
     * @param pn 当前页 default 0 ［可选］
     *
     */
    public function digestList()
    {
        $pn = intval(I('get.pn', 0));
        $page = $pn * 10;
        $pageEnd = ($pn + 1) * 10;
        $obj = M('forum_thread');
        $where['displayorder'] = array('GT', -1);
        $where['digest'] = 1;
        $data = $obj->where($where)->order('lastpost desc')->limit($page, $pageEnd)->select();
        //echo M('forum_thread')->getLastSql();die;
        $objet = new \Home\Model\forumModel();
        foreach ($data as $k => $v) {
            $data[$k]['userface'] = "http://uc.movshow.com/avatar.php?uid=" . $v['authorid'] . "&size=middle";
            $data[$k]['dateline'] = date("Y-m-d H:i", $v['dateline']);
            $data[$k]['lastpost'] = date("Y-m-d H:i", $v['lastpost']);
            if ($v['attachment'] == 2) {
                $prcs = $objet->getAttachment($v['tid'], $v['authorid']);
                $data[$k]['pics'] = $prcs;
            }
        }
        if (empty($data)) {
            printJson(false, 404, '失败', $data);
        } else {
            printJson(true, 200, '成功', $data);
        }
    }

    /**
     * @name  圈 -贴子列表
     * @param fid 圈子ID ［必选］
     * @param pn 当前页[默认每页10条]［可选］
     */
    public function postList()
    {
        $fidList = array(21, 4, 5, 119, 18, 231, 154, 4, 20, 16, 14, 25, 116, 60, 29, 111, 147, 155, 146, 56, 34, 24, 11);
        $fid = intval(I('get.fid', 0));
        $pn = intval(I('get.pn', 0));
        if (!in_array($fid, $fidList)) {
            printJson(false, 404, "参数不合法");
        }
        $page = $pn * 10;
        $pageSize = ($pn + 1) * 10;
        $obj = M('forum_thread');
        $where['fid'] = $fid;
        $where['displayorder'] = array('GT', -1);
        $where['isgroup'] = 0;
        $data = $obj->where($where)->order('dateline desc')->limit($page, $pageSize)->select();
        if (empty($data)) {
            printJson(false, 404, '失败', $data);
        } else {
            printJson(true, 200, '成功', $data);
        }
    }


    /*
     * 帖子详情
     * @param tid 主题ID ［必传］
     * @param user_id 用户ID	［可选］
     */
    public function postInfo()
    {
        $data = array();
        $objet = new \Home\Model\forumModel();
        $tid = intval(I('get.tid', 0));
        $re_session = I('get.re_session', 0);
        if (!empty($re_session)) {
            $user_id = $this->getUid($re_session);
        }
        if (empty($tid)) {
            printJson(false, 404, "参数不合法");
        }
        $Model = new Model();
        $sql = "SELECT t.tid,t.fid,t.posttableid,t.authorid,t.author,t.`subject`,t.lastpost,t.views,t.replies,t.digest,t.attachment,t.recommend_add,t.dateline,f.name as forumname,t.special,t.icon,t.status,t.sharetimes,t.favtimes,t.displayorder FROM `pre_forum_thread` as t LEFT JOIN `pre_forum_forum` as f ON t.fid = f.fid where t.tid  ={$tid}";
        $threadinfo = $Model->query($sql);
        $threadinfo = $threadinfo['0'];
        if (!$threadinfo) {
            printJson(false, 404, '抱歉，数据不存在', $data);
        }
        if ($threadinfo[displayorder] < 0) {
            printJson(false, 404, '抱歉，主题已被删除或未审核！', $data);
        }
        $threadinfo['isapple'] = '';
        $threadinfo['hiddenreplies'] = getstatus($threadinfo['status'], 2);
        $threadinfo['addtime'] = date('Y-m-d H:i:s', $threadinfo['dateline']);
        $threadinfo['userface'] = "http://uc.movshow.com/avatar.php?uid=" . $threadinfo['authorid'] . "&size=middle";

        //楼主帖子
        $post = $objet->GetPostInfoFirstByTid($tid, $threadinfo[posttableid], $threadinfo['authorid']);
//        dd_log($post);
        if (!$post) {
            printJson(false, 404, '抱歉，帖子获取失败或不存在！', $data);
        }
        //楼主帖子信息图片
        if ($threadinfo['attachment'] == 2) {
            $pics = $objet->GetAttachListByTid($tid, $threadinfo['authorid']);
        }

        $content = $post['message'];
        $threadinfo['statustitle'] = $threadinfo["forumname"];
        $threadinfo['useip'] = $post['useip'];
        $threadinfo['pid'] = $post['pid'];
        $threadinfo['message'] = $post['message'];
        $threadinfo['attachment'] = $post['attachment'];
        $threadinfo['position'] = $post['position'];
        $threadinfo['gender'] = $objet->getUserSex($threadinfo['authorid']);
        $threadinfo['tags'] = '';
        $threadinfo['oldmessage'] = $content;
        $threadinfo['message'] = $objet->superStr($threadinfo['message'], $threadinfo['tid'], $threadinfo['pid'], $threadinfo['attachment'], '', $pics, $user_id);
        $threadinfo['activityinfo'] = "";
        $threadinfo['content'] = "";
        # 获取用户地址
        if (empty($threadinfo['address'])) {
            $uid = $threadinfo["authorid"];
            $addressSql = "select resideprovince,residecity,residedist from `pre_common_member_profile` where uid={$uid} ";
            $addressInfo = $Model->query($addressSql);
            $addressInfo = $addressInfo[0];
            $threadinfo['address'] = $addressInfo["resideprovince"] . $addressInfo["residecity"];
        }
        if (empty($threadinfo['address'])) {
            $threadinfo['address'] = $objet->getIPLoc_sina($post['useip']);
        }
        #赞总数列表
        if ($threadinfo["authorid"] > 0) {
            $myrecommendCount = $objet->GetMemberRecommendCountByTid($tid, $threadinfo["authorid"]);
            $threadinfo[recommend_add] = $myrecommendCount;
            $recommendarray = $objet->GetMemberRecommendListByTid($tid);
            $threadinfo[recommendarray] = $recommendarray;
        }

        #赞否
        if (!empty($user_id)) {
            $myrecommend = M('forum_memberrecommend')->where(array('recommenduid' => $user_id, 'tid' => $tid))->find();
            //echo M('forum_memberrecommend')->getLastSql();die;
            $threadinfo['myrecommend'] = empty($myrecommend) ? 0 : 1;
        }

        #更新阅读数
        $views = 1;
        $threadSql = "UPDATE `pre_forum_thread` SET views=views + $views WHERE tid =" . $tid;
        $Model->execute($threadSql);
        $threadinfo["views"] = (string)($threadinfo["views"] + $views);

        #评论总数
        $tablestr = "pre_forum_post";
        if ($threadinfo[posttableid] > 0) {
            $tablestr = "forum_post_" . $threadinfo[posttableid];
        }
        $postwhere = " and invisible=0 and position > 1 and tid=" . $tid . "";
        $toSql = "SELECT COUNT('pid') as pids FROM " . $tablestr . " WHERE 1=1 " . $postwhere;
        $total = $Model->query($toSql);
        $threadinfo['posttotal'] = $total[0]['pids'];
        printJson(true, 200, '成功', $threadinfo);

    }

    /**
     * @name  帖子详情 -楼层列表
     * @param tid 主题ID ［必传］
     * @param re_session 用户序列号  判断隐藏   ［可选］
     * @param pn 当前页 default 1 ［可选］
     * @param pagesize 每页数量 default 10
     */
    public function threadShowList()
    {

        $data = array();
        $objet = new \Home\Model\forumModel();
        $tid = intval(I('get.tid', 0));
        $re_session = I('get.re_session', 0);
        if (!empty($re_session)) {
            $user_id = $this->getUid($re_session);
        }
        $pn = intval(I('get.pn', 0));
        $Model = new Model();
        $sql = "SELECT t.tid,t.fid,t.posttableid,t.authorid,t.author,t.`subject`,t.lastpost,t.views,t.replies,t.digest,t.attachment,t.recommend_add,t.dateline,f.name as forumname,t.special,t.icon,t.status,t.sharetimes,t.favtimes,t.displayorder FROM `pre_forum_thread` as t LEFT JOIN `pre_forum_forum` as f ON t.fid = f.fid where t.tid  = {$tid}";
        $threadinfo = $Model->query($sql);
        $threadinfo = $threadinfo['0'];
        if (!$threadinfo) {
            printJson(false, 404, '抱歉，数据不存在', $data);
        }
        if ($threadinfo[displayorder] < 0) {
            printJson(false, 404, '抱歉，主题已被删除或未审核！', $data);
        }
        $threadinfo['hiddenreplies'] = getstatus($threadinfo['status'], 2);
        $authortotal = 0;
        $authorlist = array();
        $postwhere = " and invisible=0 and position > 1 and tid=" . $tid . "";
        $orderstr = " pid asc";
        $posttotal = 0;
        $postlist = $objet->GetPostListByTable($threadinfo, $postwhere, $orderstr, $WSQ = false, $pn, $user_id);
        if (empty($postlist)) {
            printJson(false, 404, '获取失败', $postlist);
        } else {
            printJson(true, 200, '成功', $postlist);
        }
    }

    /*
     * 圈子-置顶帖
     * fid 圈子id
     */
    public function forumThreadTopList()
    {
        $fid = intval(I('get.fid', 0));
        $pn = intval(I('get.pn', 0));
        if (empty($fid)) {
            printJson(false, 404, "参数不合法");
        }
        $list = array();
        $page = $pn * 10;
        $pageSize = ($pn + 1) * 10;
        $sql = "SELECT tid,fid,author,authorid,`subject`,views,dateline FROM `pre_forum_thread` WHERE fid={$fid} AND displayorder>0 order by tid desc LIMIT {$page} , {$pageSize} ";
        $Model = new Model();
        $list = $Model->query($sql);
        $forumsql = "SELECT name,threads,posts,todayposts,yesterdayposts,lastpost FROM `pre_forum_forum` WHERE `fid` = {$fid} ";
        $forumInfo = $Model->query($forumsql);
        $forumInfo = $forumInfo[0];
        $data = array(
            'list' => $list,
            'forumInfo' => $forumInfo
        );
        printJson(true, 200, '成功', $data);
    }

    /**
     * @name  圈子 -帖子列表
     * @param pn 当前页 default 0 ［可选］
     * @param fid 圈子id
     * @param type 1最新 2精华 3有图
     */
    public function forumThreadList()
    {
        $fid = intval(I('get.fid', 0));
        $pn = intval(I('get.pn', 0));
        $type = intval(I('get.type', 0));
        if (empty($fid)) {
            printJson(false, 404, "参数不合法");
        }
        $page = $pn * 10;
        $pageEnd = ($pn + 1) * 10;
        $Model = new Model();
        $obj = M('forum_thread');
        $where['displayorder'] = array('GT', -1);
        $where['fid'] = $fid;
        $data = $obj->where($where)->order('dateline desc')->limit($page, $pageEnd)->select();
        //echo M('forum_thread')->getLastSql();die;
        $objet = new \Home\Model\forumModel();
        foreach ($data as $k => $v) {
            $data[$k]['userface'] = "http://uc.movshow.com/avatar.php?uid=" . $v['authorid'] . "&size=middle";
            $data[$k]['dateline'] = date("Y-m-d H:i", $v['dateline']);
            $data[$k]['lastpost'] = date("Y-m-d H:i", $v['lastpost']);
            if ($v['attachment'] == 2) {
                $prcs = $objet->getAttachment($v['tid'], $v['authorid']);
                $data[$k]['pics'] = $prcs;
            }

        }
        if (empty($data)) {
            printJson(false, 404, '失败', $data);
        } else {
            printJson(true, 200, '成功', $data);
        }
    }

    //-----------------------------------------分割线---------------------------------------------
    //TODO 将uid 给存进 缓存里面vel 返回前端 为key 生效时间1小时
    /*
     * 用户id set处理 返回前端
     * re_session 用户序列号
     */
    private function setUid($uid)
    {
        $re_session = empty($uid) ? "" : base64_encode($uid . time() . "5476");
        return $re_session;
    }

    /*
     * 用户id字符串 get处理 获取id
     * $re_session    用户序列号
     */
    private function getUid($re_session)
    {
        if (empty($re_session)) {
            printJson(false, 404, "参数不能为空");
        }
        $re_session = base64_decode($re_session);
        $uid = substr($re_session, 0, -14);
        $key = substr($re_session, -4);
        $time = substr($re_session, -14, 10);
        if ($key != "5476") {
            printJson(false, 404, "参数不合法");
        }
        if (time() - $time > 3600) {
            printJson(false, 404, "登录超时，请到个人中心刷新登录!");
        }
        return $uid;
    }

    /*
     * 用户登录权限判断
     * @param userInfo 微信用户信息
     * @param code 登录凭证（code）
     */
    public function onLogin()
    {
        $data = array();
        $objet = new \Home\Model\forumModel();
        $username = I('get.nickName');
        $avatar = I('get.avatarUrl');
        $code = I('get.code');
        $appid = "xxxxxxxx小程序appid";
        $AppSecret = "xxxxxxx小程序私钥";
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appid . "&secret=" . $AppSecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $session = getCurlPush($url);
        $sessionobj = json_decode($session);
        if (empty($sessionobj->openid)) {
            printJson(false, 404, 'openid获取失败', $data);
        }
        $openid = $sessionobj->openid;
        //根据openid查询用户社区信息 不存在则创建
        $Model = D('common_member_wechat_xcx');
        $where['openid'] = $openid;
        $openInfo = $Model->where($where)->find();
        if (empty($openInfo)) {
            $userInfo = $objet->auotoUser($openid, $username);
            if (empty($userInfo['uid'])) {
                printJson(false, 404, '创建用户失败，您可以重试或联系管理员', $data);
            }
        } else {
            $uid = $openInfo['uid'];
            $ModelMember = D('common_member');
            $userInfo = $ModelMember->where(array('uid' => $uid))->field('uid,username,groupid')->find();
            if (empty($userInfo)) {
                printJson(false, 404, '用户不存在', $data);
            }
            if ($userInfo['groupid'] == 4 or $userInfo['groupid'] == 5) {
                printJson(false, 404, '用户权限问题禁止登录，您可以重试或联系管理员', $data);
            }
        }
        $userInfo['imageUrl'] = "http://uc.movshow.com/avatar.php?uid=" . $userInfo['uid'] . "&size=middle&time=" . time();
        $userInfo['re_session'] = $this->setUid($userInfo['uid']);
        printJson(true, 200, '登录成功!', $userInfo);

    }

    /*
     * 个人资料
     * @param re_session 用户序列号
     */
    public function getUserInfo()
    {
        $re_session = I('get.re_session', 0);
        $uid = $this->getUid($re_session);
        $where['uid'] = $uid;
        $userInfo = M('common_member_profile')->where($where)->field('gender,resideprovince,residecity,residedist')->find();
        $data = array(
            'sex' => $userInfo['gender'],
            'province' => $userInfo['resideprovince'],
            'city' => $userInfo['residecity'],
            'area' => $userInfo['residedist'],
            'imageUrl' => "http://uc.movshow.com/avatar.php?uid=" . $uid . "&size=middle&time=" . time(),
        );
        printJson(true, 200, "成功", $data);
    }

    /*
     * 单文件上传，头像更新
     *
     */
    public function uploadChangePic()
    {
        $re_session = I('get.re_session', 0);
        $uid = $this->getUid($re_session);
        $savePath = $this->get_home($uid);
        $saveName = $this->get_avatar($uid);

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728;// 设置附件上传大小
        $upload->replace = true;//同名覆盖
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = '/data/wwwroot/www.movshow.com/uc_server/data/avatar'; // 设置附件上传根目录
        $upload->autoSub = true;
        $upload->subName = $savePath;//设置附件上传（子）目录
        $upload->saveName = $saveName;  //文件名
        $info = $upload->uploadOne($_FILES['file']);
        if (!$info) {// 上传错误提示错误信息
            printJson(false, 404, '上传错误', $upload->getError());
        } else {// 上传成功 获取上传文件信息
            $data = array(
                'imageUrl' => "http://uc.movshow.com/avatar.php?uid=" . $uid . "&size=middle&time=" . time(),
            );
            printJson(true, 200, '上传成功', $data);
        }
    }

    /*
     * 头像通过uid解析出文件路径
     */
    private function get_home($uid)
    {
        $uid = sprintf("%09d", $uid);
        $dir1 = substr($uid, 0, 3);
        $dir2 = substr($uid, 3, 2);
        $dir3 = substr($uid, 5, 2);
        return '/' . $dir1 . '/' . $dir2 . '/' . $dir3;
    }

    /*
     * 头像文件名
     */
    private function get_avatar($uid)
    {
        $name = substr($uid, -2);
        $name = $name . "_avatar_middle";
        return $name;
    }

    /*
     * 保存个人资料：性别地址
     */
    public function Updateuserinfo()
    {

        $re_session = I('get.re_session', 0);
        $sex = I('get.sex', 0);
        $province = I('get.province', "北京");
        $city = I('get.city', "北京市");
        $county = I('get.county', "东城区");
        $uid = $this->getUid($re_session);
        $User = M("common_member_profile");
        $data['gender'] = $sex;
        $data['resideprovince'] = $province;
        $data['residecity'] = $city;
        $data['residedist'] = $county;
        $status = $User->where(array('uid' => $uid))->save($data);
        if (empty($status)) {
            printJson(false, 404, "更新失败", $status);
        } else {
            printJson(true, 200, "更新成功", $status);
        }

    }

    /*
     * 帖子点赞
     * @param re_session 用户序列号
     * @param iscancel 0赞 1取消
     * @param tid 帖子id
     *
     */
    public function praisePost()
    {
        $re_session = I('get.re_session', 0);
        $tid = I('get.tid', 0);
        $iscancel = I('get.iscancel', 0);
        $uid = $this->getUid($re_session);
        if (empty($tid)) {
            printJson(false, 404, "参数不合法");
        };
        $Model = M('forum_memberrecommend');
        $threadModel = D();
        //取消
        if ($iscancel) {
            $where['recommenduid'] = $uid;
            $where['tid'] = $tid;
            $info = $Model->where($where)->find();
            if (empty($info)) {
                printJson(false, 404, "尚未点赞");
            }
            $Model->where(array('recommenduid' => $uid, 'tid' => $tid))->delete();
            $sql = "UPDATE `pre_forum_thread` SET recommend_add=recommend_add-1 WHERE tid = {$tid}";
            $threadModel->execute($sql);
            printJson(true, 200, "取消成功");

        } else {
            $where['recommenduid'] = $uid;
            $where['tid'] = $tid;
            $info = $Model->where($where)->find();
            if (!empty($info)) {
                printJson(false, 404, "已经点过赞");
            }
            $postinfo = M('forum_thread')->where(array('tid' => $tid))->field('fid,tid,author,authorid,subject')->find();
            if (empty($postinfo)) {
                printJson(false, 404, "找不到该帖子,可能已被删除");
            }
            #更新用户活跃时间和赞记录
            M('forum_groupuser')->where(array('fid' => $postinfo['fid'], 'uid' => $uid))->save(array('lastupdate' => time()));
            $rec = $Model->add(array('tid' => $tid, 'recommenduid' => $uid, 'dateline' => time()));
            if ($rec) {
                $sql = "UPDATE `pre_forum_thread` SET recommend_add=recommend_add+1 WHERE tid = {$tid}";
                $threadModel->execute($sql);
            }
            printJson(true, 200, "点赞成功");
        }

    }

    /*
    * 帖子回复
    * @param re_session 用户序列号
    * @param content 内容
    * @param tid 帖子id
    *
    */
    public function postReplyNew()
    {
        $re_session = I('get.re_session', 0);
        $tid = I('get.tid', 0);
        $content = I('get.content', 0);
        $uid = $this->getUid($re_session);
        if (empty($tid) or empty($re_session)) {
            printJson(false, 404, "参数不合法！", array());
        }
        if (empty($content)) {
            printJson(false, 404, "回复内容不可为空！", array());
        }
        $result = M('common_member')->where(array('uid' => $uid))->field('status,username')->find();
        if ($result && $result['status'] == -1) {
            printJson(false, 404, "您已被禁言！", array());
        }
        $threadinfo = M('forum_thread')->where(array('tid' => $tid))->field('fid,tid,subject,posttableid,authorid,author,status,closed,dateline')->find();
        if (!$threadinfo) {
            printJson(false, 404, "主题不存在！", array());
        }
        if ($threadinfo['closed'] == 1) {
            printJson(false, 404, "主题已关闭！", array());
        }
        $table = empty($threadinfo['posttableid']) ? 'forum_post' : 'forum_post_' . $threadinfo['posttableid'];
        //检查我的上次回复时间
        $user_dateline = M($table)->where(array('authorid' => $uid, 'first' => '0'))->field('dateline,message')->order('dateline DESC')->limit(1)->find();
        if ($user_dateline) {
            if (time() - $user_dateline['dateline'] < 10) {
                printJson(false, 404, "请休息10秒再发！", array());
            }
        }
        $userInfo = M('common_member_profile')->where(array('uid' => $uid))->field('gender,resideprovince,residecity,residedist')->find();
        $time = time();
        $forumData['tid'] = $tid;
        $forumData['fid'] = $threadinfo['fid'];
        $forumData['author'] = $result['username'];
        $forumData['authorid'] = $uid;
        $forumData['dateline'] = $time;
        $forumData['message'] = $content;
        $pid = M('forum_post_tableid')->add(array('pid' => null));
        if (empty($pid)) {
            printJson(false, 404, "回复失败！");
        }
        $forumData['pid'] = $pid;
        $addstatus = M($table)->add($forumData);
        if ($addstatus) {
            $postData['id'] = $addstatus;
            $postData['message']['0'] = array(
                'content' => $content,
                'type' => 'article',
            );
            $postData['addtime'] = date('Y-m-d H:i:s', $time);
            $postData['username'] = $result['username'];
            $postData['address'] = $userInfo['resideprovince'] . $userInfo['residecity'];
            $postData['userface'] = "http://uc.movshow.com/avatar.php?uid=" . $uid . "&size=middle&time=" . $time;
            printJson(true, 200, "回复成功！", $postData);
        } else {
            printJson(false, 404, "回复失败！");
        }
    }

    /* 发帖
     * @param uid 		用户ID  [必选]
     * @param fid 		圈子ID  [必选]
     * @param title 	发帖标题 [必选]
     * @param content 	发帖内容 [必选]
     * @param aidlist 	图片附件 [可选]
     */
    public function threadPost()
    {
        $re_session = I('get.re_session', 0);
        $fid = I('get.fid', 0);
        $title = I('get.title', 0);
        $content = I('get.content', 0);
        $aidlist = I('get.aidlist', 0);
        if (empty($title) or empty($content)) {
            printJson(false, 404, "标题和内容不可为空！", array());
        }
        $uid = $this->getUid($re_session);
        if (empty($fid)) {
            printJson(false, 404, "必须选择圈子", array());
        }
        if (empty($uid)) {
            printJson(false, 404, "登录状态超时，请到个人中心刷新登录", array());
        }
        $userInfo = M('common_member')->where(array('uid' => $uid))->field('username,status')->find();
        if (empty($userInfo)) {
            printJson(false, 404, "用户不存在！", '');
        }
        if ($userInfo['status'] == -1) {
            printJson(false, 404, "您已被禁言！", '');
        }
        //更新用户活跃
        M('forum_groupuser')->where(array('fid' => $fid, 'uid' => $uid))->save(array('lastupdate' => time()));
        //入主题表得 主题id
        $threadData = array(
            'fid' => $fid,
            'author' => $userInfo['username'],
            'authorid' => $uid,
            'subject' => $title,
            'dateline' => time(),
            'lastpost' => time(),
            'lastposter' => $uid,
            'views' => 7,
            'status' => 192,
            'stamp' => -1,
            'icon' => -1,
            'attachment' => empty($aidlist) ? 0 : 2,
            'sharetimes' => 3,
        );
        $tid = M('forum_thread')->add($threadData);
        if (empty($tid)) {
            printJson(false, 404, "发布主题失败！", '');
        }
        //入post分表协调表 得pid
        $pid = M('forum_post_tableid')->add(array('pid' => null));
        if (!$pid) {
            printJson(false, 404, "发布帖子失败！", '');
        }
        //图片附件
        $attachment = empty($aidlist) ? 0 : 2;
        //帖子表
        $posrData = array(
            'pid' => $pid,
            'fid' => $fid,
            'tid' => $tid,
            'author' => $userInfo['username'],
            'authorid' => $uid,
            'subject' => $title,
            'dateline' => time(),
            'message' => $content,
            'first' => 1,
            'usesig' => 1,
            'htmlon' => 0,
            'bbcodeoff' => 0,
            'smileyoff' => 0,
            'position' => 1,
            'status' => 1032,
            'smileyoff' => -1,
            'attachment' => $attachment,
        );
        $addPost = M('forum_post')->add($posrData);
        if ($addPost <= 0) {
            printJson(false, 404, "发布帖子失败！", '');
        }

        //绑定图片
        $objet = new \Home\Model\forumModel();
        if ($aidlist && trim($aidlist) != '') {
            $objet->updateattach($tid, $pid, $uid, $aidlist);
        }
        printJson(true, 200, "发布帖子成功！", '');

    }

    /*
     * 单文件上传，帖子图片
     *小程序限制一次上传一张，前端递归
     */
    public function uploadthreadImage()
    {
        $url = "";
        $re_session = I('get.re_session', 0);
        $uid = $this->getUid($re_session);
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = '/mystore/upload.movshow.com/forum/xcximage/'; // 设置附件上传根目录
        $upload->savePath = ''; // 设置附件上传（子）目录//
        $info = $upload->uploadOne($_FILES['file']);
        if (!$info) {// 上传错误提示错误信息
            printJson(false, 404, '上传错误', $upload->getError());
        } else {// 上传成功 获取上传文件信息
            $url = "http://upload.movshow.com/forum/xcximage/" . $info['savepath'] . $info['savename'];
        }
        $aid = M('forum_attachment')->add(array('tid' => 0, 'pid' => 0, 'uid' => $uid, 'tableid' => 127));
        if (empty($aid)) {
            printJson(false, 404, '插入附件表失败', $info);
        }
        $insert = array(
            'aid' => $aid,
            'dateline' => time(),
            'filename' => $info['savename'],
            'filesize' => $info['size'],
            'attachment' => "xcximage/" . $info['savepath'] . $info['savename'],
            'isimage' => 1,
            'uid' => $uid,
            'thumb' => 0,
            'remote' => 0,
            'width' => 400,
            'height' => '',
        );
        $unusedid = M('forum_attachment_unused')->add($insert);
        if (empty($unusedid)) {
            printJson(false, 404, '未使用附件表', $info);
        }
        printJson(true, 200, '上传成功', array('aid' => $aid));
    }

    /*
     * 个人中心-我的帖子
     * re_session  【必选】
     * pn 【可选】
     */
    public function mythreadNew()
    {
        $re_session = I('get.re_session', 0);
        $uid = $this->getUid($re_session);
        $pn = intval(I('get.pn', 0));
        $page = $pn * 10;
        $pageEnd = ($pn + 1) * 10;
        $obj = M('forum_thread');
        $where['displayorder'] = array('GT', -1);
        $where['authorid'] = $uid;
        $data = $obj->where($where)->order('dateline desc')->limit($page, $pageEnd)->select();
        //echo M('forum_thread')->getLastSql();die;
        $objet = new \Home\Model\forumModel();
        foreach ($data as $k => $v) {
            $data[$k]['userface'] = "http://uc.movshow.com/avatar.php?uid=" . $v['authorid'] . "&size=middle";
            $data[$k]['dateline'] = date("Y-m-d H:i", $v['dateline']);
            $data[$k]['lastpost'] = date("Y-m-d H:i", $v['lastpost']);
            if ($v['attachment'] == 2) {
                $prcs = $objet->getAttachment($v['tid'], $v['authorid']);
                $data[$k]['pics'] = $prcs;
            }
        }
        if (empty($data)) {
            printJson(false, 404, '失败', $data);
        } else {
            printJson(true, 200, '成功', $data);
        }
    }

    /*
     * 删除贴子
     */
    public function delthread()
    {
        $tid = I('get.tid', 0);
        if (empty($tid)) {
            printJson(false, 404, "没有帖子ID参数");
        }
        $re_session = I('get.re_session', 0);
        $uid = $this->getUid($re_session);
        $userInfo = M('common_member')->where(array('uid' => $uid))->field('username,status')->find();
        if (empty($userInfo)) {
            printJson(false, 404, "用户不存在！", '');
        }
        if ($userInfo['status'] == -1) {
            printJson(false, 404, "当前帐号已被禁用！", '');
        }
        $model = M('forum_thread');
        $where['displayorder'] = array('GT', -1);
        $where['authorid'] = $uid;
        $where['tid'] = $tid;
        $data = $model->where($where)->select();
        if (empty($data)) {
            printJson(false, 404, "帖子不存在或已被管理员删除！", '');
        }
        $return = $model->where(array('tid' => $tid, 'authorid' => $uid))->save(array('displayorder' => '-1'));//主题
        if ($return) {
            printJson(true, 200, "删除成功", '');
        } else {
            printJson(false, 404, "删除失败", '');
        }
        /*
        $tabid = empty($data['posttableid']) ? 'forum_post' :'forum_post_1';
        M($tabid)->where(array('tid'=>$tid,'authorid'=>$uid))->delete();//帖子
        $aidlist = M('pre_forum_attachment')->where(array('tid'=>$tid,'uid'=>$uid))->select();//附件
        */


    }
}