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
                <h5 class="text-center">Verify the 6-digit code sent to (<?= $user['email'] ?>)</h5>

                <form action="assets/php/actions.php?verify_email" method="post">

                    <!-- for email  -->
                    <div class="form-floating">

                        <input type="number" name="code" class="form-control my-3 " id="verificationCode" 
                            autocomplete="username" placeholder="Email address">

                        <label for="verificationCode">Verification code</label>
                    </div>
                    <?php if(isset($_GET['resent'])){
                        ?>
                            <p class="text-success">Verification code has been resent to your e-mail id!</p>
                        <?php
                    } ?>
                    <?=showError('email_verify')?>
                    <!-- for login btn -->

                    <button type="submit" class="btn btn-primary w-100 my-3">Verify email</button>

                </form>
            
                <!-- for forgot password btn -->
                <a class="text-decoration-none text-center" href="assets/php/actions.php?resend_code">
                    <p>Re-send code</p>
                </a>

                <hr>
                <!-- create account button -->
                <a href="assets/php/actions.php?logout"
                    class="text-decoration-none text-center d-flex my-4 align-items-center justify-content-center">
                    <button class="btn btn-success btn-lg">Log out</button>
                </a>

            </div>


        </div>

    </div>
