<?php
function getFileRowCount($filename)
{
    $file = fopen($filename, "r");
    $rowCount = 0;

    while (!feof($file)) {
        fgets($file);
        $rowCount++;
    }

    fclose($file);

    return $rowCount;
}

// Mendapatkan informasi host, path, dan skema dari URL saat ini
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$path = dirname($_SERVER['REQUEST_URI']);

// Set $urlPath sesuai dengan host, path, dan nama file
$urlPath = "$protocol://$host$path/";

$judulFile = "list.txt";
$jumlahBaris = getFileRowCount($judulFile);
$sitemapFile = fopen("sitemap.xml", "w");
fwrite($sitemapFile, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
fwrite($sitemapFile, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);
$fileLines = file($judulFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($fileLines as $index => $judul) {
    $target_string = strtolower($judul);
    $BRAND = strtoupper($target_string);

    // Membentuk URL untuk setiap file HTML sesuai dengan nama di list.txt
    $htmlURL = $urlPath . $target_string . ".html";

    fwrite($sitemapFile, '  <url>' . PHP_EOL);
    fwrite($sitemapFile, '    <loc>' . $htmlURL . '</loc>' . PHP_EOL);
    date_default_timezone_set('Asia/Jakarta');
    $currentTime = date('Y-m-d\TH:i:sP');
    fwrite($sitemapFile, '    <lastmod>' . $currentTime . '</lastmod>' . PHP_EOL);
    fwrite($sitemapFile, '    <changefreq>daily</changefreq>' . PHP_EOL);
    fwrite($sitemapFile, '  </url>' . PHP_EOL);
}
fwrite($sitemapFile, '</urlset>' . PHP_EOL);
fclose($sitemapFile);
echo "SITEMAP DONE CREATE!";
?>