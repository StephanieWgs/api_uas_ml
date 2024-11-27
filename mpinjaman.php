<?php
require_once "koneksi.php";
class Mpinjaman
{
    public  function get_data()
    {
        global $mysqli;
        $query = "SELECT * FROM pinjaman";
        $result = $mysqli->query($query);
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status'     => 200,
            'message'     => 'Berhasil mendapatkan data pinjaman!',
            'data'         => $data
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function get_data_by_id($id = 0)
    {
        global $mysqli;
        $query = "SELECT * FROM pinjaman";
        if ($id != 0) {
            $query .= " WHERE kode_pinjaman =" . $id . " LIMIT 1";
        }
        $result = $mysqli->query($query);
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status'     => 200,
            'message'     => 'Berhasil mendapatkan data pinjaman!',
            'data'         => $data
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function insert_data()
    {
        global $mysqli;
        $id_pinjaman = $_POST['id_pinjaman'];
        $id_member = $_POST['id_member'];
        $id_pustakawan = $_POST['id_pustakawan'];
        $kode_pinjaman = $_POST['kode_pinjaman'];
        $tgl_pinjam = $_POST['tgl_pinjam'];
        $tgl_kembali = $_POST['tgl_kembali'];
        $status = $_POST['status'];

        $query = "INSERT INTO pinjaman SET
                id_pinjaman = '$_POST[id_pinjaman]',
				id_member 	= '$_POST[id_member]',
				id_pustakawan 	= '$_POST[id_pustakawan]',
                kode_pinjaman = '$_POST[email]',
				tgl_pinjam 	= '$_POST[tgl_pinjam]',
                tgl_kembali 	= '$_POST[tgl_kembali]'
                status 	= '$_POST[status]',";

        $result = mysqli_query($mysqli, $query);

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'pinjaman berhasil ditambah!'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal menambahkan pinjaman...'
            );
        }


        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function update_data($id)
    {
        global $mysqli;

        $result = mysqli_query($mysqli, "UPDATE pinjaman SET
				id_member 	= '$_POST[id_member]',
				id_pustakawan 	= '$_POST[id_pustakawan]',
                kode_pinjaman = '$_POST[email]',
				tgl_pinjam 	= '$_POST[tgl_pinjam]',
                tgl_kembali 	= '$_POST[tgl_kembali]'
                status 	= '$_POST[status]',	
				WHERE id_pinjaman ='$id'");
        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Data pinjaman berhasil di-update!'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal meng-update data pinjaman...'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function delete_data($id)
    {
        global $mysqli;
        $query = "DELETE FROM pinjaman WHERE id_pinjaman='" . $id . "'";
        if (mysqli_query($mysqli, $query)) {
            $response = array(
                'status' => 1,
                'message' => 'Data pinjaman berhasil dihapus!'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal menghapus data pinjaman...'
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
