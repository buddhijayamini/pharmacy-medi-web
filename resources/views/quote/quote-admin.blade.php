@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h2>Add Quote Data</h2>
            </div>
            <div class="card-body">
                <div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form method="post" action="{{ route('quotation.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="prescription_id" value="{{ $data->id }}" />
                        <input type="hidden" name="user_id" value="{{ $data->user_id }}" />
                        <div class="row">
                            <div class="col-sm-4 p-8 text-black">
                                <div class="form-group">
                                    <label for="img"> Prescription Image: </label>
                                    <img class="form-control image" src="{{ asset("storage/".$data->images[0]->image_path) }}" style="height:350px" title="Prescription" />
                                </div>
                            </div>
                            <div class="col-sm-8 p-3 text-black">
                                <div class="form-group">
                                    <table id="list" class="table table-bordered table-responsive">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th style="width:300px">Drug</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <div class="form-group" style="float:right">
                                        <label for="total">Total:</label>
                                        <input type="text" id="total" name="total" readonly />
                                    </div>
                                </div>
                                <br /><br />
                                <div class="form-group">
                                    <label for="drug">Drug:</label>
                                    <input type="text" class="form-control" id="drug" />
                                </div>
                                <div class="form-group">
                                    <label for="qty">Quantity:</label><br />
                                    <input type="number" style="width:200px; float:left" placeholder="Per Price" id="qty" />
                                    <label style="margin-left:20px">*</label>
                                    <input type="number" style="width:200px; margin-left:20px" placeholder="Quantity" id="qty1" />
                                </div>
                                <br />
                                <button type="button" style="float:right" class="btn btn-primary" onclick="AddData()">Add</button>
                            </div>
                        </div>
                        <br />
                        <button type="submit" style="float:right; width: 300px" class="btn btn-primary">Send Quotation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
    function AddData() {
        var drug = document.getElementById("drug").value;
        var qty = document.getElementById("qty").value;
        var qty1 = document.getElementById("qty1").value;
        var price = qty * qty1;

        // Append a new row to the table with the drug, quantity, and price
        $('#list tbody').append('<tr><td><input type="hidden" name="drug[]" value="' + drug + '">' + drug +
            '</td><td><input type="hidden" name="qty[]" value="' + qty1 + '">' + qty + '*' + qty1 +
            '</td><td><input type="hidden" name="amount[]" value="' + price + '">' + price + '</td></tr>');

        // Calculate the total price
        var total = 0;
        $("input[name='amount[]']").each(function() {
            total += parseFloat($(this).val());
        });

        // Update the total input field
        $('#total').val(total);

        // Clear input fields
        $('#drug').val('');
        $('#qty').val('');
        $('#qty1').val('');
    }
</script>
