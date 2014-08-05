<?php enqueueScript( 'js/home.js' ) ?>

<div class="row">

    <div class="col-sm-12">

        <div class="row">

        <?php
        /**
         * Stats bar for Total Users
         */
        $users = array(
            'title' => 'Total Users',
            'figure' => $users_count,
            'color' => 'orange',
            'icon' => 'fa-users',
            'link' => 'index.php?action=users'
        );
        echo \imvision\Template::Render( dirname(__FILE__) . '/layout/stat_bar.php', $users );

        /**
         * Stats bar for Total Surveys
         */
        $surveys = array(
            'title' => 'Total Surveys',
            'figure' => $survey_count,
            'color' => 'tar',
            'icon' => 'fa-file-text-o',
            'link' => 'index.php?action=survey_list'
        );
        echo \imvision\Template::Render( dirname(__FILE__) . '/layout/stat_bar.php', $surveys );

        /**
         * Stats bar for Total Questions
         */
        $questions = array(
            'title' => 'Total Questions',
            'figure' => $question_count,
            'color' => 'pink',
            'icon' => 'fa-question',
            'link' => 'index.php?action=survey_list'
        );
        echo \imvision\Template::Render( dirname(__FILE__) . '/layout/stat_bar.php', $questions );

        /**
         * Stats bar for Total news
         */
        $news = array(
            'title' => 'Total News',
            'figure' => $news_count,
            'color' => 'green',
            'icon' => 'fa-clipboard',
            'link' => 'index.php?action=news_list'
        );
        echo \imvision\Template::Render( dirname(__FILE__) . '/layout/stat_bar.php', $news );
        ?>
        </div>

        <div class="row">

        <?php
        /**
         * Quick Links
         */
        $content = '
            <table class="table table-bordered">
                <tr><td><a href="index.php?action=users">Manage Users</a></td></tr>
                <tr><td><a href="index.php?action=survey_create">Create a new Survey</a></td></tr>
                <tr><td><a href="index.php?action=survey_list">See all Surveys</a></td></tr>
                <tr><td><a href="index.php?action=news_list">News</a></td></tr>
            </table>';

        $portlet = array(
            "title" => "Quick Links",
            "content" => $content
        );
        echo \imvision\Template::Render( dirname(__FILE__) . '/layout/portlet.php', $portlet );

        /**
         * Donut chart for Top Surveys
         */
        $donut = array(
            "title" => "Top Surveys Taken",
            "data" => $top_surveys
        );
        echo \imvision\Template::Render( dirname(__FILE__) . '/layout/pie_chart.php', $donut );
        ?>

        </div>
    </div>
</div>
