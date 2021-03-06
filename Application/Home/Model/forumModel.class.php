<?php

/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2017/4/14
 * Time: 15:04
 */
namespace Home\Model;

use Think\Model;

class forumModel extends Model
{
    protected $tablePrefix = 'pre_forum_';

    public function index()
    {
        $classesPic = array(
            array(
                'name' => '猫咪有约推荐',
                'list' => array(
                    array(
                        "fid" => "18",
                        "name" => "流浪动物领养中心",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/18.png"
                    ),
                    array(
                        "fid" => "4",
                        "name" => "七嘴-八舌",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/4.png"
                    ),
                    array(
                        "fid" => "14",
                        "name" => "猫物推荐",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/14.png"
                    ),
                    array(
                        "fid" => "25",
                        "name" => "跳蚤市场",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/25.png"
                    ),
                )
            ),
            array(
                'name' => '公益事业区',
                'list' => array(
                    array(
                        "fid" => "5",
                        "name" => "流浪救助信息",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/5.png"
                    ),
                    array(
                        "fid" => "119",
                        "name" => "医生会诊交流区",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/119.png"
                    ),
                    array(
                        "fid" => "231",
                        "name" => "北京领养日",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/231.png"
                    ),
                    array(
                        "fid" => "154",
                        "name" => "义卖专区",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/154.png"
                    ),
                    array(
                        "fid" => "20",
                        "name" => "养猫新手上路",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/20.png"
                    ),
                    array(
                        "fid" => "16",
                        "name" => "养猫攻略分享",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/16.png"
                    ),

                )
            ),
            array(
                'name' => '有约地方站',
                'list' => array(
                    array(
                        "fid" => "116",
                        "name" => "济南猫窝",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/116.png"
                    ),
                    array(
                        "fid" => "60",
                        "name" => "上海猫友会",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/60.png"
                    ),
                    array(
                        "fid" => "29",
                        "name" => "天津猫友会",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/29.png"
                    ),
                    array(
                        "fid" => "111",
                        "name" => "武汉分站",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/111.png"
                    ),
                    array(
                        "fid" => "147",
                        "name" => "太原分站",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/147.png"
                    ),
                    array(
                        "fid" => "155",
                        "name" => "粤来粤爱猫",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/155.png"
                    ),

                )
            ),
            array(
                'name' => '交流活动区',
                'list' => array(
                    array(
                        "fid" => "146",
                        "name" => "有约活动专区",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/146.png"
                    ),
                    array(
                        "fid" => "34",
                        "name" => "生活大杂烩",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/34.png"
                    ),
                    array(
                        "fid" => "24",
                        "name" => "猫狗一家亲",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/24.png"
                    ),

                )
            ),
            array(
                'name' => '管理专区',
                'list' => array(
                    array(
                        "fid" => "224",
                        "name" => "新手报到",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/224.png"
                    ),
                    array(
                        "fid" => "21",
                        "name" => "争议讨论区",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/21.png"
                    ),
                    array(
                        "fid" => "11",
                        "name" => "站务办公室",
                        "picurl" => "http://upload.movshow.com/forum/classesPic/11.png"
                    ),
                )
            ),
        );
        return $classesPic;

    }

