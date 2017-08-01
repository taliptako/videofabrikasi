@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Admin</div>
                    <div class="panel-body">
                        <a href="{{ route('delete_storage') }}">
                            Public storage ı tamamen sil.
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
