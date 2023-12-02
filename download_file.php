<?php
// File: download_file.php

$file = isset($_GET['file']) ? $_GET['file'] : 'file.pdf';

// Langsung menggunakan nilai $file untuk menentukan path file
// Tanpa validasi atau sanitasi
$filePath = $file;

if (file_exists($filePath)) {
    // Mendapatkan ekstensi file untuk menentukan content type
    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

    // Set header berdasarkan ekstensi file
    switch ($fileExtension) {
        case 'pdf':
            header('Content-Type: application/pdf');
            break;
        // Tambahkan case lain jika perlu
        default:
            header('Content-Type: application/octet-stream');
    }

    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    readfile($filePath);
    echo "file ditemukan.";
    exit;
} else {
    echo "Maaf, file tidak ditemukan.";
    // Redirect ke halaman utama atau dashboard
    header('Location: about.php');
}
?>
