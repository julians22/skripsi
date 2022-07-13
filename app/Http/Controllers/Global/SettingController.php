<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\Global\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::all();
        return view('backend.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Global\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Global\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Global\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //  remove _token from request
        $request->request->remove('_token');
    }

    public function updateBulk(Request $request)
    {
        //  remove _token from request
        $request->request->remove('_token');

        foreach ($request->all() as $key => $value) {
            $setting = Setting::where('setting_key', $key)->first();
            if ($setting->isImage()) {

                // delete old image
                if ($setting->setting_value) {
                    $oldImage = public_path($setting->setting_value);
                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                    }
                }

                $value = $this->uploadImage($value, $setting->setting_key);
            }elseif ($setting->isText()) {
                $value = $value;
            }

            $setting->update([
                'setting_value' => $value
            ]);
        }

        return redirect()->back()->withFlash('success', 'Settings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Global\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }

    /**
     * Upload image
     *
     * @param $image
     * @param $add_name
     * @return string
     */
    private function uploadImage($image, $add_name = 'image')
    {
        $image_name = $add_name . '_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('img'), $image_name);

        // return url
        return 'img/' . $image_name;
    }
}
