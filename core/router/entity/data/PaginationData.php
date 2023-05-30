<?php
declare(strict_types=1);

namespace app\core\router\entity\data;

class PaginationData
{
    private $page = 1;
    private $orderBy;
    private $orderByDirection = 'ASC';
    private $limit = 20;

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    public function setOrderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    public function getOrderByDirection(): ?string
    {
        return $this->orderByDirection;
    }

    public function setOrderByDirection(string $orderByDirection): self
    {
        $this->orderByDirection = $orderByDirection;

        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }


}
