<?php
/**
 * News
 *
 * Adds various news related operations
 *
 * List, View, Delete, Create
 */
global $app;

$app->registerPlugin( 'news_list' );
$app->registerPlugin( 'news_view' );
$app->registerPlugin( 'news_delete' );
$app->registerPlugin( 'news_create' );
$app->registerPlugin( 'news_edit' );


function news_list() {
    // retrieve response object
    $response = responseObject();

    // get sureys
    $news = fetch_all_news();

    $data = array( "news" => $news );

    $response->send( 'views/news_list.php', $data );
}


/**
 * Detail page of survey
 *
 * @return array associative array of survey data
 */
function news_view() {
    // retrieve response object
    $response = responseObject();

    $locale = get_var( 'locale', 'en' );

    // response data
    $data = array();

    // language str
    $locale_str = array(
        'en' => array(
            'title' => 'englishtitle',
            'detail' => 'englishdetails',
            'dir' => 'ltr'
        ),
        'ar' => array(
            'title' => 'arabictitle',
            'detail' => 'arabicdetails',
            'dir' => 'rtl'
        ),
        'fr' => array(
            'title' => 'frenchtitle',
            'detail' => 'frenchdetails',
            'dir' => 'ltr'
        )
    );

    $data['locale'] = $locale;
    $data['dir'] = $locale_str[$locale]['dir'];
    $data['title'] = $locale_str[$locale]['title'];
    $data['detail'] = $locale_str[$locale]['detail'];

    // news id from request
    $id = get_var( 'id' );

    // fetch news data
    $news = db_row( 'news', '*', 'newsid', $id );

    if( $news == null ) {
        $response->isTemplate( false );
        $response->Send( '404.html' );
        return;
    }

    $data['news'] = $news;

    $response->send( 'views/news_view.php', $data );
}


/**
 * Create news
 *
 * @return void
 */
function news_create() {
    // create news
    if( $_SERVER['REQUEST_METHOD']=="POST" ) {
        $title = get_var( 'title' );
        $detail = get_var( 'detail' );

        $news_id = insert_news( $title, $detail );

        imv_redirect( 'news_list' );
        exit;
    }

    // retrieve response object
    $response = responseObject();

    // template data
    $data = array(
        'title' => array('en' => '', 'ar' => '', 'fr'=>''),
        'detail' => array('en'=>'', 'ar'=>'', 'fr'=>'')
    );

    $data['txt_btn_submit'] = 'Add';

    $response->send( 'views/news_create.php', $data );
}


/**
 * Edit news
 *
 * @return void
 */
function news_edit() {
    // news id
    $news_id = get_var( 'id' );

    // create new news
    if( $_SERVER['REQUEST_METHOD']=="POST" ) {
        $title = get_var( 'title' );
        $detail = get_var( 'detail' );

        // update
        update_news( $news_id, $title, $detail );

        // flash message
        $_SESSION['message'] = array( 'type' => 'success', 'message' => 'Updated successfully!' );
    }

    // load news
    $news = db_row( 'news', '*', 'newsid', $news_id );

    // template data
    $data = array(
        'title' => array('en' => $news['englishtitle'], 'ar' => $news['arabictitle'], 'fr'=>$news['frenchtitle']),
        'detail' => array('en'=>$news['englishdetails'], 'ar'=>$news['arabicdetails'], 'fr'=>$news['frenchdetails'])
    );

    $data['txt_btn_submit'] = "Save";

    // retrieve response object
    $response = responseObject();

    $response->send( 'views/news_create.php', $data );
}


/**
 * Delete news
 *
 * @return void
 */
function news_delete() {
    $id = get_var( 'id' );

    if( $id == null ) {
        imv_redirect( 'news_list' );
        exit;
    }

    $conn = connectionObject();
    $query = $conn->prepare( 'DELETE FROM news WHERE newsid=?' );
    $query->execute( array( $id ) );

    // flash message
    $_SESSION['message'] = array( 'type' => 'success', 'message' => 'News deleted successfully!' );

    imv_redirect( 'news_list' );
    exit;
}


/**
 * insert news in db
 *
 * @return int news id
 */
function insert_news( $title, $detail ) {
    // news create date
    $current_date = date('Y-m-d H:i:s');

    // connection object
    $conn = connectionObject();

    // insert
    $query = $conn->prepare( 'INSERT INTO news (englishtitle,arabictitle,frenchtitle,englishdetails,arabicdetails,frenchdetails,creationdate,updatedate) VALUES(?,?,?,?,?,?,?)' );
    $query->execute( array( $title['en'], $title['ar'], $title['fr'], $detail['en'], $detail['ar'], $detail['fr'], $current_date,$current_date ) );
    return $conn->lastInsertId();
}


/**
 * fetch news from db
 *
 * @return array list of news
 */
function fetch_all_news() {
    $conn = connectionObject();
    $query = $conn->prepare( 'SELECT * FROM news ORDER BY creationdate DESC' );
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * update news in db
 *
 * @return void
 */
function update_news( $id, $title, $detail ) {
    // connection object
    $conn = connectionObject();

    // update date
    $current_date = date('Y-m-d H:i:s');

    // update
    $sql = 'UPDATE news SET englishtitle=?, arabictitle=?, frenchtitle=?,englishdetails=?,arabicdetails=?,frenchdetails=?,updatedate=? WHERE newsid=?';
    $query = $conn->prepare( $sql );
    $query->execute( array($title['en'],$title['ar'],$title['fr'],$detail['en'],$detail['ar'],$detail['fr'],$current_date,$id) );
    return true;
}
