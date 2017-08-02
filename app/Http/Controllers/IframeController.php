<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Storage;

class IframeController extends Controller
{
    public function show($id, $hash)
    {
        $video = Video::where('status', 1)->findorfail($id);
        if ($video->hash != $hash) {
            abort(404);
        }

        $video->dash_url = Storage::url($video->folder.'/'.$video->extension.'/dash.mpd');
        $video->fallback_url = Storage::url($video->folder.'/mp4/fallback_480p.mp4');

        return view('iframe-dash', ['video' => $video]);
    }
}
