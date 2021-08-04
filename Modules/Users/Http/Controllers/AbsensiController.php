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
use Modules\Users\Entities\Absensi;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // if (\Sentinel::getUser()->hasAccess('absensi.checkinout')) {
            $currentUser = \Sentinel::getUser();
            $_SESSION['menu'] = 'absensi';

            $canCheckin = false;
            $canCheckout = false;
            $currentDatetime = $currentDate = Carbon::now()->setTimezone('Asia/Jakarta');
            $absensi = null;

            // CHeck if user already checkedin on current date
            $checkedUser = Absensi::where('user_id','=',$currentUser->id)
            ->whereRaw('DATE(checkin) = ?',[$currentDate->format('Y-m-d')])
            ->first();

            if(empty($checkedUser))
                $canCheckin = true;
            else{
                $absensi = $checkedUser;
                // CHeck if user already checkedout on current date
                $checkedUser = Absensi::where('user_id','=',$currentUser->id)
                ->whereRaw('DATE(checkout) = ?',[$currentDate->format('Y-m-d')])
                ->first();
                
                if(empty($checkedUser))
                    $canCheckout = true;
            }

            return view('users::absensi.index', [
                'serverTime' => $currentDatetime->format('d-m-Y H:i:s'),
                'canCheckin' => $canCheckin,
                'canCheckout' => $canCheckout,
                'absensi' => $absensi,
            ]);
        // } else {
            // return redirect()->route('dashboard')->with('error', 'Access dennied!');
        // }
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

    // Checkin process
    public function checkin()
    {
        $currentUser = \Sentinel::getUser();
        try{
            if(empty($currentUser))
                throw new \Exception('Silahkan Login terlebih dahulu');

            $currentDate = Carbon::now()->format('Y-m-d');
            $currentDatetime = $currentdtlocal = Carbon::now();

            // CHeck if user already checkedin on current date
            $checkedUser = Absensi::where('user_id','=',$currentUser->id)
                        ->whereRaw('DATE(checkin) = ?',[$currentDate])
                        ->first();
            
            if(!empty($checkedUser))
                throw new \Exception('Anda sudah checkin pada hari ini');

            // Prepare Data for save
            \DB::beginTransaction();

            $absensi = new Absensi();
            $absensi->user_id = $currentUser->id;
            $absensi->checkin = $currentDatetime->format('Y-m-d H:i:s');
            $absensi->status = 'checkedin';
            $absensi->save();

            \DB::commit();

            return redirect()->route('absensi.index')->with('success', 'Anda telah berhasil checkin pada '.$currentdtlocal->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'));
        }catch(\Exception $e){
            \DB::rollBack();
            return redirect()->route('absensi.index')->with('error', $e->getMessage());
        }
    }

    // Checkout process
    public function checkout()
    {
        $currentUser = \Sentinel::getUser();
        try{
            if(empty($currentUser))
                throw new \Exception('Silahkan Login terlebih dahulu');

            $currentDate = Carbon::now()->format('Y-m-d');
            $currentDatetime = $currentdtlocal = Carbon::now();

            // CHeck if user already checkedout on current date
            $checkedUser = Absensi::where('user_id','=',$currentUser->id)
            ->whereRaw('DATE(checkout) = ?',[$currentDate])
            ->first();

            if(!empty($checkedUser))
                throw new \Exception('Anda sudah checkout pada hari ini');

                
            // CHeck if user already checkedin on current date
            $checkedUser = Absensi::where('user_id','=',$currentUser->id)
            ->whereRaw('DATE(checkin) = ?',[$currentDate])
            ->first();

            if(empty($checkedUser))
                throw new \Exception('Anda belum checkin pada hari ini');


            // Prepare Data for save
            \DB::beginTransaction();

            $absensi = $checkedUser;
            $absensi->checkout = $currentDatetime->format('Y-m-d H:i:s');
            $absensi->status = 'checkedout';
            $absensi->save();

            \DB::commit();

            return redirect()->route('absensi.index')->with('success', 'Anda telah berhasil checkout pada '.$currentdtlocal->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'));
        }catch(\Exception $e){
            \DB::rollBack();
            return redirect()->route('absensi.index')->with('error', $e->getMessage());
        }
    }

}
