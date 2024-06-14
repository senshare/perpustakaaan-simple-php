<?php
// Include file konfigurasi koneksi ke database
include 'koneksi.php';

// Query untuk mengambil 5 buku terbaru
$sql = "SELECT b.judul, b.penulis, c.cover_path
        FROM buku b
        LEFT JOIN covers c ON b.id = c.book_id
        ORDER BY b.id DESC
        LIMIT 5";
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
    <title>Perpustakaan Online</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/slider/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">
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
            <h1>Koleksi Terbaru</h1>
            <div class="slider">
                <?php foreach ($books as $book) : ?>
                    <div>
                        <img src="img/covers/<?php echo $book['cover_path']; ?>" alt="<?php echo $book['judul']; ?>">
                        <h3><?php echo $book['judul']; ?></h3>
                        <p><?php echo $book['penulis']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Perpustakaan Online. All rights reserved.</p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.slider').slick({
                autoplay: true,
                autoplaySpeed: 3000,
                dots: true,
                arrows: true,
                prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                nextArrow: '<button type="button" class="slick-next">Next</button>',
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
    </script>
</body>

</html>