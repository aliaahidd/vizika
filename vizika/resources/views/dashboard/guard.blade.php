@extends('layouts.sideNav')
@section('content')

<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0 d-flex">
        <h1 class="page-title ml-3">Dashboard</h1>
    </div>
</div>

<!-- Dashboard information start -->
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <i class="material-icons md-48" style="font-size: 50px; top: 10px">person</i>
                    </div>
                    <div class="col-8">
                        <h1>75</h1>
                        <span>Total Visitor</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <i class="material-icons md-48" style="font-size: 50px; top: 10px">event</i>
                    </div>
                    <div class="col-8">
                        <h1>356</h1>
                        <span>Total Appointment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <i class="material-icons md-48" style="font-size: 50px; top: 10px">event</i>
                    </div>
                    <div class="col-8">
                        <h1>20</h1>
                        <span>Total Checkin</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <i class="material-icons md-48" style="font-size: 50px; top: 10px">event</i>
                    </div>
                    <div class="col-8">
                        <h1>25</h1>
                        <span>Total Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<!-- Dashboard information end -->

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header pb-0">
                <h5>Visitor Log</h5>
            </div>
            <div class="card-body">
                <div id="total_visitor_data" style="width: 520px; height: 200px"></div>
            </div>
        </div>
    </div>
</div>


@endsection