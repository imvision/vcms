<div class="col-md-6">
        <section class="panel">
            <div class="panel-body">
                <div class="top-stats-panel">
                    <h4 class="widget-h"><?php echo $title ?></h4>
                    <div class="sm-pie">
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php
$rows = array();
foreach( $data as $row ) {
    $rows[] = sprintf( '{ label: "%s", data: %s}', $row['label'], $row['figure'] );
}
?>

<script>
var dataPie = [ <?php echo implode(",",$rows) ?> ];
</script>