    /*
     * 发帖圈子列表
     */
    public function forum()
    {
        $data = array(
            array(
                "fid" => "18",
                "name" => "流浪动物领养中心",
            ),
            array(
                "fid" => "4",
                "name" => "七嘴-八舌",
            ),
            array(
                "fid" => "14",
                "name" => "猫物推荐",
            ),
            array(
                "fid" => "25",
                "name" => "跳蚤市场",
            ),
            array(
                "fid" => "119",
                "name" => "医生会诊交流区",
            ),
            array(
                "fid" => "5",
                "name" => "流浪救助信息",
            ),
            array(
                "fid" => "231",
                "name" => "北京领养日",
            ),
            array(
                "fid" => "154",
                "name" => "义卖专区",
            ),
            array(
                "fid" => "20",
                "name" => "养猫新手上路",
            ),
            array(
                "fid" => "16",
                "name" => "养猫攻略分享",
            ), array(
                "fid" => "116",
                "name" => "济南猫窝",
            ), array(
                "fid" => "60",
                "name" => "上海猫友会",
            ), array(
                "fid" => "29",
                "name" => "天津猫友会",
            ), array(
                "fid" => "111",
                "name" => "武汉分站",
            ), array(
                "fid" => "147",
                "name" => "太原分站",
            ), array(
                "fid" => "155",
                "name" => "粤来粤爱猫",
            ), array(
                "fid" => "146",
                "name" => "有约活动专区",
            ), array(
                "fid" => "34",
                "name" => "生活大杂烩",
            ), array(
                "fid" => "24",
                "name" => "猫狗一家亲",
            ),
            array(
                "fid" => "224",
                "name" => "新手报到",
            ),
            array(
                "fid" => "21",
                "name" => "争议讨论区",
            ),
            array(
                "fid" => "11",
                "name" => "站务办公室",
            ),
        );
        return $data;
    }

    /*
     * 主题贴获取封面图片附件
     * tid 帖子id
     * authorid 会员id
     * limit  false首页3张,true详情页全部
     */
    public function getAttachment($tid, $authorid, $limit = "")
    {
        if (empty($limit)) {
            $limit = "->limit(0, 3)";
        } else {
            $limit = "->limit()";
        }
        $imgs = array();
        if (empty($tid)) {
            return false;
            die;
        }
        $where['tid'] = $tid;
        $where['uid'] = $authorid;
        $attachmentList = M('forum_attachment')->where($where)->field('aid,tableid')->limit($limit)->select();
        if (empty($attachmentList)) {
            return false;
            die;
        }
        $aids = '';
        foreach ($attachmentList as $k => $v) {
            if (empty($aids)) {
                $aids = $v['aid'];
            } else {
                $aids = $aids . "," . $v['aid'];
            }
        }
        $dawhere['aid'] = array('in', $aids);
        $tableid = $attachmentList['0']['tableid'];
        $data = M('forum_attachment_' . $tableid)->where($dawhere)->field('attachment')->select();
        foreach ($data as $k => $v) {
            $imgs[$k] = "http://upload.movshow.com/forum/" . $v['attachment'];
        }
        return $imgs;

    }

    /*
    * 所有帖子的图片附件列
     * 主帖子内容处理根据id，回复列表内容处理一次获取全部
     * tid  帖子id       【必选】
     * authorid 发帖人uid 【可选】
    */
    function GetAttachListByTid($tid, $authorid)
    {
        $data = array();
        $Model = new Model();
        $tableWhere['tid'] = $tid;
        if (!empty($authorid)) {
            $tableWhere['uid'] = $authorid;
        }
        $tablInfo = M('forum_attachment')->where($tableWhere)->field('aid,tableid')->select();
        if (empty($tablInfo)) {
            return $data;
        }
        $aidList = "";
        foreach ($tablInfo as $k => $aid) {
            if (empty($aidList)) {
                $aidList = $aid['aid'];
            } else {
                $aidList = $aidList . "," . $aid['aid'];
            }
        }
        $tableid = $tablInfo['0']['tableid'];
        $table = 'pre_forum_attachment_' . $tableid;
        $sql = "SELECT aid,attachment,remote,thumb,width FROM {$table} WHERE `aid` IN ($aidList)";
        $list = $Model->query($sql);
        foreach ($list as $k => $v) {
            $v['url'] = "http://upload.movshow.com/forum/" . $v['attachment'];
            $v['type'] = 'image';
            $data[$v['aid']] = $v;
        }
        return $data;
    }

