<div class="container d-flex flex-column flex-lg-row justify-content-evenly mt-5 pt-5">
        <!-- heading -->
        <div class="text-center text-lg-start mt-lg-5 pt-lg-5  ">
            <img src="assets/images/Full_logo.png" alt="logo" width="360px" height="110px">
            <p class="w-85 mx-auto mx-lg-2 fs-4 pt-3 ps-2">Get the latest news of your city.</p>
        </div>

        <!-- login form -->
        <div style="max-width:28rem;width: 100%;">
            <div class="bg-white shadow rounded  p-3 input-group-lg">
                <h5 class="text-center">Forgot your password?</h5>
                <?php 
                    if (isset($_SESSION['forgot_code']) and !isset($_SESSION['auth_temp'])) {
                        $action = 'verifycode';
                    }elseif (isset($_SESSION['forgot_code']) and isset($_SESSION['auth_temp'])) {
                        $action = 'changepassword';
                    }else {
                        $action = 'forgotpassword';
                    }
                ?>
                <form action="assets/php/actions.php?<?=$action?>" method="post">

                <?php
                    if ($action == 'forgotpassword') {
                        ?>
                        <!-- for email  -->
                        <div class="form-floating">

                            <input type="email" name="email" class="form-control my-3 " id="emailLabel"
                                autocomplete="username" placeholder="Email address">

                            <label for="emailLabel">E-mail address</label>
                        </div>
                        <?=showError('email')?>
                        <button type="submit" class="btn btn-primary w-100 my-1">Send Verification Code</button>
                        <?php
                    }
                ?>    


                <?php
                    if ($action == 'verifycode') {
                        ?>
                        <h6 class="text-center">Enter the 6-digit code sent to your e-mail (<?=$_SESSION['forgot_email']?>)</h6>
                        <div class="form-floating">

                            <input type="number" name="code" class="form-control my-3 " id="verificationCode"
                                autocomplete="username" placeholder="verification code">

                            <label for="verificationCode">Verification code</label>
                        </div>
                        <?=showError('email_verify')?>
                        <button type="submit" class="btn btn-primary w-100 my-1">Verify Code</button>
                        <?php
                    }
                ?>    

                <?php
                    if ($action == 'changepassword') {
                        ?>
                    <h6 class="text-center">Enter your new password (<?=$_SESSION['forgot_email']?>)</h6>
                    <!-- for password -->
                    <div class="form-floating">

                        <input type="password" name="password" class="form-control my-3" placeholder="pass" id="passwordLabel" value="<?=showFormData('pass')?>"
                            autocomplete="current-password">
                        <label for="passwordLabel">New password</label>
                    </div>
                    <?=showError('password')?>
                    <!-- for show hide password -->
                    <div>
                        <p class="text-end text-primary text-decoration-none cursor-pointer" id="showPassword"
                            onclick="showPassword()">Show password</p>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 my-1">Change Password</button>
                        <?php
                    }
                ?>  

                </form>

                <hr>
                <!-- create account button -->
                <a href="?login"
                    class="text-decoration-none text-center d-flex my-4 align-items-center justify-content-center">
                    <button class="btn btn-success btn-lg">Go Back To Login</button>
                </a>

            </div>


        </div>

    </div>
