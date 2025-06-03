<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Models\Application;
use App\Models\User;
use App\Notifications\ApplicationAccepted;
use App\Notifications\ApplicationDeclined;
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
    return Inertia::render('Tenant/Applications/Show',[
        'user' => Auth::user(),
        'application' => $application
    ]);
}

public function accept(Application $application)
{
    $application->status = 'accepted';
    $application->save();

    $user = $application->user;

    $user->notify(new ApplicationAccepted($application));

    return back()->with('success','Appliation accepted, refresh the page to see the changes');
}

public function decline(Request $request,Application $application)
{
    $application->status = 'declined';
    $application->declined_reason = $request->reason;
    $application->save();

    $user = $application->user;

    $user->notify(new Applicationdeclined($application));

    return back()->with('success','Appliation declined, refresh the page to see the changes');
}

public function revoke(Request $request,Application $application)
{
    $request->validate(['reason' => 'required|string|max:1000']);

    $application->status = 'declined';
    $application->revoked_reason = $request->reason;
    $application->save();

    $user = $application->user;

    $user->notify(new ApplicationDeclined($application));

    return back()->with('success','Appliation accepted, refresh the page to see the changes');
}

public function tenantApplication(Application $application)
{
      // dd(auth()->user()->full_name);
      $application->load('user');
      return Inertia::render('Admin/Applications/Show',[
        'user' => Auth::user(),
        'application' => $application
    ]);
}
}
