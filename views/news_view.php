<div class="row">

    <?php
    global $app;
    $app->flash();
    ?>

    <div class="col-sm-12">

        <section class="panel">
            <header class="panel-heading">
                News - <?php echo $news['englishtitle'] ?></a>
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
                            <a href="<?php echo imv_url('news_edit&id='.$news['newsid']) ?>"><strong>Edit this News</strong></a>&nbsp;

                            <a title="Edit" href="<?php echo imv_url('news_edit&id='.$news['newsid']) ?>" class="btn btn-xs btn-info">
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
                                    <p dir='<?php echo $dir ?>' lang='<?php echo $locale ?>'><?php echo $news[$title] ?></p>
                                </td>
                            </tr>

                            <tr>
                                <th>Published</th>
                                <td>
                                    <p dir='<?php echo $dir ?>' lang='<?php echo $locale ?>'><?php echo pretty_date($news['creationdate']) ?></p>
                                </td>
                            </tr>

                            <tr>
                                <th>Modified</th>
                                <td>
                                    <p dir='<?php echo $dir ?>' lang='<?php echo $locale ?>'><?php echo pretty_date($news['updatedate']) ?></p>
                                </td>
                            </tr>

                             <tr>
                                <th>Detail</th>
                                <td dir='<?php echo $dir ?>' lang='<?php echo $locale ?>'>
                                    <?php echo $news[$detail] ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>

        </section>

    </div>
</div>
