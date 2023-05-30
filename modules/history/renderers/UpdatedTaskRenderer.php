<?php
declare(strict_types=1);

namespace app\modules\history\renderers;

use app\modules\history\services\HistoryEventRendererInterface;

class UpdatedTaskRenderer extends BaseTaskRenderer implements HistoryEventRendererInterface
{
}
