<?php
    require_once 'functions.php';
    require_once 'send_code.php';
    
    // This file runs only when the submit button is clicked i.e. the form tag's action attribute contains this file's URL
    // For managing signup
    if (isset($_GET['signup'])) { // if the URL contains localhost/CPE/?signup
        $response = validateSignupForm($_POST); // if there's no error $response would look like: ['status'=>true], otherwise it may look like ['msg'=>"Age isn't given!", 'status'=>false, 'field'=>'age']; this function runs everytime the form is submitted (as the request comes only when the form is submitted)
        if ($response['status']) { // if there's no error then just insert the user's data to the db
            if (createUser($_POST)) { // $_POST contains the user-inserted text-fields' data and other UI controls' (like list etc.) data 
                header("location:../../?login&newuser");
            }
            else {
                echo "<script>alert('Something went wrong!')</script>";
            }
        }else {  
            // Storing error related info. and user-inserted text-fields' data when there's some error, we have to store this becoz form submission reloads the page to check and display the error(s)
            $_SESSION['error'] = $response; // for storing error related information; for example $response can look like: ['msg'=>"Age isn't given!", 'status'=>false, 'field'=>'age']
            $_SESSION['formdata'] = $_POST; // storing the user-inserted form data, so if any error occurs we can still maintain form's user inserted data, this is used in showFormData() function in functions.php
            header("location:../../?signup"); // Reloading the signup page so the function calls embedded in the signup script can check and display the error(s), these functions first check if $_SESSION['error'] is set or not
        }
    }

    // For managing login
    if (isset($_GET['login'])) {
        $response = validateLoginForm($_POST);
        if ($response['status']) {
            $_SESSION['Auth'] = true; // this means the user is authorised
            $_SESSION['userdata'] = $response['user']; // saving the user data's whole column to save all the user's attributes
            if ($response['user']['ac_status'] == 0) {
                $_SESSION['code'] = $code = rand(111111, 999999);
                sendCode($response['user']['email'], "Verify Your E-mail", $code);
            }
            header("location:../../");

        }else {
            // Storing error related info. and user-inserted text-fields' data in SESSION variables when there's some error, we have to store this becoz form submission reloads the page to check and display the error(s)
            $_SESSION['error'] = $response; 
            $_SESSION['formdata'] = $_POST;
            header("location:../../?login"); // Reloading the login page so the function calls embedded in the login script can check and display the error(s), these functions first check if $_SESSION['error'] is set or not
        }
    }

    if (isset($_GET['resend_code'])) {
        $_SESSION['code'] = $code = rand(111111, 999999);
        sendCode($_SESSION['userdata']['email'], "Verify Your E-mail", $code);
        header("location: ../../?resent");
    }

    if (isset($_GET['verify_email'])) {
        $user_code = $_POST['code'];
        $code = $_SESSION['code'];
        if ($code == $user_code) {
            if(verifyEmail($_SESSION['userdata']['email'])){
                header("location:../../");
            }else{
                echo "SOMETHING WENT WRONG";
            }

        } else{
            $response['msg'] = "Incorrect verification code!";
            if (!$_POST['code']) {
                $response['msg'] = "Please enter the 6-digit code.";   
            }
            $response['field'] = 'email_verify';
            $_SESSION['error'] = $response; 
            header("location: ../../");
        }

    }

    if (isset($_GET['forgotpassword'])) {
        if (!$_POST['email']) {
            $response['msg'] = "Enter your e-mail id.";
            $response['field'] = 'email';
            $_SESSION['error'] = $response;
            header("location: ../../?forgotpassword");

        }elseif (!emailExists($_POST['email'])) { 
            $response['msg'] = "This e-mail id is not registered with us!";
            $response['field'] = 'email';
            $_SESSION['error'] = $response;
            header("location: ../../?forgotpassword");

        }else {
            $_SESSION['forgot_email'] = $_POST['email'];
            $_SESSION['forgot_code'] = $code = rand(111111, 999999);
            sendCode($_POST['email'], "Forgot Password? Use this code to recover", $code);
            header("location: ../../?forgotpassword&resent");
        }
    }

    // For logging the user out
    if(isset($_GET['logout'])){
        session_destroy();
        header("location: ../../");
    }

    // for verifying forgot code
    if (isset($_GET['verifycode'])) {
        $user_code = $_POST['code'];
        $code = $_SESSION['forgot_code'];
        if ($code == $user_code) {
            $_SESSION['auth_temp'] = true;
            header("location:../../?forgotpassword");
        
        } else{
            $response['msg'] = "Incorrect verification code!";
            if (!$_POST['code']) {
                $response['msg'] = "Please enter the 6-digit code.";   
            }
            $response['field'] = 'email_verify';
            $_SESSION['error'] = $response; 
            header("location: ../../?forgotpassword");
        }

    }

    if (isset($_GET['changepassword'])) {
        if (!$_POST['password']) {
            $response['msg'] = "Please enter your new password";
            $response['field'] = 'password';
            $_SESSION['error'] = $response;
            header("location: ../../?forgotpassword");
        }else {
            if (resetPassword($_SESSION['forgot_email'], $_POST['password'])) {
                header("location:../../?reseted");          
            }else {
                echo "Can't change pasword!";
            }
        }
    }

    if (isset($_GET['updateprofile'])) {
        $response = validateUpdateForm($_POST, $_FILES['profile_pic']);
        if ($response['status']) {
            if (updateProfile($_POST, $_FILES['profile_pic'])) {
                header("location:../../?editprofile&success");
            }else {
                echo "Something went wrong";
            } 
        }else{  
            $_SESSION['error'] = $response;
            header("location:../../?editprofile");
        }
    }

    // for managing create post request
    if (isset($_GET['addpost'])) {
        $response = validatePostImage($_FILES['post_img']);

        if ($response['status']) {
            if (createPost($_POST, $_FILES['post_img'], $_SESSION['user']['city'])) {
                header("location:../../?new_post_added"); 
                
            }else {
                echo "Something went wrong";
            }
        }else {
            $_SESSION['error'] = $response;
            header("location:../../"); 
        }
    }

    if (isset($_GET['delpost'])) {
        $post_id = $_GET['delpost'];
        if(deletePost($post_id)){
            header("location:{$_SERVER['HTTP_REFERER']}");
        }else{
            echo "Something went wrong";
        }
    }

    // for reporting a post
    if (isset($_GET['reportPost'])) {
        $post_id = $_SESSION['report_postId']; 
        $post_header = $_SESSION['report_postHeader'];
        $user_id = $_SESSION['user']['user_id'];  
        $user_email = $_POST['user_email'];
        $user_name = $_POST['user_name'];
        $uploader_name = $_POST['uploader_name'];

        foreach ($_POST['report_options'] as $option) {
            $report_reason = $option;
        }

        $message = "I (user id: <b>'$user_id'</b>) have reported a post uploaded by <b>\"$uploader_name\"</b> with post id - <b>'$post_id'</b> whose header is - <b>\"$post_header\"</b> which I gave a flag of - <b>'$report_reason'.</b>";

        if (!empty($_POST['report_description'])) {
            $message .= " I further added this description about the report - <b>\"".$_POST['report_description']."\"</b>";
        }

        if(reportPost($user_email, $message, $user_name)){
            header("location: ../../");
        }else{
            echo "Something went wrong";
        }
    }    
?>