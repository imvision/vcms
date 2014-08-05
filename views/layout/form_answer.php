<div class="form-group">
    <label for="answers">Answer # <?php echo $answer_counter ?></label>
    <div class="input-group m-bot15">
        <span class="input-group-btn">
        <button type="button" class="btn btn-info">English</button>
        </span>
        <input type="text" name="answer[old][<?php echo $answerid ?>][en]" class="form-control" value="<?php echo $englishtitle ?>" />
    </div>
    <div class="input-group m-bot15">
        <span class="input-group-btn">
        <button type="button" class="btn btn-danger">Arabic</button>
        </span>
        <input type="text" name="answer[old][<?php echo $answerid ?>][ar]" class="form-control" value="<?php echo $arabictitle ?>" />
    </div>
    <div class="input-group m-bot15">
        <span class="input-group-btn">
        <button type="button" class="btn btn-success">French</button>
        </span>
        <input type="text" name="answer[old][<?php echo $answerid ?>][fr]" class="form-control" value="<?php echo $frenchtitle ?>" />
    </div>
</div>
