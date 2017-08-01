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

        return view('iframe-dash', ['video' => $video]);
    }
}
