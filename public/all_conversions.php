<?php

/**
 * @file All conversions.
 */

/**
 * Fetch and display all currency conversions.
 */
session_start();
require_once "../src/require.php";

$db = new Database();
$pdo = $db->getPDO();

$query = "SELECT * FROM conversions ORDER BY timestamp DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$conversions = $stmt->fetchAll();

include "../templates/all_conversions_template.php";
