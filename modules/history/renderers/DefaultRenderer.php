<?php
declare(strict_types=1);

namespace app\modules\history\renderers;

use app\modules\history\entity\History;
use app\modules\history\services\HistoryEventRendererInterface;

class DefaultRenderer implements HistoryEventRendererInterface
{
    private const TEMPLATE_NAME = 'default';

    public function getParams(History $history): array
    {
        return [
            'username' => $history->user->username ?? null,
            'body' => $history->eventText,
            'datetime' => $history->ins_ts,
            'iconClass' => 'fa-gear bg-purple-light',
        ];
    }

    public function getTemplate(): string
    {
        return self::TEMPLATE_NAME;
    }
}
