    <div class="container d-flex flex-column flex-lg-row justify-content-evenly mt-5 pt-5">
        <!-- heading -->
        <div class="text-center text-lg-start mt-lg-5 pt-lg-5  ">
            <img src="assets/images/Full_logo.png" alt="logo" width="360px" height="110px">
            <p class="w-85 mx-auto mx-lg-2 fs-4 pt-3 ps-2">Get the latest news of your city.</p>
        </div>

        <!-- login form -->
        <div style="max-width:28rem;width: 100%;">
            <div class="bg-white shadow rounded  p-3 input-group-lg">
                <h5 class="text-center">Welcome back to AlertMe!</h5>

                <form action="assets/php/actions.php?login" method="post">

                    <!-- for email  -->
                    <div class="form-floating">

                        <input type="email" name="email" class="form-control my-3 " id="emailLabel" value="<?=showFormData('email')?>"
                            autocomplete="username" placeholder="Email address">

                        <label for="emailLabel">E-mail address</label>
                    </div>
                    <?=showError('email')?>

                    <!-- for password -->
                    <div class="form-floating">

                        <input type="password" name="pass" class="form-control my-3" placeholder="pass" id="passwordLabel" value="<?=showFormData('pass')?>"
                            autocomplete="current-password">
                        <label for="passwordLabel">Password</label>
                    </div>
                    <?=showError('pass')?>
                    <?=showError('checkuser')?>

                    <!-- for show hide password  -->
                    <div>
                        <p class="text-end text-primary text-decoration-none cursor-pointer" id="showPassword"
                            onclick="showPassword()">Show password</p>
                    </div>

                    <!-- for login btn -->

                    <button type="submit" class="btn btn-primary w-100 my-3">Log-in</button>

                </form>
            
                <!-- for forgot password btn -->
                <a class="text-decoration-none text-center" href="?forgotpassword&newfp">
                    <p>Forgot password?</p>
                </a>

                <hr>
                <!-- create account button -->
                <a href="?signup"
                    class="text-decoration-none text-center d-flex my-4 align-items-center justify-content-center">
                    <button class="btn btn-success btn-lg">Create new account</button>
                </a>

            </div>


        </div>

    </div>
