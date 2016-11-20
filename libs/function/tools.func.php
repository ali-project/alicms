<?php

 function getVersion()
{
    return "2.0.2";
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
    $d['views'] = $result[0]["views"]+1;
    $db->where($c)->save("content_rank",$d);


    return  array("status"=>0,"views"=>$result[0]['views']);
}

function alikeyvalue($cid,$field,$value)
{
    //根据cid获取到model
    $db = load_class("mydb","alicms");

    $c['cid'] = $cid ;
    $result = $db->where($c)->getall("category");
    $d['modelid'] = $result[0]['modelid'];
    $d['field'] = $field;
    $result = $db->where($d)->getall("model_field");
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






