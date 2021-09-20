<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Channel;
use App\Models\Custom_field;
use App\Models\Email_account;
use App\Models\Log;
use App\Models\Shortcode;
use App\Models\Sip_account;
use App\Models\Sms_account;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $accounts = Account::all();
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
        if (Auth::user()->role == 1) {
            $shortcodes = Shortcode::all();
            $email_accounts = Email_account::all();
            $sip_accounts = Sip_account::all();
            $accounts = Account::all();
            $channels = Channel::where('status', 1)->get();
            $sms_accounts = Sms_account::all();
            $custom_fields = Custom_field::all();
            $select_options = DB::table('custom_select_fields')->join('custom_fields', 'field_id', '=', 'custom_fields.id')
            ->select('custom_select_fields.*')->get();
        } else if (Auth::user()->role == 2) {
            $shortcodes = ShortCode::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $email_accounts = Email_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $sip_accounts = Sip_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $channels = Channel::where('status', 1)->get();
            $sms_accounts = Sms_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $custom_fields = Custom_field::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $select_options = DB::table('custom_select_fields')->join('custom_fields', 'field_id', '=', 'custom_fields.id')
            ->select('custom_select_fields.*')->where('status', 1)->where('account_id', Auth::user()->account_id)->get();
        } else {
            return response()->json(['message' => 'you do not have the necessary rights'], 300);
        }
        return view('auth.settings', [
            'email_accounts' => $email_accounts ?? [],
            'sip_accounts' => $sip_accounts ?? [],
            'accounts' => $accounts ?? [],
            'channels' => $channels ?? [],
            'sms_accounts' => $sms_accounts ?? [],
            'shortcodes' => $shortcodes ?? [],
            'custom_fields' => $custom_fields ?? [],
            'select_options' => $select_options,
        ]);
    }
}
