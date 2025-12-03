<?php
include('../config/db.php');
$res = $conn->query("SELECT DATABASE() as dbname");
$r = $res->fetch_assoc();
echo "CURRENT DATABASE: " . $r['dbname'];
