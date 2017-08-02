<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ $video->name }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/6.1.0/video-js.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-ads/5.0.3/videojs.ads.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-ima/0.6.0/videojs.ima.min.css" rel="stylesheet">


    <!-- If you'd like to support IE8 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/6.1.0/ie8/videojs-ie8.min.js"></script>
</head>
<body>

    <video id="video" preload="metadata"
           class="video-js vjs-default-skin vjs-16-9" controls>

        <source src="{{ $video->dash_url}}" type="application/dash+xml">

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
            adTagUrl: 'http://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/124319096/external/ad_rule_samples&ciu_szs=300x250&ad_rule=1&impl=s&gdfp_req=1&env=vp&output=xml_vmap1&unviewed_position_start=1&cust_params=sample_ar%3Dpremidpostpod%26deployment%3Dgmf-js&cmsid=496&vid=short_onecue&correlator='
        };

        // This must be called before player.play() below.
        player.ima(options);
        player.ima.requestAds();
        // On mobile devices, you must call initializeAdDisplayContainer as the result
        // of a user action (e.g. button click). If you do not make this call, the SDK
        // will make it for you, but not as the result of a user action. For more info
        // see our examples, all of which are set up to work on mobile devices.
        // player.ima.initializeAdDisplayContainer();

        // This must be called after player.ima(...) above.

    </script>

</body>
</html>