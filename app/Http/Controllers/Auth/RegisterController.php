<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Raffle;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'raffle_type' => ['required'],
            
        ]);
    }
    public function showRegistrationForm(Request $request)
    {
        $rafflestypes=Raffle::all();
        return view('auth.register', compact('rafflestypes'));
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $input
     * @return \App\User
     */
    protected function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $messages = [
                'required'  => ':attribute is require',
                'unique' => ':attribute is already registered for same raffle type.',
            ];
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'email' => [
                    'required',
                    'string','email','max:255',
                    Rule::unique('users')->where(function ($query) use($input) {
                    return $query->where('raffle_type', $input['raffle_type']);
                })],
                'raffle_type'=>'required'
            ],$messages);
    
            if ($validator->fails()) {
                return redirect('register')
                            ->withErrors($validator)
                            ->withInput();
            }  
             
                if($input['name'] && $input['email']){
                    $user = User::create([
                        'name' => $input['name'],
                        'email' => $input['email'],
                        'raffle_type' => $input['raffle_type'],
                    ]);
                    if($user){
                        Auth::login($user);
                        return redirect('home');
                    }
                }
        }
       
    }
}
