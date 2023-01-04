<?php
session_start();
require_once('../inc/connection.php');

use src\inc\connection;

$connection = new connection;

$stmt = $connection->pdo->prepare("SELECT * FROM posts");

$stmt->execute();

$_SESSION['posts'] = $stmt->fetchAll();