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
                        Create New User
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form role="form" method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="text" name="email" class="form-control" value="">
                                </div>

                                <div class="form-group">
                                    <label for="gender" class="control-label">Gender</label>
                                    <select name='gender'>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Age</label>
                                    <input type="text" name="age" class="form-control" value="">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Country</label>
                                    <input type="text" name="country" class="form-control" value="">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Latitude</label>
                                    <input type="text" name="lat" class="form-control" value="">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Longitude</label>
                                    <input type="text" name="lng" class="form-control" value="">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">Profile Picture</label>
                                    <input type="file" name='profile_pic' id="exampleInputFile">
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-info" type="submit">Create</button>
                                    <a href="<?php echo imv_url('users') ?>" class="btn btn-success">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
