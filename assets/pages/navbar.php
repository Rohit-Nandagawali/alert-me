<?php
global $user;
?>
<!-- navbar -->
<div class="bg-white d-flex align-items-center fixed-top shadow" style="min-height:56px; z-index:5">
    <div class="container-fluid">
        <div class="row align-items-center">

            <!-- icon -->
            <div class="col">
                <a href="?">
                    <img src="assets/images/logo.png" alt="logo" height="28">
                </a>
            </div>
            <!-- search -->
            <div class="col d-flex align-items-center">
                <form class="d-flex" id="searchform">
                    <input class="form-control me-2" type="search" id="search" placeholder="Looking for someone?" aria-label="Search" autocomplete="off">
                    <div class="bg-white text-end rounded border shadow py-3 px-4 mt-5" style="display:none;position:absolute;z-index:+99;" id="search_result" data-bs-auto-close="true">
                        <button type="button" class="btn-close" aria-label="Close" id="close_search"></button>
                        <div id="sra" class="text-start">
                            <p class="text-center text-muted">Enter first or last name </p>
                        </div>
                    </div>
                </form>
            </div>
            <!-- menus -->
            <div class="col d-flex align-items-center justify-content-end">
                <!-- avatar -->
                <a href="?u=<?= $user['f_name'] ?>_<?= $user['l_name'] ?>" class="text-decoration-none text-dark">
                    <div class="d-none d-xl-flex align-items-center justify-content-end cursor-pointer me-2 px-2 py-1 rounded-pill user <?php global $user;
                                                                                                                                        if (isset($_GET['u']) and ($_GET['u'] == $user['f_name'] . '_' . $user['l_name'])) {
                                                                                                                                            echo "active-icon";
                                                                                                                                        } ?>">

                        <!-- avatar img -->
                        <img src="assets/images/profiles/<?= $user['pfp'] ?>" class="rounded-circle me-2" style="height: 38px; width: 38px; object-fit: cover;" alt="avatar">

                        <p class="m-0 me-2"><?= $user['f_name'] . ' ' . $user['l_name']; ?>
                        </p>

                    </div>
                </a>
                <!-- home -->
                <a href="?">
                    <div class="d-flex align-items-center justify-content-center p-1 me-2 bg-gray-icon rounded-circle cursor-pointer <?php if (isset($_GET['u']) or isset($_GET['editprofile'])) {
                                                                                                                                            echo " text-dark";
                                                                                                                                        } else {
                                                                                                                                            echo "active-icon";
                                                                                                                                        } ?>" style="height: 38px; width: 38px; object-fit: cover;">
                        <i class="bi bi-house-fill"></i>
                    </div>
                </a>
                <!-- create -->

                <div class="d-flex align-items-center justify-content-center p-1 me-2 bg-gray-icon rounded-circle cursor-pointer " data-bs-toggle="modal" data-bs-target="#addpost" style="height: 38px; width: 38px; object-fit: cover;">
                    <i class="fa-solid fa-circle-plus"></i>
                </div>

                <div class="d-flex align-items-center justify-content-center p-1 me-2 bg-gray-icon rounded-circle cursor-pointer" style="height: 38px; width: 38px; object-fit: cover;" type="button">
                    <?php
                    if (getUnreadNotificationsCount() > 0) {
                    ?>
                        <!-- notification -->
                        <a id="show_not" class="text-dark" data-bs-toggle="offcanvas" href="#notification_sidebar" role="button" aria-controls="offcanvasExample">
                            <i class="fa-solid fa-bell"></i>
                            <span class="un-count position-absolute start-10 translate-middle badge p-1 rounded-pill bg-danger">
                                <small><?= getUnreadNotificationsCount() ?></small>
                            </span>
                        </a>
                    <?php
                    } else {
                    ?>
                        <a class="text-dark nav-link" data-bs-toggle="offcanvas" href="#notification_sidebar" role="button" aria-controls="offcanvasExample">
                            <i class="fa-solid fa-bell"></i>
                        </a>
                    <?php
                    }
                    ?>
                </div>


                <!-- secondary menu ... -->

                <div class="d-flex align-items-center justify-content-center p-1 me-2 bg-gray-icon rounded-circle cursor-pointer" style="height: 38px; width: 38px; object-fit: cover;" id="secondaryMenu" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    <i class="fa-solid fa-ellipsis"></i>
                </div>

                <!--secodary dropdown  -->
                <ul class="dropdown-menu border-0 shadow p-3" aria-labelledby="secondaryMenu" style="width: 23em; max-height: 600px; ">




                    <!-- logout -->
                    <li class="dropdown-item p-1 my-3 rounded" type="button">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="assets/php/actions.php?logout" class="d-flex text-decoration-none text-dark">
                                    <i class="fa-solid fa-right-from-bracket bg-gray p-2 rounded-circle"></i>

                                    <div class="
                      ms-3
                      d-flex
                      justify-content-between
                      align-items-center
                      w-100
                    ">
                                        <p class="m-0">Log Out</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>

            </div>
        </div>
    </div>
</div>