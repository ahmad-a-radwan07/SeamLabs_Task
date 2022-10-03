<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //
        $data = $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'nullable|max:255',
            'password' => 'required|min:8',
            'date_of_birth' => 'nullable|max:255',
            'phone_number' => 'nullable|numeric',
            'username' => 'required|max:255|unique:users,username',
        ]);

        // $data['password'] =  Hash::make($data['password']);

        $user = User::create($data);

        auth()->login($user);

        return response()->json($user);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)):
            return response()->json('Login Failed')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $data = $request->validate([
            'email' => 'nullable|email|unique:users,email',
            'name' => 'nullable|max:255',
            'password' => 'nullable|min:8',
            'date_of_birth' => 'nullable|max:255',
            'phone_number' => 'nullable|numeric',
            'username' => 'nullable|max:255|unique:users,username',
        ]);

        $user->update($data);

        // auth()->login($user);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json("User Removed Successfully");
    }
}
