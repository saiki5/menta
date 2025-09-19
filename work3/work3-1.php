<!-- ### **第3部 演習問題** -->
<!-- 1. **ひとこと掲示板:** 名前とメッセージを入力して送信すると、ページ下部に `「名前：メッセージ」` の形式で投稿内容が追記されていく、簡単な掲示板を作成してみましょう。（この段階ではファイルに保存しなくてOKです。送信された内容を `$_POST` で受け取り、表示するだけで構いません）。XSS対策として `htmlspecialchars()` を必ず使用してください。 -->


<?php
  // form.htmlから送られてきたデータを受け取る
  $name = $_POST['user_name'];
  $comment = $_POST['comment'];

  // 表示する前に必ず htmlspecialchars() をかける！
  $escaped_name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
  $escaped_comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>データ受信</title>
</head>
<body>
    <h1>投稿内容</h1>
    <p>お名前: <?php echo $name; ?></p>
    <p>コメント: <?php echo $comment; ?></p>
</body>
</html>