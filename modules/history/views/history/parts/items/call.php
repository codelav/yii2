<?php
/* @var $username string */
/* @var $body string */
/* @var $footer string */
/* @var $datetime string */
/* @var $iconClass string */
/* @var $content string */
/* @var $deleted bool */
?>
<i class="icon icon-circle icon-main white <?= $iconClass ?>"></i>
<div class="bg-success">
    <?= ($deleted ? '<i>' . $body . '</i>' : $body) ?>
</div>
<?php if ($username !== null): ?>
    <div class="bg-info"><?= $username ?></div>
<?php endif; ?>
<?php if ($content !== null): ?>
    <div class="bg-info">
        <?= $content ?>
    </div>
<?php endif; ?>
<div class="bg-warning">
    <?php if ($footer !== null): ?>
        Called <span><?= $footer ?></span>
    <?php endif; ?>
    <span><?= \app\widgets\DateTime\DateTime::widget(['dateTime' => $datetime]) ?></span>
</div>
