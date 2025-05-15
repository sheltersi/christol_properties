<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $rental_applications = Application::with('user')
            ->when($search, fn($q) =>
            $q->whereHas('user', fn($q) =>
            // $q->where('first_name', 'like', "%$search%")))
            $q->where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // $rental_applications =Application::all();

        return Inertia::render('Admin/Applications/Index',[
            'applications' => $rental_applications,
            'filters' => ['search' => $search],
        ]);
    }


    public function create()
    {
        // dd(auth()->user()->full_name);
        return Inertia::render('ApplyToRent/Create',[
            'user' => Auth::user(),
        ]);
    }

    public function store(ApplicationRequest $request)
    {
        $user = Auth::user();
        // dd('we are here');
//
    $validated = $request->validated();
    $validated['user_id'] = $request->user()?->id;

    $rent = Application::create($validated);

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

public function show(Application $application)
{
    // dd(auth()->user()->full_name);
    return Inertia::render('Admin,Application/Show',[
        'user' => Auth::user(),
        'application' => $application
    ]);
}

}
