<?php
declare(strict_types=1);

namespace app\modules\history\renderers;

use app\models\Fax;
use app\modules\history\entity\History;
use app\modules\history\services\HistoryEventRendererInterface;
use Yii;
use yii\helpers\Html;

class BaseFaxRenderer
{
    public function getParams(History $history): array
    {
        /** @var Fax $relatedObject */
        $relatedObject = $history->getRelatedObject($history->object);

        return [
            'username' => $history->user->username ?? null,
            'body' => $this->getBody($history, $relatedObject),
            'footer' => Yii::t('app', '{type} was sent to {group}', [
                'type' => $relatedObject ? $relatedObject->getTypeText() : 'Fax',
                'group' => isset($fax->creditorGroup)
                    ? Html::a($fax->creditorGroup->name, ['creditors/groups'], ['data-pjax' => 0])
                    : ''
            ]),
            'datetime' => $history->ins_ts,
            'iconClass' => 'fa-fax bg-green',
        ];
    }

    public function getTemplate(): string
    {
        return HistoryEventRendererInterface::TEMPLATE_COMMON;
    }

    private function getBody(History $history, Fax $fax): string
    {
        $url = isset($fax->document)
            ? Html::a(
                Yii::t('app', 'view document'),
                $fax->document->getViewUrl(),
                ['target' => '_blank', 'data-pjax' => 0]
            )
            : '';

        return $history->eventText . ($url !== '' ? ' - ' . $url : '');
    }
}
