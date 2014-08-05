<div class="row">

            <?php
            global $app;
            $app->flash();
            ?>

            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Surveys
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body">

                    <div id="chart_div" style="width: 960px; height: 350;"></div>

                    <div id="chart_gender_stats" style="width: 960px; height: 350;"></div>

                    <div id="chart_age_stats" style="width: 960px; height: 350;"></div>

                    <div class="adv-table">
                    <table  class="display table table-bordered" id="dynamic-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title (en)</th>
                        <th>Address</th>
                        <th>Created</th>
                        <th>Expiry</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $i=0; foreach( $surveys as $survey ): ?>
                        <?php $expired = ( isExpired( $survey['validdate'] ) ) ? "expired":"" ?>

                        <tr class="gradeA <?php echo $expired ?>">
                            <td><?php echo ++$i ?></td>
                            <td>
                                <a title="View" href="index.php?action=survey_view&amp;id=<?php echo $survey['surveyid']?>&amp;ret=survey_list">
                                    <?php echo $survey['englishtitle']?>
                                </a>
                            </td>
                            <td><?php echo $survey['address'] ?></td>
                            <td><?php echo pretty_date($survey['creationdate']) ?></td>
                            <td><?php echo pretty_date($survey['validdate']) ?></td>
                            <td>
                                <a title="View" href="index.php?action=survey_view&amp;id=<?php echo $survey['surveyid']?>&amp;ret=survey_list" class="btn btn-xs btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a title="View" href="index.php?action=survey_edit&amp;id=<?php echo $survey['surveyid']?>&amp;ret=survey_list" class="btn btn-xs btn-success">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <a title="View" href="index.php?action=survey_delete&amp;id=<?php echo $survey['surveyid']?>&amp;ret=survey_list" class="btn btn-xs btn-danger" onclick="return confirm('Do you want to delete this survey?');">
                                    <i class="fa fa-times-circle"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ;?>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Title (en)</th>
                        <th>Address</th>
                        <th>Created</th>
                        <th>Expiry</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    </table>
                    </div>
                    </div>
                </section>
            </div>
        </div>

<?php
// filling frequency
$stats_str = array( "['Survey', 'Submissions']" );
foreach( $stats as $survey ) {
    $stats_str[] = sprintf( "['%s', %s]", $survey['label'], $survey['figure'] );
}

// gender
$gender_str = array( "['Survey', 'Male', 'Female']" );
foreach( $stats_gender as $survey ) {
    $gender_str[] = sprintf( "['%s', %s, %s]", $survey['title'], $survey['male'],$survey['female'] );
}

// age
$age_str = array( "['Survey', '<20', '20-40', '40-60', '>60']" );
foreach( $stats_age as $survey ) {
    $age_str[] = sprintf( "['%s', %s, %s, %s, %s]", $survey['title'], $survey['20'],$survey['40'],$survey['60'],$survey['90'] );
}
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {

        // data for Filling frequency
        var data = google.visualization.arrayToDataTable([
          <?php echo implode( ",", $stats_str ) ?>
        ]);

        // Options for Filling frequency
        var options = {
            title: 'Filling Frequency',
            hAxis: {title: 'Survey', titleTextStyle: {color: 'red',bold:true}, textStyle: {fontSize:9}, slantedText: true, maxAlternation:3},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);

        // data for gender
        var data = google.visualization.arrayToDataTable([
          <?php echo implode( ",", $gender_str ) ?>
        ]);

        // Options for Filling frequency
        var options = {
            title: 'Stats by Gender',
            hAxis: {title: 'Survey', titleTextStyle: {color: 'red',bold:true}, textStyle: {fontSize:9}, slantedText: true, maxAlternation:3},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_gender_stats'));
        chart.draw(data, options);

        // data for age
        var data = google.visualization.arrayToDataTable([
          <?php echo implode( ",", $age_str ) ?>
        ]);

        // Options for Filling frequency
        var options = {
            title: 'Stats by Age',
            hAxis: {title: 'Survey', titleTextStyle: {color: 'red',bold:true}, textStyle: {fontSize:9}, slantedText: true, maxAlternation:3},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_age_stats'));
        chart.draw(data, options);
    }
</script>
