<?php
require_once "koneksi.php";
class Mbuku
{
    public  function get_data()
    {
        global $mysqli;
        $query = "SELECT * FROM buku";
        $result = $mysqli->query($query);
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status'     => 200,
            'message'     => 'Berhasil mendapatkan data buku!',
            'data'         => $data
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function get_data_by_id($id = 0)
    {
        global $mysqli;
        $query = "SELECT * FROM buku";
        if ($id != 0) {
            $query .= " WHERE kode_buku =" . $id . " LIMIT 1";
        }
        $result = $mysqli->query($query);
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status'     => 200,
            'message'     => 'Berhasil mendapatkan data buku!',
            'data'         => $data
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function insert_data()
    {
        global $mysqli;
        $kode_buku = $_POST['kode_buku'];
        $judul = $_POST['judul'];
        $penulis = $_POST['penulis'];
        $penerbit = $_POST['penerbit'];
        $kategori = $_POST['kategori'];
        $tahun = $_POST['tahun'];
        $stok = $_POST['stok'];

        $query = "INSERT INTO buku SET
                kode_buku = '$kode_buku',
                judul = '$judul',
                penulis = '$penulis',
                penerbit = '$penerbit',
                kategori = '$kategori',
                tahun = '$tahun',
                stok = '$stok'";

        $result = mysqli_query($mysqli, $query);

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Buku berhasil ditambah!'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal menambahkan buku...'
            );
        }


        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function update_data($id)
    {
        global $mysqli;

        $result = mysqli_query($mysqli, "UPDATE buku SET
				judul 	= '$_POST[judul]',
				penulis 	= '$_POST[penulis]',
                penerbit = '$_POST[penerbit]',
				kategori 	= '$_POST[kategori]',
				tahun 	= '$_POST[tahun]',
                stok 	= '$_POST[stok]'	
				WHERE kode_buku ='$id'");
        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Data buku berhasil di-update!'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal meng-update data buku...'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function delete_data($id)
    {
        global $mysqli;
        $query = "DELETE FROM buku WHERE kode_buku='" . $id . "'";
        if (mysqli_query($mysqli, $query)) {
            $response = array(
                'status' => 1,
                'message' => 'Data buku berhasil dihapus!'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal menghapus data buku...'
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
