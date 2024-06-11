<?php

// Definisikan feedback404() jika belum ada
function feedback404() {
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found";
    // Anda juga bisa memasukkan halaman kustom 404 di sini
}

$filename = "list.txt";
$lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $target_string) {
    $target_string =  strtolower($target_string);
    $BRAND = strtoupper($target_string);
    $USMANPRO = str_replace("-", " ", $BRAND);
    $USMANGG = strtolower($target_string);

    // Mendapatkan informasi host dan skema dari URL saat ini
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    
    // Mendapatkan direktori tempat skrip berada
    $dir = rtrim(dirname($_SERVER['PHP_SELF']), '/');

    // Set $urlPath sesuai dengan host, path, dan nama file
    $urlPath = "$protocol://$host$dir/$target_string.html";
    
    // Include file template.php dan teruskan variabel-variabel yang diperlukan
    ob_start(); // Mulai buffer output
    include 'template.php';
    $html_content = ob_get_clean(); // Ambil konten dari buffer output dan bersihkan buffer
    
    // Buat file HTML sesuai dengan isi list.txt
    file_put_contents("$target_string.html", $html_content);
}

date_default_timezone_set('Asia/Jakarta');
$currentTime = date('Y-m-d\TH:i:sP');
echo "FILE DONE CREATE!";
?>
