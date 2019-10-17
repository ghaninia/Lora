<?php
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketAppendStore;
use App\Models\User;
use App\Models\Role;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{

    public function index(Request $request)
    {
        $side = $this->side( $request->input('search') ) ;
        return view("dashboard.ticket.index" , compact('side') ) ;
    }

    public function side()
    {
        $search = request()->input('search') ;
        $tickets = Ticket::side()->filter(function ($item , $value) use ($search) {
                return preg_match("/{$search}/" , $item->tracking_code ) ;
            });
        $NotReads = Ticket::notRead()
            ->select('tracking_code' , DB::raw('COUNT(*) AS counter') )
            ->groupBy('tracking_code')
            ->pluck('counter' , 'tracking_code')
            ->toArray() ;

        return view('dashboard.ticket.side' , compact('tickets' , 'NotReads') )->render() ;
    }

    public function content()
    {
        $trakingCode = request()->input('traking_code') ;
        $contents = Ticket::content( $trakingCode , 'user' ) ;
        $information = null ;
        if(!! $contents->first() )
            if (!! $contents->first() )
                $information = $contents->first()->first() ;

        return view('dashboard.ticket.content' , compact('contents' , 'information' , 'trakingCode') ) ;
    }

    public function changeStatus(Request $request)
    {

        $this->validate($request , [
           "tracking_code" => 'required'
        ]) ;

        Ticket::where('tracking_code' , $request->input('tracking_code'))
            ->whereIn('id' , Ticket::access() )
            ->update(['status' => 'disable' ]) ;

        return RepMessage(trans('dashboard.tickets.messages.changestatus')) ;
    }

    public function replay(Request $request)
    {

        $this->validate($request , [
            'tracking_code' => ['required' , Rule::in( Ticket::trackingCodeAccess('user') ) ] ,
            'message' => 'required'
        ]) ;

        $parent = Ticket::where('tracking_code' , $request->input('tracking_code') )
                ->where('status' , 'enable')
                ->first() ;

        $guard = "user" ;
        $user = Auth::guard($guard)->user() ;

        if (!!$parent && !!$user)
        {
            $insert = [] ;
            // from id & type
            /////////////////
            if (
                ($parent->from_id == $user->role->id && $parent->from_type == 'role')
                    ||
                ($parent->to_id == $user->role->id && $parent->to_type == 'role')
            ){
                $insert['from_id'] = $user->role->id ;
                $insert['from_type'] = 'role' ;
            }

            if (
                ($parent->from_id == $user->id && $parent->from_type = $guard )
                    ||
                ($parent->to_id == $user->id && $parent->to_type == $guard )
            ){
                $insert['from_id'] = $user->id ;
                $insert['from_type'] = $guard ;
            }
            // to id & type
            /////////////////
            if (
                ($parent->from_id == $insert['from_id'])
                    &&
                ($parent->from_type == $insert['from_type'])
            ){
                $insert['to_id'] = $parent->to_id ;
                $insert['to_type'] = $parent->to_type ;
            }

            if (
                ($parent->to_id == $insert['from_id'])
                    &&
                ($parent->to_type == $insert['from_type'])
            ){
                $insert['to_id'] = $parent->from_id ;
                $insert['to_type'] = $parent->from_type ;
            }

            if (count($insert) == 4)
            {
                $insert['message'] = $request->input('message') ;
                $insert['tracking_code'] = $request->input('tracking_code') ;
                Ticket::create($insert) ;
                return RepMessage( $insert['message'] , true ) ;
            }

        }

        return RepMessage( "" , false ) ;
    }

    public function append(Request $request)
    {
        $this->validate($request , [
            'to_type' => ['nullable' , 'in:user,role']
        ]);

        if ( $request->has('to_type') )
        {
            $user = me() ;
            $user_id = $user->id ;
            $role_id = $user->role->id ;

            if ($request->input('to_type') == 'user') {
                $items = User::select(['id','firstname','lastname','username'])->where("id" , "<>" , $user_id)->get() ;
            }
            elseif ($request->input('to_type') == 'role') {
                $items =  Role::select(['id','name','description'])->where("id" , "<>" , $role_id )->get() ;
            }

            return view('dashboard.ticket.append_tickets_toid' , [
                'items' => $items ,
                'type'  => $request->input('to_type')
            ])->render() ;
        }

        return view("dashboard.ticket.append_tickets")->render() ;
    }

    public function appendStore(TicketAppendStore $request)
    {
        $user = Auth::guard('user')->user() ;
        if (!! $user->role && ($request->input('from_type') == "role"))
        {
            $formId = $user->role->id ;
            $formType = "role" ;
        }else{
            $formId = $user->id ;
            $formType = "user" ;
        }

        $ticket = Ticket::create([
            'tracking_code' => time() ,
            'status' => 'enable' ,
            'priority' => $request->input('priority') ,
            'from_type' => $formType ,
            'from_id' => $formId ,
            'to_type' => $request->input('to_type') ,
            'to_id' => $request->input('to_id') ,
            'subject' => $request->input('subject') ,
            'message' => strip_tags( $request->input('message') ) ,
        ]);

        return RepMessage( trans('dashboard.messages.success.tickets.create') , true ) ;

    }
    
}
