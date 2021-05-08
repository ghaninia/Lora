<?php

namespace App\Repositories\Ticket;

use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;
use App\Repositories\Ticket\TicketRepositoryInterface;

class TicketRepository extends BaseRepository implements TicketRepositoryInterface
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
