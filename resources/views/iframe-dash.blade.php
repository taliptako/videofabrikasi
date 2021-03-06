<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ $video->name }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/6.1.0/video-js.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-ads/5.0.3/videojs.ads.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/0.6.0/videojs.ima.min.css" rel="stylesheet">

    {!! $skin_url !!}

    <!-- If you'd like to support IE8 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/6.1.0/ie8/videojs-ie8.min.js"></script>
</head>
<body>

    <video id="video" preload="metadata"
           class="video-js {{ $skin_class }} vjs-16-9" controls>

        

        <source src="{{ $video->fallback_url}}" type="video/mp4">


        <p class="vjs-no-js">
            Tarayıcınız html5 video özelliğini desteklemiyor!
        </p>
    </video>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/6.1.0/video.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/6.1.0/lang/tr.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dashjs/2.5.0/dash.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-dash/2.9.1/videojs-dash.min.js"></script>

    <script src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-ads/5.0.3/videojs.ads.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/0.6.0/videojs.ima.min.js"></script>

    <script>
        var player = videojs('video');

        var options = {
            id: 'video',
            adTagUrl: 'https://videofabrikasi.com/vmap'
        };

        // This must be called before player.play() below.
        player.ima(options);

        // Remove controls from the player on iPad to stop native controls from stealing
        // our click
        var contentPlayer =  document.getElementById('video_html5_api');
        if ((navigator.userAgent.match(/iPad/i) ||
                navigator.userAgent.match(/Android/i)) &&
            contentPlayer.hasAttribute('controls')) {
            contentPlayer.removeAttribute('controls');
        }

        // Initialize the ad container when the video player is clicked, but only the
        // first time it's clicked.
        var startEvent = 'click';
        if (navigator.userAgent.match(/iPhone/i) ||
            navigator.userAgent.match(/iPad/i) ||
            navigator.userAgent.match(/Android/i)) {
            startEvent = 'touchend';
        }

        player.one(startEvent, function() {
            player.ima.initializeAdDisplayContainer();
            player.ima.requestAds();
            player.play();
        });

    </script>

</body>
</html>