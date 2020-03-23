<?php
namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Download;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        [$users_count, $permissions_count] = [User::count(), Permission::count()];

        return view("dashboard.dashboard" , compact('users_count', 'permissions_count') ) ;
    }

}
