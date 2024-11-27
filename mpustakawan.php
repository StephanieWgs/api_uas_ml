<?php
require_once "koneksi.php";
class Mpustakawan
{
    public  function get_data()
    {
        global $mysqli;
        $query = "SELECT * FROM pustakawan";
        $result = $mysqli->query($query);
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status'     => 200,
            'message'     => 'Berhasil mendapatkan data pustakawan!',
            'data'         => $data
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function get_data_by_id($id = 0)
    {
        global $mysqli;
        $query = "SELECT * FROM pustakawan";
        if ($id != 0) {
            $query .= " WHERE id_pustakawan =" . $id . " LIMIT 1";
        }
        $result = $mysqli->query($query);
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status'     => 200,
            'message'     => 'Berhasil mendapatkan data pustakawan!',
            'data'         => $data
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function login()
    {
        global $mysqli;

        $username = $_POST['username'];
        $password = $_POST['password'];
        

        $sql = "SELECT * FROM pustakawan WHERE username = '$username' AND password = '$password'";
        $result = $mysqli->query($sql);


        if ($result->num_rows > 0) {
            $user_data = $result->fetch_object();
            $response = array(
                'status' => 1,
                'message' => 'Yeyy, login berhasil',
                'data' => $user_data
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Login gagal, silakan coba lagi, semangat menebaknya!'
            );
        }

        // Mengirim response JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
