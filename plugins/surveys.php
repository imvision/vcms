<?php
/**
 * Survey
 *
 * Supports various survey operations
 *
 * List, View, Delete, Create
 */
global $app;

// require dirname(__FILE__) . '/survey_group.php';

$app->registerPlugin( 'survey_list' );
$app->registerPlugin( 'survey_view' );
$app->registerPlugin( 'survey_create' );
$app->registerPlugin( 'survey_edit' );
$app->registerPlugin( 'survey_delete' );
$app->registerPlugin( 'survey_question' );
$app->registerPlugin( 'survey_question_edit' );
$app->registerPlugin( 'survey_question_delete' );
$app->registerPlugin( 'survey_stats_data' );

/**
 * List all surveys
 *
 * @return array $surveys array of surveys, each member of array is an associative array
 */
function survey_list() {
    // retrieve response object
    $response = responseObject();

    // get sureys
    $surveys = fetch_all_surveys();

    // Filling frequency
    $top_surveys = SurveyStats();

    // Survey by Gender
    $stats_gender = GenderStats();

    // Survey by Age
    $stats_age = AgeStats();

    $data = array( "surveys" => $surveys, "stats" => $top_surveys, "stats_gender" => $stats_gender,"stats_age"=>$stats_age );

    $response->send( 'views/survey_list.php', $data );
}

/**
 * Detail page of survey
 *
 * @return array associative array of survey data
 */
function survey_view() {
    // retrieve response object
    $response = responseObject();

    // survey id from request
    $id = get_var( 'id' );

    $locale = get_var( 'locale', 'en' );

    // response data
    $data = array();

    // language str
    $locale_str = array(
        'en' => array(
            'title' => 'englishtitle',
            'dir' => 'ltr'
        ),
        'ar' => array(
            'title' => 'arabictitle',
            'dir' => 'rtl'
        ),
        'fr' => array(
            'title' => 'frenchtitle',
            'dir' => 'ltr'
        )
    );

    $data['locale'] = $locale;
    $data['dir'] = $locale_str[$locale]['dir'];
    $data['title'] = $locale_str[$locale]['title'];

    // fetch survey data
    $survey = db_row( 'survey', '*', 'surveyid', $id );

    // fetch survey questions
    $questions = db_rows( 'survey_questions', '*', 'surveyid', $survey['surveyid'] );

    for( $i=0; $i<count($questions); $i++ ) {
        $answers = db_rows( 'survey_answers', '*', 'questionid', $questions[$i]['questionid'] );

        for( $j=0; $j<count($answers); $j++ ) {
            $total_answers = db_row( 'user_answer', 'COUNT(*) as total_answers', 'answerid', $answers[$j]['answerid'] );
            $answers[$j]['total_answers'] = $total_answers['total_answers'];
        }

        $questions[$i]['answers'] = $answers;
    }

    // set in $data
    $data['questions'] = $questions;

    if( $survey == null ) {
        $response->isTemplate( false );
        $response->Send( '404.html' );
        return;
    }

    $data['survey'] = $survey;

    $response->Send( 'views/survey_view.php', $data );
}

/**
 * Create new survey
 *
 * @return void
 */
function survey_create() {
    // create new survey
    if( $_SERVER['REQUEST_METHOD']=="POST" ) {
        $title = get_var( 'title' );
        $expiry = get_var( 'expiry_date' );
        $location = get_var( 'location' );

        // save in db
        $survey_id = insert_new_survey( $title, $location, $expiry );

        // save survey audience
        $survey_aud_spec = array();
        $survey_aud_type = get_var( 'survey_group' );

        if( $survey_aud_type == 2 ) {
            $survey_aud_spec[] = get_var( 'age_from' );
            $survey_aud_spec[] = get_var( 'age_to' );
        }
        else if( $survey_aud_type == 3 ) {
            $survey_aud_spec = get_var( 'gender_group' );
            if( count($survey_aud_spec) == 1 ) {
                $survey_aud_spec[] = "";
            }
        }

        // save survey audience details
        insert_survey_audience( $survey_id, $survey_aud_type, serialize($survey_aud_spec) );

        // notify all survey audience of survey availability
        $message = "New survey added - {$title['englishtitle']}";

        $sg = new SurveyGroupAud( $survey_id, $survey_aud_type, $survey_aud_spec);
        $audience = $sg->getAudience();

        foreach( $audience as $survey_user ) {
            if( $survey_user['device_token'] == "" OR $survey_user['device_type'] == "" )
                continue;

            Notification::Push($survey_user['device_type'], $survey_user['device_token'], $message);
        }

        imv_redirect( 'survey_question&survey_id=' . $survey_id );
        exit;
    }

    // retrieve response object
    $response = responseObject();

    // template data
    $data = array(
        'title' => array('en' => '', 'ar' => '', 'fr'=>''),
        'location' => "",
        'expiry' => ''
    );

    $data['txt_btn_submit'] = 'Save and Add Questions';

    $response->send( 'views/survey_create.php', $data );
}

