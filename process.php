<?php
require_once('../includes/config.php');
require_once('../includes/PHPMailer/class.phpmailer.php');
require_once('../includes/formvalidator.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
      
    $validator = new FormValidator();
    
    $validator->addRule('name', 'This field is required.', 'required');
    $validator->addRule('email', 'This field is required.', 'required');
    $validator->addRule('email', ' Invalid email address.', 'email');
    $validator->addRule('message', 'This field is required.', 'required');
    
    $validator->addEntries($_POST);
    $validator->validate();
    $entries = $validator->getEntries();
    
    if (!$validator->foundErrors()) {
        
        $formOK = true;        
        // Passing true causes PHPMailer to throw exceptions
        $mail = new PHPMailer(true);
        try {
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            $mail->Host = MAIL_HOST;
            $mail->Port = MAIL_PORT;
            $mail->Username = MAIL_USER;
            $mail->Password = MAIL_PASS;
            $mail->AddReplyTo($entries['email'], $entries['name']);
            $mail->SetFrom(MAIL_USER, $entries['name']);
            $mail->Subject = "Contact Form Submission";
            $mail->Body = $entries['message'];
            $mail->AddAddress(MAIL_ADDR, "Christopher Wojcik");
            $mail->Send();
            
            echo "Thank you! Your email has been submitted.";
        }
        catch (phpmailerException $e) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "We're sorry, your email could not be sent. Please try again later.";
            exit();
        }
    }
    else {
        $formOK = false;
        $errors = $validator->getErrors();
    }
    
    //if this is not an ajax request  
    if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'){  
        session_start();  
        $return_data = array(
            'formOK'  => $formOK,
            'errors'  => $errors,
            'entries' => $entries
        );
        $_SESSION['return_data']  = $return_data;
        header('Location: ' . BASE_URL . '#contact');
        exit();
    } 
}
else {
    header('Location: ' . BASE_URL);
    exit();
}