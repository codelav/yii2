<?php
declare(strict_types=1);

namespace app\modules\history\services;

use app\modules\history\entity\History;

interface HistoryEventRendererInterface
{
    public const TEMPLATE_COMMON = 'common';
    public function getParams(History $history): array;

    public function getTemplate(): string;
}
