<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Cache;

class IframeController extends Controller
{
    public function show($id, $hash)
    {
        $video = Cache::remember('video-'.$id, 2, function () use ($id) {
            return Video::where('status', 1)->with('setting', 'user')->findorfail($id);
        });

        if ($video->hash != $hash) {
            abort(404);
        }

        if ($video->setting->player_skin == 'twitchy') {
            $skin_url = '<link href="//cdn.rawgit.com/mmcc/videojs-skin-twitchy/v2.0.1/dist/videojs-skin-twitchy.css" rel="stylesheet" type="text/css">';
            $skin_class = 'vjs-skin-twitchy';
        } elseif ($video->setting->player_skin == 'sublime_skin') {
            $skin_url = '<link href="//cdn.rawgit.com/zanechua/videojs-sublime-inspired-skin/25a23c1f/dist/videojs-sublime-skin.min.css" rel="stylesheet" type="text/css">';
            $skin_class = 'vjs-sublime-skin';
        } else {
            $skin_url = '';
            $skin_class = 'vjs-default-skin';
        }

        $video->dash_url = 'https://user'.$video->user->id.'.b-cdn.net/'.$video->id.'/'.$video->extension.'/dash.mpd';
        $video->fallback_url = 'https://user'.$video->user->id.'.b-cdn.net/'.$video->id.'/'.'/mp4/fallback_480p.mp4';

        return view('iframe-dash', ['video' => $video,
            'skin_url'                      => $skin_url, 'skin_class' => $skin_class, ]);
    }

    public function vmap()
    {
        $response = view('vmap');
        return response($response)
            ->withHeaders([
                'Content-Type' => 'text/xml',
                'Access-Control-Allow-Credentials' => '*'
            ]);
    }
}
