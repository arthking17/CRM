<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Appointment;
use App\Models\Communication;
use App\Models\Contact;
use App\Models\Contact_data;
use App\Models\Email_account;
use App\Models\Log;
use App\Models\Note;
use App\Models\Sip_account;
use App\Models\Sms_account;
use App\Models\User;
use App\Models\Users_permission;
use DateTime;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 1) {
            $accounts = DB::table('accounts')
                ->orderBy('id', 'desc')->get();

            $email_accounts = Email_account::where('status', 1)->get();
            $sip_accounts = Sip_account::where('status', 1)->get();
            $sms_accounts = Sms_account::where('status', 1)->get();

            $users = User::all();
            if ($users->count() > 0) {
                $user = $users->last();
                $users_permissions = Users_permission::where('user_id', $user->id)->get();
                $notes = DB::table('notes')
                    ->where('element', getElementByName('users'))->where('element_id', $user->id)->get();
            }

            //Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'users.show', 'element' => getElementByName('users'), 'element_id' => 0, 'source' => 'users']);

            return view('users.list', [
                'users' => $users,
                'users_permissions' => $users_permissions,
                'notes' => $notes,
                'accounts' => $accounts,
                'elementClass' => getElementByName('users'),
                'email_accounts' => $email_accounts,
                'sip_accounts' => $sip_accounts,
                'sms_accounts' => $sms_accounts,
            ]);
        } else {
            return response()->json(['message' => 'you do not have the necessary rights'], 300);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = DB::table('accounts')
            ->orderBy('id', 'desc')
            ->get();

        return view('users.create', [
            'accounts' => $accounts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'account_id' => 'required|exists:App\Models\Account,id',
            'username' => 'required|string|min:3|max:128|unique:users',
            'login' => 'required|string|min:3|max:128|unique:users',
            'pwd' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'role' => 'required|integer|min:1|max:3',
            'language' => 'required|string|min:2|max:5',
            'photo' => 'required|mimes:jpg,png,jpeg',
        ]);

        $request->file('photo')->storePublicly('public/images/users');
        $data['photo'] = $request->file('photo')->hashName();
        $data['pwd'] = bcrypt($data['pwd']);
        $user = User::create($data);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'user.create', 'element' => getElementByName('users'), 'element_id' => $user->id, 'source' => 'user.create']);
        //return redirect(route('users'));
        //return response()->json(['user' => $user, 'success' => 'This User has been added']);
        $users = User::orderBy('id', 'DESC')->get();
        $sip_accounts = Sip_account::where('status', 1)->get();
        $returnHTML = view('users/datatable-users', compact('users', 'sip_accounts'))->render();
        return response()->json(['success' => 'This user has been added', 'html' => $returnHTML, 'user' => $user]);
    }

    /**
     * Get user by id.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserById(int $id)
    {
        $accounts = DB::table('accounts')
            ->orderBy('id', 'desc')
            ->get();
        $user = User::find($id);

        return view('users.edit', [
            'user' => $user,
            'accounts' => $accounts,
        ]);
    }

    /**
     * Get user by id with json response.
     *
     * @param int $id
     * @param int $modal
     * @return \Illuminate\Http\Response
     */
    public function getUserJsonById(int $id, int $modal)
    {
        $user = User::find($id);
        if ($modal == 0) {
            $user->account = $user->account[0];
            $user->role = (int)$user->role;
            if (Auth::user()->role == 1)
                $sip_accounts = Sip_account::where('status', 1)->get();
            else if (Auth::user()->role == 2)
                $sip_accounts = Sip_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $returnHTML = view('users/user-info', compact('user', 'sip_accounts'))->render();
            return response()->json(['success' => 'User found', 'html' => $returnHTML, 'elementClass' => getElementByName('users')]);
        }
        if ($modal == 1)
            return response()->json($user);
        //return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $page_name
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $page_name)
    {
        if ($request->input('pwd')) {
            $data = $request->validate([
                'account_id' => 'required|exists:App\Models\Account,id',
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
                'pwd' => [
                    'required',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
                ],
                'role' => 'required|integer|min:1|max:3',
                'language' => 'required|string|min:2|max:5',
                'photo' => 'mimes:jpg,png,jpeg',
            ]);
            $data['pwd'] = bcrypt($data['pwd']);
        } else {
            $data = $request->validate([
                'account_id' => 'required|exists:App\Models\Account,id',
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
                'role' => 'required|integer|min:1|max:3',
                'language' => 'required|string|min:2|max:5',
                'photo' => 'mimes:jpg,png,jpeg',
            ]);
        }
        $user = User::find($request->id);
        if ($request->hasFile('photo')) {
            Storage::delete('public/images/users/' . $user->photo);
            $request->file('photo')->storePublicly('public/images/users');
            $data['photo'] = $request->file('photo')->hashName();
        }
        $user->update($data);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'user.update', 'element' => getElementByName('users'), 'element_id' => $user->id, 'source' => 'user.update, ' . $request->id]);
        //return redirect(route('users'));
        //return response()->json(['success' => 'This User has been edited']);
        $user->account = $user->account[0];
        $user->role = (int)$user->role;
        if ($page_name == 'page_list')
            return response()->json(['success' => 'This user has been Updated', 'user' => $user]);
        else if ($page_name == 'page_view') {
            if (Auth::user()->role == 1)
                $sip_accounts = Sip_account::where('status', 1)->get();
            else if (Auth::user()->role == 2)
                $sip_accounts = Sip_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();

            $returnHTML = view('users.user-info', compact('user', 'sip_accounts'))->render();
            return response()->json(['success' => 'This user has been Updated', 'html' => $returnHTML]);
        }
    }

    /**
     * Update user photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePhoto(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'photo' => 'required|mimes:jpg,png,jpeg',
        ]);
        $user = User::find($request->id);

        Storage::delete('public/images/users/' . $user->photo);
        $request->file('photo')->storePublicly('public/images/users');
        $user->photo = $request->file('photo')->hashName();

        $user->save();

        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'user.photo.update', 'element' => getElementByName('users'), 'element_id' => $request->id, 'source' => 'user.photo.update, ' . $request->id]);
        return response()->json(['success' => 'This user profile picture Updated', 'user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = User::find($id);
        $user->status = 0;
        if ($user->save()) {
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'user.delete', 'element' => getElementByName('users'), 'element_id' => $user->id, 'source' => 'user.delete, ' . $id]);
            return response()->json(['success' => 'This User has been Disabled !!!', 'user' => $user]);
        } else
            return response()->json(['error' => 'Failed to delete this user !!!']);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $user = User::find($id);
        $user->status = 1;
        if ($user->save()) {
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'user.restore', 'element' => getElementByName('users'), 'element_id' => $user->id, 'source' => 'user.restore, ' . $id]);
            return response()->json(['success' => 'This User has been Actived !!!', 'user' => $user]);
        } else
            return response()->json(['error' => 'Failed to active this user !!!']);
    }

    /**
     * grid view of users with pagination, filter and search 
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getGridView(Request $request)
    {
        //return $request->ajax();
        /*if ($request->ajax()) {*/
        $sort_by = $request->get('sortby');
        $sort_type = $request->get('sorttype');

        if ($sort_by == 'status') {
            if ($request->get('sorttype') == 'asc')
                $sort_type = 'desc';
            else
                $sort_type = 'asc';
        }

        $query = $request->get('query');
        $query = str_replace(" ", "%", $query);
        $users = User::where('account_id', Auth::user()->account_id)
            ->where('id', 'like', '%' . $query . '%')
            ->orWhere('username', 'like', '%' . $query . '%')
            ->orWhere('role', 'like', '%' . $query . '%')
            ->orWhere('status', 'like', '%' . $query . '%')
            ->orderBy($sort_by, $sort_type)->get();
        $accounts = Account::all();
        return view('users/grid', compact('users', 'accounts'))->render();
        /* }*/
    }

    /**
     * list Logs
     * @param int $user_id
     * @param int $modal
     * @return \Illuminate\Http\Response
     */
    public function listLogs($user_id, $modal)
    {
        if ($modal == 1) {
            $logs = DB::table('logs')
                ->where('user_id', $user_id)
                ->orderBy('log_date', 'desc')
                ->get();
            return view('users/logs', compact('logs'))->render();
        } else if ($modal == 0) {
            $logs = DB::table('logs')
                ->where('user_id', $user_id)
                ->orderBy('log_date', 'desc')
                ->take(20)
                ->get();
            return view('users/logs-info', compact('logs'))->render();
        }
    }

    /**
     * list users_permissions
     */
    public function listUsers_Permissions($user_id)
    {
        $users_permissions = Users_permission::all()
            ->where('user_id', $user_id);
        return view('permissions.users_permissions', compact('users_permissions'))->render();
    }

    /**
     * list All activity Logs
     */
    public function getAllLogs()
    {
        $logs = Log::all();
        return view('users/all-logs', [
            'logs' => $logs,
        ]);
    }

    /**
     * Update user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        //return $request;
        $data = $request->validate([
            'id' => 'required',
            'pwd' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'confirm-pwd' => [
                'required',
                'same:pwd',
            ],
        ]);
        $pwd = bcrypt($data['pwd']);
        $user = User::find($request->id);
        $user->pwd = $pwd;
        $user->save();
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'user.password.update', 'element' => getElementByName('users'), 'element_id' => $user->id, 'source' => 'password.update, ' . $request->id]);
        //return redirect(route('users'));
        return response()->json(['success' => 'This user password has been Updated']);
    }
    /**
     * Display an user.
     *
     * @param int $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function view(int $id)
    {
        $user = User::find($id);
        $user->account = $user->account[0];
        $logs = Log::orderBy('id', 'DESC')->where('user_id', $user->id)->get();
        $notes = DB::table('notes')
            ->where('element', getElementByName('users'))->where('element_id', $user->id)->get();
        $users_permissions = Users_permission::where('user_id', $user->id)->where('status', 1)->get();
        $contact_datas = Contact_data::where('status', 1)->where('element', getElementByName('users'))->where('element_id', $user->id)->get();

        if (Auth::user()->role == 1) {
            $contacts = DB::table('contacts')->select('id', 'class')->get();
            $users = DB::table('users')->select('id', 'username')->get();
            $appointments = Appointment::where('user_id', $user->id)->get();
            $communications = Communication::where('user_id', $user->id)->get();

            $email_accounts = Email_account::where('status', 1)->get();
            $sip_accounts = Sip_account::where('status', 1)->get();
            $sms_accounts = Sms_account::where('status', 1)->get();

            $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select('contacts.id', 'contacts_companies.name')->get();
            $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->select('contacts.id', 'first_name', 'last_name')->get();
            $accounts = DB::table('accounts')
                ->orderBy('id', 'desc')->get();
        } else if (Auth::user()->role == 2) {
            //retrieve all the contacts and users belonging to the account id of the logged in user
            $users = DB::table('users')->select('id', 'username')->where('account_id', Auth::user()->account_id)->get();
            $contacts = DB::table('contacts')->select('id', 'class')->where('account_id', Auth::user()->account_id)->get();
            //make a contact id table
            $contact_id = [];
            foreach ($contacts as $contact) {
                array_push($contact_id, $contact->id);
            }
            $communications = Communication::where('user_id', $user->id)->whereIn('contact_id', [$contact_id])->get();
            $appointments = Appointment::where('user_id', $user->id)->whereIn('contact_id', [$contact_id])->get();

            $email_accounts = Email_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $sip_accounts = Sip_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $sms_accounts = Sms_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();

            $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->where('account_id', Auth::user()->account_id)
                ->select('contacts.id', 'contacts_companies.name')->get();
            $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->where('account_id', Auth::user()->account_id)
                ->select('contacts.id', 'first_name', 'last_name')->get();
        } else {
            return response()->json(['message' => 'you do not have the necessary rights'], 300);
        }

        return view('users.view', [
            'user' => $user,
            'logs' => $logs,
            'users_permissions' => $users_permissions,
            'notes' => $notes,
            'accounts' => $accounts ?? [],
            'appointments' => $appointments,
            'communications' => $communications,
            'contacts' => $contacts,
            'contacts_persons' => $contacts_persons,
            'contacts_companies' => $contacts_companies,
            'users' => $users,
            'email_accounts' => $email_accounts,
            'sip_accounts' => $sip_accounts,
            'sms_accounts' => $sms_accounts,
            'contact_datas' => $contact_datas,
            'users_permissions' => $users_permissions,
        ]);
    }
}