/**
 * Edit survey
 *
 * @return void
 */
function survey_edit() {
    // survey id
    $survey_id = get_var( 'id' );

    // create new survey
    if( $_SERVER['REQUEST_METHOD']=="POST" ) {
        $title = get_var( 'title' );
        $expiry = get_var( 'expiry_date' );
        $location = get_var( 'location' );

        // update
        update_survey( $survey_id, $title, $location, $expiry );

        // flash message
        $_SESSION['message'] = array( 'type' => 'success', 'message' => 'Updated successfully!' );
    }

    // load survey
    $survey = db_row( 'survey', '*', 'surveyid', $survey_id );

    // template data
    $data = array(
        'title' => array('en' => $survey['englishtitle'], 'ar' => $survey['arabictitle'], 'fr'=>$survey['frenchtitle']),
        'location' => $survey['address'],
        'expiry' => $survey['validdate']
    );

    $data['txt_btn_submit'] = "Save";
    $data['txt_btn_extra'] = "Edit Questions";
    $data['link_btn_extra'] = imv_url('survey_view&id='.$survey_id);

    // retrieve response object
    $response = responseObject();

    $response->send( 'views/survey_create.php', $data );
}

/**
 * List all surveys
 *
 * @return void
 */
function survey_delete() {
    $id = get_var( 'id' );

    if( $id == null ) {
        imv_redirect( 'survey_list' );
        exit;
    }

    $conn = connectionObject();
    $query = $conn->prepare( 'DELETE FROM survey WHERE surveyid=?' );
    $query->execute( array( $id ) );

    // flash message
    $_SESSION['message'] = array( 'type' => 'success', 'message' => 'Survey deleted successfully!' );

    imv_redirect( 'survey_list' );
    exit;
}

/**
 * Create a new question for the survey
 */
function survey_question() {
    // survey id
    $id = get_var( 'survey_id' );

     // create new question
    if( $_SERVER['REQUEST_METHOD']=="POST" ) {

        // question string
        $title = get_var( 'title' );

        $type = get_var( 'question_type' );

        // save new question
        $question_id = insert_new_question( $id, $title, $type );

        // answers
        $answers = get_var( 'answer' );

        // save all answers
        save_all_answers( $answers, $id, $question_id );

        // flash message
        $_SESSION['message'] = array( 'type' => 'success', 'message' => 'Questions created successfully!' );

        // go to survey detail page
        imv_redirect( 'survey_view&id='.$id );
        exit;
    }

    // retrieve response object
    $response = responseObject();

    $data = array( 'survey_id' => $id );

    $response->send( 'views/survey_question.php', $data );
}

/**
 * Edit question and its answers
 */
function survey_question_edit() {
    // survey id
    $qid = get_var( 'id' );

    // create new question
    if( $_SERVER['REQUEST_METHOD']=="POST" ) {

        // question string
        $title = get_var( 'title' );

        $type = get_var( 'question_type' );

        $question = db_row( 'survey_questions', '*', 'questionid', $qid );

        // update question
        update_survey_question( $qid, $title, $type );

        $answers = get_var( 'answer' );

        // save new answers
        save_all_answers( $answers['new'], $question['surveyid'], $qid );

        // update old answers
        update_all_answers( $answers['old'], $qid );

        imv_flash( 'success', 'Updated!' );
    }

    $data = array();

    // load question data
    $data['question'] = db_row( 'survey_questions', '*', 'questionid', $qid );

    // load all answers
    $data['answers'] = db_rows( 'survey_answers', '*', 'questionid', $qid );

    // retrieve response object
    $response = responseObject();

    $response->send( 'views/survey_question_edit.php', $data );
}


function survey_question_delete() {
    $qid = get_var( 'id' );

    $survey_id = get_var( 'survey_id' );

    if( $qid == null ) {
        imv_redirect( 'survey_list' );
        exit;
    }

    $conn = connectionObject();
    $query = $conn->prepare( 'DELETE FROM survey_questions WHERE questionid=?' );
    $query->execute( array( $qid ) );

    // flash message
    imv_flash( 'success', 'Question deleted successfully!' );

    imv_redirect( 'survey_view&id='.$survey_id );
    exit;
}


