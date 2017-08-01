@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <a href="{{ route('video-settings.create') }}" style="margin-bottom: 10px;" class="btn btn-default">Yeni Ekle</a>
                <div class="panel panel-default">
                    <div class="panel-heading">Video Ön Ayarları</div>
                    <div class="panel-body">

                        <table class="table">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Ayar Adı</td>
                                <th>Düzenle</th>
                                <th>Sil</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($video_settings as $video_setting)
                                <tr>
                                    <td>{{ $video_setting->id }}</td>
                                    <td>{{ $video_setting->name }}</td>
                                    <td><a class="btn btn-primary" href="{{ route('video-settings.edit', ['video_id' => $video_setting->id]) }}">Düzenle</a></td>
                                    <td>
                                        <form method="post" action="{{ route('video-settings.destroy', ['setting_id' => $video_setting->id]) }}">
                                            {{ method_field('DELETE') }}
                                            <div class="form-group">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
