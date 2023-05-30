<?php
/* @var $username string */
/* @var $body string */
/* @var $datetime string */
/* @var $iconClass string */
?>
<i class="icon icon-circle icon-main white <?= $iconClass ?>"></i>
<div class="bg-success ">
    <?= $body ?>
    <span><?= \app\widgets\DateTime\DateTime::widget(['dateTime' => $datetime]) ?></span>
</div>
<?php if ($username !== null): ?>
    <div class="bg-info"><?= $username ?></div>
<?php endif; ?>
