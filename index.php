<?php
// Cek jika user sudah login (berdasarkan keberadaan cookie)
$loggedIn = isset($_COOKIE['login']);

// Logika untuk logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    setcookie('login', '', time() - 3600, "/"); // Menghapus cookie
    header('Location: index.php'); // Redirect kembali ke index.php
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Pinnacle Ventures!</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Urbanist:ital,wght@0,600;0,700;0,800;1,600;1,700;1,800&display=swap');
        body {
            background-image: url('img/bg-3.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #FFFFFF; /* Set text color to white */
            font-family: 'Poppins', sans-serif; /* Custom Font */
        }
        .card {
            background-color: #000000;
        }

        .btn-primary {
            background-color: #C852E2;
            border-color: #C852E2;
        }

        h3{
            font-family: 'Urbanist', sans-serif;
            color: white
        }

        .btn-primary:hover {
            background-color: #DA007C;
            border-color: #DA007C;
        }

        /* Custom class for centered text in card */
        .card-title-center, .card-text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="index.php"><h3>Pinnacle Ventures</h3></a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" style="color: #FFFFFF; font-size:20px;"  href="about.php">About</a>
                    </li>
                <?php if ($loggedIn): ?>
                    <li class="nav-item">
                        <a class="nav-link" style="color: #FFFFFF; font-size:20px;"  href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: #FFFFFF; font-size:20px;"  href="?action=logout">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" style="color: #FFFFFF; font-size:20px;"  href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-5" style="padding-top:20%">
        <p class="text-center mb-4 ">Embark on Your Mystical Journey!</p>
        <p class="text-center" style="font-size:20px">Dive into our collection and find the potion that resonates with your soul. Whether for collection, display, or to simply bask in their enigmatic presence, PoisonPantry.com is your portal to a world of arcane wonder.</p>
        <div class="row" style="padding-top:35px">
            <?php
            require_once 'config.php';

            $query = "SELECT * FROM poisons";
            $result = mysqli_query($koneksi, $query);

            while ($product = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-3 d-flex align-items-stretch mb-4">'; // Menggunakan 'd-flex align-items-stretch'
                echo '<div class="card" style="background-color: #000000;">'; // Kartu produk
                // Pastikan semua gambar memiliki ukuran yang sama atau kelas yang membuatnya responsif
                echo '<img class="card-img-top" src="img/' . $product['name'] . '.jpg" alt="' . htmlspecialchars($product['name']) . '" style="width: 100%; height: auto;">';
                echo '<div class="card-body d-flex flex-column">'; // Menggunakan 'd-flex flex-column'
                echo '<h5 class="card-title-center">' . htmlspecialchars($product['name']) . '</h5>';
                echo '<p class="card-text-center">Price: ' . htmlspecialchars($product['pricess']) . '</p>';
              if ($loggedIn): 
                    echo '<a href="buy.php?id=' . $product['id'] . '" class="btn btn-primary mt-auto">Buy</a>';
              else:
                    echo '<button onclick="loginAlert()" class="btn btn-primary mt-auto">Buy</button>';
              endif; 
                
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        function loginAlert() {
            Swal.fire({
                title: 'Login Required',
                text: 'Please log in to continue',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    </script>
</body>
</html>