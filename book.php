<?php include 'koneksi.php';


// Tampilkan pesan jika ada
if (!empty($msg)) {
    echo $msg;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku Baru - Perpustakaan Online</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container form {
            display: grid;
            grid-gap: 10px;
        }

        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container textarea {
            width: calc(100% - 20px);
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container textarea {
            resize: vertical;
        }

        .form-container input[type="file"] {
            font-size: 14px;
        }

        .form-container button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <img src="img/logo.png" alt="Logo Perpustakaan" class="logo">
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="book.php">Buku</a></li>

                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h2>Tambah Buku Baru</h2>
            <form action="process_add_book.php" method="post" enctype="multipart/form-data">
                <input type="text" name="judul" placeholder="Judul" required>
                <input type="text" name="penulis" placeholder="Penulis" required>
                <input type="number" name="tahun_terbit" placeholder="Tahun Terbit" required>
                <textarea name="sinopsis" placeholder="Sinopsis" rows="6" required></textarea>
                <label for="cover_path">Sampul Buku:</label>
                <input type="file" name="cover_path" id="cover_path" accept=".jpg, .jpeg, .png" required>
                <button type="submit" name="submit">Tambah Buku</button>
            </form>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Perpustakaan Online. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>