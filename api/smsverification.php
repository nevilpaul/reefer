<?php
require __DIR__ .'\vendor\autoload.php';
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$account_sid = 'AC786089b58afcd57badb189c033349fdc';
$auth_token = 'bc1b1e1a2c08abaf70b9fd24a1462cb3';
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

// A Twilio number you own with SMS capabilities
$twilio_number = "+18595442314";

$client = new Client($account_sid, $auth_token);
$client->messages->create(
    // Where to send a text message (your cell phone?)
    '+254701753461',
    array(
        'from' => $twilio_number,
        'body' => 'your verification code is 34dfE34!'
    )
);