<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Settings\Entities\Setting;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (\Sentinel::getUser()->hasAccess('setting.list')) {
            $_SESSION['menu'] = 'setting';
            $settings = Setting::all();
            return view('settings::setting.index',
                [
                    'settings' => $settings
                ]);
        } else {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        if (\Sentinel::getUser()->hasAccess('setting.create')) {
            $_SESSION['menu'] = 'setting';
            return view('settings::setting.create');
        } else {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (\Sentinel::getUser()->hasAccess('setting.create')) {
            $rules = [
                'key' => 'required|unique:settings',
                'value' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()
                    ->route('setting.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            $setting = new Setting();
            $setting['key'] = $request['key'];
            $setting['value'] = $request['value'];
            $setting->save();

            return redirect()->route('setting.index')->with('success', 'Setting berhasil disimpan');
        } else {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */

    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        if (\Sentinel::getUser()->hasAccess('setting.edit')) {
            $_SESSION['menu'] = 'setting';
            $setting = Setting::find($id);
            return view('settings::setting.edit', [
                'setting' => $setting,
            ]);
        } else {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        if (\Sentinel::getUser()->hasAccess('setting.edit')) {
            $setting = Setting::find($id);
            $rules = [
                'value' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()
                    ->route('setting.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }

            $setting['value'] = $request['value'];
            $setting->save();

            return redirect()->route('setting.index')->with('success', 'Setting berhasil di ubah');
        } else {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        if (\Sentinel::getUser()->hasAccess('setting.delete')) {
            $_SESSION['menu'] = 'setting';
            $setting = Setting::find($id);
            $setting->delete();
            return redirect()->route('setting.index')->with('success', 'Setting berhasil di hapus');
        } else {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
    }
}
