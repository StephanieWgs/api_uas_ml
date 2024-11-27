<?php
require_once "koneksi.php";
class Mpengembalian
{
    public  function get_data()
    {
        global $mysqli;
        $query = "SELECT * FROM pengembalian";
        $result = $mysqli->query($query);
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status'     => 200,
            'message'     => 'Berhasil mendapatkan data pengembalian!',
            'data'         => $data
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function get_data_by_id($id = 0)
    {
        global $mysqli;
        $query = "SELECT * FROM pengembalian";
        if ($id != 0) {
            $query .= " WHERE kode_pengembalian =" . $id . " LIMIT 1";
        }
        $result = $mysqli->query($query);
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status'     => 200,
            'message'     => 'Berhasil mendapatkan data pengembalian!',
            'data'         => $data
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }


    public function insert_data()
    {
        global $mysqli;
        $tgl_kembali = $_POST['tgl_kembali'];
        $kode_pinjaman = $_POST['kode_pinjaman'];

        $query_last_code = "SELECT 	kode_pengembalian FROM pengembalian WHERE kode_pengembalian LIKE 'KB%' ORDER BY kode_pengembalian DESC LIMIT 1";
        $result_last_code = mysqli_query($mysqli, $query_last_code);
        $last_code = mysqli_fetch_assoc($result_last_code)['kode_pengembalian'];

        if ($last_code) {
            $last_number = (int) substr($last_code, 2);
            $new_number = $last_number + 1;
        } else {
            $new_number = 1;
        }
        $kode_pengembalian = 'KB' . str_pad($new_number, 3, '0', STR_PAD_LEFT);

        $query = "INSERT INTO pengembalian SET
        kode_pengembalian = '$kode_pengembalian',
        tgl_kembali 	= '$tgl_kembali',
        kode_pinjaman = '$kode_pinjaman'";

        $result = mysqli_query($mysqli, $query);

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Pinjaman berhasil ditambah!',
                'kode_pinjaman' => $kode_pengembalian
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal menambahkan pengembalian...'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }


    function update_data($id)
    {
        global $mysqli;

        $result = mysqli_query($mysqli, "UPDATE pengembalian SET
				tgl_kembali 	= '$_POST[tgl_kembali]',
				kode_pinjaman 	= '$_POST[kode_pinjaman]'
				WHERE kode_pengembalian ='$id'");
        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Data pengembalian berhasil di-update!'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal meng-update data pengembalian...'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function delete_data($id)
    {
        global $mysqli;
        $query = "DELETE FROM pengembalian WHERE kode_pengembalian='" . $id . "'";
        if (mysqli_query($mysqli, $query)) {
            $response = array(
                'status' => 1,
                'message' => 'Data pengembalian berhasil dihapus!'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal menghapus data pengembalian...'
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
