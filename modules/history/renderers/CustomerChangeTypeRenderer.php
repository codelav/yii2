<?php
declare(strict_types=1);

namespace app\modules\history\renderers;

use app\models\Customer;
use app\modules\history\entity\History;
use app\modules\history\services\HistoryEventRendererInterface;

class CustomerChangeTypeRenderer extends BaseCustomerRenderer implements HistoryEventRendererInterface
{
    public function getParams(History $history): array
    {
        return array_merge(parent::getParams($history), [
            'oldValue' => Customer::getTypeTextByType($history->getDetailOldValue('type')),
            'newValue' => Customer::getTypeTextByType($history->getDetailNewValue('type')),
        ]);
    }
}