    #帖子内容处理 begin 
    /*
     * 帖子内容信息
     */
    function GetPostInfoFirstByTid($tid, $posttableid,$uid)
    {
        $tablestr = "forum_post";
        if ($posttableid > 0) {
            $tablestr = "forum_post_" . $posttableid;
        }
        $where['tid'] = $tid;
        $where['first'] = 1;
        $where['authorid'] = $uid;
        $post = M($tablestr)->where($where)->find();
        return $post;
    }

    /*
     * 新浪通过ip查询地址
     */
    function getIPLoc_sina($queryIP)
    {
        if (empty($queryIP)) {
            return "";
            die;
        }
        $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=' . $queryIP;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_ENCODING, 'utf8');
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回
        $location = curl_exec($ch);
        $location = json_decode($location);
        curl_close($ch);
        $loc = "";
        if ($location === FALSE) return "";
        if (empty($location->desc)) {
            $loc = $location->province . $location->city;
        } else {
            $loc = $location->desc;
        }
        return $loc;
    }

    /*
     * 获取用户性别信息
     */
    function getUserSex($uid)
    {
        $where['uid'] = $uid;
        $userInfo = M('common_member_profile')->where($where)->field('gender')->find();
        return (int)$userInfo['gender'];
    }

    /*
     * 处理帖子内容，字段匹配和查看权限
     */
    function superStr($str, $tid, $pid, $attach, $ios, $pics, $user_id)
    {
        $str = str_replace("&#9829;", ":heart:", $str);
        $str = preg_replace("/&#(.*?);/is", '', $str);
        //兼容PC端没回车也要换行
        $str = str_replace("[/align]", "\r\n", $str);
        $str = preg_replace("/\[postbg\](.*?)\[\/postbg\]|\[qq\](.*?)\[\/qq\]|\[flash(.*?)\](.*?)\[\/flash\]|\[em(.*?)\]/is", '', $str);
        $str = str_replace(array('[i]', '[/i]', '[b]', '[/b]', '[/u]', '[/color]', '[/url]', '[/size]', '[/p]', '[/font]', '[/backcolor]', '[/postbg]', '[tr]', '[/tr]', '[td]', '[/td]', '[/float]', '[/table]', '[/flash]', '[fly]', '[/fly]', '[url]', '[indent]', '[/indent]', '[list]', '[/list]'), array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''), $str);
        $str = preg_replace("/\[back(.*?)\]|\[i=(.*?)\]|\[flash(.*?)\]|\[float(.*?)\]|\[table(.*?)\]|\[u\]|\[post(.*?)\]|\[align=(.*?)\]|\[p=(.*?)\]|\[font=(.*?)\]|\[color=(.*?)\]|\[size=(.*?)\]|\[url=(.*?)\]|\[list=(.*?)\]|\[tr=(.*?)\]|\[td=(.*?)\]/is", '', $str);
        //去除太多的换行
        $str = str_replace("\r\n \r\n", "\r\n", $str);
        $str = str_replace("\r\n\r\n", "\r\n", $str);
        $str = str_replace("\r\n\r\n", "\r\n", $str);
        $str = str_replace("&nbsp;", " ", $str);
        $str = strip_tags($str);
        $allStr = $str;

        //回复可见 开始
        if (strpos($allStr, '[hide]') !== FALSE) {
            $authorreplyexist = null;
            if ($user_id) {
                $autwhere['tid'] = $tid;
                $autwhere['authorid'] = $user_id;
                $authorreplyexist = M('forum_post')->where($autwhere)->field('pid,message')->find();
            }

            if ($authorreplyexist) {
                $allStr = preg_replace("/\[hide\]\s*(.*?)\s*\[\/hide\]/is", "\r\n------本帖隐藏的内容------\r\n\\1", $allStr);
            } else {
                preg_match("/\[hide\](.*?)\[\/hide\]/is", $allStr, $hideData);
                preg_match_all("/\[attach(.*?)\](\d+)\[\/attach(.*?)\]/is", $hideData[1], $hideimageIds);
                $allStr = preg_replace("/\[hide\](.*?)\[\/hide\]/is", "如果您要查看本帖隐藏内容请回复", $allStr);
            }
        }
        if (strpos($allStr, '[hide=') !== FALSE) {
            $allStr = preg_replace("/\[hide=(.*?)\](.*?)\[\/hide\]/is", "\r\n------本帖隐藏的内容------\r\n", $allStr);
        }

