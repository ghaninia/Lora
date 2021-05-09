<?php

namespace App\Services\Permission;

use App\Models\Permission;
use App\Repositories\Permission\PermissionRepository;
use App\Services\Permission\PermissionServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PermissionService implements PermissionServiceInterface
{
    public $permissions;
    public function __construct(PermissionRepository $permissions)
    {
        $this->permissions = $permissions;
    }

    public function all(Request $request): Paginator
    {
        return
            $this->permissions
            ->query()
            ->withCount("roles")
            ->when($request->default, function ($query) {
                $query->whereStatus(true);
            })
            ->orderBy($request->input("orderby", "name"), "DESC")
            ->paginate(config("lora.paginator"));
    }

    public function create(array $data): Permission
    {
        return $this->permissions->create([
            'name' => $data["name"],
            'description' => $data["description"] ?? null,
            'default' => $data["default"] ?? false
        ]);
    }
}
