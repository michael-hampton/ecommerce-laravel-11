<?php



namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'account-dashboard';

    protected $maxAttempts = 3;
    protected $decayMinutes = 2; // Default is 1


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function loginView(Request $request)
    {
        return view('auth.login');
    }

    public function loginApi(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;

            return $this->success($success, 'User login successfully.');
        }

        return $this->error('Unauthorised.', ['error' => 'Unauthorised']);
    }

    /**
     * Handle an authentication attempt.
     */
    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);

    //     if (
    //         method_exists($this, 'hasTooManyLoginAttempts') &&
    //         $this->hasTooManyLoginAttempts($request)
    //     ) {
    //         die('yes');

    //         $this->fireLockoutEvent($request);

    //         return $this->sendLockoutResponse($request);
    //     }

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();

    //         if (auth()->user()->active === false) {
    //             Auth::logout();

    //             return Redirect::back()->withErrors(['msg' => 'Your account appears to be inactive. Please contact support']);
    //         }

    //         return $this->sendLoginResponse($request);

    //     }

    //      // If the login attempt was unsuccessful we will increment the number of attempts
    //     // to login and redirect the user back to the login form. Of course, when this
    //     // user surpasses their maximum number of attempts they will get locked out.
    //     $this->incrementLoginAttempts($request);

    //     return $this->sendFailedLoginResponse($request);
    // }
}
