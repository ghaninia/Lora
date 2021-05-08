<?php

namespace App\Repositories\User;

use App\Models\User;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class ;
    }
    
}
