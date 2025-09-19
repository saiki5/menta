<?php foreach ($posts as $post): ?>
    <div class="post">
        <div class="meta">
            <strong><?= $post->getName() ?></strong>
            (<?= $post->getCreatedAt() ?>)
            <a class="delete" href="?delete=<?= $post->getId() ?>" onclick="return confirm('削除しますか？')">[削除]</a>
        </div>
        <div>
            <?= $post->getContent() ?>
        </div>
    </div>
<?php endforeach; ?>
