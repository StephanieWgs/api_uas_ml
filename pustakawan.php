<?php
require_once "mpustakawan.php";

$data = new Mpustakawan();

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            $id = $_GET["id"];
            $data->get_data_by_id($id);
        } else {
            $data->get_data();
        }
        break;
    case 'POST':
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $data->login();
        }
        break;
    default:
        header("HTTP/1.1 405 Method Not Allowed");
        break;
}
