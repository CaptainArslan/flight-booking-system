<!doctype html>
<html lang="en">
    <head>
        <?php $this->load->view('common/head', @$head); ?>
    </head>
    <body class="antialiased">
        <div class="wrapper">
            <?php 
                $this->load->view('common/sidebar', @$sidebar);
                $this->load->view('common/header', @$header);
            ?>
            <div class="page-wrapper">
                <div class="container-xl">
                    <!-- Page title -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h2 class="page-title"><?php echo $head['page_title']?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="page-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header bg-dark">
                                        <h3 class="mb-0 text-white">Profile Settings</h3>
                                    </div>
                                    <form method="post" action="<?php echo base_url('user/do_upload'); ?>" id="profile_form" enctype="multipart/form-data" accept-charset="utf-8">
                                        <input type="hidden" name="profile_id" value="<?php echo $profile['profile_id']; ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $profile['user_id']; ?>">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-12">
                                                            <div class="mb-2">
                                                                <label>Full Name</label>
                                                                <input type="text" name="user_full_name" value="<?php echo $profile['user_full_name']; ?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-12">
                                                            <div class="mb-2">
                                                                <label>Designation</label>
                                                                <input type="text" name="user_post" value="<?php echo $profile['user_post']; ?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-12">
                                                            <div class="mb-2">
                                                                <label>Work Email</label>
                                                                <input type="email" name="user_work_email" value="<?php echo $profile['user_work_email']; ?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-12">
                                                            <div class="mb-2">
                                                                <label>Work Phone</label>
                                                                <input type="text" name="user_work_number" value="<?php echo $profile['user_work_number']; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 col-12">
                                                            <div class="mb-2">
                                                                <label>Personal Email</label>
                                                                <input type="email" name="user_personal_email" value="<?php echo $profile['user_personal_email']; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-12">
                                                            <div class="mb-2">
                                                                <label>Personal Mobile</label>
                                                                <input type="text" name="user_personal_num" value="<?php echo $profile['user_personal_num']; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-12">
                                                            <div class="mb-2">
                                                                <label>Blood Group</label>
                                                                <select name="user_blood_group" class="form-control">
                                                                    <option>Select Blood Group</option>
                                                                    <option value="A+" <?php echo($profile['user_blood_group'] == 'A+')?'selected':''; ?>>A+</option>
                                                                    <option value="A-" <?php echo($profile['user_blood_group'] == 'A-')?'selected':''; ?>>A-</option>
                                                                    <option value="B+" <?php echo($profile['user_blood_group'] == 'B+')?'selected':''; ?>>B+</option>
                                                                    <option value="B-" <?php echo($profile['user_blood_group'] == 'B-')?'selected':''; ?>>B-</option>
                                                                    <option value="AB+" <?php echo($profile['user_blood_group'] == 'AB+')?'selected':''; ?>>AB+</option>
                                                                    <option value="AB-" <?php echo($profile['user_blood_group'] == 'AB-')?'selected':''; ?>>AB-</option>
                                                                    <option value="O+" <?php echo($profile['user_blood_group'] == 'O+')?'selected':''; ?>>O+</option>
                                                                    <option value="O-" <?php echo($profile['user_blood_group'] == 'O-')?'selected':''; ?>>O-</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-12">
                                                            <div class="mb-2">
                                                                <label>Personal Address</label>
                                                                <input type="text" name="user_personal_address" value="<?php echo $profile['user_personal_address']; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="mb-2">
                                                                <label>Profile Picture</label>
                                                                <input type="file" class="form-control" name="filefoto">
                                                                <small class="help-block">Please Upload jpg|png|jpeg|bmp files</small>
                                                            </div>                                                
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-2">
                                                                <label>Description</label>
                                                                <textarea rows="4" id="mymce" name="user_description" class="form-control"><?php echo $profile['user_description']; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <button type="submit" class="btn btn-success btn-sm">Update Profile</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->load->view('common/footer', @$footer); ?>
            </div>
        </div>
        <?php $this->load->view('common/scripts', @$scripts); ?>
    </body>
</html>