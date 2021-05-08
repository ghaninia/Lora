<?php

namespace App\Repositories\Discount;

use App\Models\Discount;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;
use App\Repositories\Discount\DiscountRepositoryInterface;

class DiscountRepository extends BaseRepository implements DiscountRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Discount::class;
    }

    public function query()
    {
        return ($this->model())::query() ;
    }

    public function getTableName() : string
    {
        return $this->model->getTable();
    }
}
