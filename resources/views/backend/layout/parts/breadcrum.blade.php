@php
    
    $route = Route::currentRouteName();
    $title = str_replace('-', " ", $route);
    $title = str_replace('.', " ", $route);
@endphp
<div class="col-12">
    <div class="page-title-box">
        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
                {{-- <li class="breadcrumb-item"><a href="{{ $}}">Apps</a></li> --}}
                <li class="breadcrumb-item active">{{ ucwords($title ?? '') }}</li>
            </ol>
        </div>
        <h4 class="page-title">{{ ucwords( $title ) ?? '' }}</h4>
    </div>
</div>