@php
    $route = Route::currentRouteName();
    $title = str_replace('-', " ", $route);
    
@endphp
<div class="wizard-nav">
    <a href="{{ route('online.student') }}" class="menu-item active" >
        <img src="{{ asset('assets/front/images/student.png') }}" alt="">
        <span>Student Info</span>
    </a>
    <a href="@if(isset(session()->get('order')['student_id'] )){{ route('online.food') }}@else javascript:; @endif" class="menu-item @if( $title == 'online.food' || isset(session()->get('order')['student_id'] ) ) active @endif">
        <img src="{{ asset('assets/front/images/food.png') }}" alt="">
        <span>Food Info</span>
    </a>
    <a href="@if(isset(session()->get('order')['product_id'] )){{ route('confirm.order') }}@else javascript:; @endif" class="menu-item confirm-order @if( $title == 'confirm.order' ) active @endif">
        <img src="{{ asset('assets/front/images/confirm-order.png') }}" alt="">
        <span>Confirm Order</span>
    </a>
</div>