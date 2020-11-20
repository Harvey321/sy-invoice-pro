@extends('admin.user.layout')
@section('content-wrapper')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">您没有访问权限！</div>
        </div>
    </div>
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 55vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 50px;
        }

    </style>
@endsection

