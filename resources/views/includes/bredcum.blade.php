<div class="col-sm-9">
    <h4 class="page-title">{{ $title }}</h4>
    <ol class="breadcrumb">
        @php
        $path = explode('/', $_SERVER['PATH_INFO']);
        @endphp
        @foreach($path as $path_fraction)
        <li class="breadcrumb-item"><a href="javaScript:void();">{{ $path_fraction }}</a></li>
        @endforeach
    </ol>
</div>