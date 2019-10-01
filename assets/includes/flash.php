<?php foreach (recupererAlerteMessages() as $message): ?>
    <div class="alert alert-<?= $message['type']; ?>">
        <?= $message['message']; ?>
    </div>
<?php endforeach; ?>