function survey_stats() {
    $id = get_var( 'id' );

     // fetch survey questions
    $questions = db_rows( 'survey_questions', '*', 'surveyid', $id );

    for( $i=0; $i<count($questions); $i++ ) {
        $answers = db_rows( 'survey_answers', '*', 'questionid', $questions[$i]['questionid'] );

        for( $j=0; $j<count($answers); $j++ ) {
            $answers[$j]['total_answers'] = db_rows( 'user_answer', 'COUNT(*) as total_answers', 'answerid', $answers[$j]['answerid'] );
        }

        $questions[$i]['answers'] = $answers;
    }
    return $questions;
}






/**
 * fetch surveys from db
 *
 * @return array list of surveys
 */
function fetch_all_surveys() {
    $conn = connectionObject();
    $query = $conn->prepare( 'SELECT * FROM survey ORDER BY creationdate DESC' );
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * insert new surveys in db
 *
 * @return int survey id
 */
function insert_new_survey( $title, $location, $expiry ) {
    // survey create date
    $current_date = date('Y-m-d');

    // connection object
    $conn = connectionObject();

    // insert
    $query = $conn->prepare( 'INSERT INTO survey (englishtitle,arabictitle,frenchtitle,creationdate,validdate,address) VALUES(?,?,?,?,?,?)' );
    $query->execute( array( $title['en'], $title['ar'], $title['fr'], $current_date, $expiry, $location ) );
    return $conn->lastInsertId();
}

/**
 * update surveys in db
 *
 * @return void
 */
function update_survey( $id, $title, $location, $expiry ) {
    // connection object
    $conn = connectionObject();

    // update
    $sql = 'UPDATE survey SET englishtitle=?, arabictitle=?, frenchtitle=?, validdate=?, address=? WHERE surveyid=?';
    $query = $conn->prepare( $sql );
    $query->execute( array($title['en'], $title['ar'], $title['fr'], $expiry, $location, $id) );
    return true;
}


/**
 * insert new question in db
 *
 * @return int question id
 */
function insert_new_question( $survey_id, $title, $type ) {
    $current_date = date('Y-m-d');
    $conn = connectionObject();
    $query = $conn->prepare( 'INSERT INTO survey_questions (surveyid,englishtitle,arabictitle,frenchtitle,creationdate,type) VALUES(?,?,?,?,?,?)' );
    $query->execute( array( $survey_id, $title['en'], $title['ar'], $title['fr'], $current_date, $type ) );
    return $conn->lastInsertId();
}

function update_survey_question( $qid, $title, $type ) {
    // conn object
    $conn = connectionObject();

    $sql = 'UPDATE survey_questions SET englishtitle=?,arabictitle=?,frenchtitle=?,type=? WHERE questionid=?';
    $query = $conn->prepare( $sql );
    $query->execute(array($title['en'], $title['ar'], $title['fr'], $type, $qid));
    return true;
}

function save_all_answers( $answers, $survey_id, $question_id ) {

    $current_date = date('Y-m-d');
    $conn = connectionObject();
    $sql = 'INSERT INTO survey_answers (questionid,surveyid,englishtitle,arabictitle,frenchtitle,creationdate) VALUES (?,?,?,?,?,?)';
    $query = $conn->prepare( $sql );

    foreach( $answers as $answer ) {
        if( $answer['en'] != "" ) {
            $query->execute( array( $question_id, $survey_id, $answer['en'], $answer['ar'], $answer['fr'], $current_date ) );
        }
    }
    return true;
}


function update_all_answers( $answers, $qid ) {
    $conn = connectionObject();

    $current_date = date('Y-m-d');

    $sql = 'UPDATE survey_answers SET englishtitle=?,arabictitle=?,frenchtitle=?,updatedate=? WHERE answerid=?';
    $query = $conn->prepare( $sql );

    foreach( $answers as $id => $answer ) {
        $query->execute(array( $answer['en'], $answer['ar'], $answer['fr'], $current_date, $id ));
    }
    return true;
}


function SurveyStats() {
    // connection
    $conn = connectionObject();

    $output = array();

    $surveys_all = db_rows('survey','surveyid,englishtitle');

    foreach ($surveys_all as $survey) {
            $sql = 'SELECT COUNT(DISTINCT userid) AS fillings
                        FROM user_answer
                        WHERE surveyid=?';
            $qry = $conn->prepare($sql);
            $qry->execute(array($survey['surveyid']));
            $data = $qry->fetch(PDO::FETCH_ASSOC);

            $output[$survey['surveyid']] = array('label'=>$survey['englishtitle'], 'figure'=>$data['fillings']);
        }
        return $output;
}


function GenderStats() {
    // get all surveys
    // get stats for each survey
    // count per male/female and add to output

    $conn = connectionObject();

    $output = array();

    $surveys_all = db_rows('survey','surveyid,englishtitle');

    foreach( $surveys_all as $survey ) {
        $sql = 'SELECT DISTINCT userid , u.`gender`
                    FROM user_answer a
                    INNER JOIN users u
                    ON a.`userid` = u.`user_id`
                    WHERE surveyid=?';
        $qry = $conn->prepare($sql);
        $qry->execute(array($survey['surveyid']));
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

        $male_fillout = 0;
        $female_fillout = 0;

        // count male/female submissions
        foreach( $data as $survey_fillout ) {
            if( strtolower($survey_fillout['gender']) == "male" ) {
                ++$male_fillout;
            } else {
                ++$female_fillout;
            }
        }

        $output[$survey['surveyid']] = array('title'=>$survey['englishtitle'], 'male'=>$male_fillout, 'female'=>$female_fillout);
    }

    return $output;
}

function AgeStats() {
    // connection
    $conn = connectionObject();

    $output = array();

    $surveys_all = db_rows('survey','surveyid,englishtitle');

    foreach( $surveys_all as $survey ) {
        $sql = 'SELECT COUNT(DISTINCT userid), u.`age`
                    FROM user_answer a
                    INNER JOIN users u
                    ON a.`userid` = u.`user_id`
                    WHERE surveyid=?
                    GROUP BY age';
        $qry = $conn->prepare($sql);
        $qry->execute(array($survey['surveyid']));
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);

         $output[$survey['surveyid']] = array('title'=> $survey['englishtitle'], '20'=>0,'40'=>0,'60'=>0,'90'=>0);

        foreach( $data as $age_row ) {
            if( $age_row['age'] < 20 ) {
                $output[$survey['surveyid']]['20'] += 1;
            }
            else if( $age_row['age'] <= 40 ) {
                $output[$survey['surveyid']]['40'] += 1;
            }
            else if( $age_row['age'] <= 60 ) {
                $output[$survey['surveyid']]['60'] += 1;
            }
            else if( $age_row['age'] > 60 ) {
                $output[$survey['surveyid']]['90'] += 1;
            }
        }
    }
    return $output;
}

