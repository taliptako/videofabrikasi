@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Video Detay</div>
                    <div class="panel-body">

                        <form class="form-horizontal" method="post" action="{{ route('update_video', ['video_id' => $video->id]) }}">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Durum</label>
                                <div class="col-sm-4">
                                    <p class="form-control-static">
                                        {{ $video->progress }}
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Iframe Linki</label>
                                <div class="col-sm-4">
                                    <p class="form-control-static">
                                        <a href="{{ route('show_video', ['video_id' => $video->id, 'hash' => $video->hash]) }}" target="_blank">
                                            {{ route('show_video', ['video_id' => $video->id, 'hash' => $video->hash]) }}
                                        </a>

                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Video Adı</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name" value="{{ $video->name }}">

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Kodek</label>
                                <div class="col-sm-4">
                                    <p class="form-control-static">{{ $video->extension }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Çözünürlükler</label>
                                <div class="col-sm-4">
                                    <p class="form-control-static">
                                        @foreach($video->dash_variants as $variant)
                                            {{ $variant }}
                                        @endforeach
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Statü</label>
                                <div class="col-sm-4">
                                    <label class="radio-inline">
                                        <input value="1" type="radio" name="status" @if($video->status == 1) checked @endif>Aktif
                                    </label>
                                    <label class="radio-inline">
                                        <input value="0" type="radio" name="status" @if($video->status == 0) checked @endif>Pasif
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Resimler</label>
                                <div class="col-sm-4">
                                    <a href="{{ Storage::url($video->folder . '/previews/storyboard.png') }}" target="_blank">
                                        <img src="{{ Storage::url($video->folder . '/previews/storyboard.png') }}" width="250px">
                                    </a>

                                    @for ($i = 1; $i <= 3; $i++)
                                        <a href="{{ Storage::url($video->folder . '/previews/thumbs_0'. $i . '.jpg') }}" target="_blank">
                                            <img src="{{ Storage::url($video->folder . '/previews/thumbs_0'. $i . '.jpg') }}" width="250px">
                                        </a>
                                    @endfor


                                </div>
                            </div>

                            {{ method_field('PUT') }}

                            {{ csrf_field() }}

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Gönder</button>
                                </div>
                            </div>
                        </form>

                        @include('layouts.alert')


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
