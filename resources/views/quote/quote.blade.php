@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Quotation Details</h2>
            </div>
            <div class="card-body">
                <h3>Quotation Information</h3>
                <p><strong>Quotation ID:</strong> {{ $quotation->id }}</p>
                <p><strong>Total Amount:</strong> ${{ $quotation->total }}</p>

                <h3>Pharmacy Information</h3>
                <p><strong>User Name:</strong> {{ $quotation->pharmacy->name }}</p>
                <p><strong>Email:</strong> {{ $quotation->pharmacy->email }}</p>
                <p><strong>Address:</strong> {{ $quotation->pharmacy->address }}</p>

                <h3>Status</h3>
                <p><strong>Status:</strong> {{ $quotation->status }}</p>
            </div>
        </div>
    </div>
@endsection
