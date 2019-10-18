<?php
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\userIndex;
use App\Http\Requests\userStore;
use App\Http\Requests\userUpdate;
use App\Models\User;
use App\Models\Role;
use App\Repositories\Picture;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index(UserIndex $request)
    {
        $information = [
            'title' => trans("dashboard.users.all.text") ,
            'desc'  => trans("dashboard.users.all.desc") ,
            'breadcrumb' => [
                trans("dashboard.users.all.text") => null
            ]
        ] ;
        $roles = Role::select(['id','name'])->withCount('users')->get() ;
        //**  filters **/
        $username = $request->input('username') ;
        $mobile   = $request->input('mobile') ;
        $email    = $request->input('email') ;
        $genders   = $request->input('genders') ;
        $role     = $request->input('role') ;
        $credit   = $request->input('credit') ;
        $appends  = $request->all() ;


        //*  users all *//
        $users = User::when($username , function ($query) use ($username){
            $query->where("username" , "like" , "%{$username}%") ;
        })->when($mobile , function ($query) use ($mobile){
            $query->where("mobile" , "like" , "%{$mobile}%") ;
        })->when($email , function ($query) use ($email){
            $query->where("email" , "like" , "%{$email}%") ;
        })->when($genders , function ($query) use ($genders){
            $query->whereIn("gender" , $genders) ;
        })->when($role , function($query) use ($role){
            $query->whereIn("role" , $role) ;
        })->when($credit , function ($query) use ($credit){
            $credit = explode(',' , $credit) ;
            $query->where([
                ['credit' , '>=' , changeCurrency($credit[0] , 'rial')] ,
                ['credit' , '<=' , changeCurrency($credit[1] , 'rial')]
            ]) ;
        })
            ->paginate( option("paginate_size" , config('dash.paginate_size') ) ) ;

        $rangeCreait = User::select([
            DB::raw("MIN(credit) as min") ,
            DB::raw("MAX(credit) as max")
        ])->first();

        return view('dashboard.user.index',compact('information' , 'roles' , 'users' , 'appends' , 'rangeCreait')) ;
    }

    public function create()
    {
        $information = [
            'title' => trans('dashboard.users.create.text') ,
            'desc'  => trans('dashboard.users.create.desc') ,
            'breadcrumb' => [
                trans("dashboard.users.all.text") => route('dashboard.user.index') ,
                trans('dashboard.users.create.text') => null
            ]
        ] ;
        $roles = Role::select(['id' , 'name' , 'description'])->get() ;

        return view('dashboard.user.create' , compact('roles' ,'information') ) ;
    }

    public function store(userstore $request)
    {
        $create = [
            "firstname" => $request->input('firstname') ,
            "lastname"  => $request->input('lastname') ,
            "username"  => $request->input('username') ,
            "email"     => $request->input('email') ,
            "mobile"    => $request->input('mobile') ,
            "gender"    => $request->input('gender') ,
            "theme"     => $request->input("theme") ,
            'status'    => $request->input('status' , false ) ,
            'role_id'   => $request->input('role_id' , null ) ,
            'password'  => bcrypt($request->input('password'))
        ] ;

        if ($request->hasFile('picture'))
            $create["picture"] = Picture::create("picture") ;

        User::create($create) ;

        return redirect()->route('dashboard.user.edit' , $request->input('username') )->with([
            'status' => true ,
            'message' => trans('dashboard.messages.success.users.store')
        ]);

    }

    public function edit(User $user)
    {
        $information = [
            'title' => trans('dashboard.users.edit.text') ,
            'desc'  => trans('dashboard.users.edit.desc') ,
            'breadcrumb' => [
                trans("dashboard.users.all.text") => route('dashboard.user.index') ,
                trans('dashboard.users.edit.text') => null
            ]
        ] ;
        $roles = Role::select(['id' , 'name' , 'description'])->get() ;
        return view('dashboard.user.edit' , compact('user' , 'roles' ,'information') ) ;
    }

    public function update(UserUpdate $request, User $user)
    {

        $update = [
            "firstname" => $request->input('firstname') ,
            "lastname"  => $request->input('lastname') ,
            "username"  => $request->input('username') ,
            "email"     => $request->input('email') ,
            "mobile"    => $request->input('mobile') ,
            "gender"    => $request->input('gender') ,
            "theme"     => $request->input("theme") ,
            'status'    => $request->input('status' , false ) ,
            'role_id'   => $request->input('role_id' , null )
        ] ;
        if ($request->hasFile('picture')) {
            Picture::delete($user->picture);
            $update["picture"] = Picture::create("picture") ;
        }
        $user->update( $request->input('type') == "password" ? ['password' => bcrypt($request->input('password'))] : $update );

        if ($request->input('type') == "password" )
            return RepMessage( trans('dashboard.messages.success.users.update.password') ) ;

        return redirect()->route('dashboard.user.edit' , $request->input('username') )->with([
            'status' => true ,
            'message' => trans('dashboard.messages.success.users.update.profile')
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete() ;
        return RepMessage(trans('dashboard.messages.success.users.delete')) ;
    }

}
