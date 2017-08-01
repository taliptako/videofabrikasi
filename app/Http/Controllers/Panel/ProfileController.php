<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('auth.profile');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $user = $request->user();

        $user->name = $request['name'];

        if ($request->has('password')) {
            $this->validate($request, [
                'password' => 'required|min:6|confirmed',
            ]);
            $user->password = bcrypt($request['password']);
        }

        $user->save();

        return redirect()->route('edit_profile');
    }
}
