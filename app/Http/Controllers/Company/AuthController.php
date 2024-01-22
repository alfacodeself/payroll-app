<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\{Auth, Hash};
use App\Traits\AuthenticatesCompanies;

class AuthController extends Controller
{
    public function login(Company $company)
    {
        return view('companies.auth.login', [
            'company' => $company->slug
        ]);
    }
    public function authenticate(Company $company, Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $remember = $request->has('remember');
        try {
            if ($credentials['username'] != $company->username) {
                return back()->withErrors([
                    'username' => ['The provided username does not match our records.']
                ])
                ->withInput();
            }
            if (!Hash::check($credentials['password'], $company->password)) {
                return back()->withErrors([
                    'password' => ['The provided password does not match our records.']
                ])
                ->withInput();
            }
            Auth::guard('company')->attempt($credentials, $remember);
            return redirect()->intended(route('company.dashboard', $company->slug))->with('success', 'Login successful!');
        } catch (\Throwable $th) {
            return back()->withErrors([
                'username' => [$th->getMessage()]
            ])
            ->withInput();
        }
    }
    public function logout(Request $request, Company $company)
    {
        Auth::guard('company')->logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('company.auth.login', $company->slug)->with('success', 'Logout successful!');
    }
}