        //回复可见 结束
        $attachData = array();
        if ($attach == 2) {
            $attachData = $pics;
        }
        $imageIds = array();
        $content = array();
        while (true) {
            $findTagName = "";
            $findTag = array();
            $matchUpload = strpos($allStr, "[upload");
            $matchImg = strpos($allStr, "[img");
            $matchAttach = strpos($allStr, "[attach");
            $matchVideo = strpos($allStr, "[media");
            $matchQuote = strpos($allStr, "[quote");


            if ($matchUpload !== false) {
                $findTag['upload']['index'] = (int)$matchUpload;
                $findTag['upload']['name'] = "upload";
            }
            if ($matchImg !== false) {
                $findTag['img']['index'] = (int)$matchImg;
                $findTag['img']['name'] = "img";
            }
            if ($matchAttach !== false) {
                $findTag['attach']['index'] = (int)$matchAttach;
                $findTag['attach']['name'] = "attach";
            }
            if ($matchQuote !== false) {
                $findTag['quote']['index'] = (int)$matchQuote;
                $findTag['quote']['name'] = "quote";
            }


            sort($findTag);

            if (count($findTag) > 0 && (int)$findTag[0]["index"] >= 0) {
                $index = (int)$findTag[0]["index"];
                if ($index > 0) {
                    $tempContent = substr($allStr, 0, $index);
                    $key = count($content);
                    $content[$key]['content'] = trim($tempContent);
                    $content[$key]['coverImg'] = '';
                    $content[$key]['width'] = '';
                    $content[$key]['height'] = '';
                    $content[$key]['type'] = 'article';
                    $allStr = substr($allStr, strlen($tempContent));
                }
                $findTagName = $findTag[0]["name"];
            } else {
                $key = count($content);
                $content[$key]['content'] = trim($allStr);
                $content[$key]['coverImg'] = '';
                $content[$key]['width'] = '';
                $content[$key]['height'] = '';
                $content[$key]['type'] = 'article';
                $allStr = '';
            }

            if ($matchUpload !== false && $findTagName == "upload") {
                $key = count($content);
                preg_match("/\[upload(.*?)\](.*?)\[\/upload]/is", $allStr, $uploadStr);
                if (!empty($uploadStr)) {
                    $imgInfo = array();
                    $imgWidth = 300;
                    $imgHeight = 300;
                    $imgUrl = "http://upload.movshow.com/forum/" . trim($uploadStr[2]) . '@!water';
                    $content[$key]['type'] = 'image';
                    $imgInfo = @getimagesize($imgUrl);
                    $imgWidth = $imgInfo[0];
                    $imgHeight = $imgInfo[1];
                    if ((int)$imgInfo[2] == 1) {
                        $content[$key]['type'] = 'gif';
                    }
                    $content[$key]['content'] = $imgUrl;
                    $content[$key]['contentbig'] = $imgUrl;
                    $content[$key]['coverImg'] = "";
                    $content[$key]['width'] = "$imgWidth";
                    $content[$key]['height'] = "$imgHeight";
                    $allStr = substr($allStr, strlen($uploadStr[0]));
                }
            }

            if ($matchImg !== false && $findTagName == "img") {
                $key = count($content);
                preg_match("/\[img(.*?)\](.*?)\[\/img]/is", $allStr, $imgStr);
                if (!empty($imgStr)) {
                    $imgInfo = array();
                    $imgWidth = 300;
                    $imgHeight = 300;
                    $imgUrl = trim($imgStr[2]);
                    $content[$key]['type'] = 'image';
                    if (strpos($imgUrl, "http://") === false) {
                        $filename = DISCUZ_ROOT . $imgUrl;
                        if (file_exists($filename)) {
                            $imgUrl = "http://bbs.movshow.com/" . $imgUrl;
                        }
                    }
                    if (strpos($imgUrl, "http://") !== false) {
                        if (strpos($imgUrl, ".jpeg") !== false || strpos($imgUrl, ".jpg") !== false || strpos($imgUrl, ".png") !== false || strpos($imgUrl, ".gif") !== false) {
                            $imgInfo = @getimagesize($imgUrl);
                            $imgWidth = $imgInfo[0];
                            $imgHeight = $imgInfo[1];
                            if ((int)$imgInfo[2] == 1) {
                                $content[$key]['type'] = 'gif';
                            }
                        }
                    }
                    $content[$key]['aid'] = "0";
                    $content[$key]['content'] = $imgUrl;
                    $content[$key]['contentbig'] = $imgUrl;
                    $content[$key]['coverImg'] = '';
                    $content[$key]['width'] = $imgWidth;
                    $content[$key]['height'] = $imgHeight;
                    $allStr = substr($allStr, strlen($imgStr[0]));
                }
            }
            if ($matchAttach !== false && $findTagName == "attach") {
                $key = count($content);
                preg_match("/\[attach(.*?)\](\d+)\[\/attach(.*?)\]/is", $allStr, $attachStr);
                if (!empty($attachStr)) {
                    $aid = (int)$attachStr[2];
                    $ainfo = $attachData[$aid];
                    if ($ainfo) {
                        $content[$key]['aid'] = "$aid";
                        $content[$key]['content'] = $ainfo['urlthumb'] ? $ainfo['urlthumb'] : $ainfo['url'];
                        $content[$key]['contentbig'] = $ainfo['url'];
                        $content[$key]['coverImg'] = '';
                        $content[$key]['width'] = $ainfo['width'];
                        $content[$key]['height'] = $ainfo['height'];
                        $content[$key]['type'] = $ainfo['type'];
                        $imageIds[] = $aid;
                    }
                    $allStr = substr($allStr, strlen($attachStr[0]));
                }
            }

            if ($matchQuote !== false && $findTagName == "quote") {
                $key = count($content);
                preg_match("/\[quote(.*?)\](.*?)\[\/quote\]/is", $allStr, $quoteStr);
                if (!empty($quoteStr)) {
                    $content[$key]['content'] = $quoteStr[2];
                    $content[$key]['coverImg'] = '';
                    $content[$key]['width'] = '';
                    $content[$key]['height'] = '';
                    $content[$key]['type'] = 'quote';
                    $allStr = substr($allStr, strlen($quoteStr[0]));
                }
            }

            if (trim($allStr) == "" || strlen($allStr) == strlen($end_allStr)) {
                break;
            }
            $end_allStr = $allStr;
        }
        //帖子附件
        if ($attach == 2) {
            $otherImages = $this->getImagesByPid($pid, $tid, $imageIds);
            if ($otherImages) {
                foreach ($otherImages as $otherAttachKey => $otherAttachValue) {
                    $aid = $otherAttachValue['aid'];
                    //放弃隐藏部分的附件
                    if (in_array($aid, $hideimageIds[2])) {
                        continue;
                    }
                    $ainfo = $attachData[$aid];
                    if ($ainfo) {
                        $key = count($content);
                        $content[$key]['aid'] = "$aid";
                        $content[$key]['content'] = $ainfo['urlthumb'] ? $ainfo['urlthumb'] : $ainfo['url'];
                        $content[$key]['contentbig'] = $ainfo['url'];
                        $content[$key]['coverImg'] = '';
                        $content[$key]['width'] = $ainfo['width'];
                        $content[$key]['height'] = $ainfo['height'];
                        $content[$key]['type'] = $ainfo['type'];
                    }
                }
            }
        }
        return $content;
    }

    /*
     * 处理帖子内容,图片相关信息
     */
    function getImagesByPid($pid, $tid, $existingAid)
    {
        $tableid = substr($tid, -1);
        $condition = '';
        if ($existingAid && count($existingAid) > 0) {
            $existingAids = implode(",", $existingAid);
            $condition = " AND aid not in(" . $existingAids . ")";
        }
        $Model = new Model();
        $sql = "SELECT aid,attachment FROM pre_forum_attachment_{$tableid} WHERE pid = {$pid}" . $condition;
        $List = $Model->query($sql);
        return $List;
    }


    //得到推荐总数
    function GetMemberRecommendCountByTid($tid, $uid = 0)
    {
        $Model = new Model();
        $sqlcount = "SELECT count(tid) as rec FROM `pre_forum_memberrecommend` where tid=$tid";
        $sqlcountInfo = $Model->query($sqlcount);
        $rec = $sqlcountInfo[0]['rec'] ? $sqlcountInfo[0]['rec'] : 0;
        return $rec;
    }

    //得到推荐列表
    function GetMemberRecommendListByTid($tid, $limit = 5)
    {
        $arr = array();
        $sql = "SELECT r.tid,r.recommenduid,r.dateline,m.username FROM `pre_forum_memberrecommend` as r LEFT JOIN `pre_common_member` as m ON r.recommenduid=m.uid WHERE r.tid={$tid} ORDER BY r.dateline DESC limit {$limit};";
        $Model = new Model();
        $list = $Model->query($sql);

        while (list($key, $value) = each($list)) {
            $value['userface'] = "http://uc.movshow.com/avatar.php?uid=" . $value['recommenduid'] . "&size=middle";
            $arr[] = $value;
        }
        return $arr;
    }
    #帖子内容处理 END

    /*
     * 楼层回复列表数据
     */
    function GetPostListByTable($threadinfo, $wString, $orderby, $WSQ = false, $pn, $user_id)
    {
        $page = $pn * 10;
        $pageSize = ($pn + 1) * 10;
        $tablestr = "pre_forum_post";
        if ($threadinfo[posttableid] > 0) {
            $tablestr = "forum_post_" . $threadinfo[posttableid];
        }
        $postlist = $list = $postusers = array();
        $sql = "SELECT COUNT('pid') as pids FROM " . $tablestr . "  WHERE 1=1 " . $wString;
        $Model = new Model();
        $total = $Model->query($sql);
        $total = $total[0]['pids'];
        if ($total) {
            $sql = "SELECT pid,tid,fid,author,authorid,message,useip,dateline,attachment,comment,position,ratetimes FROM " . $tablestr . " WHERE 1=1 " . $wString . " ORDER BY $orderby LIMIT $page,$pageSize";
            $post = $Model->query($sql);
            $pics = $this->GetAttachListByTid($threadinfo['tid']);
            while (list($key, $value) = each($post)) {
                if ($value['position'] > 1) {
                    $value['address'] = $this->getIPLoc_sina($value['useip']);
                    if ($threadinfo['hiddenreplies'] && $user_id != $threadinfo['authorid']) {

                        $content['content'] = "此帖仅作者可见";
                        $content['coverImg'] = '';
                        $content['width'] = '';
                        $content['height'] = '';
                        $content['type'] = 'article';
                    } else {
                        $content = $this->superStr($value['message'], $value['tid'], $value['pid'], $value['attachment'], '', $pics, $user_id);
                    }
                }

                $list[$key]['message'] = $content;
                $list[$key]['addtime'] = date('Y-m-d H:i:s', $value['dateline']);
                $list[$key]['userface'] = "http://uc.movshow.com/avatar.php?uid=" . $value['authorid'] . "&size=middle";
                $list[$key]['member_adminid'] = "0";
                $list[$key]['member_groupid'] = "0";
                $list[$key]['commenttotal'] = "0";
                $list[$key]['commentarray'] = array();
                $list[$key]['ratesum'] = "0";
                $list[$key]['ratetimes'] = "0";
                $id = $value['authorid'];
                $userSql = "SELECT username FROM `pre_common_member` WHERE uid = {$id} ";
                $userInfo = $Model->query($userSql);
                $list[$key]['username'] = $userInfo['0']['username'];
                $list[$key]['address'] = $this->getIPLoc_sina($value['useip']);;
                if (empty($list[$key]['address'])) {
                    $addressSql = "select resideprovince,residecity,residedist from `pre_common_member_profile` where uid={$id} ";
                    $addressInfo = $Model->query($addressSql);
                    $addressInfo = $addressInfo[0];
                    $list[$key]['address'] = $addressInfo["resideprovince"] . $addressInfo["residecity"];
                }
            }
        }
        return $list;
    }

    /*
     * 微信小程序自动创建用户
     * @param $openid 微信ID
     * @param name 微信昵称
     */
    public function auotoUser($openid, $name)
    {
        $ModelMember = D('common_member');
        $ModelWechat = D('common_member_wechat_xcx ');
        $ModelProfile = D('common_member_profile');
        $name = $this->filter($name);
        $userInfo = $ModelMember->where(array('username' => $name))->field('uid')->find();
        if ($userInfo['uid']) {
            $name = $this->generate();
        }
        $ModelWechat->startTrans();//事务在第一个模型里启用就可以了，或者第二个也行
        $data_mem['username'] = "wx_" . $name;
        $data_mem['password'] = md5(rand(5, 15));
        $uid = $ModelMember->add($data_mem);
        $data_mem['uid'] = $uid;
        $data_xcx['openid'] = $openid;
        $data_xcx['uid'] = $uid;
        $data_xcx['status'] = 1;
        $uid_openid = $ModelWechat->add($data_xcx);

        if ($uid && $uid_openid) {
            $ModelWechat->commit();//成功则提交
            $ModelProfile->add(array('uid' => $uid, 'gender' => '0'));
            return $data_mem;
        } else {
            $ModelWechat->rollback();//不成功，则回滚
            return array();
        }


    }

    /**
     * $str  微信昵称过滤，ps隐私全部随机生成
     **/
    public function filter($str)
    {
        /*
        if ($str) {
            $name = $str;
            $name = preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '', $name);
            $name = preg_replace('/xE0[x80-x9F][x80-xBF]‘.‘|xED[xA0-xBF][x80-xBF]/S', '?', $name);
            $return = json_decode(preg_replace("#(\\\ud[0-9a-f]{3})#ie", "", json_encode($name)));
            if (strlen($return) < 4 or strlen($return) > 18) {
                $return = $this->generate();
            }
        } else {
            $return = $this->generate();
        }*/
        $return = $this->generate();
        return $return;

    }

    /*
     * 随机名称字符串
     */
    function generate($length = 9)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $string;
    }

    /*
     * 【发帖-图片绑定处理】
     */
    public function updateattach($tid, $pid, $uid, $aidlist)
    {
        $arr = explode(",", $aidlist);
        if (count($arr) == 0) {
            return '';
        }
        $where['uid'] = $uid;
        $where['aid'] = array('in', $arr);
        $newArr = M('forum_attachment_unused')->where($where)->select();
        $tableid = substr($tid, -1);
        $tableid = empty($tableid) ? 0 : $tableid;

        $Model = M('forum_attachment');
        $ModelN = M('forum_attachment_'.$tableid);
        $ModelUnused = M('forum_attachment_unused');
        foreach ($newArr as $key => $val) {
            $update = $val;
            $update['readperm'] = 0;
            $update['price'] = 0;
            $update['remote'] = 1;//远程附件FTP
            $update['tid'] = $tid;
            $update['pid'] = $pid;
            $update['uid'] = $uid;
            $update['description'] = '猫咪有约小程序帖子图片';

            $ModelN->add($update);
            $Model->where(array('aid'=>$val['aid']))->save(array('tid' => $tid, 'pid' => $pid, 'tableid' =>$tableid));
            $ModelUnused->where(array('aid'=>$val['aid']))->delete();
        }

    }

}