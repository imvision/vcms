<?php

global $app;

$app->registerPlugin('users');
$app->registerPlugin('user_delete');
$app->registerPlugin('user_view');
$app->registerPlugin('user_edit');
$app->registerPlugin('user_create');

function users() {
	global $app;
	// retrieve response object
	$response = responseObject();

	// connection
	$conn = connectionObject();

	$users = db_rows("users", "*");

	$data = array();

	$data['users'] = $users;

	$response->Send('views/users.php', $data);
}

function user_delete() {
	global $app;
	// retrieve response object
	$response = responseObject();

	// connection
	$conn = connectionObject();

	// id
	$id = get_var('id');

	$stmt = $conn->prepare('DELETE FROM users WHERE user_id = ?');
	$stmt->execute(array($id));

	$_SESSION['message'] = array('type' => 'success', 'message' => 'User deleted successfully!');

	$move_to = get_var('ret', 'users');

	imv_redirect($move_to);
	exit;
}

function user_view() {
	// retrieve response object
	$response = responseObject();

	// connection
	$conn = connectionObject();

	// id
	$id = get_var('id');

	$users = db_row("users", "*", "user_id", $id);

	$data = array("user" => $users);

	$response->Send('views/profile.php', $data);
}

function user_edit() {
	// retrieve response object
	$response = responseObject();

	// connection
	$conn = connectionObject();

            // id
            $id = get_var('id');

            if( $_SERVER['REQUEST_METHOD'] == "POST" ) {
                update_user( $id, $_POST );
                imv_flash('success','User profile updated!');
            }

            $user = db_row("users", "*", "user_id", $id);

            $data = array("user" => $user);

            $response->Send('views/profile_edit.php', $data);
}

function user_create() {
    // retrieve response object
    $response = responseObject();

    // connection
    $conn = connectionObject();

    if( $_SERVER['REQUEST_METHOD'] == "POST" ) {

        $uploads_dir = dirname(dirname(__FILE__)) . '/uploads/images';

        $tmp_name = $_FILES["profile_pic"]["tmp_name"];
        $name = uniqid() . $_FILES["profile_pic"]["name"];
        move_uploaded_file($tmp_name, "$uploads_dir/$name");

        $_POST['image'] = $name;

        create_new_user( $_POST );
        imv_flash('success','New user added!');
    }

    $data = array();

    $response->Send('views/user_create.php', $data);
}

function create_new_user( $user ) {
    $conn = connectionObject();

    $sql = 'INSERT INTO users (first_name,last_name,image,email,gender,age,country,lat,lng) VALUES (?,?,?,?,?,?,?,?,?)';
    $qry = $conn->prepare( $sql );
    $qry->execute(array($user['first_name'],$user['last_name'],$user['image'],$user['email'],$user['gender'],$user['age'],$user['country'],$user['lat'],$user['lng']));
    return true;
}

function update_user( $id, $user ) {
    $conn = connectionObject();

    $sql = 'UPDATE users SET first_name=?,last_name=?,email=?,gender=?,age=?,country=?,lat=?,lng=? WHERE user_id=?';
    $qry = $conn->prepare( $sql );
    $qry->execute(array($user['first_name'],$user['last_name'],$user['email'],$user['gender'],$user['age'],$user['country'],$user['lat'],$user['lng'],$id));
    return true;
}
