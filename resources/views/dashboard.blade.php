@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4 font-weight-bold">Dashboard</h4>
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100 py-3">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                                Data Ruangan
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-dark">{{ $totalRuangan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-door-open fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
