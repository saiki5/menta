<?php
require_once 'Post.php';

// DB接続
$pdo = new PDO('mysql:host=localhost;dbname=posts1_db;charset=utf8mb4', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// 投稿データを取得
$stmt = $pdo->query("SELECT * FROM posts1 ORDER BY created_at DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Postオブジェクトの配列に変換
$posts = [];
foreach ($rows as $row) {
    $posts[] = new Post($row['id'], $row['name'], $row['content'], $row['created_at']);
}
