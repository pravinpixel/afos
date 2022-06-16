@extends('layouts.app')
@section('content')
<main>
    
    <div class="menu">
        <div>
            <div class="card option_card border-0  col-lg-8 mx-auto" >
                <div class="card-title">
                    Order Confirmation
                </div>
                <div class="card-body mb-5 shadow-sm border">
                    <div class="confirmed_message">
                        <div class="fa fa-check-circle text-success fa-3x m-3"></div>
                        <p class="m-0">Your Order is confirmed. Your Order No ODR0001. Please find the Payment transaction details below</p>
                    </div>
                </div>
                <div class="card-title">
                    Transaction Info
                </div>
                <table class="table order-table">
                    <thead>
                        <tr>
                            <th>Particular</th>
                            <th></th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Student Name</th>
                            <td>:</td>
                            <td>P. Sam</td>
                        </tr>
                        <tr>
                            <th>Register No</th>
                            <td>:</td>
                            <td>131300001</td>
                        </tr>
                        <tr>
                            <th>Class</th>
                            <td>:</td>
                            <td>4 std</td>
                        </tr>
                        <tr>
                            <th>Section</th>
                            <td>:</td>
                            <td>A sec</td>
                        </tr>
                        <tr>
                            <th>Father Name</th>
                            <td>:</td>
                            <td>P. Prem</td>
                        </tr>
                        <tr>
                            <th>Mother Name</th>
                            <td>:</td>
                            <td>Debora</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center mt-3" >
                    <a href="Order-Confirmation.html" class="px-3 btn btn-primary">Go to Home</a>
                </div>

            </div> 
        </div>
    </div>
</main>
@endsection
