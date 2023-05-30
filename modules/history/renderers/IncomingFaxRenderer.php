<?php
declare(strict_types=1);

namespace app\modules\history\renderers;

use app\modules\history\services\HistoryEventRendererInterface;

class IncomingFaxRenderer extends BaseFaxRenderer implements HistoryEventRendererInterface
{
}
