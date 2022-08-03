<?php
global $user;
?>


<!-- notifications -->
<?php
if (isset($_SESSION['Auth'])) {
?>
  <div class="offcanvas offcanvas-start" tabindex="-1" id="notification_sidebar" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Notifications</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <?php
      $notifications = getNotifications();
      foreach ($notifications as $not) {
        $fuser = getUser($not['from_user_id']);
        $post = '';
        if ($not['post_id']) {
          $post = 'data-bs-toggle="modal" data-bs-target="#postview' . $not['post_id'] . '"';
        }
        $fbtn = '';
      ?>
        <div class="d-flex justify-content-between border-bottom">
          <div class="d-flex align-items-center p-2">
            <div><img src="assets/images/profiles/<?= $fuser['pfp'] ?>" alt="" height="40" width="40" class="rounded-circle border">
            </div>
            <div>&nbsp;&nbsp;</div>
            <div class="d-flex flex-column justify-content-center" <?= $post ?>>
              <a href='?u=<?= $fuser['f_name'] . "_" . $fuser['l_name'] ?>' class="text-decoration-none text-dark">
                <h6 style="margin: 0px;font-size: small;"><?= $fuser['f_name'] ?> <?= $fuser['l_name'] ?></h6>
              </a>
              <p style="margin:0px;font-size:small" class="<?= $not['read_status'] ? 'text-muted' : '' ?>"><?= $fuser['f_name'] ?> <?= $fuser['l_name'] ?> <?= $not['message'] ?></p>
            </div>
          </div>
          <div class="d-flex align-items-center">
            <?php
            if ($not['read_status'] == 0) {
            ?>
              <div class="p-1 bg-primary rounded-circle"></div>

            <?php

            } else if ($not['read_status'] == 2) {
            ?>
              <span class="badge bg-danger">Post Deleted</span>
            <?php
            }
            ?>

          </div>
        </div>
      <?php
      }
      ?>

    </div>
  </div>
  </div>
<?php
}
?>

<!-- create post modal -->
<div class="modal fade" id="addpost" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class=" modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- head -->
      <div class="modal-header align-items-center">
        <h5 class="text-dark text-center w-100 m-0" id="exampleModalLabel">
          Create Post
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- here form start -->

      <form action="assets/php/actions.php?addpost" enctype="multipart/form-data" method="post">
        <!-- body -->
        <div class="modal-body">
          <div class="my-1 p-1">
            <div class="d-flex flex-column">
              <!-- name -->
              <div class="d-flex align-items-center">
                <div class="p-2">
                  <img src="assets/images/profiles/<?= $user['pfp'] ?>" alt="from fb" class="rounded-circle" style="
                            width: 38px;
                            height: 38px;
                            object-fit: cover;
                          " />
                </div>
                <div>
                  <p class="m-0 fw-bold"><?= $user['f_name'] . ' ' . $user['l_name'] ?></p>
                </div>
              </div>

              <!-- text -->
              <div>
                <div class="form-floating">
                  <textarea class="form-control my-3 " id="city" name="post_text" placeholder="Select City" autocomplete="city" required></textarea>
                  <label name="" for="city">Add heading for your news</label>
                </div>

              </div>

              <img src="" style="display:none" id="post_img" class="w-100 rounded border">
              <label class="mt-1">Upload images/videos</label>
              <!-- drag and drop -->
              <div class="d-flex my-2 py-4 border rounded d-flex-row align-items-center justify-content-center bg-gray">

                <div class="d-block align-items-center justify-content-center">
                  <input type="file" name="post_img" id="select_post_img" multiple>
                  <!-- media icon -->
                </div>
              </div>
              <!-- location -->
              <div>
                <div class="form-floating">
                  <input type="text" class="form-control my-3 " id="city" name="post_location" placeholder="Select City" autocomplete="city" required>
                  <label name="djkldsl" for="city">Tell something about your location in the city</label>
                </div>

              </div>
            </div>
          </div>

          <!-- end -->
        </div>
        <!-- footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary w-100">
            Post
          </button>
      </form>
    </div>
  </div>
</div>



</body>

<!-- JavaScript bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- this is for show and hide password -->
<script src="assets/js/showPassword.js"></script>

<!-- jQuery -->
<script src="assets/js/jQuery.js"></script>

<script src="assets/js/custom.js?v=<?= time() ?>"></script>

</html>