function AgeStatsOld() {
    // connection
    $conn = connectionObject();

    $sql = 'SELECT a.surveyid, s.`englishtitle`, COUNT(a.surveyid) AS figure
                FROM user_answer a
                LEFT JOIN survey s
                ON a.`surveyid` = s.`surveyid`
                WHERE userid IN (SELECT user_id FROM users WHERE age > ? AND age < ?)
                GROUP BY a.`surveyid`';
    $qry = $conn->prepare( $sql );

    // <20
    $qry->execute(array(0,20));
    $teens = $qry->fetchAll(PDO::FETCH_ASSOC);

    // 20-40
    $qry->execute(array(20,40));
    $adults = $qry->fetchAll(PDO::FETCH_ASSOC);

    // 40-60
    $qry->execute(array(40,60));
    $old = $qry->fetchAll(PDO::FETCH_ASSOC);

    // 60-90
    $qry->execute(array(60,90));
    $so_old = $qry->fetchAll(PDO::FETCH_ASSOC);

    $stats_age = array();

    foreach ($teens as $stat) {
        $stats_age[$stat['surveyid']] = array(
            "title" => $stat['englishtitle'],
            '20' => $stat['figure'],
            '40' => 0,
            '60' => 0,
            '90' => 0
        );
    }

    foreach ($adults as $stat) {
        $stats_age[$stat['surveyid']]['40'] = $stat['figure'];
    }

    foreach ($old as $stat) {
        $stats_age[$stat['surveyid']]['60'] = $stat['figure'];
    }

    foreach ($so_old as $stat) {
        $stats_age[$stat['surveyid']]['90'] = $stat['figure'];
    }
    return $stats_age;
}

function insert_survey_audience( $survey_id, $aud_type, $aud_spec ) {
    // connection
    $conn = connectionObject();

    $sql = 'INSERT INTO survey_audience ( surveyid, type, type_specs ) VALUES( ?,?,? )';
    $qry = $conn->prepare( $sql );
    $qry->execute( array( $survey_id, $aud_type, $aud_spec ) );
    return true;
}


function survey_stats_data() {
    $survey = SurveyStats();
    $age = AgeStats();
    $gender = GenderStats();

    // echo 'Survey stats';
    // var_dump($survey);

    echo 'Age stats';
    var_dump($age);

    echo 'Age Stats new';
    var_dump(age_stats());

    // echo 'Gender stats';
    // var_dump($gender);
}
