<?php
enqueueScript( 'js/ckeditor/ckeditor.js' );
?>
<div class="row">
    <?php
    global $app;
    $app->flash();
    ?>
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-12" id="Survey">
                <section class="panel">
                    <header class="panel-heading">
                        Edit User Profile
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form role="form" method="post" action="">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="<?php echo $user['first_name'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="<?php echo $user['last_name'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="text" name="email" class="form-control" value="<?php echo $user['email'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="gender" class="control-label">Gender</label>
                                    <select name='gender'>
                                        <option value="Male" <?php echo (strtolower($user['gender'])=="male")?'SELECTED':'' ?> >Male</option>
                                        <option value="Female" <?php echo (strtolower($user['gender'])=="female")?'SELECTED':'' ?>>Female</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Age</label>
                                    <input type="text" name="age" class="form-control" value="<?php echo $user['age'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Country</label>
                                    <input type="text" name="country" class="form-control" value="<?php echo $user['country'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Latitude</label>
                                    <input type="text" name="lat" class="form-control" value="<?php echo $user['lat'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Longitude</label>
                                    <input type="text" name="lng" class="form-control" value="<?php echo $user['lng'] ?>">
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-info" type="submit">Save</button>
                                    <a href="<?php echo imv_url('users') ?>" class="btn btn-success">All Users</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
