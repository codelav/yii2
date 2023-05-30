<?php
/* @var $username string */
/* @var $body string */
/* @var $oldValue string */
/* @var $newValue string */
/* @var $datetime string */
?>
<div class="bg-success ">
    <?= $body ?>
    <span class='badge badge-pill badge-warning'><?= $oldValue ?? '<i>not set</i>' ?></span>
    &#8594;
    <span class='badge badge-pill badge-success'><?= $newValue ?? '<i>not set</i>' ?></span>
    <span><?= \app\widgets\DateTime\DateTime::widget(['dateTime' => $datetime]) ?></span>
</div>

<?php if ($username !== null): ?>
    <div class="bg-info"><?= $username ?></div>
<?php endif; ?>
