<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\GetVideos;
use App\Models\Video;
use Illuminate\Http\Request;
use Log;

class WebHookController extends Controller
{
    public function index($video_id, Request $request)
    {
        $video = Video::findOrFail($video_id);

        $data = $request->json()->all();

        Log::info('webhook isteği geldi');
        dispatch(new GetVideos($video, $data));

        return 'Successful';
    }
}
