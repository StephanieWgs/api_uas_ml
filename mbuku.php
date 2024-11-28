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

        // Ambil data dari POST
        $judul = $_POST['judul'];
        $penulis = $_POST['penulis'];
        $penerbit = $_POST['penerbit'];
        $kategori = $_POST['kategori'];
        $tahun = $_POST['tahun'];
        $stok = $_POST['stok'];

        // Ambil kode_buku terakhir dari database
        $query_last_code = "SELECT kode_buku FROM buku WHERE kode_buku LIKE 'BU%' ORDER BY kode_buku DESC LIMIT 1";
        $result_last_code = mysqli_query($mysqli, $query_last_code);
        $last_code = mysqli_fetch_assoc($result_last_code)['kode_buku'];

        if ($last_code) {
            $last_number = (int) substr($last_code, 2);
            $new_number = $last_number + 1;
        } else {
            $new_number = 1;
        }
        $kode_buku = 'BU' . str_pad($new_number, 3, '0', STR_PAD_LEFT);

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
                'message' => 'Buku berhasil ditambah!',
                'kode_buku' => $kode_buku
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal menambahkan buku...'
            );
        }

        // Kembalikan respon dalam format JSON
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

    function update_stock($id, $action)
    {
        global $mysqli;
        $query = mysqli_query($mysqli, "SELECT stok FROM buku WHERE kode_buku = '$id'");
        $buku = mysqli_fetch_assoc($query);
        $stok_sekarang = $buku['stok'];

        if ($action == 'pinjam') {
            $stok_baru = $stok_sekarang - 1;
        } elseif ($action == 'kembali') {
            $stok_baru = $stok_sekarang + 1;
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Aksi tidak valid.'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        if ($stok_baru < 0) {
            $response = array(
                'status' => 0,
                'message' => 'Stok buku tidak mencukupi untuk dipinjam.'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $result = mysqli_query($mysqli, "UPDATE buku SET stok = '$stok_baru' WHERE kode_buku = '$id'");
        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Stok buku berhasil diperbarui.'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Gagal memperbarui stok buku.'
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
