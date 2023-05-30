<?php
declare(strict_types=1);

namespace app\core\router\services;

use app\core\router\entity\data\PaginationData;

class PaginationDataMapper implements NormalizerInterface
{
    public function mapToNormalizedData($data): PaginationData
    {
        $paginationData = new PaginationData();

        if (isset($data['page'])) {
            $paginationData->setPage((int)$data['page']);
        }

        if (isset($data['limit'])) {
            $paginationData->setLimit((int)$data['limit']);
        }

        if (isset($data['orderBy'])) {
            $paginationData->setOrderBy($data['orderBy']);
        }

        if (isset($data['orderByDirection'])) {
            $paginationData->setOrderByDirection($data['orderByDirection']);
        }

        return $paginationData;
    }
}
