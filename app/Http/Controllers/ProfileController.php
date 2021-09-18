<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Channel;
use App\Models\Email_account;
use App\Models\Log;
use App\Models\Sip_account;
use App\Models\Sms_account;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * show profile page
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $email_accounts = Email_account::where('status', 1)->get();
        $sip_accounts = Sip_account::where('status', 1)->get();
        $accounts = Account::where('status', 1)->get();
        $channels = Channel::where('status', 1)->get();
        $sms_accounts = Sms_account::where('status', 1)->get();
        return view('auth.profile', [
            'email_accounts' => $email_accounts,
            'sip_accounts' => $sip_accounts,
            'accounts' => $accounts,
            'channels' => $channels,
            'sms_accounts' => $sms_accounts,
        ]);
    }

    /**
     * Update user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:128',
                Rule::unique('users')->ignore($request->id)
            ],
            'login' => [
                'required',
                'string',
                'min:3',
                'max:128',
                Rule::unique('users')->ignore($request->id)
            ],
            'language' => 'required|string|min:2|max:5',
        ]);
        $user = User::find($request->id);
        $user->update($data);

        Log::create(['user_id' => Auth::user()->id, 'log_date' => new DateTime(), 'action' => 'user.update', 'element' => getElementByName('users'), 'element_id' => $user->id, 'source' => 'user.update, ' . Auth::user()->id]);
        //return redirect(route('users'));
        //return response()->json(['success' => 'This User has been edited']);
        return response()->json(['success' => 'Your profile has been Updated', 'user' => $user]);
    }
    /**
     * show settings page
     * 
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $email_accounts = Email_account::where('status', 1)->get();
        $sip_accounts = Sip_account::where('status', 1)->get();
        $accounts = Account::where('status', 1)->get();
        $channels = Channel::where('status', 1)->get();
        $sms_accounts = Sms_account::where('status', 1)->get();
        return view('auth.settings', [
            'email_accounts' => $email_accounts,
            'sip_accounts' => $sip_accounts,
            'accounts' => $accounts,
            'channels' => $channels,
            'sms_accounts' => $sms_accounts,
        ]);
    }
}
