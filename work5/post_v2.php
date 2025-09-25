<?php foreach ($posts as $post): ?>
    <div class="post">
        <p><strong><?= $post->getName(); ?></strong></p>
        <p><?= $post->getContent(); ?></p>
        <small><?= $post->getCreatedAtDiff(); ?></small>
    </div>
<?php endforeach; ?>
