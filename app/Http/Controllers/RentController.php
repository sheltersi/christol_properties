<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RentController extends Controller
{
    public function create()
    {
        return Inertia::render('ApplyToRent/Create',[
            'user' => auth()->user(),
        ]);
    }
}
