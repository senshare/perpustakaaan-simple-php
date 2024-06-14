<?php
// Include file konfigurasi koneksi ke database
include 'koneksi.php';

// Variabel untuk pesan error atau sukses
$msg = '';

// Proses tambah buku baru
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    // Ambil data dari form dan escape nilai-nilainya
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $sinopsis = mysqli_real_escape_string($conn, $_POST['sinopsis']);

    // Proses unggah gambar sampul buku
    $target_dir = "img/covers/";
    $cover_path = $target_dir . basename($_FILES["cover_path"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($cover_path, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["cover_path"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $msg = '<div class="alert error">File bukan gambar.</div>';
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($_FILES["cover_path"]["size"] > 500000) {
        $msg = '<div class="alert error">Ukuran file terlalu besar. Maksimal 500 KB.</div>';
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        $msg = '<div class="alert error">Hanya format JPG, JPEG, dan PNG yang diperbolehkan.</div>';
        $uploadOk = 0;
    }

    // Insert data buku ke database
    $sql_insert = "INSERT INTO buku (judul, penulis, tahun_terbit, sinopsis) VALUES ('$judul', '$penulis', '$tahun_terbit', '$sinopsis')";
    if ($conn->query($sql_insert) === TRUE) {
        // Insert data cover buku ke database
        $book_id = $conn->insert_id; // Ambil ID buku yang baru ditambahkan
        $sql_cover = "INSERT INTO covers (book_id, cover_path) VALUES ('$book_id', '" . basename($_FILES["cover_path"]["name"]) . "')";
        if ($conn->query($sql_cover) === TRUE) {
            $msg = '<div class="alert success">Buku berhasil ditambahkan.</div>';
        } else {
            $msg = '<div class="alert error">Error: ' . $conn->error . '</div>';
        }
    } else {
        $msg = '<div class="alert error">Error: ' . $conn->error . '</div>';
    }
}

// Ambil data yang dikirim dari form
$book_id = $_POST['book_id']; // Misalnya dari form input
$cover_path = $_POST['cover_path']; // Misalnya dari form input

// Tutup koneksi database
$conn->close();

// Redirect kembali ke halaman utama dengan pesan hasil operasi
header("Location: book.php?msg=" . urlencode($msg));
exit;
