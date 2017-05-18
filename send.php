<?php
if(empty($fromName)) $fromName = $modx->getOption('site_name');
parse_str($_POST['str'],$out);
$subject = $out['subject'];
$fio = $out['fio'];
$email = $out['email'];
$phone = $out['phone'];

if($debug == 1) {
    $str_email = $devEmail;
}
else {
    $str_email = $emailTo;
}
$emls = explode(',', $str_email);

foreach( $emls AS $eml) {
    $eml = trim($eml);
        $message = "";
        if(!empty($email)) {
            $message .= "E-mail: {$email}<br>";
            $email_from = 'no-reply@'.$_SERVER['SERVER_NAME'];
        }
        else {
            $email_from = 'no-reply@'.$_SERVER['SERVER_NAME'];
        }
        if(!empty($fio)) {
            $message .= "Имя: {$fio}<br>";
        }
        if(!empty($phone)) {
            $message .= "Телефон: {$phone}<br>";
        }
        if(!empty($out['floor'])) {
            $message .= "Этажность: {$out['floor']}<br>";
        }
        
        if(!empty($out['foundation'])) {
            $message .= "Фундамент: {$out['foundation']}<br>";
        }
        
        if(!empty($out['matouter'])) {
            $message .= "Материал внешних стен: {$out['matouter']}<br>";
        }
        
        if(!empty($out['matinner'])) {
            $message .= "Материал внутренних стен: {$out['matinner']}<br>";
        }
        
        if(!empty($out['roof'])) {
            $message .= "Тип кровли: {$out['roof']}<br>";
        }
        if(!empty($out['prim'])) {
            $message .= "Примечание: {$out['prim']}<br>";
        }
        
        if(!empty($cart)) {
            $message .= "Ссылка на проект: <a href='".$modx->makeUrl($cart,'','','full')."' target='_blank'>".$modx->makeUrl($cart,'','','full')."</a><br>";
        }
        
        if($debug == 1) {
            $message .= implode(',', $out).'<br>';
        }
    
    if($eml == "lead@1istok.ru") {
        $message .= "Это сообщение было отправлено следующим адресатам: ".implode(', ', $emls);
    }
    
    $modx->getService('mail', 'mail.modPHPMailer');
    $modx->mail->set(modMail::MAIL_BODY,$message);
    $modx->mail->set(modMail::MAIL_FROM,$email_from);
    $modx->mail->set(modMail::MAIL_FROM_NAME, $fromName);
    $modx->mail->set(modMail::MAIL_SUBJECT,$subject);

    $modx->mail->address('to', trim($eml));
    
    
    $modx->mail->address('reply-to',$email_from);
    $modx->mail->setHTML(true);
    if (!$modx->mail->send()) {
        $modx->log(modX::LOG_LEVEL_ERROR,'An error occurred while trying to send the email: '.$modx->mail->mailer->ErrorInfo);
        
    }
    
    $modx->mail->reset();
}






echo 'true';
