<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('company.auth');
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Company $company)
    {
        return view('companies.dashboard', compact('company'));
    }
}
