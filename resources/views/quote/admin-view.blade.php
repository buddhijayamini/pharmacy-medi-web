@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Quotations</h1>
        @if ($quotations->isEmpty())
            <p>No quotations available.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Drug Details</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quotations as $quotation)
                            <tr>
                                <td>{{ $quotation->id }}</td>
                                <td>
                                    @foreach ($quotation->items as $item)
                                    {{ $item->drug }} ,
                                    @endforeach
                                   </td>
                                <td>{{ $quotation->total }}</td>
                                <td>{{ $quotation->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
