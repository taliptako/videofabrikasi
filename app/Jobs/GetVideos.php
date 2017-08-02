<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;

class GetVideos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;
    public $data;

    /**
     * Create a new job instance.
     */
    public function __construct($video, $data)
    {
        $this->video = $video;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $paths = Storage::disk('s3')->files($this->video->folder.'/'.$this->video->extension);

        $fallback_path = $this->video->folder.'/mp4/fallback_480p.mp4';

        Storage::disk('public')->put($fallback_path, Storage::disk('s3')->get($fallback_path));

        foreach ($paths as $path) {
            Storage::disk('public')->put($path, Storage::disk('s3')->get($path));
        }

        $preview_paths = Storage::disk('s3')->files($this->video->folder.'/previews');
        foreach ($preview_paths as $preview_path) {
            Storage::disk('public')->put($preview_path, Storage::disk('s3')->get($preview_path));
        }

        $this->video->progress = 'Transcoding tamamlandı.Dash dosyası oluşturuluyor.';
        $this->video->save();

        $job = new \App\Jobs\CreateDash($this->video);
        dispatch($job);
    }
}
