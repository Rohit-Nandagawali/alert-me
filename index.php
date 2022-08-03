<?php 
    // This is the master file
    require_once "assets/php/functions.php";
    
    if (isset($_GET['newfp'])) {
        unset($_SESSION['auth_temp']);
        unset($_SESSION['forgot_email']);
        unset($_SESSION['forgot_code']);
    }
    if (isset($_SESSION['Auth'])) {
        $user = getUser($_SESSION['userdata']['user_id']); // getting real-time user data
        $_SESSION['user'] = $user;
        $posts = getPosts();
    }

    $pagecount = count($_GET);

    // managing pages
    if(isset($_SESSION['Auth']) and $user['ac_status'] == 1 and !$pagecount){
        showPage("header", ['page_title'=>$user['city']."'s Posts - AlertMe"]);
        showPage("navbar");
        showPage("home");
    }elseif(isset($_SESSION['Auth']) and $user['ac_status'] == 0 and !$pagecount){
        showPage("header", ['page_title'=>"Verify Your E-mail - AlertMe"]);
        showPage("verify_email");
    }elseif(isset($_SESSION['Auth']) and $user['ac_status'] == 2 and !$pagecount){
        showPage("header", ['page_title'=>"Blocked Account"]);
        showPage("blocked");
    }elseif (isset($_SESSION['Auth']) and isset($_GET['editprofile']) and $user['ac_status'] == 1) {
        showPage("header", ['page_title'=>"Edit Profile - AlertMe"]);
        showPage("navbar");
        showPage("edit_profile");
    }elseif (isset($_SESSION['Auth']) and isset($_GET['u']) and $user['ac_status'] == 1) {
        $profile = getUserByUsername($_GET['u']);
        if (!$profile) {
            showPage("header", ['page_title'=>"User Not Found"]);
            showPage("navbar");
            showPage("user_not_found");
            
        }else {
            $profile['subscribers'] = getSubscribers($profile['user_id']);
            $profile['subscribed'] = getSubscribed($profile['user_id']);
            $profilePost = getPostsById($profile['user_id']);
            showPage("header", ['page_title'=>$profile['f_name'].' '.$profile['l_name']."'s Profile - AlertMe"]);
            showPage("navbar");
            showPage("profile");
        }
    } elseif (isset($_GET['signup'])) { 
        showPage("header", ['page_title'=>"SignUp - AlertMe"]);
        showPage("signup");
    } elseif (isset($_GET['login'])) {
        showPage("header", ['page_title'=>"Login - AlertMe"]);
        showPage("login");
    } elseif (isset($_GET['forgotpassword'])) {
        showPage("header", ['page_title'=>"Forgot password - AlertMe"]);
        showPage("forgot_password");
    }else {
        if (isset($_SESSION['Auth']) and $user['ac_status'] == 1) {
            showPage("header", ['page_title'=>$user['city']."'s Posts - AlertMe"]);
            showPage("navbar");
            showPage("home"); 
        }elseif(isset($_SESSION['Auth']) and $user['ac_status'] == 0){
            showPage("header", ['page_title'=>"Verify Your E-mail - AlertMe"]);
            showPage("verify_email");
        }elseif(isset($_SESSION['Auth']) and $user['ac_status'] == 2){
            showPage("header", ['page_title'=>"Blocked Account"]);
            showPage("blocked");
        }else {
            showPage("header", ['page_title'=>"Login - AlertMe"]);
            showPage("login");
        }
    }
    showPage("footer");  
    // These session variables are set in actions.php as it handles the form submit requests and error handling; so these session variables are not even created until the user submits the form and after submission there's some error
    // we are not destroying the whole session and unsetting particular session variables becoz we need this session for login & other uses too
    unset($_SESSION['error']); // unsetting $_SESSION['error'] because we no longer need it
    unset($_SESSION['formdata']); // unsetting $_SESSION['formdata'] because we don't want to maintain the user-inserted data even after page reload as this would be a security flaw
?>