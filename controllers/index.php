<?php
require 'src/class/Database.php';

sessionStart();

try {
    $db = Database::getInstance($dbConfig, $dbParams);
    $pdo = $db->getPDO();
    echo "Connected to MySQL successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

require 'views/index.php';