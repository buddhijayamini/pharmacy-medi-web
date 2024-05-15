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
                            <th>Action</th>
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
                                <td>
                                    @if ($quotation->status == 'created')
                                        <form action="{{ route('quotation.accept', $quotation->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Accept</button>
                                        </form>
                                        <form action="{{ route('quotation.reject', $quotation->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Reject</button>
                                        </form>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($quotation->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
