<?php
$mysqli = new mysqli('localhost', 'root', '', 'db_service');
if ($mysqli->connect_errno) {
    echo 'DB_FAIL:' . $mysqli->connect_error . PHP_EOL;
    exit(1);
}

$res = $mysqli->query('SHOW COLUMNS FROM tb_user');
if (!$res) {
    echo "TABLE_MISSING\n";
    exit(1);
}

while ($row = $res->fetch_assoc()) {
    echo $row['Field'] . '|' . $row['Type'] . PHP_EOL;
}

echo "---\n";

$res = $mysqli->query('SELECT id, fname, lname, uname, pass, role, status FROM tb_user LIMIT 5');
while ($row = $res->fetch_assoc()) {
    echo json_encode($row) . PHP_EOL;
}

$mysqli->close();
