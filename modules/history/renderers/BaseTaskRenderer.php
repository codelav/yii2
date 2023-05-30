<?php
declare(strict_types=1);

namespace app\modules\history\renderers;

use app\models\Task;
use app\modules\history\entity\History;
use app\modules\history\services\HistoryEventRendererInterface;

class BaseTaskRenderer
{
    public function getParams(History $history): array
    {
        /** @var Task $relatedObject */
        $relatedObject = $history->getRelatedObject('task');

        return [
            'username' => $history->user->username ?? null,
            'body' => $history->eventText . $this->getTaskTitle($relatedObject),
            'iconClass' => 'fa-check-square bg-yellow',
            'datetime' => $history->ins_ts,
            'footer' => isset($relatedObject->customerCreditor->name)
                ? 'Creditor: ' . $relatedObject->customerCreditor->name
                : null,
        ];
    }

    public function getTemplate(): string
    {
        return HistoryEventRendererInterface::TEMPLATE_COMMON;
    }

    private function getTaskTitle(?Task $task): string
    {
        return $task === null ? '' : ': ' . $task->title;
    }
}
