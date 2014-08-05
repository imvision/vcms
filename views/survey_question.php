<?php enqueueScript( 'js/handlebars-v1.3.0.js' ) ?>
<?php enqueueScript( 'js/survey_question.js' ) ?>
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
                        Add a New Question in Survey
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form role="form" method="post" action="">
                                <div class="form-group">
                                    <label for="title">Question</label>
                                    <div class="input-group m-bot15">
                                        <span class="input-group-btn">
                                        <button type="button" class="btn btn-info">English</button>
                                        </span>
                                        <input type="text" name="title[en]" class="form-control">
                                    </div>
                                    <p class="help-block"></p>

                                    <div class="input-group m-bot15">
                                        <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger">Arabic</button>
                                        </span>
                                        <input type="text" name="title[ar]" class="form-control">
                                    </div>
                                    <p class="help-block"></p>

                                    <div class="input-group m-bot15">
                                        <span class="input-group-btn">
                                        <button type="button" class="btn btn-success">French</button>
                                        </span>
                                        <input type="text" name="title[fr]" class="form-control">
                                    </div>
                                    <p class="help-block"></p>

                                    <label for="question_type">Question type</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" checked="" value="1" id="optionsRadios1" name="question_type">
                                            Single Selection
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" value="2" id="optionsRadios2" name="question_type">
                                            Multiple Selection
                                        </label>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-12" id="questions">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success" onclick="return new_answer();">Add another answer</button>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-info" type="submit">Save Question</button>
                                    <a href="<?php echo imv_url('survey_view&id='.$survey_id) ?>" class="btn btn-danger">Go to Survey</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var answer_counter = 1;
</script>

<script id="survey_question" type="text/x-handlebars-template">
<div class="form-group">
    <label for="answers">Answer # {{ answer_counter }}</label>
    <div class="input-group m-bot15">
        <span class="input-group-btn">
        <button type="button" class="btn btn-info">English</button>
        </span>
        <input type="text" name="answer[{{ answer_counter }}][en]" class="form-control">
    </div>
    <div class="input-group m-bot15">
        <span class="input-group-btn">
        <button type="button" class="btn btn-danger">Arabic</button>
        </span>
        <input type="text" name="answer[{{ answer_counter }}][ar]" class="form-control">
    </div>
    <div class="input-group m-bot15">
        <span class="input-group-btn">
        <button type="button" class="btn btn-success">French</button>
        </span>
        <input type="text" name="answer[{{ answer_counter }}][fr]" class="form-control">
    </div>
</div>
</script>
