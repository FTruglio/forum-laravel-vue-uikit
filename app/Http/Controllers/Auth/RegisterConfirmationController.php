<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
    public function confirmation()
    {
        try {
            $user = User::where('confirmation_token', request('token'))
            ->firstOrFail()
            ->confirm();
        } catch (\Exception $e) {
            return redirect('/threads')->with('flash', 'Unknown token');
        }

        return redirect('/threads')->with('flash', 'Congratulations! start publishing threads.');
    }
}
