<?php
$base = 'http://127.0.0.1:8080';

$ch = curl_init($base . '/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
$html = curl_exec($ch);

preg_match('/name="csrf_test_name" value="([^"]+)"/', $html, $m);
$token = $m[1] ?? '';

$fields = [
    'csrf_test_name' => $token,
    'username' => 'admin',
    'password' => 'admin123',
];

$ch2 = curl_init($base . '/login');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt');
curl_setopt($ch2, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
curl_setopt($ch2, CURLOPT_POST, true);
curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query($fields));
curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, false);
$response = curl_exec($ch2);
$info = curl_getinfo($ch2);

echo 'HTTP=' . $info['http_code'] . PHP_EOL;
echo 'REDIRECT=' . ($info['redirect_url'] ?? 'NONE') . PHP_EOL;
if (!empty($response)) {
    echo substr($response, 0, 250) . PHP_EOL;
}
