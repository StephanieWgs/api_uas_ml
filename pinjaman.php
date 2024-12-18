<?php

// Menangani preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('HTTP/1.1 200 OK');
    exit;
}

require_once "mpinjaman.php";

$data = new Mpinjaman();

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["status"])) {
            $status = $_GET["status"];
            $data->get_data_by_status($status);
        } else {
            $data->get_data();
        }
        break;
    case 'POST':
        if (!empty($_GET["id"])) {
            $id = $_GET["id"];
            $data->update_data($id);
        } else {
            $data->insert_data();
        }
        break;
    case 'DELETE':
        if (!empty($_GET["id"])) {
            $id = $_GET["id"];
            $data->delete_data($id);
        } else {
            echo json_encode(["status" => 0, "message" => "ID is required for DELETE"]);
        }
        break;
    default:
        header("HTTP/1.1 405 Method Not Allowed");
        break;
}
