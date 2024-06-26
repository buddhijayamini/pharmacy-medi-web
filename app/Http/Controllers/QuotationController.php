<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Http\Controllers\Controller;
use App\Mail\QuotationNotification;
use App\Models\Prescription;
use App\Models\QuotationItem;
use App\Models\User;
use App\Notifications\QuotationStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $data = Prescription::find($id);
        return view('quote.quote-admin', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'prescription_id' => 'required|exists:prescriptions,id',
                'user_id' => 'required|exists:users,id',
                'drug.*' => 'required|string',
                'qty.*' => 'required|integer|min:1',
                'amount.*' => 'required|numeric|min:0',
                'total' => 'required|numeric',
            ]);

            // Start a database transaction
            DB::beginTransaction();

            // Create a new quotation instance
            $quotation = Quotation::create([
                'user_id' => $request->user_id,
                'prescription_id' => $request->prescription_id,
                'total' => $request->total,
                'status' => 'created'
            ]);

            // Extract drug details, quantities, and prices from the request
            $drugDetails = $request->input('drug');
            $quantities = $request->input('qty');
            $prices = $request->input('amount');

            // Loop through the drug details and create quotation items
            foreach ($drugDetails as $key => $drugDetail) {
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'drug' => $drugDetail,
                    'qty' => $quantities[$key],
                    'unit' => 'mg',
                    'amount' => $prices[$key],
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Send email notification to the user
            $user = User::findOrFail($request->user_id);
            Mail::to($user->email)->send(new QuotationNotification($quotation));

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Quotation added successfully!');
        } catch (Throwable $e) {
            // Rollback the transaction in case of any exception
            DB::rollBack();

            // Log the error for debugging
            logger()->error('Error while saving quotation: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->with('error', 'Failed to add quotation. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $quotation = Quotation::findOrFail($id);

        return view('quote.quote', compact('quotation'));
    }

    public function listAdmin()
    {
        $quotations = Quotation::all();
        return view('quote.admin-view', compact('quotations'));
    }

    public function listUser()
    {
        $quotations = Quotation::where('user_id', Auth::user()->id)->get();
        return view('quote.user-view', compact('quotations'));
    }

    public function accept($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->update(['status' => 'accepted']);

        // Notify the pharmacy
        $quotation->pharmacy->notify(new QuotationStatusNotification($quotation, 'accepted'));

        // You can send an email notification here if needed
        return redirect()->back()->with('success', 'Quotation accepted successfully!');
    }

    public function reject($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->update(['status' => 'rejected']);

        // Notify the pharmacy
        $quotation->pharmacy->notify(new QuotationStatusNotification($quotation, 'rejected'));


        // You can send an email notification here if needed
        return redirect()->back()->with('success', 'Quotation rejected successfully!');
    }
}
