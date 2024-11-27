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

    public function get_data_by_status($status = 0)
    {
        global $mysqli;

        $query = "SELECT * FROM pinjaman WHERE status = '$status'";
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

        $query = "SELECT * FROM pinjaman WHERE kode_pinjaman = " . $id . " LIMIT 1";
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
        $id_member = $_POST['id_member'];
        $kode_buku = $_POST['kode_buku'];
        $tgl_pinjam = $_POST['tgl_pinjam'];

        $query_last_code = "SELECT kode_pinjaman FROM pinjaman WHERE kode_pinjaman LIKE 'PJ%' ORDER BY kode_pinjaman DESC LIMIT 1";
        $result_last_code = mysqli_query($mysqli, $query_last_code);
        $last_code = mysqli_fetch_assoc($result_last_code)['kode_pinjaman'];

        if ($last_code) {
            $last_number = (int) substr($last_code, 2);
            $new_number = $last_number + 1;
        } else {
            $new_number = 1;
        }
        $kode_pinjaman = 'PJ' . str_pad($new_number, 3, '0', STR_PAD_LEFT);

        $query = "INSERT INTO pinjaman SET
        kode_pinjaman = '$kode_pinjaman',
        id_member 	= '$id_member',
        kode_buku = '$kode_buku',
        tgl_pinjam 	= '$tgl_pinjam',
        status 	= 'dipinjam'";

        $result = mysqli_query($mysqli, $query);

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Pinjaman berhasil ditambah!',
                'kode_pinjaman' => $kode_pinjaman
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
        $status = isset($_POST['status']) ? $_POST['status'] : null;

        if ($status == "kembali" && $id != 0) {
            $query = "UPDATE pinjaman SET status = '$status' WHERE kode_pinjaman = '$id'";
        } elseif ($id != 0) {
            $query = "UPDATE pinjaman SET
				id_member 	= '$_POST[id_member]',
                kode_buku = '$_POST[kode_buku]',
				tgl_pinjam 	= '$_POST[tgl_pinjam]',
                status 	= '$_POST[status]'
				WHERE kode_pinjaman ='$id'";
        }

        $result = mysqli_query($mysqli, $query);
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
        $query = "DELETE FROM pinjaman WHERE kode_pinjaman='" . $id . "'";
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
