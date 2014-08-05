<div class="row">
    <?php
    global $app;
    $app->flash();
    ?>
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
            Survey - <?php echo $survey['englishtitle'] ?></a>
            <span class="tools pull-right">
            <a class="fa fa-chevron-down" href="javascript:;"></a>
            <a class="fa fa-times" href="javascript:;"></a>
            </span>
        </header>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="mini-stat clearfix">
                        <form method="post" id="frm_locale" action="">
                            <a href="#"><strong>Select Language</strong></a>&nbsp;
                            <select name="locale" onchange="frm_locale.submit();">
                                <option value="en" <?php echo ($locale=="en") ? 'SELECTED':'' ?>>English</option>
                                <option value="ar" <?php echo ($locale=="ar") ? 'SELECTED':'' ?>>Arabic</option>
                                <option value="fr" <?php echo ($locale=="fr") ? 'SELECTED':'' ?>>French</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="mini-stat clearfix">
                        <a href="<?php echo imv_url('survey_edit&id='.$survey['surveyid']) ?>"><strong>Edit this Survey</strong></a>&nbsp;
                        <a title="Edit" href="<?php echo imv_url('survey_edit&id='.$survey['surveyid']) ?>" class="btn btn-xs btn-info">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </a>
                </div>
            </div>
        </div>
        <!-- list question -->
        <div class="row">
            <div class="col-md-12">
                <table  class="display table table-bordered" id="dynamic-table">
                    <tr>
                        <th>Title</th>
                        <td>
                            <p dir='<?php echo $dir ?>' lang='<?php echo $locale ?>'><?php echo $survey[$title] ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th>Creation Date</th>
                        <td><?php echo pretty_date($survey['creationdate']) ?></td>
                    </tr>
                    <tr class="<?php echo ( isExpired( $survey['validdate'] ) ) ? "expired":"" ?>">
                        <th>Expiry Date</th>
                        <td><?php echo pretty_date($survey['validdate']) ?></td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td><?php echo $survey['address'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Survey Stats -->
        <div class="row">
            <div class="col-md-12 charts_all">

                <?php for( $i=1; $i<=count($questions); $i++ ) :?>
                <div class="chart_box" id="q<?php echo $i ?>" style="width: 150px; height: 350;"></div>
                <?php endfor ;?>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo imv_url( 'survey_question&survey_id='.$survey['surveyid'] ) ?>" class="btn btn-success">
                    Add a New Question
                </a>
                <h3>Questions</h3>
                <?php $q=0; foreach( $questions as $question ): ?>
                <table  class="display table table-bordered" id="dynamic-table">
                    <tr>
                        <td>
                            <p dir='<?php echo $dir ?>' lang='<?php echo $locale ?>'>
                            <strong>
                            <?php printf( '%d. %s', ++$q, $question[$title] ) ?>
                            <a title="View" href="<?php echo imv_url('survey_question_edit&id='.$question['questionid']) ?>" class="btn btn-xs btn-info">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a title="Delete" href="<?php echo imv_url('survey_question_delete&id='.$question['questionid'].'&survey_id='.$survey['surveyid']) ?>" class="btn btn-xs btn-danger">
                                <i class="fa fa fa-times-circle"></i>
                            </a>
                            </strong>
                            </p>
                        </td>
                    </tr>
                    <?php $a=0; foreach ( $question['answers'] as $answer ): ?>
                    <tr>
                        <td>
                            <p dir='<?php echo $dir ?>' lang='<?php echo $locale ?>'>
                            <?php printf( '%d. %s', ++$a, $answer[$title] ) ?>
                            </p>
                        </td>
                    </tr>
                    <?php endforeach ;?>
                </table>
                <?php endforeach ;?>
            </div>
        </div>
    </div>
</section>
</div>
</div>
<?php
$all_chart_data = array();

foreach( $questions as $question ) {
    // answers
    $ans = $question['answers'];

    $answer_title = array('Question');
    $answer_number = array( "'".$question[$title]."'");

    foreach( $ans as $an_1 ) {
        $answer_title[] = $an_1[$title];
        $answer_number[] = $an_1['total_answers'];
    }

    $all_chart_data[] =  sprintf( "['%s'], [%s]", implode( "', '", $answer_title  ), implode( ",", $answer_number ) );
}
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);

var question_count = "<?php echo count($questions) ?>";

var q_data = [];
<?php
foreach( $all_chart_data as $q_data ) {
    printf( 'q_data.push([%s]);', $q_data );
}
?>

function drawChart() {

    // Options for Filling frequency
    var options = {
        title: 'Answers stats',
        hAxis: {title: 'Survey', titleTextStyle: {color: 'red',bold:true}, textStyle: {fontSize:9}, slantedText: true, maxAlternation:3},
    };

    for(i=1; i<=question_count; i++) {

        // data for i question
        var data = google.visualization.arrayToDataTable(q_data[i-1]);

        // draw i chart
        var chart = new google.visualization.ColumnChart(document.getElementById('q'+i));
        chart.draw(data, options);
    }
}
</script>
