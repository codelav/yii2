<?php
declare(strict_types=1);

namespace app\modules\history\renderers;

use app\models\Customer;
use app\modules\history\entity\History;
use app\modules\history\services\HistoryEventRendererInterface;

class CustomerChangeQualityRenderer extends BaseCustomerRenderer implements HistoryEventRendererInterface
{
    public function getParams(History $history): array
    {
        return array_merge(parent::getParams($history), [
            'oldValue' => Customer::getQualityTextByQuality($history->getDetailOldValue('quality')),
            'newValue' => Customer::getQualityTextByQuality($history->getDetailNewValue('quality')),
        ]);
    }
}
