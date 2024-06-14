<?php
// Include file konfigurasi koneksi ke database
include 'koneksi.php';

// Konfigurasi pagination
$results_per_page = 10; // Jumlah buku per halaman

// Hitung jumlah total buku
$sql_count = "SELECT COUNT(*) AS total FROM buku";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_books = $row_count['total'];

// Hitung jumlah halaman
$total_pages = ceil($total_books / $results_per_page);

// Tentukan halaman saat ini
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Query untuk mengambil data buku dengan pagination
$start_limit = ($current_page - 1) * $results_per_page;
$sql = "SELECT b.judul, b.penulis, c.cover_path
        FROM buku b
        LEFT JOIN covers c ON b.id = c.book_id
        LIMIT $start_limit, $results_per_page";
$result = $conn->query($sql);

// Array untuk menyimpan data buku
$books = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

// Tutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku - Perpustakaan Online</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Gaya CSS tambahan jika diperlukan */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .book {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        .book img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .book h3 {
            margin-bottom: 5px;
        }

        .book p {
            margin-bottom: 0;
            font-style: italic;
        }

        .breadcrumb {
            margin-bottom: 10px;
            background-color: #f2f2f2;
            padding: 10px;
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
                    <li><a href="koleksi.php">Buku</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="breadcrumb">
                <a href="index.php">Home</a> > Buku
            </div>
            <h1>Koleksi Buku</h1>
            <button onclick="location.href='book.php'" class="btn btn-primary">Create Book</button>


            <div class="grid-container">
                <?php foreach ($books as $book) : ?>
                    <div class="book">
                        <img src="img/covers/<?php echo $book['cover_path']; ?>" alt="<?php echo $book['judul']; ?>">
                        <h3><?php echo $book['judul']; ?></h3>
                        <p><?php echo $book['penulis']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                    <a href="book.php?page=<?php echo $page; ?>" class="<?php echo ($page == $current_page) ? 'active' : ''; ?>"><?php echo $page; ?></a>
                <?php endfor; ?>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Perpustakaan Online. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>