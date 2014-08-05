<div class="col-md-6">
    <section class="panel">
        <div class="panel-body">
            <div class="top-stats-panel">
                <div class="daily-visit">
                    <h4 class="widget-h"><?php echo $title ?></h4>
                    <div id="daily-visit-chart" style="width:100%; height: 100px; display: block">

                    </div>
                    <ul class="chart-meta clearfix">
                        <li class="pull-left visit-chart-value"><?php echo $figure ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    var d1 = [ [0, 10], [1, 20], [2, 33], [3, 24], [4, 45], [5, 96], [6, 47], [7, 18], [8, 11], [9, 13], [10, 21] ];
        var data = ([{
                label: "Daily stat - ",
                data: d1,
                lines: {
                    show: true,
                    fill: true,
                    lineWidth: 2,
                    fillColor: {
                        colors: ["rgba(255,255,255,.1)", "rgba(160,220,220,.8)"]
                    }
                }
            }]);
            var options = {
                grid: {
                    backgroundColor: {
                        colors: ["#fff", "#fff"]
                    },
                    borderWidth: 0,
                    borderColor: "#f0f0f0",
                    margin: 0,
                    minBorderMargin: 0,
                    labelMargin: 20,
                    hoverable: true,
                    clickable: true
                },
                // Tooltip
                tooltip: true,
                tooltipOpts: {
                    content: "%s Date: %x Surveys: %y",
                    shifts: {
                        x: -60,
                        y: 25
                    },
                    defaultTheme: false
                },

                legend: {
                    labelBoxBorderColor: "#ccc",
                    show: false,
                    noColumns: 0
                },
                series: {
                    stack: true,
                    shadowSize: 0,
                    highlightColor: 'rgba(30,120,120,.5)'

                },
                xaxis: {
                    tickLength: 0,
                    tickDecimals: 0,
                    show: true,
                    min: 2,
                    font: {
                        style: "normal",
                        color: "#666666"
                    }
                },
                yaxis: {
                    ticks: 3,
                    tickDecimals: 0,
                    show: true,
                    tickColor: "#f0f0f0",
                    font: {
                        style: "normal",
                        color: "#666666"
                    }
                },
                points: {
                    show: true,
                    radius: 2,
                    symbol: "circle"
                },
                colors: ["#87cfcb", "#48a9a7"]
            };
</script>
