@extends('layouts.app')
@section('content')
    <main>
        <div class="menu">
            <div class="col-lg-4 col-md-6 mx-auto">
                <div class="card option_card shadow-sm">
                    <div class="card-body p-0">
                        <div class="card-title">
                            Choose your Options 
                        </div>
                        <div>
                            <label for="pay_fees_online" class="check-box">
                                <input type="radio" name="some" class="form-check-input" id="pay_fees_online">
                                Pay Fees Online
                            </label>
                            <label for="Order_Food_online" class="check-box">
                                <input type="radio" name="some" class="form-check-input" id="Order_Food_online">
                                Order Food Online
                            </label>
                            <a href="{{ route('online.student') }}">
                                <input type="submit" value="Proceed" class="w-100 btn btn-primary">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection