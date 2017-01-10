<?php

 function getVersion()
{
    return "2.0.7";
}



/**
 * 根据cid获取相对表名称
 */
function aligettablebycid($cid)
{
    $db = load_class("mydb","alicms");

    $c['cid'] = $cid ;
    $result = $db->where($c)->getall("category");
    $modelid = $result[0]['modelid'];
    $d['modelid'] = $modelid ;
    $result = $db->where($d)->getall("model");
    $tablename[0] = $result[0]['master_table'];
    $tablename[1] = $result[0]['attr_table'];

    return $tablename ;
}

/**
 * 格式化数组
 * @param $var
 * @param bool $echo
 * @param null $label
 * @param bool $strict
 * @return mixed|null|string
 */
function alidump($var, $echo=true, $label=null, $strict=true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}

/**
 * 设置和获取文章阅读数
 * @param $cid
 * @param $id
 */
function setgetviews($cid,$id)
{
    
    //content_rank
    $db = load_class("mydb","alicms");
    $c['cid'] = $cid;
    $c['id'] = $id;
    $result = $db->where($c)->getall("content_rank");
    if(count($result)==0){
        $db->add("content_rank",$c);
    }
    $d['views'] = $result[0]["views"]+1;
    $db->where($c)->save("content_rank",$d);


    return  array("status"=>0,"views"=>$result[0]['views']);
}

function alikeyvalue($cid,$field,$value)
{
    //根据cid获取到model
    $db = load_class("mydb","alicms");

    $c['cid'] = $cid ;
    $result = $db->begin()->where($c)->getall("category");
    $d['modelid'] = $result[0]['modelid'];
    $d['field'] = $field;
    $result = $db->begin()->where($d)->getall("model_field");
    $temp = $result[0]['setting'];

    $setting = unserialize($temp);
    $setting = $setting['options'];
    $arr = $arr = explode("\n",$setting);

    $array = array();
    foreach($arr as $t)
    {
        $arr2 = explode("|",$t);

        $array[str_replace(" ","",str_replace(chr(13),chr(32),$arr2[1]))]=$arr2[0] ;

    }

    return($array[$value]);






}

/**
 * 带附件的邮件发送
 * @param $to
 * @param $subject
 * @param $body
 * @param null $att
 * @return bool
 */
function alisend_mail($to,$subject,$body,$att=null) {
    if($to=='') return false;
    require_once COREFRAME_ROOT.'extend/class/PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $config = get_cache('sendmail');

    $password = decode($config['password']);
    $smtp_server = $config['smtp_server'];
    $smtp_user = $config['smtp_user'];
    $send_email = $config['send_email'];
    $smtp_port = $config['smtp_port'];

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->CharSet    ="UTF-8";
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $smtp_server;  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $smtp_user;                 // SMTP username
    $mail->Password = $password;                           // SMTP password
    $mail->SMTPSecure = $config['openssl'] ? 'ssl' : '';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = $smtp_port;                                    // TCP port to connect to

    $mail->setFrom($send_email, $config['nickname']);
    $mail->isHTML(true);
    $emails = explode(';',$to);
    foreach($emails as $_to) {
        $tmp_body = str_replace('TO_EMAIL',$_to,$body);
        $mail->addAddress($_to);
        $mail->Subject = $subject;
        $mail->Body    = $tmp_body;

        if($att!=null){
            foreach ($att as $a)
            {
                $mail->addAttachment($a['path'],$a['name']);
                
            }
        }


        if(!$mail->send()) {
            return false;
        }
    }
}


function alipinyin($_String, $_Code='UTF-8')
{
    $_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".
        "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".
        "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".
        "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".
        "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".
        "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".
        "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".
        "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".
        "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".
        "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
        "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".
        "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".
        "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".
        "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".
        "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".
        "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";
    $_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".
        "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".
        "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".
        "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".
        "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".
        "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".
        "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".
        "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".
        "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".
        "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".
        "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".
        "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".
        "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".
        "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".
        "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".
        "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".
        "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".
        "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".
        "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".
        "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".
        "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".
        "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".
        "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".
        "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".
        "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".
        "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".
        "|-10270|-10262|-10260|-10256|-10254";
    $_TDataKey = explode('|', $_DataKey);
    $_TDataValue = explode('|', $_DataValue);
    $_Data = (PHP_VERSION>='5.0') ? array_combine($_TDataKey, $_TDataValue) : _Array_Combine($_TDataKey, $_TDataValue);
    arsort($_Data);
    reset($_Data);
    if($_Code != 'gb2312') $_String = _U2_Utf8_Gb($_String);
    $_Res = '';
    for($i=0; $i<strlen($_String); $i++)
    {
        $_P = ord(substr($_String, $i, 1));
        if($_P>160) { $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536; }
        $_Res .= _Pinyin($_P, $_Data);
    }
    return preg_replace("/[^a-z0-9]*/", '', $_Res);
}
function _Pinyin($_Num, $_Data)
{
    if ($_Num>0 && $_Num<160 ) return chr($_Num);
    elseif($_Num<-20319 || $_Num>-10247) return '';
    else {
        foreach($_Data as $k=>$v){ if($v<=$_Num) break; }
        return $k;
    }
}
function _U2_Utf8_Gb($_C)
{
    $_String = '';
    if($_C < 0x80) $_String .= $_C;
    elseif($_C < 0x800)
    {
        $_String .= chr(0xC0 | $_C>>6);
        $_String .= chr(0x80 | $_C & 0x3F);
    }elseif($_C < 0x10000){
        $_String .= chr(0xE0 | $_C>>12);
        $_String .= chr(0x80 | $_C>>6 & 0x3F);
        $_String .= chr(0x80 | $_C & 0x3F);
    } elseif($_C < 0x200000) {
        $_String .= chr(0xF0 | $_C>>18);
        $_String .= chr(0x80 | $_C>>12 & 0x3F);
        $_String .= chr(0x80 | $_C>>6 & 0x3F);
        $_String .= chr(0x80 | $_C & 0x3F);
    }
    return iconv('UTF-8', 'GB2312', $_String);
}
function _Array_Combine($_Arr1, $_Arr2)
{
    for($i=0; $i<count($_Arr1); $i++) $_Res[$_Arr1[$i]] = $_Arr2[$i];
    return $_Res;
}
















/**
 * 增加一个新的自定义字段数据
 * @param $c
 */
function saveziduan($c){
    $mydb = load_class("mydb","api");

    $table = $c['table'];
    $d['dbname'] = $table ;
    $cums = $mydb->begin()->where($d)->getall("ziduanx");
    $dbs = $mydb->begin()->where($d)->getall("ziduan");
    $subject = "自定义字段【".$dbs[0]["discribe"]."】有新的信息";
    $tomail = $dbs[0]["targetmail"];
    //echo $subject ;
    $body = "";
    foreach ($cums as $r)
    {
        $body .= $r['dbdescribe']."(".  $r['dbcum'].")=>".$c[$r['dbcum']]."<br>";
        $c[$r['dbcum']]= $c[$r['dbcum']];
    }
    $c['createtime'] = date('Y-m-d H:i:s',time());
    //echo $body ;
    $uid = get_cookie('_uid');
    if($uid){
        $c['uid']=$uid;
    }
    $mydb->add($table,$c);

    if($dbs[0]["tixing"]==1)
    {
        load_function('sendmail');
        $mailarr = explode(";", $tomail);
        foreach ($mailarr as $mails) {
            send_mail($mails,$subject,$body);
        }
    }else if($dbs[0]["tixing"]==2)
    {
        $send = load_class("Mail","api");

        $mailarr = explode(";", $tomail);
        foreach ($mailarr as $mails) {
            $send->send($mails,$subject,$body);
        }
    }



}



