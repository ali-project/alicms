<?php
include_once 'aliyun-php-sdk-core/Config.php';
    use Dm\Request\V20151123 as Dm;            
    $iClientProfile = DefaultProfile::getProfile("cn-beijing", "", "");
    $client = new DefaultAcsClient($iClientProfile);    
    $request = new Dm\SingleSendMailRequest();     
    $request->setAccountName("no-reply@mail.9hlh.com");
    $request->setAddressType(1);
    $request->setTagName("test");
    $request->setReplyToAddress("true");
    $request->setToAddress($_POST['email']);
    $request->setSubject($_POST['subject']);
    $request->setHtmlBody($_POST['body']);        
    $response = $client->getAcsResponse($request);    
    print_r($response);  

