@extends('layouts.sideNav')

@section('content')
<div class="page-header row no-gutters">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h1 class="page-title mb-3">Qr Code</h1>
        <h6>QR Code</h6>
    </div>
</div>

<body>
    <!-- to display the alert message if the record has been deleted -->
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
            </div>
        </div>

        <div class="card-body">
            <form class="text-center" action="{{route('generateQrCode')}}" method="get" accept-charset="utf-8">
                <div class="row">
                    <div class="col-md-12">
                        <h2>QR Code - Visitor</h2>
                        <button class="btn btn-success" type="submit">Generate</button>
                        <a href="{{asset('qrcode.png')}}" class="btn btn-primary" download>Download</a><br>
                        <img class="img-thumbnail" src="{{asset('assets/qr/qrcode.png')}}" width="300" height="300" style="margin-top: 20px">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

<script src="{{ asset('frontend') }}/js/jquery.dataTables.js"></script>
<script src="{{ asset('frontend') }}/js/dataTables.bootstrap4.js"></script>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

<script>
    // to search the appointment 
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [1, "desc"]
            ],
            "language": {
                search: '<i class="fa fa-search" aria-hidden="true"></i>',
                searchPlaceholder: 'Search record'
            }
        });
    });
</script>

@endsection