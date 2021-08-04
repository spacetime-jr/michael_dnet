<?php

namespace App\Http\Controllers;

//use App\Http\Requests;
use Illuminate\Http\Request;
use Session;

class SiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function login(Request $request)
    {
        // if(Session::has('error')){
        // dd(Session::get('error'));die;
        // }
        $params = [];
        if(!empty($request->redirect))
            $params['redirect'] = $request->redirect;


        return view('auth.login',$params);
    }

    public function dashboard()
    {
        return view('home');

    }

    public function error()
    {
        return view('errors.404');

    }
}
