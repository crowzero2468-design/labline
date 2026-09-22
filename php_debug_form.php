<?php
$html = file_get_contents('http://127.0.0.1:8080/login');
if (!$html) {
    echo "NO_HTML\n";
    exit;
}

preg_match('/name="csrf_test_name" value="([^"]+)"/', $html, $match);
if (!empty($match[1])) {
    echo 'CSRF_TEST_NAME=' . $match[1] . PHP_EOL;
} else {
    echo 'NO_CSRF_TEST_NAME' . PHP_EOL;
}

preg_match('/name="csrf_test_name" value="([^"]+)"/', $html, $match2);
if (!empty($match2[1])) {
    echo 'TOKEN=' . $match2[1] . PHP_EOL;
}

echo substr($html, 0, 500) . PHP_EOL;
