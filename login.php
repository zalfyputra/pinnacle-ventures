<?php
// Sertakan file konfigurasi database
require_once 'config.php';

// Mulai sesi
session_name('session_id');
session_start();

// Cek jika user sudah login (berdasarkan keberadaan session)
$loggedIn = isset($_COOKIE['login']);

if ($loggedIn) {
    header('Location: index.php'); // Redirect kembali ke index.php
    exit();
}

// Logika untuk logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy(); // Menghapus session
    header('Location: index.php'); // Redirect kembali ke index.php
    exit();
}

// Jika metode request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); // Password di-hash dengan MD5

    // Cek apakah username ada di tabel users
    $queryUser = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $resultUser = mysqli_query($koneksi, $queryUser);

    if (mysqli_num_rows($resultUser) == 1) {
        // Jika user bukan admin
        $cookieData = serialize(array('username' => $username));
    } else {
        // Jika login gagal
        echo 'Username atau password salah!';
        exit();
    }

    // Increment session ID
    if (!isset($_SESSION['login_count'])) {
        $_SESSION['login_count'] = 0;
    } else {
        $_SESSION['login_count']++;
    }

    $session_id = $_SESSION['login_count'];
    session_id($session_id); // Set session ID
    setcookie("session_id", $session_id, time() + (86400 * 30), "/");

    // Set session
    $_SESSION['loggedin'] = true;

    // Set cookie
    setcookie('login', $username, time() + (86400 * 30), "/"); // Cookie akan bertahan selama 30 hari
    header('Location: about.php'); // Redirect ke halaman index
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
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

        .form-signin {
            max-width: 330px;
            padding: 1rem;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="text"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
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
        <h1 class="text-center">Login</h1>
        <main class="form-signin w-100 m-auto">
            <form action="login.php" method="post">
                <div>
                    <input type="text" class="form-control" placeholder="Username" id="username" name="username" required>
                </div>
                <div class="mt-4">
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                </div>
                <div class="text-start">
                    <p style="font-size: 12px;">
                        Don't have an account yet? <a href="register.php">Register</a>
                    </p>
                </div>
                <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
            </form>
        </main>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
