<?php

### **第2部 演習問題**

/*2. **配列と関数:** 数値の配列 `$numbers = [10, 25, 8, 43, 17];` があります。この配列を引数として受け取り、配列内の数値の合計値を計算して返す（`return` する）`sum_array` という名前の関数を作成してください。作成した関数を呼び出し、結果を表示してください。（ヒント: `foreach`でループを回し、合計値を足し算していきます）*/

function sum_array(array $numbers): int {
  $sum = 0;
  foreach ($numbers as $number) {
    $sum += $number;
  }
  return $sum;
}

$numbers = [10, 25, 8, 43, 17];
$result = sum_array($numbers);
echo "配列の合計値: " . $result;

?>