@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Upload Prescription') }}</div>

                    <div class="card-body">
                        {{-- Success Message --}}
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Error Messages --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('prescription.upload') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="images">Prescription Images (Max 5)</label>
                                <input type="file" class="form-control-file" name="images[]" id="images" multiple
                                    accept="image/*" required>
                            </div>
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" name="notes" id="notes" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="delivery_address">Delivery Address</label>
                                <input type="text" class="form-control" name="delivery_address" id="delivery_address"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="delivery_time">Preferred Delivery Time</label>
                                <select class="form-control" name="delivery_time" id="delivery_time" required>
                                    <option value="">Select Delivery Time</option>
                                    @foreach ($deliverySlots as $slot => $display)
                                        <option value="{{ $slot }}">{{ $display }}</option>
                                    @endforeach
                                </select>
                            </div>
                            </br>
                            <div class="form-group" style="text-align: right">
                                <button type="submit" class="btn btn-primary">Upload Prescription</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Display success message if session has 'success' key
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        // Display error messages if any
        @if ($errors->any())
            Swal.fire({
                title: 'Error!',
                text: 'Please check the form for errors.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush
