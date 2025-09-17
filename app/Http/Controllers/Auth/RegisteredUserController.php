<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
        ]);

        $lastCode = Employee::orderBy('employee_id', 'desc')->first()?->employee_id ?? 'KYW000';
        $number = intval(substr($lastCode, 3)) + 1; // ambil mulai setelah 'KYW'
        $employeeId = 'KYW' . str_pad($number, 3, '0', STR_PAD_LEFT);

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'employee_id' => $employeeId
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
