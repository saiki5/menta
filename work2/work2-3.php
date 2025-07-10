<?php

### **第2部 演習問題**

/*3. **組み込み関数:** 変数 `$email = " user@example.com ";` があります。この変数には前後に余分な半角スペースが含まれています。PHPの組み込み関数を調べて、前後のスペースを削除し、さらに `@` が含まれているかどうかを判定するプログラムを書いてください。（ヒント: `trim()` `strpos()` などを調べてみましょう）*/

$email = "  user@example.com  "; // 前後に余分な半角スペースが含まれる文字列

// trim()関数で前後の空白を削除
$trimmed_email = trim($email);

// strpos()関数で'@'が含まれているか判定
if (strpos($trimmed_email, '@') !== false) {
    echo "変数には'@'が含まれています。" . PHP_EOL;
} else {
    echo "変数には'@'が含まれていません。" . PHP_EOL;
}

echo "元の文字列: " . $email . PHP_EOL;
echo "トリム後の文字列: " . $trimmed_email . PHP_EOL;


?>