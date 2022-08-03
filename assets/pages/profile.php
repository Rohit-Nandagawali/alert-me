<?php
global $user;
global $profile;
global $profilePost;
?>
<div class="bg-gray d-lg-block">

  <!-- =================================== -->

  <!-- profile  -->
  <div class="container-fluid ">
    <div class="row d-flex justify-content-center align-items-center">
      <!-- post section -->

      <div class="col-12 col-lg-6 pb-5">
        <div class="d-flex flex-column justify-content-center w-100 mx-auto" style="padding-top: 56px; max-width: 680px">

          <!-- profile view/change -->
          <div class="bg-white mt-5 p-4 d-flex flex-column justify-content-between rounded-corner border shadow position-relative">

            <!-- for avatar and name and edit button -->
            <div class="d-flex flex-row">
              <!-- avatar -->
              <div class="d-flex">
                <div class="p-1 me-2">
                  <img src="assets/images/profiles/<?= $profile['pfp'] ?>" alt="avatar" class="rounded-circle me-2" style="width: 80px; height: 80px; object-fit: cover" />
                </div>
              </div>
              <!-- name -->
              <div class="d-flex align-items-center justify-content-center">
                <div class="d-flex">
                  <h3><?= $profile['f_name'] ?> <?= $profile['l_name'] ?><?php
                                                                          if ($profile['verified'] == 1) {
                                                                          ?>
                    <i class="bi bi-patch-check-fill mx-2 text-primary"></i>
                  <?php
                                                                          }
                  ?>
                  </h3>
                </div>
              </div>

              <!-- edit profile button -->
              <div class="d-flex ms-3">
                <?php
                if ($user['f_name'] == $profile['f_name'] and $user['l_name'] == $profile['l_name']) {
                ?>
                  <div class="d-flex justify-content-center align-items-center">
                    <a href="?editprofile">
                      <button class="btn rounded btn-outline-primary">
                        <i class="fa-solid fa-pen me-3"></i>Edit Profile
                      </button>
                    </a>
                  </div>
                <?php
                } else {
                ?>
                  <div class="d-flex justify-content-center align-items-center">
                    <?php
                    if (checkSubscribeStatus($profile['user_id'])) {
                    ?>
                      <button class="btn rounded btn-outline-primary unsubbtn" data-user-id="<?= $profile['user_id'] ?>">
                        <i class="bi bi-check-circle-fill"></i> Unsubscribe
                      <?php
                    } else {
                      ?>
                        <button class="btn rounded btn-outline-primary subbtn" data-user-id="<?= $profile['user_id'] ?>">
                          <i class="bi bi-person-plus-fill me-3"></i> Subscribe
                        <?php
                      }
                        ?>
                        </button>
                  </div>
                <?php
                }
                ?>

              </div>

            </div>

            <!-- number of post, followers, following -->
            <div class="d-flex flex-row align-items-center justify-content-center">
              <div class="d-flex flex-column flex-lg-row mt-3">
                <!-- number of post-->
                <div class="
                      dropdown-item
                      rounded
                      border
                      d-flex 
                      me-2
                      px-3
                      bg-gray
                      align-items-center
                      justify-content-center
                    " type="button">
                  <a class="m-0 text-muted text-decoration-none"><span><?= count($profilePost) ?></span> Posts</a>
                </div>
                <!-- number of subs-->
                <div class="
                      dropdown-item
                      rounded
                      border
                      d-flex
                      me-2
                      px-3
                      bg-gray
                      align-items-center
                      justify-content-center
                    " type="button">
                  <a class="m-0 text-muted text-decoration-none" data-bs-toggle="modal" data-bs-target="#sub_list"><span><?= count($profile['subscribers']) ?></span> subscribers</a>
                </div>
                <!-- number of subbed-->
                <div class="
                      dropdown-item
                      rounded
                      border
                      d-flex
                      me-2
                      px-3
                      bg-gray
                      align-items-center
                      justify-content-center
                    " type="button">
                  <a class="m-0 text-muted text-decoration-none" data-bs-toggle="modal" data-bs-target="#subbed_list"><span class="font-weight-bold"><?= count($profile['subscribed']) ?></span> subscribed</a>
                </div>
              </div>

            </div>

            <!-- description -->
            <div class="d-flex mt-2">
              <p><?= $profile['about'] ?></p>

            </div>

          </div>

          <?php
          if ($_SESSION['userdata']['user_id'] == $profile['user_id']) {
          ?>
            <!-- create post -->
            <div class="bg-white p-3 mt-3 rounded-corner border shadow">
              <!-- avatar -->
              <div class="d-flex" type="button">
                <div class="p-1">
                  <img src="assets/images/profiles/<?= $profile['pfp'] ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                </div>
                <input type="text" class="form-control rounded-pill border-1 bg-gray cursor-pointer" disabled placeholder="What news have you got, <?= $profile['f_name'] ?>?" data-bs-toggle="modal" data-bs-target="#addpost" />
              </div>
            </div>
          <?php
          }
          ?>

          <?php
          foreach ($profilePost as $post) {
          ?>
            <!-- modal for comments -->
            <div class="modal fade" id="postview<?= $post['post_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">

                  <div class="modal-body d-md-flex p-0">

                    <?php
                    $hasalpha = false;
                    $img = $post['images'];
                    for ($i = 0; $i < strlen($img); $i++) {
                      if (ctype_alpha($img[$i])) {
                        $hasalpha = true;
                        break;
                      }
                    }
                    if ($hasalpha) {
                    ?>
                      <!-- this is post image -->
                      <div class="col-md-8 col-sm-12">
                        <img src="assets/images/posts/<?= $post['images'] ?>" style="max-height:90vh" class="w-100 overflow:hidden">
                      </div>
                    <?php
                    } else {
                    ?>
                      <div class="col-md-8 col-sm-12 d-flex justify-content-center">
                        <p class="my-auto"><b>This post doesn't have any image</b></p>
                      </div>
                    <?php
                    }
                    ?>

                    <!-- right hand section -->

                    <div class="col-md-4 col-sm-12 d-flex flex-column">

                      <div class="d-flex align-items-center p-2 border-bottom">
                        <!-- user info  -->
                        <div><img src="assets/images/profiles/<?= $profile['pfp'] ?>" alt="" height="50" width="50" class="rounded-circle border">
                        </div>

                        <div class="m-2 d-flex flex-column justify-content-start">
                          <h6 style="margin: 0px;"><?= $profile['f_name'] ?> <?= $profile['l_name'] ?></h6>
                        </div>

                        <!-- user info end -->
                      </div>


                      <!-- div for comment section  -->
                      <div class="flex-fill align-self-stretch overflow-auto" id="comment-section<?= $post['post_id'] ?>" style="height: 100px;">

                        <?php
                        $comments = getComments($post['post_id']);
                        if (count($comments) < 1) {
                        ?>
                          <p class="p-3 text-center my-2">No comments on this post yet</p>
                        <?php
                        }
                        foreach ($comments as $comment) {
                          $cuser = getUser($comment['user_id']);
                        ?>
                          <!-- the comments -->
                          <div class="d-flex align-items-center p-2">
                            <div><img src="assets/images/profiles/<?= $cuser['pfp'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                            </div>

                            <div class="m-2 d-flex flex-column justify-content-start align-items-start">
                              <h6 style="margin: 0px;"><a href="?u=<?= $cuser['f_name'] ?>_<?= $cuser['l_name'] ?>" class="text-decoration-none text-dark text-small text-muted"><?= $cuser['f_name'] ?> <?= $cuser['l_name'] ?></a>
                              </h6>
                              <p style="margin:0px;" class="text-muted"><?= $comment['comment'] ?></p>
                            </div>
                          </div>
                        <?php
                        }
                        ?>
                      </div>

                      <!-- div for comment input -->
                      <div class="input-group p-2 border-top">
                        <input type="text" class="form-control rounded-0 border-0 comment-input" placeholder="Add a comment here.." aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-primary rounded-0 border-0 add-comment" data-cs="comment-section<?= $post['post_id'] ?>" data-post-id="<?= $post['post_id'] ?>" type="button" id="button-addon2">Post</button>
                      </div>

                    </div>

                  </div>

                </div>
              </div>
            </div>
            <!-- posts -->
            <div class="bg-white p-4 rounded-corner shadow mt-3">
              <!-- author -->
              <div class="d-flex justify-content-between">
                <!-- avatar -->
                <div class="d-flex">
                  <img src="assets/images/profiles/<?= $profile['pfp'] ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
                  <div>
                    <p class="m-0 fw-bold"><?= $profile['f_name'] ?> <?= $profile['l_name'] ?>
                      <?php
                      if ($profile['verified'] == 1) {
                      ?>
                        <i class="bi bi-patch-check-fill mx-2 text-primary"></i>
                      <?php
                      }
                      ?>
                    </p>
                    <span class="text-muted fs-7"><?= $post['posted_on'] ?> | <?= $post['post_location'] ?></span>
                  </div>
                </div>
                <!-- edit -->
                <i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <!-- edit menu -->
                <ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
                  <?php
                  if ($user['user_id'] == $profile['user_id']) {
                  ?>
                    <li class="d-flex align-items-center">
                      <a class="
                              dropdown-item
                              d-flex
                              justify-content-around
                              align-items-center
                              fs-7
                            " href="assets/php/actions.php/?delpost=<?= $post['post_id'] ?>">
                        Delete Post</a>
                    </li>
                  <?php
                  } else {
                  ?>
                    <li class="d-flex align-items-center cursor-pointer">
                      <a class="
													dropdown-item
													d-flex
													justify-content-around
													align-items-center
													fs-7" data-bs-toggle="modal" data-bs-target="#reportPost" <?php $_SESSION['report_postId'] = $post['post_id'];
                                                                                    $_SESSION['report_postHeader'] = $post['post_header']; ?>>
                        Report Post</a>
                    </li>
                  <?php
                  }
                  ?>
                </ul>
              </div>
              <!-- description -->
              <div class="d-flex mt-2">
                <p><?= $post['post_header'] ?></p>

              </div>

              <!-- post content -->
              <div class="mt-3">
                <!-- content -->
                <div>
                  <!-- post image if any -->
                  <div>
                    <?php
                    $hasalpha = false;
                    $img = $post['images'];
                    for ($i = 0; $i < strlen($img); $i++) {
                      if (ctype_alpha($img[$i])) {
                        $hasalpha = true;
                        break;
                      }
                    }
                    if ($hasalpha) {
                    ?>
                      <img src="assets/images/posts/<?= $post['images'] ?>" class="d-block w-100" alt="post1">
                    <?php
                    }
                    ?>
                  </div>


                  <!-- carousel end -->

                </div>
                <!-- likes & comments -->
                <div class="post__comment mt-3 position-relative">
                  <!-- likes -->
                  <div class="accordion" id="accordionExample">
                    <div class="accordion-item border-0">
                      <hr />
                      <!-- real,fake, share comment-->
                      <div class="d-flex justify-content-around">
                        <!-- comment icon -->
                        <div class="
                            dropdown-item
                            rounded
                            d-flex
                            justify-content-center
                            align-items-center
                            pointer
                            text-muted
                            p-1
                          " data-bs-toggle="modal" data-bs-target="#postview<?= $post['post_id'] ?>" aria-expanded="false" aria-controls="collapsePost1">
                          <i class="fas fa-comment-alt me-3"></i>
                          <p class="m-0">Comment</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end -->
                </div>
              </div>
            </div>

          <?php
          }
          ?>


        </div>

      </div>

      <!-- post section end -->

    </div>
  </div>
  <!-- profile  -->

  <!-- subscribers list modal -->
  <div class="modal fade" id="sub_list" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <!-- head -->
        <div class="modal-header align-items-center">
          <h5 class="text-dark text-center w-100 m-0" id="exampleModalLabel">
            Subscribers
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php
          foreach ($profile['subscribers'] as $sub) {
            $sub_user = getUser($sub['subscriber_id']);
            $sub_btn = '';
            if (checkSubscribeStatus($sub['subscriber_id'])) {
              $sub_btn = '<button class="btn rounded btn-outline-primary unsubbtn" data-user-id="' . $sub_user['user_id'] . '">
                <i class="bi bi-check-circle-fill me-3"></i>Unsubscribe';
            } elseif ($user['user_id'] == $sub['subscriber_id']) {
              $sub_btn = '';
            } else {
              $sub_btn = '<button class="btn rounded btn-outline-primary subbtn" data-user-id="' . $sub_user['user_id'] . '">
                <i class="bi bi-person-plus-fill me-3"></i>Subscribe';
            }
          ?>
            <div class="d-flex justify-content-between">
              <div class="d-flex align-items-center p-2">
                <div><img src="assets/images/profiles/<?= $sub_user['pfp'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                </div>
                <div>&nbsp;&nbsp;</div>
                <div class="d-flex flex-column justify-content-center">
                  <a href='?u=<?= $sub_user['f_name'] ?>_<?= $sub_user['l_name'] ?>' class="text-decoration-none text-dark">
                    <h6 style="margin: 0px;font-size: small;"><?= $sub_user['f_name'] ?> <?= $sub_user['l_name'] ?></h6>
                  </a>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <?= $sub_btn ?>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <!-- subscribed users list modal -->
  <div class="modal fade" id="subbed_list" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <!-- head -->
        <div class="modal-header align-items-center">
          <h5 class="text-dark text-center w-100 m-0" id="exampleModalLabel">
            This user has subscribed these accounts
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php
          foreach ($profile['subscribed'] as $sub) {
            $sub_user = getUser($sub['user_id']);
            $sub_btn = '';
            if (checkSubscribeStatus($sub['user_id'])) {
              $sub_btn = '<button class="btn rounded btn-outline-primary unsubbtn" data-user-id="' . $sub_user['user_id'] . '">
                <i class="bi bi-check-circle-fill me-3"></i>Unsubscribe';
            } elseif ($user['user_id'] == $sub['user_id']) {
              $sub_btn = '';
            } else {
              $sub_btn = '<button class="btn rounded btn-outline-primary subbtn" data-user-id="' . $sub_user['user_id'] . '">
                <i class="bi bi-person-plus-fill me-3"></i>Subscribe';
            }
          ?>
            <div class="d-flex justify-content-between">
              <div class="d-flex align-items-center p-2">
                <div><img src="assets/images/profiles/<?= $sub_user['pfp'] ?>" alt="" height="40" width="40" class="rounded-circle border">
                </div>
                <div>&nbsp;&nbsp;</div>
                <div class="d-flex flex-column justify-content-center">
                  <a href='?u=<?= $sub_user['f_name'] ?>_<?= $sub_user['l_name'] ?>' class="text-decoration-none text-dark">
                    <h6 style="margin: 0px;font-size: small;"><?= $sub_user['f_name'] ?> <?= $sub_user['l_name'] ?></h6>
                  </a>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <?= $sub_btn ?>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Report Modal -->
  <div class="modal fade" id="reportPost" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content ">
        <div class="modal-header  bg-danger text-white">
          <h5 class="modal-title" id="exampleModalLabel">Report news Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="assets/php/actions.php?reportPost" method="post">
          <div class="modal-body">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="report_options[]" id="report_options[]1" value="Sexual content">
              <label class="form-check-label" for="report_options[]1">
                Sexual content
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="report_options[]" id="report_options[]2" value="Violent or repulsive content">
              <label class="form-check-label" for="report_options[]2">
                Violent or repulsive content
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="report_options[]" id="report_options[]3" value="Promotes terrorism">
              <label class="form-check-label" for="report_options[]3">
                Promotes terrorism
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="report_options[]" id="report_options[]4" value="Hateful or abusive content">
              <label class="form-check-label" for="report_options[]4">
                Hateful or abusive content
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="report_options[]" id="report_options[]5" value="Harassment or bullying">
              <label class="form-check-label" for="report_options[]5">
                Harassment or bullying
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="report_options[]" id="report_options[]5" value="Something not meant for this site" checked>
              <label class="form-check-label" for="report_options[]5">
                Something not meant for this site
              </label>
            </div>
            <div class="form-floating">
              <textarea class="form-control" placeholder="Describe here" id="floatingTextarea2" name="report_description" style="height: 100px"></textarea>
              <label for="floatingTextarea2">Describe here</label>
            </div>
            <input type="hidden" name="user_email" value="<?= $user['email'] ?>">
            <input type="hidden" name="user_name" value="<?= $user['f_name'] . " " . $user['l_name'] ?>">
            <input type="hidden" name="uploader_name" value="<?= $profile['f_name'] . " " . $profile['l_name'] ?>">

            <br>
            <p style="font-size: .8rem; font-style: italic;">Flagged posts and users are reviewed by AlertMe staff 24 hours a day, 7 days a week to determine whether they violate Community Guidelines. Accounts are penalized for Community Guidelines violations, and serious or repeated violations
              can lead to account termination. </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Report</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>