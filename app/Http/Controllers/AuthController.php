<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function loginCashier()
    {
        return inertia("Dashboard/Login");
    }
    public function authenticateCashier(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $cashier = Cashier::where("name", "=", $credentials['username'])->first();

        if ($cashier) {
            Auth::guard('cashier')->login($cashier);
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors(['username' => 'Invalid credentials']);
    }

    public function loginAdmin()
    {
        return inertia("Admin/Login");
    }

    public function authenticateAdmin(Request $request)
    {

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = User::where("name", "=", $credentials['username'])->first();

        if ($admin) {
            Auth::login($admin);
            $request->session()->regenerate();
            return redirect()->route('cashiers.index');
        }

        return back()->withErrors(['username' => 'Invalid credentials']);
    }

}
