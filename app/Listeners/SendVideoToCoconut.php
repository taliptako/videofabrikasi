<?php

namespace App\Listeners;

use App\Events\VideoUploaded;
use App\Http\Controllers\Coconut;
use Storage;
use Log;

class SendVideoToCoconut
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param VideoUploaded $event
     */
    public function handle(VideoUploaded $event)
    {
        $s3 = 's3://'.config('filesystems.disks.s3.key').':'.config('filesystems.disks.s3.secret').'@'.config('filesystems.disks.s3.bucket');

        $s3_visibility = '?x-amz-acl=private';

        $video_url = Storage::url($event->video->folder.'/'.$event->video->original_file_name);

        $video_setting = $event->video->setting;

        if (! empty($video_setting->watermark) and ! empty($video_setting->watermark_position)) {
            $watermark = ', watermark_url='.Storage::url($video_setting->watermark);
            $watermark_position = ', watermark_position='.str_replace('_', '', $video_setting->watermark_position);
            $watermark_setting = $watermark.$watermark_position;
        } else {
            $watermark_setting = '';
        }

        $ffmpeg_settings = ',keep=video_bitrate';

        $watermark_setting .= $ffmpeg_settings;

        if ($event->video->extension == 'mp4') {
            foreach ($event->video->dash_variants as $resolution) {
                if ($resolution == 'default') {
                    $outputs['mp4'] = $s3.'/'.$event->video->folder.'/mp4/default.mp4'.$s3_visibility.$watermark_setting;
                } else {
                    $outputs['mp4:'.$resolution] = $s3.'/'.$event->video->folder.'/mp4/'.$resolution.'.mp4'.$s3_visibility.$watermark_setting;
                }
            }
        } elseif ($event->video->extension == 'webm') {
            foreach ($event->video->dash_variants as $resolution) {
                if ($resolution == 'default') {
                    $outputs['webm:vp9'] = $s3.'/'.$event->video->folder.'/webm/default.webm'.$s3_visibility.$watermark_setting;
                } else {
                    $outputs['webm:vp9_'.$resolution] = $s3.'/'.$event->video->folder.'/webm/'.$resolution.'.webm'.$s3_visibility.$watermark_setting;
                }
            }
        }
        $outputs['mp4:480p'] = $s3.'/'.$event->video->folder.'/mp4/fallback_480p.mp4'.$s3_visibility.$watermark_setting;


        $outputs['jpg:300x'] = $s3.'/'.$event->video->folder.'/previews/thumbs_#num#.jpg?x-amz-acl=private, number=3';
        $outputs['jpg:640x'] = $s3.'/'.$event->video->folder.'/previews/thumbs_#num#.jpg?x-amz-acl=private, number=3';

        $coconut = [
            'api_key' => 'k-bc7205e41b762203cd6494b6aa7d8410',
            'source'  => $video_url,
            'webhook' => route('coconut_webhook', ['video_id' => $event->video->id]),
            'outputs' => $outputs,
        ];

        $job = Coconut::create($coconut);

        if ($job->status == 'ok') {
            $event->video->progress = 'Transcoding Yapılıyor ...';
        } else {
            $event->video->progress = 'Hata Kodu : '.$job->error_code;
            Log::error($job->error_code);
        }
        $event->video->save();
    }

    public function dash_variants($dash_variants)
    {
        $variants = 'variants=mp4:x,';

        foreach ($dash_variants as $dash_variant) {
            switch ($dash_variant) {
                case 'default':
                    $variants .= 'mp4::x,';
                    break;
                case '240p':
                    $variants .= 'mp4:240p:x,';
                    break;
                case '360p':
                    $variants .= 'mp4:360p:x,';
                    break;
                case '480p':
                    $variants .= 'mp4:480p:x,';
                    break;
                case '720p':
                    $variants .= 'mp4:720p:x,';
                    break;
                case '1080p':
                    $variants .= 'mp4:1080p:x,';
                    break;
            }
        }

        //$variants = $this->dash_variants($event->video->dash_variants);

        //$outputs['dash'] = $s3 . '/' .$event->video->folder . '/dash.mpd?x-amz-acl=private,' . $variants ;

        return $variants;
    }
}
