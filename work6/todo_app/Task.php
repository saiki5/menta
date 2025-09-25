<?php
require_once 'Database.php';
require_once __DIR__ . '/vendor/autoload.php';

use Respect\Validation\Validator as v;

class Task
{
    // 全件取得（優先度順＋作成日降順）
    public static function findAll()
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM tasks ORDER BY 
            CASE priority
                WHEN '高' THEN 1
                WHEN '中' THEN 2
                WHEN '低' THEN 3
            END, created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 作成
    public static function create($title, $priority = '中')
    {
        $titleValidator = v::stringType()->notEmpty()->length(1, 100);
        $priorityValidator = v::in(['高', '中', '低']);

        if (!$titleValidator->validate($title)) {
            throw new InvalidArgumentException("タイトルが不正です。");
        }
        if (!$priorityValidator->validate($priority)) {
            throw new InvalidArgumentException("優先度が不正です。");
        }

        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO tasks (title, priority) VALUES (?, ?)");
        return $stmt->execute([$title, $priority]);
    }

    // 状態更新
    public static function updateStatus($id, $is_completed)
    {
        $is_completed = (int) (bool) $is_completed;
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE tasks SET is_completed = ? WHERE id = ?");
        return $stmt->execute([$is_completed, $id]);
    }

    // タイトル更新
    public static function updateTitle($id, $title)
    {
        $titleValidator = v::stringType()->notEmpty()->length(1, 100);
        if (!$titleValidator->validate($title)) {
            throw new InvalidArgumentException("タイトルが不正です。");
        }

        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE tasks SET title = ? WHERE id = ?");
        return $stmt->execute([$title, $id]);
    }

    // 削除
    public static function delete($id)
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}