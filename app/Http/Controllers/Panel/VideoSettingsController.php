<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Storage;

class VideoSettingsController extends Controller
{
    public function index()
    {
        $video_settings = Auth::user()->video_settings()->get();

        return view('panel.video-settings.index', ['video_settings' => $video_settings]);
    }

    public function create()
    {
        return view('panel.video-settings.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'               => 'required',
            'watermark_image'    => 'nullable|image|max:2000|mimes:png',
            'watermark_position' => [
                Rule::in(['top_left', 'top_right', 'bottom_left', 'bottom_right']),
            ],
        ]);

        $video_setting = $request->user()->video_settings()->create($request->all());

        if ($request->hasFile('watermark_image') and $request->file('watermark_image')->isValid()) {
            $video_setting->watermark = $request->watermark_image->store('user-'.$request->user()->id.'/watermark-'.$video_setting->id);
            $video_setting->update();
        }

        return redirect()->route('video-settings.index');
    }

    public function edit($setting_id)
    {
        $video_setting = Auth::user()->video_settings()->findOrFail($setting_id);

        return view('panel.video-settings.edit', ['video_setting' => $video_setting]);
    }

    public function update($setting_id, Request $request)
    {
        $this->validate($request, [
            'name'               => 'required',
            'watermark_image'    => 'nullable|image|max:2000|mimes:png',
            'watermark_position' => [
                Rule::in(['top_left', 'top_right', 'bottom_left', 'bottom_right']),
            ],
        ]);

        $video_setting = $request->user()->video_settings()->findOrFail($setting_id);

        $video_setting->update($request->all());

        if ($request->hasFile('watermark_image') and $request->file('watermark_image')->isValid()) {
            $video_setting->watermark = $request->watermark_image->store('user-'.$request->user()->id.'/watermark-'.$video_setting->id);
            $video_setting->update();
        }

        return redirect()->route('video-settings.edit', ['setting_id' => $video_setting->id]);
    }

    /*public function destroy($setting_id)
    {
        $video_setting = Auth::user()->video_settings->findOrFail($setting_id);

        Storage::deleteDirectory('user-'.Auth::id().'watermark-'.$video_setting->id);
        $video_setting->delete();

        return redirect()->route('video-settings.index');
    }*/
}
