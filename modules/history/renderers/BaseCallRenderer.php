<?php
declare(strict_types=1);

namespace app\modules\history\renderers;

use app\models\Call;
use app\modules\history\entity\History;

class BaseCallRenderer
{
    protected const TEMPLATE_NAME = 'call';

    public function getParams(History $history): array
    {
        /** @var Call|null $relatedObject */
        $relatedObject = $history->getRelatedObject($history->object);

        return [
            'username' => $history->user->username ?? null,
            'content' => $relatedObject->comment ?? null,
            'body' => $relatedObject === null ? 'Deleted' : $relatedObject->totalStatusText ?? null,
            'datetime' => $history->ins_ts,
            'footer' => $relatedObject->applicant->name ?? null,
            'iconClass' => $relatedObject !== null && $relatedObject->isAnswered()
                ? 'md-phone bg-green'
                : 'md-phone-missed bg-red',
            'deleted' => $relatedObject === null,
        ];
    }

    public function getTemplate(): string
    {
        return static::TEMPLATE_NAME;
    }
}
