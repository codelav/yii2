<?php
declare(strict_types=1);

namespace app\core\database\repository;

use app\core\router\entity\data\PaginatedResult;
use RuntimeException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;

abstract class AbstractRepository
{
    private const SORTS = [
        'ASC' => SORT_ASC,
        'DESC' => SORT_DESC,
    ];

    abstract public function getModelClass(): string;

    public function createModel(ActiveRecord $model): ActiveRecord
    {
        if ($model->save() === false) {
            throw new RuntimeException('failed to create');
        }

        return $model;
    }

    public function updateModel(ActiveRecord $model): ActiveRecord
    {
        if ($model->update() === false) {
            throw new RuntimeException('failed to update');
        }

        return $model;
    }

    public function deleteModel(ActiveRecord $model): void
    {
        if ($model->delete() === false) {
            throw new RuntimeException('failed to delete');
        }
    }

    public function getPaginatedResult(
        ActiveQuery $activeQuery,
        int $page,
        int $limit,
        ?string $orderBy,
        string $orderByDirection
    ): PaginatedResult {
        $query = $activeQuery
            ->limit($limit)
            ->offset(($page - 1) * $limit)
        ;

        if ($orderBy !== null) {
            $query->orderBy([$orderBy => self::SORTS[$orderByDirection]]);
        }

        return (new PaginatedResult())
            ->setItems($query->all())
            ->setPage($page)
            ->setLimit($limit)
            ->setTotalCount((int)$query->count())
        ;
    }

    protected function getActiveQuery(): ActiveQuery
    {
        $modelClass = $this->getModelClass();

        return (new $modelClass)::find();
    }
}
