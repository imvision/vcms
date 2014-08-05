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
                        New News
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form role="form" method="post" action="">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">News Title</label>
                                    <input type="text" name="title[en]" class="form-control" value="<?php echo $title['en'] ?>">
                                    <p class="help-block">English text</p>
                                    <input type="text" name="title[ar]" class="form-control" value="<?php echo $title['ar'] ?>" dir="rtl">
                                    <p class="help-block">Arabic text</p>
                                    <input type="text" name="title[fr]" class="form-control" value="<?php echo $title['fr'] ?>">
                                    <p class="help-block">French text</p>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-sm-2">Details (English)</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control ckeditor" name="detail[en]" rows="6"><?php echo $detail['en'] ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-sm-2">Details (Arabic)</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control ckeditor" dir="rtl" name="detail[ar]" rows="6"><?php echo $detail['ar'] ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-sm-2">Details (French)</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control ckeditor" name="detail[fr]" rows="6"><?php echo $detail['fr'] ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-info" type="submit"><?php echo $txt_btn_submit ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
