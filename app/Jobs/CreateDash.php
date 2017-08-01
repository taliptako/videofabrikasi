<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Storage;
use Symfony\Component\Process\Process;

class CreateDash implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    /**
     * Create a new job instance.
     */
    public function __construct($video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $public_disk = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();

        $video_folder = $public_disk.$this->video->folder.'/'.$this->video->extension.'/';

        $command = 'packager-linux ';
        foreach ($this->video->dash_variants as $dash_variant) {
            $input = $video_folder.$dash_variant.'.'.$this->video->extension.',';
            $output = $video_folder.'dash_'.$dash_variant.'.'.$this->video->extension.' ';
            $command .= 'input='.$input;
            $command .= 'stream=video,output='.$output;
        }

        $command .= 'input='.$input.'stream=audio,output='.$video_folder.'dash_audio.'.$this->video->extension;

        $command .= ' --mpd_output '.$video_folder.'dash.mpd';

        $process = new Process($command);
        $process->run();

        if ($process->isSuccessful()) {
            $this->video->progress = 'Video Hazır.';
        } else {
            $this->video->progress = 'Dash sırasında hata oluştu.';
        }

        $this->video->save();
    }
}
