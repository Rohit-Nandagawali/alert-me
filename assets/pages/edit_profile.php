<?php
global $user;
?>
<!-- login -->
<div class="container d-flex flex-column flex-lg-row justify-content-evenly mt-5 pt-5">
    <!-- heading -->
    <div class="text-center text-lg-start mt-lg-5 pt-lg-5  ">
        <img src="assets/images/Full_logo.png" alt="logo" width="380px" height="110px">
        <p class="w-85 mx-auto mx-lg-2 fs-4 pt-3 ps-2">Get the latest news of your city.</p>
    </div>
    <div id="success-msg"></div>
    <!-- login form -->
    <div style="max-width:28rem;width: 100%;">
        <div class="bg-white shadow rounded  p-3 input-group-lg">
            <h5 class="text-center">Edit Your Profile</h5>
            <?php 
                if (isset($_GET['success'])) {
                    ?>
                        <p class="text-success text-center">Profile updated successfully!</p>
                    <?php
                }
            ?>
            <form action="assets/php/actions.php?updateprofile" enctype="multipart/form-data" method="post">
                <!-- body -->
                <div>
                    <div class="my-1 p-1">
                        <!-- change avatar -->
                        <div class="d-flex justify-content-center">
                            <div class="p-2 ">
                                <div class="d-flex justify-content-center">
                                    <img src="assets/images/profiles/<?= $user['pfp'] ?>" alt="from fb" class="rounded-circle" style="
                                          width: 66px;
                                          height: 66px;
                                          object-fit: cover;
                                        " />
                                </div>

                                <div>
                                    <label class="text-primary cursor-pointer my-1 ">
                                        <input type="file" name="profile_pic" id="file_upload" />
                                        Upload your photo
                                    </label>

                                </div>
                            </div>

                        </div>
                        <?=showError('profile_pic')?>    


                        <!-- first name last name -->
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" name="fname" value="<?=$user['f_name']?>" class="form-control" id="floatingInputGrid" placeholder="Your First name" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Only 20 digits allowed and @,#,$,!,^,*,,etc. symbols are not allowed ">
                                    <label name="dfkdl" for="floatingInputGrid">Your First name</label>
                                </div>
                            </div>
                            <?=showError('fname')?>


                            <!-- last name  -->
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" name="lname" value="<?=$user['l_name']?>" class="form-control" id="floatingInputGrid" placeholder="Your Last name" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Only 20 digits allowed and @,#,$,!,^,*,,etc. symbols are not allowed ">
                                    <label name="djkdsl" for="floatingInputGrid">Your Last name</label>
                                </div>
                            </div>
                            <?=showError('lname')?>    
                        </div>

                        
                        <!-- age -->
                        <div class="form-floating">
                            
                            <input type="number"
                            min="18" 
                            max="100"
                            value="<?=$user['age']?>"
                            class="form-control my-3"
                            placeholder="age"
                            name="age"
                            id="ageLabel"  
                            required                       
                            >
                            <label for="ageLabel">Age</label>
                        </div>     

                        <!-- bio-->
                        <div class="my-3">
                            <textarea cols="30" name="about" rows="2" placeholder="Tell something about yourself..." class="form-control border-1 "><?=$user['about']?></textarea>
                        </div>

                        <!-- current city -->
                        <div class="form-floating">
                            <input
                            value="<?=$user['city']?>"
                            min="18" 
                            max="100"
                            class="form-control my-3"
                            disabled                       
                            >
                            <label for="ageLabel">Current city</label>
                        </div>    

                        <!-- city -->
                        <div class="form-floating">
                            <select class="form-select" name="city" id="citySelect" aria-label="Floating label select example">
                                <option value="Yavatmal">Yavatmal</option>
                                <option value="Amaravati">Amaravati</option>
                                <option value="Pune">Pune</option>
                            </select>
                            <label for="citySelect">Change your city</label>
                        </div>
                        <br>
                        
                        <!-- new password -->
                        <div class="row g-2">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password" placeholder="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" autocomplete="current-password">
                                    <label name="dsdjj" for="passwordLabel">New Password</label>
                                </div>
                            </div> 
                        </div>                        

                    </div>

                    <!-- end -->
                </div>
                <br>
                <input type="submit" class="btn btn-primary w-100">

            </form>

        </div>


    </div>
</div>