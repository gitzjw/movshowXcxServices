<?php
namespace Home\Controller;

use Think\Controller;
use Think\Model;

class IndexController extends Controller
{


    public function hell()
    {
        $test = new \Home\Model\testModel();
        $b = $test->test();
        dd_log($b);
    }

    /*
     * 首页
     */
    public function index()
    {
        echo time() . "开发中";
    }
    /*
     * banner图幻灯
     */
    public function bannerUrls()
    {

    }
    /*
     * 圈子列表[前端写死，未使用]
     */
    public function forumList()
    {

        $oobjet = new \Home\Model\forumModel();
        $data = $oobjet->index();
        if (empty($data)) {
            printJson('false', 404, '失败', $data);
        } else {
            printJson('true', 200, '成功', $data);
        }
    }

    /**
     * @name  首页精华贴列表
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
            printJson('false', 404, '失败', $data);
        } else {
            printJson('true', 200, '成功', $data);
        }
    }

    /**
     * @name  圈 -贴子列表
     * @param fid 圈子ID ［必选］
     * @param pn 当前页[默认每页10条]［可选］
     */
    public function postList()
    {
        $fidList = array(4, 5, 119, 18, 231, 154, 4, 20, 16, 14, 25, 116, 60, 29, 111, 147, 155, 146, 56, 34, 24, 11);
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
            printJson('false', 404, '失败', $data);
        } else {
            printJson('true', 200, '成功', $data);
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
        $user_id = intval(I('get.user_id', 0));
        if (empty($tid)) {
            printJson(false, 404, "参数不合法");
        }
        $Model = new Model();
        $sql = "SELECT t.tid,t.fid,t.posttableid,t.authorid,t.author,t.`subject`,t.lastpost,t.views,t.replies,t.digest,t.attachment,t.recommend_add,t.dateline,f.name as forumname,t.special,t.icon,t.status,t.sharetimes,t.favtimes,t.displayorder FROM `pre_forum_thread` as t LEFT JOIN `pre_forum_forum` as f ON t.fid = f.fid where t.tid  ={$tid}";
        $threadinfo = $Model->query($sql);
        $threadinfo = $threadinfo['0'];
        if (!$threadinfo) {
            printJson('false', 404, '抱歉，数据不存在', $data);
        }
        if ($threadinfo[displayorder] < 0) {
            printJson('false', 404, '抱歉，主题已被删除或未审核！', $data);
        }
        $threadinfo['isapple'] = '';
        $threadinfo['hiddenreplies'] = getstatus($threadinfo['status'], 2);
        $threadinfo['addtime'] = date('Y-m-d H:i:s', $threadinfo['dateline']);
        $threadinfo['userface'] = "http://uc.movshow.com/avatar.php?uid=" . $threadinfo['authorid'] . "&size=middle";

        //楼主帖子
        $post = $objet->GetPostInfoFirstByTid($tid, $threadinfo[posttableid]);
        if (!$post) {
            printJson('false', 404, '抱歉，帖子获取失败或不存在！', $data);
        }
        //楼主帖子信息图片
        if ($threadinfo['attachment'] == 2) {
            $pics = $objet->GetAttachListByTid($tid);
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
        printJson('true', 200, '成功', $threadinfo);

    }

    /**
     * @name  帖子详情 -楼层列表
     * @param tid 主题ID ［必传］
     * @param user_id 用户ID  判断隐藏   ［可选］
     * @param pn 当前页 default 1 ［可选］
     * @param pagesize 每页数量 default 10
     */
    public function threadShowList()
    {

        $data = array();
        $objet = new \Home\Model\forumModel();
        $tid = intval(I('get.tid', 0));
        $user_id = intval(I('get.user_id', 0));
        $pn = intval(I('get.pn', 0));
        $Model = new Model();
        $sql = "SELECT t.tid,t.fid,t.posttableid,t.authorid,t.author,t.`subject`,t.lastpost,t.views,t.replies,t.digest,t.attachment,t.recommend_add,t.dateline,f.name as forumname,t.special,t.icon,t.status,t.sharetimes,t.favtimes,t.displayorder FROM `pre_forum_thread` as t LEFT JOIN `pre_forum_forum` as f ON t.fid = f.fid where t.tid  = {$tid}";
        $threadinfo = $Model->query($sql);
        $threadinfo = $threadinfo['0'];
        if (!$threadinfo) {
            printJson('false', 404, '抱歉，数据不存在', $data);
        }
        if ($threadinfo[displayorder] < 0) {
            printJson('false', 404, '抱歉，主题已被删除或未审核！', $data);
        }
        $threadinfo['hiddenreplies'] = getstatus($threadinfo['status'], 2);
        $authortotal = 0;
        $authorlist = array();
        $postwhere = " and invisible=0 and position > 1 and tid=" . $tid . "";
        $orderstr = " pid asc";
        $posttotal = 0;

        $postlist = $objet->GetPostListByTable($threadinfo, $postwhere, $orderstr, $WSQ = false, $pn, $user_id);
        if (empty($postlist)) {
            printJson('false', 404, '获取失败', $postlist);
        } else {
            printJson('true', 200, '成功', $postlist);
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
        printJson('true', 200, '成功', $data);
    }

    /**
     * @name  圈子 -列表
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
            printJson('false', 404, '失败', $data);
        } else {
            printJson('true', 200, '成功', $data);
        }
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
        $appid = "wx9d0d76ce43dab283";
        $AppSecret = "04860cc568204ffdfa23dadc17025720";
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appid . "&secret=" . $AppSecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $session = getCurlPush($url);
        $sessionobj = json_decode($session);
        if (empty($sessionobj->openid)) {
            printJson('false', 404, 'openid获取失败', $data);
        }
        $openid = $sessionobj->openid;
        //根据openid查询用户社区信息 不存在则创建
        $Model = D('common_member_wechat_xcx');
        $where['openid'] = $openid;
        $openInfo = $Model->where($where)->find();
        if (empty($openInfo)) {
            $userInfo = $objet->auotoUser($openid, $username);
            if(empty($userInfo['uid'])){
                printJson('false', 404, '创建用户失败，您可以重试或联系管理员', $data);
            }
        } else {
            $uid = $openInfo['uid'];
            $ModelMember = D('common_member');
            $userInfo = $ModelMember->where(array('uid' => $uid))->field('uid,username,groupid')->find();
            if (empty($userInfo)) {
                printJson('false', 404, '用户不存在', $data);
            }
            if ($userInfo['groupid'] == 4 or $userInfo['groupid'] == 5) {
                printJson('false', 404, '用户权限问题禁止登录，您可以重试或联系管理员', $data);
            }
        }
        //TODO 将uid 给存进 缓存里面vel 返回前端 为key 生效时间1小时

        $userInfo['imageUrl'] = "http://uc.movshow.com/avatar.php?uid=" . $userInfo['uid'] . "&size=middle";
        printJson('true',200,'登录成功!',$userInfo);

    }
}