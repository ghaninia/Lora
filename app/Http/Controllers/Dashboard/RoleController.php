<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStore;
use App\Http\Requests\RoleUpdate;
use App\Models\Permission;
use App\Models\Role;
use App\Repositories\Picture;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index(Request $request)
    {

        $information = [
            'title' => trans('dashboard.roles.all.text') ,
            'desc'  => trans("dashboard.roles.all.desc") ,
            'breadcrumb' => [
                trans("dashboard.roles.all.text") => null
            ]
        ] ;

        $this->validate($request , [
            'orderBy' => 'nullable|in:id,name,users_count,permissions_count' ,
            'default' => 'nullable|boolean'
        ]);
        $roles = Role::with(["permissions" , "users"])
            ->withCount(["permissions" , "users"])
            ->orderBy($request->input('orderBy' , 'id') , 'desc')
            ->where(function ($q) use ($request) {
                if ( $request->has('default') )
                    $q->where(['default' => true ]) ;
            })
            ->get() ;

        return view('dashboard.role.index' , compact('roles' , 'information') ) ;
    }

    public function create()
    {

        $information = [
            'title' => trans('dashboard.roles.create.text') ,
            'desc'  => trans("dashboard.roles.create.desc") ,
            'breadcrumb' => [
                trans('dashboard.roles.all.text') => route('dashboard.role.index') ,
                trans("dashboard.roles.create.text") => null
            ]
        ] ;

        $permissions = Permission::select(['id','name','description'])->get() ;
        return view("dashboard.role.create" , compact('information' , 'permissions') ) ;
    }

    public function store(RoleStore $request)
    {
        $role = Role::create([
            'name' => $request->input('name') ,
            'description' => $request->input('description') ,
            'default' => $request->input('default' , false) ,
            'picture' => Picture::create('picture') ,
        ]);
        $role->permissions()->sync($request->input('permissions' , [] )) ;
        return RepMessage(trans('dashboard.messages.success.roles.update') , true , 'dashboard.role.index' ) ;
    }

    public function show(Role $role)
    {

    }

    public function edit(Role $role)
    {


        $information = [
            'title' => trans('dashboard.roles.edit.text') ,
            'desc'  => trans("dashboard.roles.edit.desc") ,
            'breadcrumb' => [
                trans('dashboard.roles.all.text') => route('dashboard.role.index') ,
                trans("dashboard.roles.edit.text") => null
            ]
        ] ;

        $role_permissions = $role->permissions()->pluck('id')->toArray() ;
        $permissions = Permission::select(['id','name','description'])->get() ;

        return view('dashboard.role.edit' , compact('role' , 'information' , 'role_permissions' , 'permissions' ) ) ;
    }

    public function update(RoleUpdate $request, Role $role)
    {
        $update = [
            'name' => $request->input('name') ,
            'description' => $request->input('description') ,
            'default' => $request->input('default' , false) ,
        ] ;
        if ($request->hasFile('picture')){
            Picture::delete($role->picture) ;
            $update['picture'] = Picture::create('picture') ;
        }
        $role->permissions()->sync($request->input('permissions' , [] )) ;
        $role->update($update);
        return RepMessage(trans('dashboard.messages.success.roles.update') ) ;
    }

    public function destroy(Role $role)
    {
        if (!$role->default)
        {
            $role->delete() ;

            return RepMessage(trans('dashboard.messages.success.roles.delete')) ;
        }
        return RepMessage(trans('dashboard.messages.errors.delete_fail') , false ) ;
    }
}
