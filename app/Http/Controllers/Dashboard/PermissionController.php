<?php
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionStore;
use App\Http\Requests\PermissionUpdate;
use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{

    public function index(Request $request)
    {
        $this->validate($request , [
            'orderBy' => 'nullable|in:id,name,roles_count' ,
            'default' => 'nullable|boolean'
        ]);
        $permissions = Permission::with(["roles"])->withCount(["roles"])
            ->orderBy($request->input('orderBy' , 'id') , 'desc')
            ->where(function ($q) use ($request) {
                if ( $request->has('default') )
                    $q->where(['default' => true ]) ;
            })
            ->get() ;

        $information = [
            'title' => trans('dashboard.permissions.all.text') ,
            'desc'  => trans('dashboard.permissions.all.desc') ,
            'breadcrumb' => [
                trans('dashboard.permissions.all.text') => null
            ]
        ] ;


        return view('dashboard.permission.index' , compact('permissions','information') ) ;
    }

    public function create()
    {
        $information = [
            'title' => trans('dashboard.permissions.create.text') ,
            'desc'  => trans('dashboard.permissions.create.desc') ,
            'breadcrumb' => [
                trans('dashboard.permissions.all.text') => route('dashboard.permission.index') ,
                trans('dashboard.permissions.create.text') => null
            ]
        ] ;
        return view("dashboard.permission.create" , compact('information') ) ;
    }

    public function store(PermissionStore $request)
    {
        Permission::create([
            'name' => $request->input('name'),
            'description' => $request->input('description') ,
            'default' => $request->input('default' , false )
        ]);
        return RepMessage(trans('dashboard.messages.success.permissions.store') , true , "dashboard.permission.index" ) ;
    }

    public function edit(Permission $permission)
    {

        $information = [
            'title' => trans('dashboard.permissions.edit.text') ,
            'desc'  => trans('dashboard.permissions.edit.desc') ,
            'breadcrumb' => [
                trans('dashboard.permissions.all.text') => route('dashboard.permission.index') ,
                trans('dashboard.permissions.edit.text') => null
            ]
        ] ;

        return view('dashboard.permission.edit',compact( 'permission' ,'information')) ;
    }

    public function update(PermissionUpdate $request, Permission $permission)
    {
        $permission->update([
            'name' => $request->input('name' , $permission->name ) ,
            'description' => $request->input('description') ,
            'default' => $request->input('default' , false)
        ]);
        return RepMessage(trans('dashboard.messages.success.permissions.update') , true ) ;
    }

    public function destroy(Permission $permission)
    {
        if (!$permission->default)
        {
            $permission->delete() ;
            return RepMessage(trans('dashboard.messages.success.permissions.delete')) ;
        }
        return RepMessage(trans('dashboard.messages.errors.delete_fail') , false ) ;
    }
}
