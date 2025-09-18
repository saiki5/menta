<?php foreach ($posts as $post): ?>
    <div class="post">
        <p><strong><?= $post->getName(); ?></strong></p>
        <p><?= $post->getContent(); ?></p>
        <small><?= $post->getCreatedAt(); ?></small>
    </div>
<?php endforeach; ?>
