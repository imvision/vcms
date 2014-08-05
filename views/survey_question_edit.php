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
                                        <input type="text" name="title[en]" class="form-control" value="<?php echo $question['englishtitle'] ?>">
                                    </div>
                                    <p class="help-block"></p>

                                    <div class="input-group m-bot15">
                                        <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger">Arabic</button>
                                        </span>
                                        <input type="text" name="title[ar]" class="form-control" value="<?php echo $question['arabictitle'] ?>">
                                    </div>
                                    <p class="help-block"></p>

                                    <div class="input-group m-bot15">
                                        <span class="input-group-btn">
                                        <button type="button" class="btn btn-success">French</button>
                                        </span>
                                        <input type="text" name="title[fr]" class="form-control" value="<?php echo $question['frenchtitle'] ?>">
                                    </div>
                                    <p class="help-block"></p>

                                    <label for="question_type">Question type</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" value="1" name="question_type" <?php echo $question['type']==1 ? 'checked':'' ?> />
                                            Single Selection
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" value="2" name="question_type" <?php echo $question['type']==2 ? 'checked':'' ?> />
                                            Multiple Selection
                                        </label>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-12" id="questions">

                                        <?php foreach( $answers as $key => $answer ) :?>
                                        <?php
                                        $answer['answer_counter'] = ++$key;
                                        echo \imvision\Template::Render( dirname(__FILE__) . '/layout/form_answer.php', $answer );
                                        ?>
                                        <?php endforeach ;?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success" onclick="return new_answer();">Add another answer</button>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-info" type="submit">Save Question</button>
                                    <a href="<?php echo imv_url('survey_view&id='.$question['surveyid']) ?>" class="btn btn-danger">Go to Survey</a>
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
    var answer_counter = '<?php echo count($answers) + 1 ?>';
</script>

<script id="survey_question" type="text/x-handlebars-template">
<div class="form-group">
    <label for="answers">Answer # {{ answer_counter }}</label>
    <div class="input-group m-bot15">
        <span class="input-group-btn">
        <button type="button" class="btn btn-info">English</button>
        </span>
        <input type="text" name="answer[new][{{ answer_counter }}][en]" class="form-control">
    </div>
    <div class="input-group m-bot15">
        <span class="input-group-btn">
        <button type="button" class="btn btn-danger">Arabic</button>
        </span>
        <input type="text" name="answer[new][{{ answer_counter }}][ar]" class="form-control">
    </div>
    <div class="input-group m-bot15">
        <span class="input-group-btn">
        <button type="button" class="btn btn-success">French</button>
        </span>
        <input type="text" name="answer[new][{{ answer_counter }}][fr]" class="form-control">
    </div>
</div>
</script>
