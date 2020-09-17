<?php
include dirname(__FILE__) . "\..\db.php";
header('Content-Type: application/json');

if (!empty($_GET['action'])) {
    call_user_func($_GET['action']);
}

function all()
{
    global $pdo;
    $get = $_GET;
    if (empty($get['id'])) {
        $users = $pdo->prepare("SELECT * FROM users");
        $users->execute();
        $users = $users->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
    } else {
        $user = $pdo->prepare("SELECT * FROM users WHERE id={$get['id']}");
        $user->execute();
        $user = $user->fetch(PDO::FETCH_ASSOC);
        echo json_encode($user);
    }
}

function delete()
{
    global $pdo;
    $get = $_GET;
    $error = false;
    if (empty($get['id'])) {
        $error = "id is missing";
    } else {
        $delete = $pdo->prepare("DELETE FROM users WHERE id = {$get['id']}");
        if (!$delete->execute()) {
            $error = "cannot delete user";
        }
    }
    if (!$error) {
        echo json_encode([
            "success" => true,
        ]);
    } else {
        echo json_encode([
            "error" => true,
            "message" => $error,
        ]);
    }
}
function insert()
{
    global $pdo;
    $post = $_POST;
    if (empty($post['username'])) {
        $error = "username is missing";
    } else if (empty($post['password'])) {
        $error = "password is missing";
    }
    if (empty($error)) {
        $user_exists = $pdo->prepare("SELECT * FROM users WHERE username='{$post['username']}'");
        $user_exists->execute();
        $user_exists = $user_exists->fetch();
        if (!empty($user_exists)) {
            $error = "user already exist";
        } else {
            $users = $pdo->prepare("INSERT INTO users(`username`,`password`) VALUES('{$post['username']}','{$post['password']}')");
            $users->execute();
            $error = false;
        }
    }
    if (!$error) {
        echo json_encode([
            "username" => $post['username'],
            "password" => $post['password'],
        ]);
    } else {
        echo json_encode([
            "error" => true,
            "message" => $error,
        ]);
    }
}
function update()
{
    global $pdo;
    $post = $_POST;
    if (empty($post['username'])) {
        $error = "username is missing";
    } else if (empty($post['password'])) {
        $error = "password is missing";
    }
    if (empty($error)) {
        $user_exists = $pdo->prepare("SELECT * FROM users WHERE username='{$post['username']}'");
        $user_exists->execute();
        $user_exists = $user_exists->fetch();
        if (empty($user_exists)) {
            $error = "user doesn't exist";
        } else {
            $users = $pdo->prepare("UPDATE users SET password='{$post['password']}' WHERE username='{$post['username']}'");
            $users->execute();
            $error = false;
        }
    }
    if (!$error) {
        echo json_encode([
            "username" => $post['username'],
            "password" => $post['password'],
        ]);
    } else {
        echo json_encode([
            "error" => true,
            "message" => $error,
        ]);
    }
}