<?php
if( isset($_POST) ){
     
    //form validation vars
    $formok = true;
    $errors = array();
     
    //sumbission data
    $ipaddress = $_SERVER['REMOTE_ADDR']; // get IP address of the visitor
    $date = date('d/m/Y'); // get the date
    $time = date('H:i:s'); // and the time they connected
     
    //form data
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $email = $_POST['emailaddress'];
//    $telephone = $_POST['telephone'];
//    $enquiry = $_POST['enquiry'];
//    $message = $_POST['message'];
     
    //form validation to go here....
    
    //validate the name
    if (empty($fname) || empty($lname) ) {
        $formok = false;
        $errors[] = "You have not entered a complete name";
    }
    
    // validate that we have an email address
    
    if (empty($email)) {
        $formok = false;
    	  $errors[] = "You have not entered an email address";
    //validate email address is valid
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $formok = false;
        $errors[] = "You have not entered a valid email address";
    }
    
    if($formok) {
        $headers = "From: website@antonygordon.net" . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
     
        $emailbody = "<p>You have recieved a new message from the enquiries form on your website.</p>
                  <p><strong>Name: </strong> {$fname} {$lname} </p>
                  <p><strong>Email Address: </strong> {$email} </p>
                  <p>This message was sent from the IP Address: {$ipaddress} on {$date} at {$time}</p>";
     
        mail("cuzintone@gmail.com","Mailing List",$emailbody,$headers);
     
    }
    
    //what we need to return back to our form
    $returndata = array(
        'posted_form_data' => array(
            'firstname' => $fname,
            'lastname' => $lname,
            'email' => $email,
//            'telephone' => $telephone,
//            'enquiry' => $enquiry,
//            'message' => $message
        ),
        'form_ok' => $formok,
        'errors' => $errors
    );
         
     
    //if this is not an ajax request
    if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'){
        //set session variables
        session_start();
        $_SESSION['cf_returndata'] = $returndata;
         
        //redirect back to form
        header('location: ' . $_SERVER['HTTP_REFERER']);
    }
}