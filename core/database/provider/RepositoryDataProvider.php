<?php
declare(strict_types=1);

namespace app\core\database\provider;

use app\core\router\entity\data\PaginatedResult;
use yii\data\BaseDataProvider;

class RepositoryDataProvider extends BaseDataProvider
{
    /**
     * @var PaginatedResult
     */
    public $paginatedResult;

    /**
     * @var string
     */
    public $key;

    protected function prepareModels(): array
    {
        return $this->paginatedResult->getItems();
    }

    protected function prepareKeys($models): array
    {
        if ($this->key === null) {
            return array_keys($this->paginatedResult->getItems());
        }

        $keys = [];

        foreach ($models as $model) {
            $keys[] = is_string($this->key) ? $model->{$this->key} : call_user_func($this->key, $model);
        }

        return $keys;
    }

    protected function prepareTotalCount(): int
    {
        return $this->paginatedResult->getTotalCount();
    }
}
