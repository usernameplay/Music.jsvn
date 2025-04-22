<?php
$secret = 'yourStrongSecret';
$file = 'asianet.m3u8';
$expires = time() + 300; // 5 min valid
$token = hash('sha256', $file . $secret . $expires);
$url = "stream.php?file=$file&expires=$expires&token=$token";
echo "Use this URL in your HTML: $url";
?>