<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TodoList</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: auto; }
        .completed { text-decoration: line-through; color: #999; }
        ul { list-style: none; padding: 0; }
        li { margin: 8px 0; }
    </style>
</head>
<body>
    <h1>TodoList</h1>

    <?php if ($errors): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="index.php" method="post">
        <input type="hidden" name="action" value="create">
        <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
        <input type="text" name="title" placeholder="新しいタスクを入力" required>
        <select name="priority">
            <option value="高">高</option>
            <option value="中" selected>中</option>
            <option value="低">低</option>
        </select>
        <button type="submit">追加</button>
    </form>

    <?php if (empty($tasks)): ?>
        <p>タスクはまだありません。</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <form action="index.php" method="post" style="display:inline;">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($task['id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="checkbox" name="is_completed" <?= $task['is_completed'] ? 'checked' : '' ?> onchange="this.form.submit()">
                        <span class="<?= $task['is_completed'] ? 'completed' : '' ?>">
                            [<?= htmlspecialchars($task['priority'], ENT_QUOTES, 'UTF-8'); ?>]
                            <?= htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    </form>

                    <!-- 編集 -->
                    <form action="index.php" method="post" style="display:inline;">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($task['id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="text" name="title" value="<?= htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        <button type="submit">編集</button>
                    </form>

                    <!-- 削除 -->
                    <form action="index.php" method="post" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($task['id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <button type="submit">削除</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
