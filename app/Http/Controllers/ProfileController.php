<?php

namespace App\Http\Controllers;

use App\TagModel;
use App\User;
use App\UserTagModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Session;


class ProfileController extends Controller
{
    public function profile()
    {

        //When account created
        $user = Auth::user();
        $string = $user->created_at;
        $s = explode(" ", $string);
        unset($s[1]);
        $s = implode(" ", $s);
        $created =  $s;

        //all user tags
        $data = DB::table('user_tags')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($tags) {
                return [
                    'id'      => $tags->id,
                    'value'   => $tags->tag_id,
                ];
            });
        foreach ($data as $tag => $value) {
            $tags[] = TagModel::where('id', $value)->first();
        }
        return view('profile.profile', compact('created', 'tags'));
    }

    public function getTags()
    {
        $user = Auth::user();
        //all user tags
        $data = DB::table('user_tags')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($tags) {
                return [
                    'id'      => $tags->id,
                    'value'   => $tags->tag_id,
                ];
            });
        foreach ($data as $tag => $value) {
            $tags[] = TagModel::where('id', $value)->first();
        }
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
            'name' => ['string', 'max:255'],
            'surname' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'starts_with:r0', 'ends_with:student.thomasmore.be,thomasmore.be', 'unique:users'],
            'password' => ['string', 'min:8', 'confirmed'],
        ]);
    }

    protected function UpdateImage()
    {
        $filename = request()->file('avatar')->getClientOriginalName();
        $filetype = explode(".", $filename);
        $check = '';


        if (request()->hasFile('avatar')) {
            if (Str::contains($filetype[1], ['jpg', 'gif', 'png', 'jpeg'])) {
                $avatar = request()->file('avatar')->getClientOriginalName();
                request()->file('avatar')->storeAs('uploads', Auth::user()->id . '/' . $avatar, '');
                User::where('id', Auth::user()->id)->update(['avatar' => '/storage/uploads/' . Auth::user()->id . '/' . $avatar . '']);

                return redirect()->back()->with('success', 'done!');
            } else {
                return redirect()->back()->with('error', 'Error!');
            }
        }
    }

    protected function update()
    {

        if (request()->has('name')) {
            User::where('id', Auth::user()->id)->update(['name' => request('name')]);
        }
        if (request()->has('surname')) {
            User::where('id', Auth::user()->id)->update(['surname' => request('surname')]);
        }
        if (request()->has('email')) {
            User::where('id', Auth::user()->id)->update(['email' => request('email')]);
        }
        if (request()->has('year')) {
            User::where('id', Auth::user()->id)->update(['year' => request('year')]);
        }
        if (request()->has('buddy')) {
            User::where('id', Auth::user()->id)->update(['buddy' => request('buddy  ')]);
        }

        if (request()->has('types')) {
            //processing skillsArray
            $RawSkillsArray = request('types');
            $RawSkillsArray = explode(', ', $RawSkillsArray);

            foreach ($RawSkillsArray as $skill) {
                //getting all skills id
                $tag = TagModel::where('name', $skill)
                    ->first();

                //creating skills for user in userTagModel
                UserTagModel::create([
                    'user_id' => Auth::user()->id,
                    'tag_id' => $tag->id
                ]);
            };
        }
        return redirect()->back();
    }

    public function PasswordPage()
    {
        return view('auth.UpdatePassword');
    }

    protected function updatePassword(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with('CurrentError', 'Error!');
        }

        if ($request->get('current-password') == $request->get('new-password')) {
            //Current password and new password are same
            return redirect()->back()->with('SameError', 'Error!');
        }

        if ($request->get('new-password_confirmation') != $request->get('new-password')) {
            //Confirm new password and new password are same
            return redirect()->back()->with('NewSameError', 'Error!');
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        $password = Hash::make($request->get('new-password'));
        User::where('id', Auth::user()->id)->update(['password' => $password]);

        return redirect(app()->getLocale() . '/profile')->with('PasswordChanged', 'changed!');
    }

    public function userProfile()
    {
        $user = User::where('name', request('name'))
            ->where('surname', request('surname'))
            ->first();

        $string = $user->created_at;
        $s = explode(" ", $string);
        unset($s[1]);
        $s = implode(" ", $s);
        $created =  $s;

        if (!$user) {
            abort(404);
        }
        return view('profile.user')->with(['user' => $user, 'created' => $created]);
    }
}
