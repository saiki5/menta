<?php
// ===== データベース接続 =====
$dsn = 'mysql:host=localhost;dbname=posts1_db;charset=utf8mb4';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}

// ===== 投稿処理 =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'insert') {
    $name = trim($_POST['name']);
    $content = trim($_POST['content']);

    if ($name !== '' && $content !== '') {
        $stmt = $pdo->prepare("INSERT INTO posts1 (name, content, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$name, $content]);
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// ===== 削除処理 =====
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM posts1 WHERE id = ?");
        $stmt->execute([$id]);
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// ===== 投稿一覧取得 =====
$stmt = $pdo->query("SELECT * FROM posts1 ORDER BY created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ひとこと掲示板</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        form { margin-bottom: 20px; }
        .post { border-bottom: 1px solid #ccc; padding: 10px 0; }
        .meta { color: #666; font-size: 0.9em; }
        .delete { color: red; margin-left: 10px; }
    </style>
</head>
<body>

<h2>ひとこと掲示板</h2>

<!-- 投稿フォーム -->
<form method="post" action="">
    <input type="hidden" name="action" value="insert">
    <p>
        名前: <input type="text" name="name" required>
    </p>
    <p>
        内容: <input type="text" name="content" size="60" required>
    </p>
    <p>
        <button type="submit">投稿する</button>
    </p>
</form>

<!-- 投稿一覧 -->
<?php foreach ($posts as $post): ?>
    <div class="post">
        <div class="meta">
            <strong><?= htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8') ?></strong>
            (<?= htmlspecialchars($post['created_at'], ENT_QUOTES, 'UTF-8') ?>)
            <a class="delete" href="?delete=<?= $post['id'] ?>" onclick="return confirm('削除しますか？')">[削除]</a>
        </div>
        <div>
            <?= nl2br(htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8')) ?>
        </div>
    </div>
<?php endforeach; ?>

</body>
</html>
