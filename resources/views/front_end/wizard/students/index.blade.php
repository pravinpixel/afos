@extends('front_end.wizard.index')
@section('wizard_content')
<div class="wizard_menu col-lg-10 mx-auto"> 
    <!--========= Wizard Body  ======-->  
    <div class="col-lg-10 mx-auto">
        <div class="card option_card shadow-sm">
            <div class="card-body p-0">
                <div class="card-title">
                    Order Food Online
                </div>
                <div id="step1">
                    @if(session()->get('order') )
                        @include('front_end.wizard.students.info')
                    @else
                        @include('front_end.wizard.students.form')
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
    <!--========= End : Wizard Body  ======-->  
</div>
@endsection
