<?php
require_once 'config.php'; // Sertakan file konfigurasi database

// Cek jika user sudah login (berdasarkan keberadaan cookie)
$loggedIn = isset($_COOKIE['login']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $hashed_password = md5($password); // Menggunakan MD5 untuk hashing password

    // Cek apakah username sudah ada
    $checkUser = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $checkUser);

    if (mysqli_num_rows($result) > 0) {
        echo "Username sudah ada, coba username lain.";
    } else {
        // Menambahkan user ke database
        $insertUser = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

        if (mysqli_query($koneksi, $insertUser)) {
            // Setelah registrasi berhasil, buat cookie untuk login otomatis
            $cookieData = serialize(array('username' => $username));
            setcookie('userLogin', $username, time() + (86400 * 30), "/");

            // Redirect ke halaman utama atau dashboard
            header('Location: index.php');
            exit();
        } else {
            echo "Terjadi kesalahan saat mendaftarkan pengguna.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Urbanist:ital,wght@0,600;0,700;0,800;1,600;1,700;1,800&display=swap');

        body {
            background-color: #2b3035;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #FFFFFF;
            /* Set text color to white */
            font-family: 'Poppins', sans-serif;
            /* Custom Font */
        }

        .btn-primary:hover {
            background-color: #003d80;
            border-color: #003d80;
        }

        .card-title-center,
        .card-text-center {
            text-align: center;
        }

        .form-register {
            max-width: 330px;
            padding: 1rem;
        }

        .form-register .form-floating:focus-within {
            z-index: 2;
        }

        .form-register input[type="text"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-register input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand">
        <div class="container-fluid">
            <div class="navbar-collapse d-flex">
                <a class="navbar-brand col-3 me-0 font-weight-bold" style="font-size: 24px;" href="index.php">Kemjar A13</a>
                <ul class="navbar-nav col-6 justify-content-center">
                    <?php if ($loggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link active" style="font-size: 24px;" href="about.php">About</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php if ($loggedIn): ?>
                    <div class="d-flex col-3 justify-content-end">
                        <a class="btn btn-primary" href="?action=logout">Logout</a>
                    </div>
                <?php else: ?>
                    <div class="d-flex col-3 justify-content-end">
                        <a class="btn btn-primary" href="login.php">Login</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container" style="padding-top:10%">
        <h1 class="text-center">Register</h1>
        <main class="form-register w-100 m-auto">
            <form action="register.php" method="post">
                <div>
                    <input type="text" class="form-control" placeholder="Username" id="username" name="username" required>
                </div>
                <div class="mt-4">
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                </div>
                <button class="btn btn-primary w-100 py-2 my-4" type="submit">Sign in</button>
            </form>
        </main>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
