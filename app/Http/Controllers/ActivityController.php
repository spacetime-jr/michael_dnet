<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Activity;

class ActivityController extends Controller
{
    public function index(){
		$activities = Activity::all();
		return view('activity.index', [
			'activities' => $activities
		]);
	}
	
	public function create(){
		
	}
	
	public function store(){
		
	}
	
	public function show(){
		
	}
	
	public function edit(){
		
	}
	
	public function update(){
		
	}
	
	public function destroy(){
		
	}

    public function ajaxListActivity(Request $request)
    {
        if (\Sentinel::getUser()->hasAccess('activity.log')) {
            $columns = array(
                0 => 'log_name',
                0 => 'subject_type',
                1 => 'description',
                2 => 'users.username',
                3 => 'created_at',
                4 => 'updated_at',
            );

            $totalData = Activity::whereNotNull('causer_id')->count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if (empty($request->input('search.value'))) {
                $activities = Activity::leftJoin('users',function($join){
                    $join->on('users.id','=','activity_log.causer_id');
                })
                    ->whereNotNull('causer_id')
                    ->select('activity_log.*','users.username as username')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $activities = Activity::leftJoin('users',function($join){
                    $join->on('users.id','=','activity_log.causer_id');
                })
                    ->whereNotNull('causer_id')
                    ->where(function ($query) use ($search) {
                        $query->where('users.username', 'LIKE', "%{$search}%")
                            ->orWhere('activity_log.description', 'LIKE', "%{$search}%")
                            ->orWhere('activity_log.subject_type', 'LIKE', "%{$search}%")
                            ->orWhere('activity_log.log_name', 'LIKE', "%{$search}%")
                            ->orWhere('activity_log.created_at', 'LIKE', "%{$search}%")
                            ->orWhere('activity_log.updated_at', 'LIKE', "%{$search}%");
                    })
                    ->select('activity_log.*','users.username as username')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = Activity::leftJoin('users',function($join){
                    $join->on('users.id','=','activity_log.causer_id');
                })
                    ->whereNotNull('causer_id')
                    ->where(function ($query) use ($search) {
                        $query->where('users.username', 'LIKE', "%{$search}%")
                            ->orWhere('activity_log.description', 'LIKE', "%{$search}%")
                            ->orWhere('activity_log.subject_type', 'LIKE', "%{$search}%")
                            ->orWhere('activity_log.log_name', 'LIKE', "%{$search}%")
                            ->orWhere('activity_log.created_at', 'LIKE', "%{$search}%")
                            ->orWhere('activity_log.updated_at', 'LIKE', "%{$search}%");
                    })
                    ->count();
            }

            $data = array();
            if (!empty($activities)) {
                foreach ($activities as $val) {

                    $nestedData['log_name'] = $val->log_name;
                    $nestedData['subject_type'] = $val->subject_type;
                    $nestedData['description'] = $val->description;
                    $nestedData['username'] = $val->username;
                    $nestedData['created_at'] = date('j M Y h:i a', strtotime($val->created_at));
                    $nestedData['updated_at'] = date('j M Y h:i a', strtotime($val->updated_at));
                    $data[] = $nestedData;

                }
            }
            $json_data = array(
                "draw" => intval($request->input('draw')),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $data
            );

            return json_encode($json_data);
        } else {
            return false;
        }
    }
}
