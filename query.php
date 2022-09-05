<?php
session_start();
function clear_data($val)
{

    $val = trim($val);
    $val = stripslashes($val);
    $val = htmlspecialchars($val);

    return $val;
}



$jsonData = json_decode($_POST["dataQuery"], true);

$name = clear_data($jsonData['name']);
$email = clear_data($jsonData['email']);
$login = clear_data($jsonData['login']);
$password = clear_data($jsonData['password']);
$confirm_password = clear_data($jsonData['confirm_password']);

$pattern_name = '/^[0-9a-zA-Z]{2}$/';
$pattern_email = '/^(?!.*@.*@.*$)(?!.*@.*--.*\..*$)(?!.*@.*-\..*$)(?!.*@.*-$)((.*)?@.+(\..{1,11})?)$/';
$pattern_login = '/^.{6,}$/';
$pattern_password = '/[0-9a-zA-Z]{6,}/';
$pattern_confirm_password = '/[0-9a-zA-Z]{6,}/';


$errorFields = [];
$errorFieldsvalid = [];

if ($name === '') {
    $errorFields[] = 'name';
}
if ($email === '') {
    $errorFields[] = 'email';
}
if ($login === '') {
    $errorFields[] = 'login';
}
if ($password === '') {
    $errorFields[] = 'password';
}
if ($confirm_password === '') {
    $errorFields[] = 'confirm_password';
}
if (!empty($errorFields)) {

    $response = [
        "status" => false,
        "type" => 1,
        "errormsg" => "Поля не заполнены",
        "fields" => $errorFields


    ];

    echo json_encode($response);
    die();
}

if (!preg_match($pattern_name, $name)) {
    $errorFieldsvalid[] = 'name';
}
if (!preg_match($pattern_email, $email)) {
    $errorFieldsvalid[] = 'email';
}
if (!preg_match($pattern_login, $login)) {
    $errorFieldsvalid[] = 'login';
}
if (!preg_match($pattern_password, $password)) {
    $errorFieldsvalid[] = 'password';
}
if (!preg_match($pattern_confirm_password, $confirm_password)) {
    $errorFieldsvalid[] = 'confirm_password';
}
if (!empty($errorFieldsvalid)) {

    $response = [
        "status" => false,
        "type" => 2,
        "errormsg" => "Ошибка валидации",
        "fields" => $errorFieldsvalid


    ];

    echo json_encode($response);
    die();
}


$jsonFile = file_get_contents('users.json');
$jsonFileData = json_decode($jsonFile, true);
foreach ($jsonFileData as $key => $value) {
    if ($value['login'] == $login) {

        $response = [
            "status" => false,
            "type" => 3,
            "errormsg" => "Такой логин уже существует"

        ];
        echo json_encode($response);
        die();
    }
}

if ($password === $confirm_password) {
    $salt = "a32994b2";
    $md5 = md5($password);
    $Hashmd5 = $salt . $md5;
    $array = array(
        "name" => $name,
        "email" => $email,
        "login" => $login,
        "password" => $Hashmd5,
        "confirm_password" => $Hashmd5

    );


    $resultData = $tempArray = array();

    $data = $array;
    if (($inp = file_get_contents('users.json')) != false) {
        $tempArray = json_decode($inp, true);
    }

    array_push($tempArray, $data);
    $resultData[] = $tempArray;
    $jsonData1 = json_encode($tempArray);
    file_put_contents('users.json', $jsonData1);

    $response = [
        "status" => true,
        "errormsg" => "Регистрация прошла успешно!"
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
} else {

    $response = [
        "status" => false,
        "errormsg" => "Пароли не совпадают!"
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
