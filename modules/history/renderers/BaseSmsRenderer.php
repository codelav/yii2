<?php
declare(strict_types=1);

namespace app\modules\history\renderers;

use app\models\Sms;
use app\modules\history\entity\History;
use app\modules\history\services\HistoryEventRendererInterface;
use Yii;

class BaseSmsRenderer
{
    public function getParams(History $history): array
    {
        /** @var Sms $relatedObject */
        $relatedObject = $history->getRelatedObject($history->object);

        return [
            'username' => $history->user->username ?? null,
            'body' => $relatedObject->message ?? '',
            'footer' => $relatedObject->isIncoming()
                ? Yii::t('app', 'Incoming message from {number}', [
                    'number' => $relatedObject->phone_from ?? ''
                ])
                : Yii::t('app', 'Sent message to {number}', [
                    'number' => $relatedObject->phone_to ?? ''
                ]),
            'datetime' => $history->ins_ts,
            'iconClass' => 'icon-sms bg-dark-blue',
        ];
    }

    public function getTemplate(): string
    {
        return HistoryEventRendererInterface::TEMPLATE_COMMON;
    }
}
