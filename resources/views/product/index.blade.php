@extends('adminLayout')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <div id="app" class="row pt-2 pb-2">
            @include('includes.bredcum',['title'=>'Product Index'])
            <router-link to="/productshow">About</router-link>
            <router-link to="/test">Test</router-link>
            <router-view></router-view>

        </div>

        <!--start overlay-->
        <div class="overlay"></div>
        <!--end overlay-->

    </div>
    <!-- End container-fluid-->

</div>
@endsection