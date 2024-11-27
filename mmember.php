<?php
require_once "koneksi.php";
class Mmember
{
    public  function get_data()
    {
        global $mysqli;
        $query = "SELECT * FROM member";
        $result = $mysqli->query($query);
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status'     => 200,
            'message'     => 'Berhasil mendapatkan data member!',
            'data'         => $data
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function get_data_by_id($id = 0)
    {
        global $mysqli;
        $query = "SELECT * FROM member";
        if ($id != 0) {
            $query .= " WHERE kode_member =" . $id . " LIMIT 1";
        }
        $result = $mysqli->query($query);
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status'     => 200,
            'message'     => 'Berhasil mendapatkan data member!',
            'data'         => $data
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function insert_data()
    {
        global $mysqli;
        $id_member = $_POST['id_member'];
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $email = $_POST['email'];
        $no_hp = $_POST['no_hp'];

        $query = "INSERT INTO member SET
                id_member = '$id_member',
				nama 	= '$nama',
				alamat 	= '$alamat',
                email = '$email',
				no_hp 	= '$no_hp'";

        $result = mysqli_query($mysqli, $query);

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'member berhasil ditambah!'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal menambahkan member...'
            );
        }


        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function update_data($id)
    {
        global $mysqli;

        $result = mysqli_query($mysqli, "UPDATE member SET
				nama 	= '$_POST[nama]',
				alamat 	= '$_POST[alamat]',
                email = '$_POST[email]',
				no_hp 	= '$_POST[no_hp]',	
				WHERE id_member ='$id'");
        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Data member berhasil di-update!'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal meng-update data member...'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function delete_data($id)
    {
        global $mysqli;
        $query = "DELETE FROM member WHERE id_member='" . $id . "'";
        if (mysqli_query($mysqli, $query)) {
            $response = array(
                'status' => 1,
                'message' => 'Data member berhasil dihapus!'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal menghapus data member...'
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
