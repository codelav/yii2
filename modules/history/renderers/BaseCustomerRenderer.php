<?php
declare(strict_types=1);

namespace app\modules\history\renderers;

use app\modules\history\entity\History;

class BaseCustomerRenderer
{
    protected const TEMPLATE_NAME = 'customer';

    public function getParams(History $history): array
    {
        return [
            'username' => $history->user->username ?? null,
            'body' => $history->eventText,
            'datetime' => $history->ins_ts,
        ];
    }

    public function getTemplate(): string
    {
        return static::TEMPLATE_NAME;
    }
}
