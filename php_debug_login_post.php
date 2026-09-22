<?php
$base = 'http://127.0.0.1:8080';
$ch = curl_init($base . '/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
$html = curl_exec($ch);
$info = curl_getinfo($ch);
if ($info['http_code'] !== 200) {
    echo "GET_LOGIN_HTTP=" . $info['http_code'] . PHP_EOL;
    exit;
}

preg_match('/name="csrf_test_name" value="([^"]+)"/', $html, $m);
$token = $m[1] ?? '';

echo 'CSRF=' . ($token ?: 'NONE') . PHP_EOL;

$fields = [
    'csrf_test_name' => $token,
    'username' => 'josh',
    'password' => 'wrongpass',
];

$ch2 = curl_init($base . '/login');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt');
curl_setopt($ch2, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
curl_setopt($ch2, CURLOPT_POST, true);
curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query($fields));
curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, false);
$response = curl_exec($ch2);
$info2 = curl_getinfo($ch2);

echo 'POST_HTTP=' . $info2['http_code'] . PHP_EOL;
printf("HEADER_LOCATION=%s\n", $info2['redirect_url'] ?? 'NONE');
if ($response) {
    echo substr($response, 0, 500) . PHP_EOL;
}
