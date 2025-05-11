<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentRequest;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RentController extends Controller
{
    public function create()
    {
        // dd(auth()->user()->full_name);
        return Inertia::render('ApplyToRent/Create',[
            'user' => Auth::user(),
        ]);
    }

    public function store(RentRequest $request)
    {
        $user = Auth::user();
        // dd('we are here');
//
    $validated = $request->validated();
    $validated['user_id'] = $request->user()?->id;

    $rent = Rent::create($validated);

    if ($request->hasFile('id_copy')) {
        $rent->addMedia($request->file('id_copy'))->toMediaCollection('id_copy');
    }

    if ($request->hasFile('payslip')) {
        $rent->addMedia($request->file('payslip'))->toMediaCollection('payslip');
    }

    if ($request->hasFile('residence_proof')) {
        $rent->addMedia($request->file('residence_proof'))->toMediaCollection('residence_proof');
    }

    return redirect()->route('cottages.index');
}

}
