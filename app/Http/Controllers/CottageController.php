<?php

namespace App\Http\Controllers;

use App\Models\Cottage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CottageController extends Controller
{
    public function index()
    {
        $cottages = Cottage::latest()->get();

        return Inertia::render('Cottages/Index',[
            'cottages' => $cottages
        ]);
    }
}
