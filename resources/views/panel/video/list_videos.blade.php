@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <a href="{{ route('upload_video') }}" style="margin-bottom: 10px;" class="btn btn-default">Yeni Video Yükle</a>

                <div class="panel panel-default">
                    <div class="panel-heading">Videolar</div>
                    <div class="panel-body">

                        <table class="table">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Eklenme Tarihi</td>
                                    <th>Video Adı</th>
                                    <th>Kodek</th>
                                    <th>Çözünürlükler</th>
                                    <th>Durum</th>
                                    <th>Statü</th>
                                    <th>Detay</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($videos as $video)
                                <tr>
                                    <td>{{ $video->id }}</td>
                                    <td>{{ $video->created_at }}</td>
                                    <td>{{ $video->name }}</td>
                                    <td>{{ $video->extension }}</td>
                                    <td>
                                        @foreach($video->dash_variants as $variant)
                                            {{ $variant }}
                                        @endforeach
                                    </td>
                                    <td>{{ $video->progress }}</td>
                                    <td>@if($video->status == 1) Aktif @else Pasif @endif</td>
                                    <td><a class="btn btn-primary" href="{{ route('video_details', ['video_id' => $video->id]) }}">Detay</a></td>
                                    <td>
                                        <form method="post" action="{{ route('delete_video', ['video_id' => $video->id]) }}">
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
