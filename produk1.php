<?php
header('Content-Type: application/json; charset=utf8');

// Cross Origin Request
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "produk");

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Menampilkan Semua Data TO DO: Buat lebih spesifik (Untuk POSTMAN)
    $sql = "SELECT * FROM produk";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data, JSON_PRETTY_PRINT);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // [POST] Menambahkan data + Use Body, x-www-form-urlencoded in Postman
    $id_produk = $_POST['id_produk']; // All Required since it's a new data
    $nama_produk = $_POST['nama_produk'];
    $harga_produk = $_POST['harga_produk'];
    $deskripsi = $_POST['deskripsi'];
    $sql = "INSERT INTO produk (id_produk, nama_produk, harga_produk, deskripsi) VALUES ('$id_produk', '$nama_produk', '$harga_produk', '$deskripsi')";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "BISA NI"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "GABISA"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // [DELETE] Id only + Use Param in Postman
    $id_produk = $_GET['id_produk'];
    $sql = "DELETE FROM produk WHERE id_produk='$id_produk'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "BISA NI"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "GABISA"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // [PUT] Use All + Use Params in Postman
    parse_str(file_get_contents("php://input"), $_PUT);
    $id_produk = $_PUT['id_produk_update'];
    $new_id_produk = $_PUT['new_id_produk'];

    // Check if a new ID was provided and use it if available
    if (isset($_PUT['new_id_produk']) && !empty($_PUT['new_id_produk'])) {
        // Update the ID in the database
        $sql_update_id_produk = "UPDATE produk SET id_produk='$new_id_produk' WHERE id_produk='$id_produk'";
        $cek_update_id_produk = mysqli_query($koneksi, $sql_update_id_produk);

        // Update the ID variable if the update was successful
        if ($cek_update_id_produk) {
            $id_produk = $new_id_produk;
        }
    }

    $nama_produk = $_PUT['nama_produk_update'];
    $harga_produk = $_PUT['harga_produk_update'];
    $deskripsi = $_PUT['deskripsi_update'];

    $sql = "UPDATE produk SET nama_produk='$nama_produk', harga_produk='$harga_produk', deskripsi='$deskripsi' WHERE id_produk='$id_produk'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "BISA NI"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "GABISA"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
}
?>
