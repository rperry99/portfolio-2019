<?php

// Configure Everything
$from = 'Contact form <contact@russperry.tech>';
$sendTo = 'Contact form <rperry1886@gmail.com>';
$subject = 'Hey Russ, I am reaching out.';
$fields = array('name' => 'Name', 'surname' => 'Surname', 'need' => 'Need', 'email' => 'Email', 'message' => 'Message');
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you as soon as possible!';
$errorMessage = 'There was an error while submitting the form. Please try again later.';

// Send the email
error_reporting(E_ALL & ~E_NOTICE);
try{
    if(count($_POST) == 0) throw new \Exception('Form is empty');
    $emailText = 'You have a new message from your contact form\n===========================\n';
    foreach($_POST as $key => $value){
        // If the fields exist in the $fields array, include it in the email
        if(isset($fields[$key])){
            $emailText .= '$fields[$key]: $value\n';
        }
    }

    // All of the headers for the email
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );

    // Send Email
    mail($sendTo, $subject, $emailText, implode('\n', $headers));
    $responseArray = array('type' => 'success', 'message' => $okMessage);
} catch (\Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

// If requested by AJAX, request return JSON response
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    header('Content-Type: application/json');
    echo $encoded;
} else {
    echo $responseARray['message'];
}