<?php
declare(strict_types=1);

use app\core\router\services\PaginationDataMapper;
use app\modules\history\repositories\HistoryRepository;
use app\modules\history\services\HistoryEventRendererResolver;
use app\modules\history\services\HistoryManager;
use yii\di\Instance;

return [
    'definitions' => [
        'historyRepository' => HistoryRepository::class,
        'historyPaginationDataMapper' => PaginationDataMapper::class,
        'historyEventRendererResolver' => HistoryEventRendererResolver::class,
        'historyManager' => [
            ['class' => HistoryManager::class],
            [
                Instance::of('historyRepository'),
                Instance::of('historyEventRendererResolver'),
            ],
        ],
    ],
];
