<?php
// index.php
session_start(); // セッションを使うよ（CSRFトークン保存のため）

// Composer のオートロードを読み込む（Carbon を使えるようにする）
require_once __DIR__ . '/vendor/autoload.php';
use Carbon\Carbon;

// Carbon を日本語にする（"5分前" のように日本語で出る）
Carbon::setLocale('ja');

// ===== データベース接続をする =====
$dsn = 'mysql:host=localhost;dbname=posts1_db;charset=utf8mb4';
$user = 'root';   // 本番では専用ユーザを作ってください
$pass = 'root';   // 本番ではもっと強いパスワードにしてください

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}

// ===== CSRFトークンを用意（安全のため） =====
if (empty($_SESSION['token'])) {
    // ランダムなトークンを作る（簡単には当てられない）
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

// ===== POSTリクエストの処理（投稿と削除） =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // トークンチェック
    if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
        exit('不正なリクエストです（CSRFトークンが一致しません）');
    }

    // 挿入処理
    if (isset($_POST['action']) && $_POST['action'] === 'insert') {
        $name = trim($_POST['name'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if ($name !== '' && $content !== '') {
            $stmt = $pdo->prepare("INSERT INTO posts1 (name, content, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$name, $content]);
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    // 削除処理（POSTで行う）
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM posts1 WHERE id = ?");
            $stmt->execute([$id]);
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// ===== 投稿一覧を取得 =====
$stmt = $pdo->query("SELECT * FROM posts1 ORDER BY created_at DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Post クラスを読み込む（上で autoload を読み込んでいるので Carbon が使える）
require_once __DIR__ . '/Post.php';

// DBの行を Post オブジェクトに変換
$posts = [];
foreach ($rows as $row) {
    $posts[] = new Post($row['id'], $row['name'], $row['content'], $row['created_at']);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ひとこと掲示板（OOP + Carbon版）</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        form { margin-bottom: 20px; }
        .post { border-bottom: 1px solid #ccc; padding: 10px 0; }
        .meta { color: #666; font-size: 0.9em; }
        .delete-form { display:inline; margin-left: 10px; }
        textarea { width: 100%; max-width: 800px; }
    </style>
</head>
<body>
    <h2>ひとこと掲示板（OOP + Carbon版）</h2>

    <!-- 投稿フォーム -->
    <form method="post" action="">
        <input type="hidden" name="action" value="insert">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8') ?>">
        <p>
            名前: <input type="text" name="name" required>
        </p>
        <p>
            内容: <br>
            <textarea name="content" rows="3" required></textarea>
        </p>
        <p>
            <button type="submit">投稿する</button>
        </p>
    </form>

    <!-- 投稿一覧 -->
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <div class="meta">
                <strong><?= $post->getName() ?></strong>
                (<?= htmlspecialchars($post->getCreatedAtForHumans(), ENT_QUOTES, 'UTF-8') ?>)
                <!-- 削除はPOSTで行う -->
                <form class="delete-form" method="post" action="" onsubmit="return confirm('削除しますか？')">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $post->getId() ?>">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8') ?>">
                    <button type="submit" style="color:red;">[削除]</button>
                </form>
            </div>
            <div>
                <?= $post->getContent() ?>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>
