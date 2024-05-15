<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PharmacyController extends Controller
{
    //  /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth:pharmacy');
    // }

    public function adminView()
    {
        return view('prescription.admin');
    }

    public function adminData()
    {
        $prescriptions = Prescription::all();

        return DataTables::of($prescriptions)
            ->addColumn('action', function ($prescription) {
                return '<button class="btn btn-sm btn-primary view-prescription" data-prescription-id="' . $prescription->id . '">View</button>';
            })
            ->addColumn('user', function ($prescription) {
                return $prescription->user->name;
            })
            ->toJson();
    }

}
