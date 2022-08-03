<?php
    require_once 'config.php';
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Couldn't  connect to database!"); 

    // function for showing pages
    function showPage($page, $data=""){
        include("assets/pages/$page.php");
    }

    function deletePost($post_id){
        global $db;
        $user_id = $_SESSION['userdata']['user_id'];
        $dellike = "DELETE FROM likes WHERE post_id=$post_id && user_id=$user_id";
        mysqli_query($db, $dellike);
        $delcom = "DELETE FROM comments WHERE post_id=$post_id && user_id=$user_id";
        mysqli_query($db, $delcom);
        $not = "UPDATE notifications SET read_status=2 WHERE post_id=$post_id && to_user_id=$user_id";
        mysqli_query($db, $not);
    
        $query = "DELETE FROM posts WHERE post_id=$post_id";
        return mysqli_query($db, $query);
    }

    //for getting post
    function getPosterId($post_id){
        global $db;
        $query = "SELECT user_id FROM posts WHERE post_id=$post_id";
        $run = mysqli_query($db,$query);
        return mysqli_fetch_assoc($run)['user_id'];

    }

    //function for creating notifications
    function createNotification($from_user_id,$to_user_id,$msg,$post_id=0){
        global $db;
        $query="INSERT INTO notifications(from_user_id,to_user_id,message,post_id) VALUES($from_user_id,$to_user_id,'$msg',$post_id)";
        mysqli_query($db,$query);    
    }

    //get notifications
    function getNotifications(){
        global $db;
        $cu_user_id = $_SESSION['userdata']['user_id'];
        $query="SELECT * FROM notifications WHERE to_user_id=$cu_user_id ORDER BY id DESC";
        $run = mysqli_query($db,$query);
        return mysqli_fetch_all($run,true);
    }

    // for getting unread notifications count
    function getUnreadNotificationsCount(){
        $cu_user_id = $_SESSION['userdata']['user_id'];
        global $db;
        $query="SELECT count(*) as row FROM notifications WHERE to_user_id = $cu_user_id && read_status=0 ORDER BY id DESC";
        $run = mysqli_query($db,$query);
        return mysqli_fetch_assoc($run)['row'];
    }

    function setNotificationStatusAsRead(){
    $cu_user_id = $_SESSION['userdata']['user_id'];
       global $db;
       $query="UPDATE notifications SET read_status=1 WHERE to_user_id=$cu_user_id";
       return mysqli_query($db,$query);
    }    

    //for searching the users
    function searchUser($keyword){
    global $db;
    $current_city = $_SESSION['user']['city'];
    $query = "SELECT * FROM users WHERE  city = '$current_city' AND (f_name LIKE '%".$keyword."%' || l_name LIKE '%".$keyword."%') LIMIT 5";
    $run = mysqli_query($db,$query);
    return mysqli_fetch_all($run,true);

    }

    // function for subscribing the user
    function subscribeUser($user_id){
        global $db;
        $current_user = $_SESSION['userdata']['user_id'];
        $query = "INSERT INTO subscribers_list(subscriber_id,user_id) VALUES($current_user, $user_id)";

        createNotification($current_user,$user_id,"subscribed you!");
        return mysqli_query($db, $query);
        
    }

    // function for checking like status
    function checkLikeStatus($post_id){
        global $db;
        $current_user = $_SESSION['userdata']['user_id'];
        $query = "SELECT count(*) as row FROM likes WHERE user_id = $current_user AND post_id = $post_id";
        $run = mysqli_query($db, $query);
        return mysqli_fetch_assoc($run)['row'];
    }
    
    // function for checking dislike status
    function checkDislikeStatus($post_id){
        global $db;
        $current_user = $_SESSION['userdata']['user_id'];
        $query = "SELECT count(*) as row FROM dislikes WHERE user_id = $current_user AND post_id = $post_id";
        $run = mysqli_query($db, $query);
        return mysqli_fetch_assoc($run)['row'];
    }

    // function for liking the post
    function like($post_id){
        global $db;
        $current_user = $_SESSION['userdata']['user_id'];
        $query = "INSERT INTO likes(post_id,user_id) VALUES($post_id, $current_user)";

        $poster_id = getPosterId($post_id);
        if($poster_id!=$current_user){
            createNotification($current_user,$poster_id,"liked your post!",$post_id);
        }

        return mysqli_query($db, $query);
    }

    // function for liking the post
    function dislike($post_id){
        global $db;
        $current_user = $_SESSION['userdata']['user_id'];
        $query = "INSERT INTO dislikes(post_id,user_id) VALUES($post_id, $current_user)";
        return mysqli_query($db, $query);
    }    

    // function for commenting 
    function addComment($post_id, $comment){
        global $db;
        $comment = mysqli_real_escape_string($db, trim($comment));
        $current_user = $_SESSION['userdata']['user_id'];
        $query = "INSERT INTO comments(user_id,post_id,comment) VALUES($current_user, $post_id, '$comment')";
        $poster_id = getPosterId($post_id);

        if($poster_id!=$current_user){
            createNotification($current_user,$poster_id,"commented on your post",$post_id);
        }
        return mysqli_query($db, $query);
    }

    // functions for getting comments count
    function getComments($post_id){
        global $db;
        $query = "SELECT * FROM comments WHERE post_id = $post_id";
        $run = mysqli_query($db, $query);
        return mysqli_fetch_all($run, true);        
    }

    // functions for getting likes count
    function getLikes($post_id){
        global $db;
        $query = "SELECT * FROM likes WHERE post_id = $post_id";
        $run = mysqli_query($db, $query);
        return mysqli_fetch_all($run, true);        
    }
    
    // functions for getting dislikes count
    function getDislikes($post_id){
        global $db;
        $query = "SELECT * FROM dislikes WHERE post_id = $post_id";
        $run = mysqli_query($db, $query);
        return mysqli_fetch_all($run, true);        
    }

    // function for unliking the post
    function unlike($post_id){
        global $db;
        $current_user = $_SESSION['userdata']['user_id'];
        $query = "DELETE FROM likes WHERE user_id = $current_user AND post_id = $post_id";
        return mysqli_query($db, $query);
    }
    
    // function for unliking the post
    function undislike($post_id){
        global $db;
        $current_user = $_SESSION['userdata']['user_id'];
        $query = "DELETE FROM dislikes WHERE user_id = $current_user AND post_id = $post_id";
        return mysqli_query($db, $query);
    }

    // function for deleting a post
    function delpost($post_id){
        global $db;
        $query = "DELETE FROM posts WHERE post_id = $post_id";
        return mysqli_query($db, $query);
    }

    // function for unsubscribing the user
    function unSubscribeUser($user_id){
        global $db;
        $current_user = $_SESSION['userdata']['user_id'];
        $query = "DELETE FROM subscribers_list WHERE subscriber_id = '$current_user' AND user_id = '$user_id'";
        return mysqli_query($db, $query);
    }

    // for getting subscribers count
    function getSubscribers($user_id){
        global $db;
        $query = "SELECT * FROM subscribers_list WHERE user_id = $user_id";
        $run = mysqli_query($db, $query);
        return mysqli_fetch_all($run, true);
    }
    
    // for getting subscribed count
    function getSubscribed($user_id){
        global $db;
        $query = "SELECT * FROM subscribers_list WHERE subscriber_id = '$user_id'";
        $run = mysqli_query($db, $query);
        return mysqli_fetch_all($run, true);
    }
    
    // function for showing errors
    function showError($field, $color = "danger"){
        if (isset($_SESSION['error'])) { // for example $_SESSION['error'] can look like: ['msg'=>"Age isn't given!", 'status'=>false, 'field'=>'age']
            $error = $_SESSION['error'];
            if (isset($error['field']) && $field == $error['field']) { // we are checking if $error['field'] is set becoz at the end of index.php we are unsetting $_SESSION['error']
                ?>
                    <div class="alert alert-<?=$color?> my-2" role="alert">  
                    <?=$error['msg']?>
                    </div>
                <?php
            }
        }
    }

    // function for maintaining user-inserted form data even after the error occurs (when the error occurs the form is reloaded as form submission occurs)
    function showFormData($field){
        if (isset($_SESSION['formdata'])) { // if any error occurs then only $_SESSION['formdata'] is set tomaintain the user-inseted form data
            $formdata = $_SESSION['formdata'];
            return $formdata[$field];
        }
    }

    // For checking duplicate email
    function emailExists($email){
        global $db;
        $query = "SELECT count(*) as row FROM users WHERE email = '$email'";
        $run = mysqli_query($db, $query);
        $return_data = mysqli_fetch_assoc($run);
        return $return_data['row']; // if there are some rows already with this user-inserted email then return the count of them
    }

    // Check if username already exists
    function usernameExists($fname, $lname){
        global $db;
        $query = "SELECT count(*) as row FROM users WHERE f_name = '$fname' AND l_name = '$lname'";
        $run = mysqli_query($db, $query);
        $return_data = mysqli_fetch_assoc($run);
        return $return_data['row']; // if there are some rows already with this user-inserted first & last name then return the count of them
    }

    // Check if this username is already registered by any another user or not
    function usernameExistsOfOther($fname, $lname){
        global $db;
        $user_id = $_SESSION['userdata']['user_id'];
        $query = "SELECT count(*) as row FROM users WHERE f_name = '$fname' AND l_name = '$lname' AND user_id != $user_id";
        $run = mysqli_query($db, $query);
        $return_data = mysqli_fetch_assoc($run);
        return $return_data['row']; // if there are some rows already with this user-inserted first & last name then return the count of them
    }

    // for validating signup only when submit button is clicked
    function validateSignupForm($form_data){
        $response = [];
        $response['status'] = true;
        if (!$form_data['age']) {
            $response['msg'] = "Age isn't given!";
            $response['status'] = false;
            $response['field'] = 'age';
        }
        
        if (!$form_data['pass']) {
            $response['msg'] = "Password isn't given!";
            $response['status'] = false;
            $response['field'] = 'pass';
        }

        if (!$form_data['email']) {
            $response['msg'] = "E-mail isn't given!";
            $response['status'] = false;
            $response['field'] = 'email';
        }

        if (!$form_data['lname']) {
            $response['msg'] = "Last name isn't given!";
            $response['status'] = false;
            $response['field'] = 'lname';
        }
        
        if (!$form_data['fname']) {
            $response['msg'] = "First name isn't given!";
            $response['status'] = false;
            $response['field'] = 'fname';
        }
        
        if (emailExists($form_data['email'])) { // this body will run only if the user-inserted email already exists i.e. the emailExists() returns some integer value (row count of matching email) other than 0 - as it's treated as false 
            $response['msg'] = "This e-mail id is already registered with us!";
            $response['status'] = false;
            $response['field'] = 'email';
        }

        if (usernameExists($form_data['fname'], $form_data['lname'])) { // this body will run only if the user-inserted first name and last name already exists
            $response['msg'] = "This username is already registered with us!";
            $response['status'] = false;
            $response['field'] = 'fname';
        }
        return $response;
    }

    // for validating login only when submit button is clicked; this function is called repetitively when the the submit button is clicked repetitively
    function validateLoginForm($form_data){ // $form_data is nothing but $_POST associative array
        $response = [];
        $response['status'] = true;
        $blank = false; // to check if form is filled or not
        if (!$form_data['pass']) {
            $response['msg'] = "Password isn't given!";
            $response['status'] = false;
            $response['field'] = 'pass';
            $blank = true;
        }

        if (!$form_data['email']) {
            $response['msg'] = "E-mail isn't given!";
            $response['status'] = false;
            $response['field'] = 'email';
            $blank = true;
        }

        if (!$blank and !checkUser($form_data)['status']) { // checking for the user's credentials only when the form is not empty
            $response['msg'] = "Login credentials are incorrect!";
            $response['status'] = false;
            $response['field'] = 'checkuser';
        }else {
            $response['user'] = checkUser($form_data)['user'];
        }

        return $response;
    }
    
    // for checking the user info (login)
    function checkUser($login_data){ // $login_data is nothing but $_POST associative array
        global $db;
        $email = $login_data['email'];
        $pass = md5($login_data['pass']);
        $query = "SELECT * FROM users WHERE email = '$email' AND u_pwd='$pass'";
        $run = mysqli_query($db, $query);
        $data['user'] = mysqli_fetch_assoc($run)??[];
        if (count($data['user']) > 0) { // if some user matches the email & password then only the status will be true
            $data['status'] = true;
        } else {
            $data['status'] = false; // status will be false when the user details don't match any record
        }

        return $data;
    }

    // for getting the user info using his/her id
    function getUser($user_id){ 
        global $db;
        $query = "SELECT * FROM users WHERE user_id = '$user_id'";
        $run = mysqli_query($db, $query);
        return mysqli_fetch_assoc($run);
    }  
    
    // for getting the userdata by username
    function getUserByUsername($username){ 
        global $db;
        $ary = explode("_", $username);
        $fname = $ary[0];
        $lname = $ary[1];
        $query = "SELECT * FROM users WHERE f_name = '$fname' AND l_name = '$lname'";
        $run = mysqli_query($db, $query);
        return mysqli_fetch_assoc($run);
    }        
    
    // for getting posts
    function getPosts(){ 
        global $db;
        global $user;
        $city = $user['city'];
        $query = "SELECT posts.post_id, posts.user_id, posts.images, posts.post_header, posts.posted_on, posts.post_location, posts.real_count, posts.fake_count, posts.share_count, posts.comments_count, users.f_name, users.l_name, users.pfp, users.verified FROM posts JOIN users ON (users.user_id = posts.user_id) WHERE (users.city = '$city' AND posts.post_city = '$city') ORDER BY post_id DESC ;";
        $run = mysqli_query($db, $query);
        return mysqli_fetch_all($run, true);
    }  

    // for getting posts by user id
    function getPostsById($user_id){ 
        global $db;
        global $user;
        $city = $user['city'];
        $query = "SELECT * FROM posts WHERE user_id = '$user_id' AND post_city = '$city' ORDER BY post_id";
        $run = mysqli_query($db, $query);
        return mysqli_fetch_all($run, true);
    }  

    // for checking if a user is subscribed by current user or not
    function checkSubscribeStatus($user_id){
        global $db;
        $current_user = $_SESSION['userdata']['user_id'];
        $query = "SELECT count(*) as row FROM subscribers_list WHERE subscriber_id= $current_user AND user_id = $user_id";
        $run = mysqli_query($db, $query);
        return mysqli_fetch_assoc($run)['row'];
    }
    
    // for adding the user's data to the database
    function createUser($data){
        global $db;
        $fname = mysqli_real_escape_string($db, trim($data['fname']));
        $lname = mysqli_real_escape_string($db, trim($data['lname']));
        $u_pwd = md5($data['pass']); // md5 encryption
        $pfp = 'profile.png'; 
        $email = mysqli_real_escape_string($db, trim($data['email']));
        $city = mysqli_real_escape_string($db, $data['city']);
        $age = mysqli_real_escape_string($db, trim($data['age']));
        $query = "INSERT INTO `users` (`f_name`, `l_name`, `u_pwd`, `pfp`, `email`, `city`, `age`)";
        $query .= "VALUES ('$fname', '$lname', '$u_pwd', '$pfp', '$email', '$city', '$age');";
        return mysqli_query($db, $query);
    }

    // function for verifying the verification code
    function verifyEmail($email){
        global $db;
        $query = "UPDATE users SET ac_status=1 WHERE email = '$email'";
        return mysqli_query($db, $query);
    }

    // function for verifying the verification code
    function resetPassword($email, $password){
        global $db;
        $password = md5($password);
        $query = "UPDATE users SET u_pwd = '$password' WHERE email = '$email'";
        return mysqli_query($db, $query);
    }

    // function for updating profile
    function validateUpdateForm($form_data, $image_data){
        $response = [];
        $response['status'] = true;

        if (!$form_data['lname']) {
            $response['msg'] = "Last name isn't given!";
            $response['status'] = false;
            $response['field'] = 'lname';
        }
        
        if (!$form_data['fname']) {
            $response['msg'] = "First name isn't given!";
            $response['status'] = false;
            $response['field'] = 'fname';
        }

        if (usernameExistsOfOther($form_data['fname'], $form_data['lname'])) { // this body will run only if the user-inserted first name and last name already exists
            $response['msg'] = "This username is already registered by another user!";
            $response['status'] = false;
            $response['field'] = 'fname';
        }

        if ($image_data['name']) {
            $image = basename($image_data['name']);
            $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
            $size = $image_data['size']/1000;
            if ($type != 'jpg' and $type != 'jpeg' and $type != 'png') {
                $response['msg'] = "Only jpg, jpeg & png images are allowed!";
                $response['status'] = false;
                $response['field'] = 'profile_pic';
            }
            if ($size > 1000) {
                $response['msg'] = "Please select an image with size less than 1MB!";
                $response['status'] = false;
                $response['field'] = 'profile_pic';
            }
        }
        return $response;
    }

    // function for upddating profile
    function updateProfile($form_data, $image_data){
        global $db;
        $fname = mysqli_real_escape_string($db, trim($form_data['fname']));
        $lname = mysqli_real_escape_string($db, trim($form_data['lname']));
        $city = mysqli_real_escape_string($db, $form_data['city']);
        $age = mysqli_real_escape_string($db, trim($form_data['age']));

        $pfp = "";
        if ($image_data['name']) {
            $image_name = time().basename($image_data['name']);
            $image_dir = "../images/profiles/$image_name";
            move_uploaded_file($image_data['tmp_name'], $image_dir);
            $pfp = ", pfp = '$image_name'";
        }

        if (!$form_data['about']) {
            $about = $_SESSION['userdata']['about'];
        }else {
            $about = mysqli_real_escape_string($db, trim($form_data['about']));
        }  

        if (!$form_data['password']) {
            $u_pwd = $_SESSION['userdata']['u_pwd'];
        }else {
            $pass = mysqli_real_escape_string($db, trim($form_data['password']));
            $u_pwd = md5($pass); // md5 encryption
        }
        
        $user_id = $_SESSION['userdata']['user_id'];
        $query = "UPDATE users SET f_name = '$fname', l_name = '$lname', age = '$age', about = '$about', u_pwd = '$u_pwd' $pfp, city = '$city' WHERE user_id = $user_id";
        return mysqli_query($db, $query);
    }

    // function for updating profile
    function validatePostImage($image_data){
        $response = [];
        $response['status'] = true;

        if ($image_data['name']) {
            $image = basename($image_data['name']);
            $type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
            $size = $image_data['size']/1000;
            if ($type != 'jpg' and $type != 'jpeg' and $type != 'png') {
                $response['msg'] = "Only jpg, jpeg & png images are allowed!";
                $response['status'] = false;
                $response['field'] = 'post_img';
            }
            if ($size > 2000) {
                $response['msg'] = "Please select an image with size less than 2MB!";
                $response['status'] = false;
                $response['field'] = 'post_img';
            }
        }
        return $response;
    }

    // for creating new post
    function createPost($text, $image, $post_city){
        global $db;
        global $user;
        $user_id = $_SESSION['userdata']['user_id'];
        $post_text = mysqli_real_escape_string($db, trim($text['post_text']));
        $post_location = mysqli_real_escape_string($db, trim($text['post_location']));
        $image_name = time().basename($image['name']);
        $image_dir = "../images/posts/$image_name";
        move_uploaded_file($image['tmp_name'], $image_dir);
    
        $query = "INSERT INTO `posts` (user_id, post_header, post_location, images, post_city)";
        $query .= "VALUES ($user_id, '$post_text', '$post_location', '$image_name', '$post_city')";
        $upload_success = mysqli_query($db, $query);
        $query2 = "SELECT post_id FROM posts WHERE user_id = $user_id AND post_header = '$post_text' AND images = '$image_name' AND post_city = '$post_city'";
        $run = mysqli_query($db, $query2);
        $ary = mysqli_fetch_assoc($run);
        $post_id = $ary['post_id'];
        $poster_id = $_SESSION['userdata']['user_id'];
        $subs = getSubscribers($poster_id);
        if (count($subs) > 0) {
            foreach ($subs as $sub) {
                createNotification($poster_id, $sub['subscriber_id'], "uploaded a post!", $post_id);
            }        
        }
        return $upload_success;
    }
     
?>