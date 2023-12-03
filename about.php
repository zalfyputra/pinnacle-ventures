<?php
// Sertakan file konfigurasi database
require_once 'config.php';
// Mulai sesi
$loggedIn = isset($_COOKIE['PHPSESSID']);

// Start the session and get the session ID
session_start();
$session_id = session_id();

// Retrieve username from session ID
$queryUser = "SELECT * FROM users WHERE username = '$session_id'";
$resultUser = mysqli_query($koneksi, $queryUser);

if ($resultUser) {
    // Check if there is data to fetch
    if ($user = mysqli_fetch_assoc($resultUser)) {
        $username = $user['username'];
    } else {
        echo "No data found for the session ID: $session_id";
        header('Location: login.php'); // Redirect ke login.php jika user belum login
        exit();
    }
} else {
    echo "Query failed: " . mysqli_error($koneksi);
}


if (!$loggedIn) {
   header('Location: login.php'); // Redirect ke login.php jika user belum login
   exit();
}

// Logika untuk logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
   if (isset($_SERVER['HTTP_COOKIE'])) {
       $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
       foreach($cookies as $cookie) {
           $parts = explode('=', $cookie);
           $name = trim($parts[0]);
           setcookie($name, '', time()-1000);
           setcookie($name, '', time()-1000, '/');
       }
   }
   header('Location: login.php'); // Redirect ke login.php
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About KemjarA13.com</title>
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
    <div class="container mt-5">
        <p class="text-center" style="font-size: 45px;">Welcome, <?php echo htmlspecialchars($username); ?>!</p>
        <div class="w-100 d-flex mt-5">
            <img src="img/arrow.png" alt="" width="250" class="align-self-center mx-auto" />
        </div>
        <div class="text-center mt-4">
            <a href="download_file.php?file=file.pdf" class="btn btn-primary mt-auto font-weight-bold p-4" style="font-size: 25px; border-radius: 20px;">Press this button</a>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
