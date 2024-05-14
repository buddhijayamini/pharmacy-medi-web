<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class UploadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $deliverySlots = $this->generateTimeSlots();

        return view('upload', compact('deliverySlots'));
    }

    public function upload(Request $request)
    {
        try {
            $request->validate([
                'images.*' => 'required|image|mimes:jpeg,png,jpg',
                'notes' => 'nullable|string',
                'delivery_address' => 'required|string',
                'delivery_time' => 'required|string',
            ]);

            // Check if the number of uploaded images exceeds the maximum limit of 5
            if (count($request->file('images')) > 5) {
                throw ValidationException::withMessages(['images.*' => 'You can upload a maximum of 5 images.']);
            }

            $user = auth()->user();

            DB::beginTransaction();

            $prescription = $user->prescriptions()->create([
                'user_id' => $user->id,
                'notes' => $request->input('notes'),
                'delivery_address' => $request->input('delivery_address'),
                'delivery_time' => $request->input('delivery_time'),
            ]);

            foreach ($request->file('images') as $image) {
                $imageName = $image->store('prescriptions', 'public'); // Store image in public/prescriptions directory

                $prescription->images()->create([
                    'prescription_id' => $prescription->id,
                    'image_path' => $imageName,
                ]);

                if (!$prescription) {
                    throw new \Exception('Failed to create prescription.');
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Prescription uploaded successfully.');
        } catch (ValidationException $e) {
            DB::rollBack();

            return redirect()->back()->withErrors($e->errors());
        } catch (Throwable $e) {
            DB::rollBack();

            // Delete uploaded images if any
            if (isset($imageName)) {
                Storage::disk('public')->delete($imageName);
            }

            Log::error("message" . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to upload prescription. ' . $e->getMessage());
        }
    }

    public function generateTimeSlots()
    {
        $startTime = Carbon::parse('00:00:00'); // Start from midnight
        $endTime = Carbon::parse('23:59:59'); // End at 11:59:59 PM
        $interval = CarbonInterval::hours(2); // Set interval to 2 hours

        $deliverySlots = [];

        // Generate time slots
        for ($time = $startTime; $time->lte($endTime); $time->add($interval)) {
            $slot = $time->format('H:i') . '-' . $time->addHours(2)->format('H:i');
            $deliverySlots[$slot] = $time->subHours(2)->format('g:i A') . ' - ' . $time->format('g:i A');
        }

        return $deliverySlots;
    }
}
