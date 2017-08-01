<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ $video->name }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/6.1.0/video-js.min.css" rel="stylesheet">
    <!-- If you'd like to support IE8 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/6.1.0/ie8/videojs-ie8.min.js"></script>
</head>
<body>

    <video id="video" width=600 height=300 class="video-js vjs-default-skin" controls>

    </video>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/6.1.0/video.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/6.1.0/lang/tr.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dashjs/2.5.0/dash.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-dash/2.9.1/videojs-dash.min.js"></script>

    <script>
        var player = videojs('video');

        player.ready(function() {
            player.src({
                src: '{{ $video->dash_url}}',
                type: 'application/dash+xml'
            });
        });
    </script>

</body>
</html>