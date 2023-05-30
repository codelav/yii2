<?php
declare(strict_types=1);

namespace app\modules\history\repositories;

use app\core\database\repository\AbstractRepository;
use app\core\router\entity\data\PaginatedResult;
use app\core\router\entity\data\PaginationData;
use app\modules\history\entity\History;
use yii\db\BatchQueryResult;

class HistoryRepository extends AbstractRepository
{
    public function getModelClass(): string
    {
        return History::class;
    }

    public function findAllPaginated(PaginationData $paginationData): PaginatedResult
    {
        $activeQuery = $this
            ->getActiveQuery()
            ->orderBy(['ins_ts' => SORT_DESC, 'id' => SORT_DESC])
            ->with(array_merge(['user'], array_keys(History::OBJECT_NAME_ENTITY_CLASS_MAP)))
        ;

        return $this->getPaginatedResult(
            $activeQuery,
            $paginationData->getPage(),
            $paginationData->getLimit(),
            $paginationData->getOrderBy(),
            $paginationData->getOrderByDirection()
        );
    }

    /**
     * @return BatchQueryResult|History[]
     */
    public function findAllChunked(int $batchSize = 1000)
    {
        return $this
            ->getActiveQuery()
            ->select(['history.*'])
            ->orderBy(['history.ins_ts' => SORT_DESC, 'history.id' => SORT_DESC])
            ->with(array_merge(['user'], array_keys(History::OBJECT_NAME_ENTITY_CLASS_MAP)))
            ->each($batchSize)
        ;
    }
}
