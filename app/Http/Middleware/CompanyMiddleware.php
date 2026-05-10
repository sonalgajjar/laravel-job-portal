<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompanyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('company_id')) {
            return redirect()->route('company.login')->with('error', 'Please login as a company first.');
        }

        $company = \App\Models\Company::find(session('company_id'));

        if (!$company) {
            session()->forget('company_id');
            return redirect()->route('company.login')->with('error', 'Company not found.');
        }

        if ($company->status !== 'approved') {
            session()->forget('company_id');
            return redirect()->route('company.login')->with('error', 'Your company account is pending admin approval. Please wait for verification.');
        }

        return $next($request);
    }
}
