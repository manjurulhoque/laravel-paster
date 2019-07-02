<?php

namespace App\Http\Controllers\Frontend;

use App\Paste;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    /*
     * User created pastes
     */
    public function my_pastes()
    {
        $user = auth()->user();
        $pastes = $user->pastes()->paginate(10);

        $recent_pastes = Paste::where('status', 1)->where(function ($query) {
            $query->where('expire_time', '>', \Carbon\Carbon::now())->orWhereNull('expire_time');
        })->orderBy('created_at', 'desc')->limit(5)->get();

        return view('frontend.users.my-pastes', compact('user', 'pastes', 'recent_pastes'));
    }

    /*
     * Profile Edit View
     */
    public function edit()
    {
        $user = auth()->user();
        return view('frontend.users.profile', compact('user'));
    }

    /*
     * Profile Update
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $this->validate(request(), [
            'current_password' => 'nullable|sometimes',
            'new_password' => 'nullable|sometimes|string|min:6|same:confirm_new_password',
            'avatar' => 'sometimes|mimes:jpeg,jpg,png|max:1024',
        ]);

        if (!empty($request->get('current_password')) && !(Hash::check($request->get('current_password'), $user->password))) {
            // The passwords doesn't matches
            return redirect()->back()->with("warning", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (!empty($request->get('new_password')) && !empty($request->get('confirm_new_password')) && strcmp($request->get('new_password'), $request->get('confirm_new_password')) != 0) {
            //Current password and new password are same
            return redirect()->back()->with("warning", "New Password cannot be same as your current password. Please choose a different password.");
        }

        if ($request->hasFile('avatar')) {
            $upload_to = 'uploads/';
            $destinationPath = date('Y') . '/' . date('m') . '/' . date('d');
            if (!file_exists($upload_to . $destinationPath)) {
                mkdir($upload_to . $destinationPath, 0755, true);
            }

            if (!empty($user->avatar)) {
                @unlink(ltrim($user->avatar));
            }

            $random = str_random(8);
            $avatar = $request->file('avatar');
            $file_extension = $avatar->getClientOriginalExtension();
            $avatar_name = $random . '.' . $file_extension;
            $resize_avatar_name = $random . '_130x130.' . $file_extension;

            $avatar->move($upload_to . $destinationPath, $avatar_name);
            $original_avatar = $upload_to . $destinationPath . '/' . $avatar_name;

            Image::make($original_avatar)->resize(130, 130)->save($upload_to . $destinationPath . '/' . $resize_avatar_name);

            $user->avatar = $destinationPath . '/' . $resize_avatar_name;
            @unlink($original_avatar);
        }


        $user->password = Hash::make($request->get('new_password'));
        $user->about = $request->about;
        $user->save();

        return redirect()->back()->with("success", "Password changed successfully");
    }
}
