<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
		return User::all();
    }

    public function store(Request $request)
    {
	    $this->validate($request, [
		    'email' => 'required|unique:users|email',
		    'username' => 'required',
	    ], [
		    'required' => 'El :attribute es requerido',
		    'email' => 'El :attribute no es correcto'
	    ]);

	    $user = new User([
	    	"name" => $request->input('username'),
		    "email" => $request->input('email'),
		    "password" => Hash::make('123456')
	    ]);

	    $user->save();

	    return $user;
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->save();
        return $user;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['res' => 'success']);
    }

}
