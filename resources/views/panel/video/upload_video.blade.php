@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Video Yükle</div>
                    <div class="panel-body">

                        <form method="post" action="{{ route('store_video') }}" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Video Adı :</label>
                                <input type="text" name="name" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="video">Video :</label>
                                <input type="file" class="form-control" name="video" id="video">
                            </div>

                            <div class="form-group">
                                <label for="codec">Kodek :</label>
                                <label class="radio-inline"><input value="webm" type="radio" name="extension">VP9/WebM</label>
                                <label class="radio-inline"><input value="mp4" type="radio" name="extension">H.264/MP4</label>
                            </div>

                            <div class="form-group">
                                <label for="variants">Çözünürlükler :</label>
                                <label class="checkbox-inline"><input name="dash_variants[]" type="checkbox" value="default">Varsayılan</label>
                                <label class="checkbox-inline"><input name="dash_variants[]" type="checkbox" value="240p">240p</label>
                                <label class="checkbox-inline"><input name="dash_variants[]" type="checkbox" value="360p">360p</label>
                                <label class="checkbox-inline"><input name="dash_variants[]" type="checkbox" value="480p">480p</label>
                                <label class="checkbox-inline"><input name="dash_variants[]" type="checkbox" value="720p">720p</label>
                                <label class="checkbox-inline"><input name="dash_variants[]" type="checkbox" value="1080p">1080p</label>
                            </div>

                            <div class="form-group">
                                <label for="codec">Statü :</label>
                                <label class="radio-inline"><input value="1" type="radio" name="status">Aktif</label>
                                <label class="radio-inline"><input value="0" type="radio" name="status">Pasif</label>
                            </div>

                            <div class="form-group">
                                <label for="codec">Ön Ayar :</label>
                                @foreach($video_settings as $video_setting)
                                    <label class="radio-inline">
                                        <input value="{{ $video_setting->id }}" type="radio" name="setting_id">{{ $video_setting->name }}
                                    </label>
                                @endforeach
                            </div>


                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-default">Yükle</button>
                        </form>
                        </br>
                        @include('layouts.alert')

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
