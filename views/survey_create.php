<?php
enqueueScript( 'js/advanced-form.js' );
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
                        New Survey
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form role="form" method="post" action="">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Survey Title</label>
                                    <input type="text" name="title[en]" class="form-control" value="<?php echo $title['en'] ?>">
                                    <p class="help-block">English text for survey title</p>
                                    <input type="text" name="title[ar]" class="form-control" value="<?php echo $title['ar'] ?>" dir="rtl">
                                    <p class="help-block">Arabic text for survey title</p>
                                    <input type="text" name="title[fr]" class="form-control" value="<?php echo $title['fr'] ?>">
                                    <p class="help-block">French text for survey title</p>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Location</label>
                                    <input type="text" placeholder="e.g Dubai" name="location" class="form-control" value="<?php echo $location ?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Expiry date</label>
                                    <input type="text" placeholder="e.g 2014-09-27" name="expiry_date" class="form-control default-date-picker" value="<?php echo $expiry ?>">
                                    <p class="help-block">Survey can not be taken after this date</p>
                                </div>
                                <!-- Survey group -->
                                <div class="form-group">
                                    <label>Which users are eligible for this survey?</label>
                                    <div class="radio" onclick="allUsers();">
                                        <label>
                                            <input type="radio" value="1" id="users_all" name="survey_group" checked="">
                                            All users
                                        </label>
                                    </div>
                                    <div class="radio" onclick="ageGroup();">
                                        <label>
                                            <input type="radio" value="2" id="users_age" name="survey_group">
                                            Specify age group
                                        </label>
                                    </div>
                                    <div class="radio" onclick="genderGroup();">
                                        <label>
                                            <input type="radio" value="3" id="users_gender" name="survey_group">
                                            Specify gender
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" id="age_group" style="display:none;">
                                    <label for="inputSuccess" class="col-sm-3 control-label col-lg-3">Age Group</label>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <input type="text" name="age_from" class="form-control">
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="text" name="age_to" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="gender_group" style="display:none;">
                                    <label for="inputSuccess" class="col-sm-3 control-label col-lg-3">Gender Group</label>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="gender_group[]" value="male" id="inlineCheckbox1"> Male
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="gender_group[]" value="female" id="inlineCheckbox2"> Female
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <button class="btn btn-info" type="submit"><?php echo $txt_btn_submit ?></button>
                                    <?php if(isset($link_btn_extra)) :?>
                                    <a href="<?php echo $link_btn_extra ?>" class="btn btn-success"><?php echo $txt_btn_extra ?></a>
                                    <?php endif ;?>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script>
function allUsers() {
var el1 = document.getElementById('age_group');
var el2 = document.getElementById('gender_group');
el1.style.display = 'none';
el2.style.display = 'none';
}
function ageGroup() {
var el1 = document.getElementById('age_group');
var el2 = document.getElementById('gender_group');
el1.style.display = 'block';
el2.style.display = 'none';
}
function genderGroup() {
var el1 = document.getElementById('age_group');
var el2 = document.getElementById('gender_group');
el1.style.display = 'none';
el2.style.display = 'block';
}
</script>
