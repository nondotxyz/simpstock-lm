<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class CashierController extends Controller
{
    public function index()
    {
        $cashiers = Cashier::all();
        return Inertia::render("Admin/Cashier/Index", [
            'cashiers' => $cashiers
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'telephone' => 'required|string',
            'password' => 'required|string',
        ]);

        $cashier = Cashier::create([
            'name' => $data['name'],
            'telephone' => $data['telephone'],
            'password' => $data['password'],
        ]);

        $cashier->assignRole('cashier');

        return redirect()->back();
    }

    public function edit(Cashier $cashier)
    {
        return Inertia::render('Admin/Cashier/Edit', [
            'cashier' => $cashier
        ]);
    }

    public function update(Request $request, Cashier $cashier)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'telephone' => 'required|string',
            'password' => 'nullable|string',
        ]);

        $cashier->name = $data['name'];
        $cashier->telephone = $data['telephone'];

        if (!empty($data['password'])) {
            $cashier->password = $data['password'];
        }

        $cashier->save();

        return redirect()->route('cashiers.index');
    }


    public function destroy(Cashier $cashier)
    {
        $cashier->delete();
        return redirect()->back();
    }
}
