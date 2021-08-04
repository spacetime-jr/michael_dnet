<?php

namespace Modules\Users\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Point;
use Modules\Users\Entities\Ijin;
use Modules\Users\Entities\Absensi;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('users::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('users::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('users::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function reportAbsensi(Request $request){
        if (\Sentinel::getUser()->hasAccess('user.create')) {
            
            $monthYear = null;

            if(!empty($request->monthYear)){
                
                $monthYear = $request->monthYear;
            }else{
                $monthYear = Carbon::now()->setTimezone('Asia/Jakarta')->format('m/Y');
            }

            // Process the date
            $month = Carbon::createFromFormat('m/Y', $monthYear)->format('m');
            $year = Carbon::createFromFormat('m/Y', $monthYear)->format('Y');
            
            
            $users = User::join('role_users', function ($join) {
                $join->on('users.id', '=', 'role_users.user_id')
                     ->where('role_users.role_id', '<>', env('SUPERADMIN_ROLE_ID',1));
            })->get() ;

            // Temporary way
            // TODO: change into relation query
            $data = [];
            if(!empty($users)){
                foreach($users as $user){
                    $data[$user->fullname]=[];
                    $absen = $user->absensi()->whereRaw('MONTH(absensi.checkin) = ?', [$month])
                    ->whereRaw('YEAR(absensi.checkin) = ?', [$year])->get();
                    if(!empty($absen)){
                        foreach($absen as $absensi)
                        $data[$user->fullname][Carbon::createFromFormat('Y-m-d H:i:s', $absensi->checkin)->format('Y-m-d')] = $absensi->status;
                    }
                }
            }

            return view('users::report.absensi', [
                'monthYear' => $monthYear,
                'month' => $month,
                'year' => $year,
                'data' => $data
            ]);
        }else {
            return redirect()->route('dashboard')->with('error', 'Access dennied!');
        }
        
    }
}
