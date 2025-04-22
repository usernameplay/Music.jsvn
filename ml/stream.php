<?php
$secret = 'yourStrongSecret';
$file = $_GET['file'] ?? '';
$expires = $_GET['expires'] ?? '';
$token = $_GET['token'] ?? '';
if (time() > $expires) {
    http_response_code(403);
    exit('Link expired');
}
$expected = hash('sha256', $file . $secret . $expires);
if (!hash_equals($expected, $token)) {
    http_response_code(403);
    exit('Invalid token');
}
$m3u8 = file_get_contents('https://raw.githubusercontent.com/usernameplay/Music.jsvn/refs/heads/main/' . basename($file));
$proxied = preg_replace_callback('/(.*\.ts)/', function ($matches) use ($secret) {
    $ts = $matches[1];
    $expires = time() + 300;
    $token = hash('sha256', $ts . $secret . $expires);
    return "proxy.php?ts=" . urlencode($ts) . "&expires=$expires&token=$token";
}, $m3u8);
header('Content-Type: application/vnd.apple.mpegurl');
echo $proxied;
?>