<!-- ### **第3部 演習問題** -->

<!-- 2. **バリデーション強化:** 上記の掲示板で、名前とメッセージの両方が空の場合は「名前とメッセージを入力してください」とエラーを表示し、どちらか片方だけが空の場合は「〇〇を入力してください」と表示するバリデーション機能を追加してください。 -->


<?php
  // form.htmlから送られてきたデータを受け取る
  $name = $_POST['user_name'];
  $comment = $_POST['comment'];

  // 表示する前に必ず htmlspecialchars() をかける！
  $escaped_name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
  $escaped_comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
?>

<?php
  // エラーメッセージを格納する配列
  $errors = [];

  // POSTされたかチェック
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['user_name'];
        $comment = $_POST['comment'];

        // 名前が空かどうかのバリデーション
        if (empty($name)) {
          $errors[] = "お名前は必須です。";
        }
        // コメントが空かどうかのバリデーション
        if (empty($comment)) {
          $errors[] = "コメントは必須です。";
        }

        // 名前の文字数バリデーション
        if (mb_strlen($name) > 20) {
          $errors[] = "お名前は20文字以内で入力してください。";
        }
        // コメントの文字数バリデーション
        if (mb_strlen($comment) > 20) {
          $errors[] = "コメントは20文字以内で入力してください。";
        }
  }

    // エラーがなければ成功処理、あればエラー表示
    if (empty($errors)) {
      // 成功時の処理（例: DB登録、完了ページ表示など）
      echo "受け付けました！";
    } else {
      // エラーメッセージを表示
      foreach ($errors as $error) {
        echo '<p style="color:red;">' . $error . '</p>';
      }
    }

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