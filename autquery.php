<?php
session_start();
error_reporting(-1);
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
    
function clear_data($val)
{

    $val = trim($val);
    $val = stripslashes($val);
    $val = strip_tags($val);
    $val = htmlspecialchars($val);

    return $val;
}

$jsonData = json_decode($_POST["dataQueryAut"], true);

$login = clear_data($jsonData['login']);
$password = clear_data($jsonData['password']);

$pattern_login = '/^[^\s()-]{6,}$/';
$pattern_password = '/[0-9a-zA-Z]{6,}/';

$errorFields = [];
$errorFieldsvalid = [];
$errorFieldsText = [];

if ($login === '') {
    $errorFields[] = 'loginaut';
}
if ($password === '') {
    $errorFields[] = 'passwordaut';
}
if (!empty($errorFields)) {

    $response = [
        "status" => false,
        "type" => 1,
        "errormsg" => "Введите логин и пароль",
        "fields" => $errorFields


    ];

    echo json_encode($response);
    die();
}
/* Проверка на ошибки */
if (!preg_match($pattern_login, $login)) {
    $errorFieldsvalid[] = 'loginaut';
    $errorFieldsText['login'] = "Ошибка минимум 6 символов, без пробелов";
}
if (!preg_match($pattern_password, $password)) {
    $errorFieldsvalid[] = 'passwordaut';
    $errorFieldsText['password'] = "Ошибка минимум 6 символов , обязательно должны состоять из цифр и букв";
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

$salt = "a32994b2";
$md5 = md5($password);
$Hashmd5 = $salt . $md5;

$jsonFile = file_get_contents('users.json');
$jsonFileData = json_decode($jsonFile);

foreach ($jsonFileData as $v) {
    if (in_array($v->login, ["$login"]) && in_array($v->password, ["$Hashmd5"])) {
        $_SESSION['user'] = [
            "status" => true,
            "name" => $v->name,
            "message" => "Hello"
        ];
        echo json_encode($_SESSION['user']);
        die();
    }
}
$responseAut = [
    "status" => false,
    "errormsg" => "Неверный логин или пароль",
];
echo json_encode($responseAut);
die();
} else {
    echo "Это не ajax запрос!";
}



