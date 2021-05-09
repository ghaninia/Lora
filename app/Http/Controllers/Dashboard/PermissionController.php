<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\PermissionIndex;
use App\Http\Requests\Permission\PermissionStore;
use App\Http\Requests\Permission\PermissionUpdate;
use App\Http\Resources\Permission\PermissionResource;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Repositories\Permission\PermissionRepository;
use App\Services\Permission\PermissionService;

class PermissionController extends Controller
{
    protected $permissions;
    public function __construct(PermissionService $permissions)
    {
        $this->permissions = $permissions;
    }

    public function index(PermissionIndex $request)
    {
        $permissions = $this->permissions->all($request);
        return PermissionResource::collection($permissions);
    }

    public function store(PermissionStore $request)
    {
        $permission = $this->permissions->create($request->all());
        return $this->success([
            "data" => new PermissionResource($permission),
            "msg"  => trans("lora.message.success.permission.create")
        ]);
    }

    public function show(Permission $permission)
    {
        return new PermissionResource( $permission );
    }

    public function update(PermissionUpdate $request, Permission $permission)
    {
        $permission->update([
            'name' => $request->input('name', $permission->name),
            'description' => $request->input('description'),
            'default' => $request->input('default', false)
        ]);
        return RepMessage(trans('lora.messages.success.permissions.update'), true);
    }

    public function destroy(Permission $permission)
    {
        if (!$permission->default) {
            $permission->delete();
            return RepMessage(trans('lora.messages.success.permissions.delete'));
        }
        return RepMessage(trans('lora.messages.errors.delete_fail'), false);
    }
}
