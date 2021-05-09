<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;
use App\Repositories\Permission\PermissionRepositoryInterface;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    public function query()
    {
        return $this->model->query();
    }
}
