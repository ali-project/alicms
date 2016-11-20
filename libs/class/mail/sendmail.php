<?php

include_once 'aliyun-php-sdk-core/Config.php';

use Dm\Request\V20151123 as Dm;

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $subject = $_GET['subject'];
    $body = $_GET['body'];
} else if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
}






$iClientProfile = DefaultProfile::getProfile("cn-beijing", "", "");
$client = new DefaultAcsClient($iClientProfile);
$request = new Dm\SingleSendMailRequest();
$request->setAccountName("no-reply@mail.9hlh.com");
$request->setAddressType(1);
$request->setTagName("test");
$request->setReplyToAddress("true");
$request->setToAddress($email);
$request->setSubject($subject);
$request->setHtmlBody($body);
$response = $client->getAcsResponse($request);
print_r($response);

