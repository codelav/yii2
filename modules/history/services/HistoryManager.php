<?php
declare(strict_types=1);

namespace app\modules\history\services;

use app\core\database\provider\RepositoryDataProvider;
use app\core\router\entity\data\PaginationData;
use app\modules\history\entity\History;
use app\modules\history\repositories\HistoryRepository;
use DateTimeImmutable;
use Exception;
use RuntimeException;
use Yii;

class HistoryManager
{
    private $historyRepository;
    private $historyEventRendererResolver;

    public function __construct(
        HistoryRepository $historyRepository,
        HistoryEventRendererResolver $historyEventRendererResolver
    ) {
        $this->historyRepository = $historyRepository;
        $this->historyEventRendererResolver = $historyEventRendererResolver;
    }

    public function getHistory(PaginationData $paginationData): RepositoryDataProvider
    {
        $paginatedResult = $this->historyRepository->findAllPaginated($paginationData);

        $historyData = [];

        /** @var History $item */
        foreach ($paginatedResult->getItems() as $item) {
            $renderer = $this->historyEventRendererResolver->get($item->event);

            $historyData[] = [
                'params' => $renderer->getParams($item),
                'template' => $renderer->getTemplate(),
            ];
        }

        return (new RepositoryDataProvider([
            'paginatedResult' => $paginatedResult->setItems($historyData),
            'pagination' => [
                'pageSize' => $paginatedResult->getLimit(),
                'totalCount' => $paginatedResult->getTotalCount(),
            ],
        ]));
    }

    /**
     * @param resource $handle
     * @throws Exception
     */
    public function exportCsv($handle): void
    {
        if (is_resource($handle) === false) {
            throw new RuntimeException('Wrong resource passed');
        }

        fputcsv($handle, [
            Yii::t('app', 'Date'),
            Yii::t('app', 'User'),
            Yii::t('app', 'Type'),
            Yii::t('app', 'Event'),
            Yii::t('app', 'Message'),
        ]);

        foreach ($this->historyRepository->findAllChunked() as $history) {
            fputcsv($handle, [
                (new DateTimeImmutable($history->ins_ts))->format('M j, Y, g:i:s A'),
                $history->user->username ?? Yii::t('app', 'System'),
                $history->object,
                $history->getEventText(),
                $this->historyEventRendererResolver->get($history->event)->getParams($history)['body'],
            ]);
        }
    }
}
