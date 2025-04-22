<?php
$secret = 'yourStrongSecret';
$ts = $_GET['ts'] ?? '';
$expires = $_GET['expires'] ?? '';
$token = $_GET['token'] ?? '';
if (time() > $expires) {
    http_response_code(403);
    exit('Expired');
}
$expected = hash('sha256', $ts . $secret . $expires);
if (!hash_equals($expected, $token)) {
    http_response_code(403);
    exit('Invalid');
}
$tsUrl = 'https://raw.githubusercontent.com/usernameplay/Music.jsvn/refs/heads/main/' . basename($ts);
header('Content-Type: video/mp2t');
readfile($tsUrl);
?>