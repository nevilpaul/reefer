<?php

require '../vendor/autoload.php';

$email = new \SendGrid\Mail\Mail();
$dateString = time()+1800;
$dateExpire = date('h:i:s a',$dateString);

$emailval = "nevilross2@gmail.com";
$user = "Nevil Paul";
$encryp1 = 'WebapplxeIo3';
$encryp2 = 'applxeIo254';
$val = rand(0,time());
$val = $encryp1.md5($val).$encryp2;
$salt = strip_tags($val);
$code = password_hash($salt, PASSWORD_DEFAULT);
$link = "https://localhost:3000/resetpsw?code=$code";

$email = new \SendGrid\Mail\Mail();
$email->setFrom("webappcode@bitrix24.com", "ReeferInc");
$email->setSubject("Reset Account Password | ReeferInc");
$email->addTo("$emailval", "$user");
$email->addContent("text/html", "<p>
<h3>Hello $user,</h3>
A request has been received to change the password for your ReeferPaper account.<br><a href='$link' style='box-sizing: border-box;border-color: #348eda;font-weight: 400;text-decoration: none;display: inline-block;margin: 0;color: #ffffff;background-color: #348eda;border: solid 1px #348eda;border-radius: 2px;font-size: 14px;padding: 12px 45px;'>Reset Password</a></p><p>If you did not initiate this request, please contact us immediately at support@reefer.com.</p>
<p>Thank you,</p>
<p>The SendGrid Team</p>");
$sendgrid = new \SendGrid('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');
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    // print_r($response->headers());
    // print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}
?>
