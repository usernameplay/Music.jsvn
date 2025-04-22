<?php
// stream.php
$token = $_GET['token'] ?? '';
$secret = 'mySecret123';
$validToken = hash('sha256', 'asianet' . $secret);

if ($token !== $validToken) {
    http_response_code(403);
    exit('Access Denied');
}

// Proxy to GitHub raw M3U8
header('Content-Type: application/vnd.apple.mpegurl');
readfile('https://raw.githubusercontent.com/usernameplay/Music.jsvn/refs/heads/main/asianet.m3u8');
?>
