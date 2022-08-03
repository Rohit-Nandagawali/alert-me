<?php
global $user;
global $posts;
?>
<div class="bg-gray d-lg-block">
	<!-- =================================== -->

	<div class="container-fluid">
		<div class="row d-flex justify-content-center">
			<!-- post section -->

			<div class="col-12 col-lg-6 pb-5">
				<div class="d-flex flex-column justify-content-center w-100 mx-auto" style="padding-top: 56px; max-width: 680px">
					<!-- posts -->
					<?= showError("post_img") ?>
					<?php
					foreach ($posts as $post) {
						$likes = getLikes($post['post_id']);
						$dislikes = getDislikes($post['post_id']);
						$comments = getComments($post['post_id']);
					?>
						<div class="bg-white p-4 rounded-corner shadow mt-3">
							<!-- author -->
							<div class="d-flex justify-content-between">
								<!-- avatar -->
								<div class="d-flex">
									<img src="assets/images/profiles/<?= $post['pfp'] ?>" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
									<div>
										<a href="?u=<?= $post['f_name'] . '_' . $post['l_name'] ?>" class="text-decoration-none cursor-pointer text-dark">
											<p class="m-0 fw-bold"><?= $post['f_name'] . ' ' . $post['l_name'] ?>
												<?php
												if ($post['verified'] == 1) {
												?>
													<i class="bi bi-patch-check-fill mx-2 text-primary"></i>
												<?php
												}
												?>
											</p>
										</a>
										<span class="text-muted fs-7"><?= $post['posted_on'] ?> | <?= $post['post_location'] ?></span>
									</div>
								</div>
								<!-- delete/report post-->
								<i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
								<!-- delete/report post menu -->
								<ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
									<?php
									if ($post['user_id'] == $user['user_id']) {
									?>
										<li class="d-flex align-items-center">
											<a class="
													dropdown-item
													d-flex
													cursor-pointer
													justify-content-around
													align-items-center
													fs-7" href="assets/php/actions.php/?delpost=<?= $post['post_id'] ?>">
												Delete Post</a>
										</li>
									<?php
									} else {
									?>
										<li class="d-flex align-items-center">
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
							<!-- post content -->
							<div class="mt-3">
								<!-- content -->
								<div>
									<p>
										<?= $post['post_header'] ?>
									</p>
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
										<img src="assets/images/posts/<?= $post['images'] ?>" alt="post image" class="img-fluid rounded" width="100%" />
									<?php
									}
									?>


								</div>
								<!-- likes & comments -->
								<div class="post__comment mt-3 position-relative">
									<!-- likes -->
									<div class="accordion" id="accordionExample">
										<div class="accordion-item border-0">

											<span class="p-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#likes<?= $post['post_id'] ?>"><?= count($likes) ?> likes</span>
											<span class="p-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#dislikes<?= $post['post_id'] ?>"><?= count($dislikes) ?> dislikes</span>
											<span class="p-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#postview<?= $post['post_id'] ?>"><?= count($comments) ?> comments</span>
											<hr />
											<!-- like, dislike, share comment-->
											<div class="d-flex justify-content-around">
												<div class="
        										dropdown-item
        										rounded
        										d-flex
        										justify-content-center
        										align-items-center
												cursor-pointer
        										text-muted
        										p-1">
													<!-- like icon -->
													<span>
														<?php
														if (checkLikeStatus($post['post_id'])) {
															$like_btn_display = 'none';
															$unlike_btn_display = '';
															$unlike_text = "Unlike";
														} else {
															$like_btn_display = '';
															$unlike_btn_display = 'none';
															$like_text = "Like";
														}
														?>
														<i class="bi bi-hand-thumbs-up-fill me-3 unlike_btn" data-post-id="<?= $post['post_id'] ?>" style="display:<?= $unlike_btn_display ?>"><?= " " . @$unlike_text ?></i>
														<i class="bi bi-hand-thumbs-up me-3 like_btn" data-post-id="<?= $post['post_id'] ?>" style="display:<?= $like_btn_display ?>"><?= " " . @$like_text ?></i>
													</span>
												</div>
												<!-- fake icon -->
												<div class="
												dropdown-item
												rounded
												d-flex
												justify-content-center
												align-items-center
												cursor-pointer
												text-muted
												p-1">
													<span>
														<?php
														if (checkDislikeStatus($post['post_id'])) {
															$dislike_btn_display = 'none';
															$undislike_btn_display = '';
															$undislike_text = "Remove dislike";
														} else {
															$dislike_btn_display = '';
															$undislike_btn_display = 'none';
															$dislike_text = "Dislike";
														}
														?>
														<i class="bi bi-hand-thumbs-down-fill me-3 undislike_btn" data-post-id="<?= $post['post_id'] ?>" style="display:<?= $undislike_btn_display ?>"><?= " " . @$undislike_text ?></i>
														<i class="bi bi-hand-thumbs-down me-3 dislike_btn" data-post-id="<?= $post['post_id'] ?>" style="display:<?= $dislike_btn_display ?>"><?= " " . @$dislike_text ?></i>
													</span>
												</div>
												<!-- comment icon -->
												<div class="dropdown-item
												rounded
												d-flex
												justify-content-center
												align-items-center
												cursor-pointer
												text-muted
												p-1" data-bs-toggle="modal" data-bs-target="#postview<?= $post['post_id'] ?>" aria-expanded="false" aria-controls="collapsePost1">
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
											<div class="col-md-8 col-sm-12">
												<p class="text-center" style="margin-top: 12%;"><b>This post doesn't have any image</b></p>
											</div>
										<?php
										}
										?>
										<!-- right hand section -->

										<div class="col-md-4 col-sm-12 d-flex flex-column">

											<div class="d-flex align-items-center p-2 border-bottom">
												<!-- user info  -->
												<div><img src="assets/images/profiles/<?= $post['pfp'] ?>" alt="" height="50" width="50" class="rounded-circle border">
												</div>

												<div class="m-2 d-flex flex-column justify-content-start">
													<h6 style="margin: 0px;"><?= $post['f_name'] ?> <?= $post['l_name'] ?></h6>
												</div>

												<!-- user info end -->
											</div>


											<!-- div for comment section  -->
											<div class="flex-fill align-self-stretch overflow-auto" id="comment-section<?= $post['post_id'] ?>" style="height: 100px;">

												<?php

												if (count($comments) < 1) {
												?>
													<p class="p-3 text-center my-2 nce">No comments on this post yet</p>
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
						<!-- modal for likes -->
						<div class="modal fade" id="likes<?= $post['post_id'] ?>" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
							<div class=" modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<!-- head -->
									<div class="modal-header align-items-center">
										<h5 class="text-dark text-center w-100 m-0" id="exampleModalLabel">
											Liked by
										</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<?php
										if (count($likes) < 1) {
										?>
											<p>No likes currently</p>
										<?php
										}
										foreach ($likes as $like) {
											$sub_user = getUser($like['user_id']);
											$sub_btn = '';
											if (checkSubscribeStatus($like['user_id'])) {
												$sub_btn = '<button class="btn rounded btn-outline-primary unsubbtn" data-user-id="' . $sub_user['user_id'] . '">
											<i class="bi bi-check-circle-fill me-3"></i>Unsubscribe';
											} elseif ($user['user_id'] == $like['user_id']) {
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
						<!-- modal for dislikes -->
						<div class="modal fade" id="dislikes<?= $post['post_id'] ?>" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
							<div class=" modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<!-- head -->
									<div class="modal-header align-items-center">
										<h5 class="text-dark text-center w-100 m-0" id="exampleModalLabel">
											Disliked by
										</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<?php
										if (count($dislikes) < 1) {
										?>
											<p>No dislikes currently</p>
										<?php
										}
										foreach ($dislikes as $dislike) {
											$sub_user = getUser($dislike['user_id']);
											$sub_btn = '';
											if (checkSubscribeStatus($dislike['user_id'])) {
												$sub_btn = '<button class="btn rounded btn-outline-primary unsubbtn" data-user-id="' . $sub_user['user_id'] . '">
											<i class="bi bi-check-circle-fill me-3"></i>Unsubscribe';
											} elseif ($user['user_id'] == $dislike['user_id']) {
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
					<?php
					}
					?>

				</div>

			</div>

			<!-- post section end -->

		</div>
	</div>
	<!-- profile  -->

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
							<input class="form-check-input" type="radio" name="report_options[]" id="report_options[]2" value="Violent or repulsive content" >
							<label class="form-check-label" for="report_options[]2">
								Violent or repulsive content
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="report_options[]" id="report_options[]3" value="Promotes terrorism" >
							<label class="form-check-label" for="report_options[]3">
								Promotes terrorism
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="report_options[]" id="report_options[]4" value="Hateful or abusive content" >
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
							<textarea class="form-control" placeholder="Describe here" id="floatingTextarea2" name = "report_description" style="height: 100px"></textarea>
							<label for="floatingTextarea2">Describe here</label>
						</div>
						<input type="hidden" name="user_email" value="<?=$user['email']?>">
						<input type="hidden" name="user_name" value="<?=$user['f_name']." ".$user['l_name']?>">
						<input type="hidden" name="uploader_name" value="<?=$post['f_name']." ".$post['l_name']?>">
						
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