@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Video Ayarları</div>
                    <div class="panel-body">

                        <form class="form-horizontal" method="post" action="{{ route('video-settings.store') }}" enctype="multipart/form-data">

                            <div class="col-md-12" style="margin-bottom: 20px;">
                                Kullanmak istemediğiniz alanları boş bırakabilirsiniz
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ön Ayar Adı</label>
                                <div class="col-sm-4">
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Watermark</label>
                                <div class="col-sm-4">
                                    <input type="file" class="form-control" name="watermark_image" id="watermark">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Watermark Yeri</label>
                                <div class="col-sm-4">
                                    <label class="radio-inline">
                                        <input value="top_left" type="radio" name="watermark_position">Yukarı Sol
                                    </label>
                                    <label class="radio-inline">
                                        <input value="top_right" type="radio" name="watermark_position">Yukarı Sağ
                                    </label>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"> </label>
                                <div class="col-sm-4">
                                    <label class="radio-inline">
                                        <input value="bottom_left" type="radio" name="watermark_position">Aşağı Sol
                                    </label>
                                    <label class="radio-inline">
                                        <input value="bottom_right" type="radio" name="watermark_position">Aşağı Sağ
                                    </label>
                                </div>

                            </div>

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
