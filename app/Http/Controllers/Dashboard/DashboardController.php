<?php
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Download;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $data = [
            'user' => [
                'count' => User::all()->count() ,
                'text' => trans('dashboard.main.user.text')
            ] ,
            'permission' => [
                'count' => Permission::all()->count() ,
                'text' => trans('dashboard.main.permission.text')
            ]
        ];
        return view("dashboard.dashboard" , compact('data') ) ;
    }

}
