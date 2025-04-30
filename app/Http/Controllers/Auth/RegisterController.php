<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'string', 'max:12'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(Request $request): RedirectResponse
    {

        $user = User::create([
            'name' => $request->string('name'),
            'email' => $request->string('email'),
            'mobile' => $request->string('mobile'),
            'password' => Hash::make($request->string('password')),
            'active' => true,
            'utype' => !empty($request->get('seller_account')) ? 'ADM' : 'USR'
        ]);

        $token = $user->createToken('MyAppToken')->plainTextToken;

        if(!empty($request->get('seller_account'))) {
            Profile::create([
                'name' => $request->string('name'),
                'email' => $request->string('email'),
                'phone' => $request->string('mobile'),
                'user_id' => $user->id,
                'active' => false
            ]);
        }

        event(new Registered($user));

        return redirect(route('verification.notice'));
    }
}
