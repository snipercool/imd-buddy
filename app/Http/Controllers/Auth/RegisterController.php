<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\TagModel;
use App\User;
use App\UserTagModel;
use Illuminate\Foundation\Auth\RegistersUsers;
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
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255','starts_with:r0', 'ends_with:student.thomasmore.be,thomasmore.be', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'year' => ['required'],
            'buddy' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'year' => $data['year'],
            'buddy' => $data['buddy'],
        ]);

        if (request()->hasFile('avatar')) {
            $avatar = request()->file('avatar')->getClientOriginalName();
            request()->file('avatar')->storeAs('uploads', $user->id . '/' . $avatar, '');
            $user->update(['avatar' => '/storage/uploads/' . $user->id . '/' . $avatar . '']);
        }

        if (request('types') != null) {
           //processing skillsArray
        $RawSkillsArray = request('types');
        $RawSkillsArray = explode(', ', $RawSkillsArray);

        foreach ($RawSkillsArray as $skill) {
            //getting all skills id
            $tag = TagModel::where('name', $skill)
                ->first();

            //creating skills for user in userTagModel
            UserTagModel::create([
                'user_id' => $user->id,
                'tag_id' => $tag->id
            ]);
        };
        }
        

        return $user;
    }

    public function redirectTo()
    {
        return app()->getLocale(). '/';
    }
}
