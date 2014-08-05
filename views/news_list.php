<div class="row">

            <?php
            global $app;
            $app->flash();
            ?>

            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        News
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                    </header>
                    <div class="panel-body">

                    <div id="chart_div" style="width: 800px; height: 350;"></div>

                    <div id="chart_gender_stats" style="width: 800px; height: 350;"></div>

                    <div class="adv-table">
                    <table  class="display table table-bordered" id="dynamic-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title (en)</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $i=0; foreach( $news as $news ): ?>

                        <tr class="gradeA">
                            <td><?php echo ++$i ?></td>
                            <td>
                                <a title="View" href="index.php?action=news_view&amp;id=<?php echo $news['newsid']?>&amp;ret=news_list">
                                    <?php echo $news['englishtitle']?>
                                </a>
                            </td>
                            <td>
                                <a title="View" href="index.php?action=news_view&amp;id=<?php echo $news['newsid']?>&amp;ret=news_list" class="btn btn-xs btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a title="View" href="index.php?action=news_edit&amp;id=<?php echo $news['newsid']?>&amp;ret=news_list" class="btn btn-xs btn-success">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <a title="View" href="index.php?action=news_delete&amp;id=<?php echo $news['newsid']?>&amp;ret=news_list" class="btn btn-xs btn-danger" onclick="return confirm('Do you want to delete this news?');">
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
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    </table>
                    </div>
                    </div>
                </section>
            </div>
        </div>
