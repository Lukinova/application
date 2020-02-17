<?php
/**
 * @var $user_name
 * @var $user_password
 */

if (isset($_REQUEST['logout'])){
    setcookie('user_password', null, -1, '/');
    header('Location: /');
    die();
}

if (\App\isAdmin())
    header('Location: /');

// sha1
$user_password = '24c05ce1409afb5dad4c5bddeb924a4bc3ea00f5';

if (isset($_POST['user_name']) && @$_POST['user_password'])
if (sha1(@$_POST['user_name'] . @$_POST['user_password']) !== $user_password) {
    echo('Неправильно, повторите попытку!');
} else {
    session_start();
    $_SESSION['user_password'] = $user_password;
    $_SESSION['user_name'] = $user_name;
    setcookie('user_name', $user_name, time() + 50000, '/');
    setcookie('user_password', $_SESSION['user_password'], time() + 50000, '/');
    header('Location: /');
}