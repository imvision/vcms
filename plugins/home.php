<?php

global $app;

$app->registerPlugin( 'home' );

function home() {

    global $app;

    // retrieve response object
    $response = responseObject();

    $top_surveys = TopSurveys();

    $data = array(
        'users_count' => objectCount( 'users' ),
        'survey_count' => objectCount( 'survey' ),
        'question_count' => objectCount( 'survey_questions' ),
        'news_count' => objectCount( 'news' ),
        'top_surveys' => $top_surveys
    );

    $response->Send( 'views/home.php', $data );
}


function objectCount( $table ) {
     $rows = db_rows( $table, "*" );
     return count( $rows );
}


function TopSurveys() {
    // connection
    $conn = connectionObject();

    $sql = 'SELECT s.`englishtitle` as label,COUNT(a.`answerid`) AS figure FROM survey s
            INNER JOIN survey_answers a
            ON s.`surveyid` = a.`surveyid`
            GROUP BY s.`surveyid`
            ORDER BY figure DESC
            LIMIT 0,4';
    $query = $conn->prepare( $sql );
    $query->execute();
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);

    $total_answer = 0;
    for($i=0; $i<count($rows); $i++) {
        $total_answer += $rows[$i]['figure'];
    }

    for($i=0; $i<count($rows); $i++) {
        $part = round($rows[$i]['figure'] * 100 / $total_answer);
        $rows[$i]['label'] = sprintf("%s (%s%s)", $rows[$i]['label'], $part, '%');
    }
    return $rows;
}
