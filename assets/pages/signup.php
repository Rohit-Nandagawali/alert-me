    <div class="container d-flex flex-column flex-lg-row justify-content-evenly mt-5 ">
        <!-- heading -->
        <div class="text-center text-lg-start mt-lg-5 pt-lg-5  ">
            <img src="assets/images/Full_logo.png" alt="logo" width="380px" height="110px">
            <p class="w-85 mx-auto mx-lg-2 fs-4 pt-3 ps-2">Get the latest news of your city.</p>
        </div>
        
        <!-- Sign-up form -->
        <div style="max-width:28rem;width: 100%;">
            <div class="bg-white shadow rounded  p-3 input-group-lg">
                <h5 class="text-center">Register to AlertMe</h5>
                <form action="assets/php/actions.php?signup" method="POST">

                     <!-- first name and last name -->
                    <!-- first name -->
                    <div class="row g-2">
                        <div class="col-md">
                          <div class="form-floating">
                            <input type="text" name="fname" value="<?=showFormData('fname')?>" class="form-control" id="floatingInputGrid" placeholder="Your First name"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Only 15 digits allowed and @,#,$,!,^,*,,etc. symbols are not allowed "  >
                            <label for="floatingInputGrid">Your First name</label>
                          </div>
                        </div>

                        <!-- last name  -->
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" name="lname" value="<?=showFormData('lname')?>" class="form-control" id="floatingInputGrid" placeholder="Your Last name" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Only 15 digits allowed and @,#,$,!,^,*,,etc. symbols are not allowed "  >
                                <label for="floatingInputGrid">Your Last name</label>
                            </div>
                        </div>
                    </div>
                    <?=showError('fname')?>
                    <?=showError('lname')?>

                    <!-- email -->
                    <div class="form-floating">

                        <input type="email"
                        class="form-control my-3 "
                        id="emailLabel"
                        name="email"
                        value="<?=showFormData('email')?>"
                        placeholder="Email address"
                        autocomplete="username"
                        >
                        <label for="emailLabel">Email address</label>
                    </div>
                    <?=showError('email')?>

                    <!-- password -->
                    <div class="form-floating">
                        
                        <input type="password"
                        class="form-control my-3"
                        name="pass"
                        value="<?=showFormData('pass')?>"
                        placeholder="password"
                        data-bs-toggle="tooltip"
                        data-bs-placement="bottom" 
                        autocomplete="current-password"
                         
                        >
                        <label for="passwordLabel">Create a password</label>
                    </div>     
                    <?=showError('pass')?>

                    <!-- age -->
                    <div class="form-floating">
                        
                        <input type="number"
                        min="18" 
                        max="100"
                        value="<?=showFormData('age')?>"
                        class="form-control my-3"
                        placeholder="age"
                        name="age"
                        id="ageLabel"                         
                        >
                        <label for="ageLabel">Age</label>
                    </div>     
                    <?=showError('age')?>

                    <!-- city -->
                    <div class="form-floating">
                        <select class="form-select" name="city" id="citySelect" aria-label="Floating label select example">
                            <option value="Yavatmal">Yavatmal</option>
                            <option value="Amaravati">Amaravati</option>
                            <option value="Pune">Pune</option>
                        </select>
                        <label for="citySelect">Select your city</label>
                    </div>
                    
                    <!-- submit button -->
                    <button type="submit" class="btn btn-success w-100 my-3">Create account</button>
               
                </form>

                <hr>
                <!-- create account button -->
                <a href="?login" class="text-center text-decoration-none text-center d-flex align-items-center justify-content-center">
                    <button class="btn btn-primary btn-lg">Log in</button>
                </a>

            </div>


        </div>

    </div>
    
