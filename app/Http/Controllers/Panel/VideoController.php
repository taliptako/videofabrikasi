<?php

namespace App\Http\Controllers\Panel;

use App\Events\VideoUploaded;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Storage;

class VideoController extends Controller
{
    public function __construct()
    {
    }

    public function list_videos()
    {
        $videos = Auth::user()->videos()->orderby('id', 'desc')->get();

        return view('panel.video.list_videos', ['videos' => $videos]);
    }

    public function create()
    {
        $video_settings = Auth::user()->video_settings()->get();

        return view('panel.video.upload_video', ['video_settings' => $video_settings]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'      => 'required',
            'extension' => 'required', [
                Rule::in(['mp4', 'webm']),
            ],
            'status' => 'required|boolean',
            'video'  => 'required|file|max:100000|mimes:mp4,webm,mpeg,mkv,3gp,mov,avi,ogx,oga,ogv,ogg',
        ];

        $video_settings = Auth::user()->video_settings()->select('id')->get();
        foreach ($video_settings as $video_setting) {
            $setting_array[] = $video_setting->id;
        }

        $rules['setting_id'] = ['required',
            Rule::in($setting_array),
        ];

        if ($request->has('dash_variants')) {
            foreach ($request->input('dash_variants') as $key => $val) {
                $rules['dash_variants.'.$key] = ['required',
                    Rule::in(['default', '240p', '360p', '480p', '720p', '1080p']),
                ];
            }
        } else {
            $rules['dash_variants'] = ['required'];
        }

        $this->validate($request, $rules);

        $user = Auth::user();

        if ($request->file('video')->isValid()) {
            $extension = $request->video->extension();
            $request['folder'] = 'upload yapılmadı';
            $request['progress'] = 'Karşıya Yükleme Yapılıyor ...';
            $request['original_file_name'] = 'original.'.$extension;
            $request['hash'] = rand();

            $video = $user->videos()->create($request->all());

            $folder = 'user-'.$user->id.'/'.$video->id;

            $request->video->storeAs($folder, $video->original_file_name);

            $video->folder = $folder;
            $video->progress = 'Karşıya Yükleme Tamamlandı.Transcoding Başlıyor..';

            $video->save();
        }

        if (config('app.env') == 'production') {
            event(new VideoUploaded($video, $user));
        }

        return redirect()->route('video_details', ['id' => $video->id]);
    }

    public function show($video_id)
    {
        $video = Auth::user()->videos()->findOrFail($video_id);

        return view('panel.video.video_details', ['video' => $video]);
    }

    public function update($video_id, Request $request)
    {
        $this->validate($request, [
            'name'   => 'required',
            'status' => 'required|boolean',
        ]);

        $video = Auth::user()->videos()->findOrFail($video_id);

        $video->name = $request['name'];
        $video->status = $request['status'];

        $video->save();

        return redirect()->route('video_details', ['video_id' => $video->id]);
    }

    public function destroy($video_id)
    {
        $video = Auth::user()->videos()->findOrFail($video_id);

        Storage::disk('public')->deleteDirectory($video->folder);
        $video->delete();

        return redirect()->route('list_videos');
    }
}
