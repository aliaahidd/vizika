@extends('layouts.sideNav')

@section('content')
<!-- to display the alert message if the record has been deleted -->
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif

<!-- Page Header -->
<div class="page-header row no-gutters pb-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Company</h1>
        <h6><a href="{{ route('company') }}">Company List </a> /
            <a>Edit Company</a>
        </h6>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <!-- form create new briefing -->
        <form method="POST" action="{{ route('updatecompany', $companyinfo->id) }}" enctype="multipart/form-data" id="company">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label>Company Name</label>
                    <input type="text" name="companyName" class="form-control" id="companyName" value="{{$companyinfo->companyName}}" required>
                    <br>
                    <label>Company Email</label>
                    <input type="text" name="companyEmail" class="form-control" id="companyEmail" value="{{$companyinfo->companyEmail}}" required>
                </div>
                <div class="col-md-6">
                    <label>Company Phone Number</label>
                    <input type="text" name="companyPhoneNo" class="form-control" id="companyEmail" value="{{$companyinfo->companyPhoneNo}}" required>
                    <br>
                    <label>Comapny Address</label>
                    <input type="text" name="companyAddress" class="form-control" id="companyAddress" value="{{$companyinfo->companyAddress}}" required>
                </div>
            </div>
            <div class="row justify-content-end">
                <a href="javascript:history.go(-1)"class="btn btn-danger pull-right mr-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

</div>

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<script src="{{ asset('frontend') }}/js/dataTables.bootstrap4.js"></script>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

<script>
    // to search the visitor contractor 
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [0, "asc"]
            ],
            "language": {
                search: '<i class="fa fa-search" aria-hidden="true"></i>',
                searchPlaceholder: 'Search company'
            }
        });

        // filter visitor contractor 
        $('.dataTables_filter input[type="search"]').css({
            'width': '300px',
            'display': 'inline-block',
            'font-size': '15px',
            'font-weight': '400'
        });
    });
</script>
<Script>

</script>
@endsection