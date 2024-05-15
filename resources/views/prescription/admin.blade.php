@extends('layouts.app')
<!-- Other CSS files -->
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Prescriptions') }}</div>

                    <div class="card-body">
                        <table class="table" id="prescriptions-table">
                            <thead>
                                <tr>
                                    <th>Prescription ID</th>
                                    <th>User</th>
                                    <th>Delivery Address</th>
                                    <th>Delivery Time</th>
                                    <th>Note</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="prescriptionModal" tabindex="-1" role="dialog" aria-labelledby="prescriptionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="prescriptionModalLabel">Prescription Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="prescriptionDetails">
                    <!-- Prescription details will be displayed here -->
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#prescriptions-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('prescription.data.admin') }}',
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user',
                    name: 'user'
                },
                {
                    data: 'delivery_address',
                    name: 'delivery_address'
                },
                {
                    data: 'delivery_time',
                    name: 'delivery_time'
                },
                {
                    data: 'notes',
                    name: 'notes'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Handle click event for view prescription button
        $(document).on('click', '.view-prescription', function() {
            var prescriptionId = $(this).data('prescription-id');

            // AJAX request to fetch prescription details
            $.ajax({
                url: '/prescriptions/' + prescriptionId,
                type: 'GET',
                success: function(response) {
                    $('#prescriptionDetails').html(response);
                    $('#prescriptionModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
