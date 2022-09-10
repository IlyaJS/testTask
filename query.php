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
/* $pattern_email = '/^(?!.*@.*@.*$)(?!.*@.*--.*\..*$)(?!.*@.*-\..*$)(?!.*@.*-$)((.*)?@.+(\..{1,11})?)$/'; */
$pattern_email = '/^[^\s()-]*$/';
$pattern_login = '/^[^\s()-]{6,}$/';
$pattern_password = '/[0-9a-zA-Z]{6,}/';
$pattern_confirm_password = '/[0-9a-zA-Z]{6,}/';


$errorFields = [];
$errorFieldsvalid = [];
$errorFieldsText = [];

/* Проверка на существующего пользователя */
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

/* Проверка на адрес электронной почты */
$jsonFile = file_get_contents('users.json');
$jsonFileData = json_decode($jsonFile, true);
foreach ($jsonFileData as $key => $value) {
    if ($value['email'] == $email) {

        $response = [
            "status" => false,
            "type" => 4,
            "errormsg" => "Такой email уже существует"

        ];
        echo json_encode($response);
        die();
    }
}

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
    $errorFieldsText['name'] = "Ошибка должно быть 2 символа только буквы";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorFieldsvalid[] = 'email';
    $errorFieldsText['email'] = "Ошибка ввдение email в формате support@gmail.com";
}
if (!preg_match($pattern_login, $login)) {
    $errorFieldsvalid[] = 'login';
    $errorFieldsText['login'] = "Ошибка минимум 6 символов, без пробелов";
}
if (!preg_match($pattern_password, $password)) {
    $errorFieldsvalid[] = 'password';
    $errorFieldsText['password'] = "Ошибка минимум 6 символов , обязательно должны состоять из цифр и букв";
}
if (!preg_match($pattern_confirm_password, $confirm_password)) {
    $errorFieldsvalid[] = 'confirm_password';
    $errorFieldsText['confirm_password'] = "Ошибка минимум 6 символов , обязательно должны состоять из цифр и букв";
}
if (!empty($errorFieldsvalid)) {

    $response = [
        "status" => false,
        "type" => 2,
        "errormsg" => "Ошибка валидации",
        "fields" => $errorFieldsvalid,
        "fieldsText" => $errorFieldsText


    ];

    echo json_encode($response);
    die();
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
