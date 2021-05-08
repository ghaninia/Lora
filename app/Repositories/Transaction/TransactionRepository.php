<?php

namespace App\Repositories\Transaction;

use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;
use App\Repositories\Transaction\TransactionRepositoryInterface;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        //return;
    }
}
