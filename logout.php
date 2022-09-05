<?php 
session_start();

$jsonData = json_decode($_POST["dataQueryUser"], true); 
if (!empty($_SESSION['user'])){
    unset($_SESSION['user']);
    $response = [
        "status" => true

    ];
    echo json_encode($response);
    die();
}

