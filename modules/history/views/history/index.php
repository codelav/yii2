<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $dataProvider ActiveDataProvider */
/* @var $linkExport string */

?>
<?php Pjax::begin(['id' => 'grid-pjax', 'formSelector' => false]); ?>

<div class="panel panel-primary panel-small m-b-0">
    <div class="panel-body panel-body-selected">
        <div class="pull-sm-right">
            <?= Html::a(Yii::t('app', 'CSV'), $linkExport, ['class' => 'btn btn-success', 'data-pjax' => 0]) ?>
        </div>
    </div>
</div>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'parts/_item',
    'options' => [
        'tag' => 'ul',
        'class' => 'list-group'
    ],
    'itemOptions' => [
        'tag' => 'li',
        'class' => 'list-group-item'
    ],
    'emptyTextOptions' => ['class' => 'empty p-20'],
    'layout' => '{items}{pager}',
]) ?>

<?php Pjax::end(); ?>
