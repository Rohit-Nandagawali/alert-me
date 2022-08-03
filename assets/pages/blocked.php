<?php
    global $user;
?>
<div class="container d-flex flex-column flex-lg-row justify-content-evenly mt-5 pt-5">
        <!-- heading -->
        <div class="text-center text-lg-start mt-lg-5 pt-lg-5  ">
            <img src="assets/images/Full_logo.png" alt="logo" width="360px" height="110px">
            <p class="w-85 mx-auto mx-lg-2 fs-4 pt-3 ps-2">Get the latest news of your city.</p>
        </div>

        <!-- login form -->
        <div style="max-width:28rem;width: 100%;">
            <div class="bg-white shadow rounded  p-3 input-group-lg">
                <h5 class="text-center">Sorry <?=$user['f_name'].' '.$user['l_name']?>! Your account has been blocked by the admin because some of your activities were found to be inappropriate!</h5>
                <hr>
                <!-- create account button -->
                <a href="assets/php/actions.php?logout"
                    class="text-decoration-none text-center d-flex my-4 align-items-center justify-content-center">
                    <button class="btn btn-success btn-lg">Log out</button>
                </a>

            </div>


        </div>

    </div>
