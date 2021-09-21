<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Contact;
use App\Models\Contacts_companie;
use App\Models\Contacts_person;
use App\Models\Log;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 1) {
            $users = DB::table('users')->select('id', 'username')->get();
            $communications = Communication::all();
            $contacts = DB::table('contacts')->select('id', 'class')->get();

            $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select('contacts.id', 'contacts_companies.name')->get();
            $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->select('contacts.id', 'first_name', 'last_name')->get();
        } else if (Auth::user()->role == 2) {
            $users = DB::table('users')->select('id', 'username')->where('account_id', Auth::user()->account_id)->get();
            $contacts = DB::table('contacts')->select('id', 'class')->where('account_id', Auth::user()->account_id)->get();
            $contact_id = [];
            foreach ($contacts as $contact) {
                array_push($contact_id, $contact->id);
            }
            $users = DB::table('users')->select('id', 'username')->where('account_id', Auth::user()->account_id)->get();
            $users_id = [];
            foreach ($users as $user) {
                array_push($users_id, $user->id);
            }
            $communications = Communication::whereIn('user_id', [$users_id])->whereIn('contact_id', [$contact_id])->get();

            $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->where('account_id', Auth::user()->account_id)
                ->select('contacts.id', 'contacts_companies.name')->get();
            $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->where('account_id', Auth::user()->account_id)
                ->select('contacts.id', 'first_name', 'last_name')->get();
        }

        return view('/communications/index', [
            'communications' => $communications,
            'contacts_persons' => $contacts_persons,
            'contacts_companies' => $contacts_companies,
            'contacts' => $contacts,
            'users' => $users,
        ]);
    }

    /**
     * get communication by id.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getCommunication(int $id)
    {
        $communication = Communication::find($id);
        return response()->json(['communication' => $communication]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string $page_name
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, string $page_name)
    {
        //return $request;
        $data = $request->validate([
            'user_id' => 'required|exists:App\Models\User,id',
            'contact_id' => 'required|exists:App\Models\Contact,id',
            'class' => 'required|integer|digits_between:1,1',
            'channel' => 'required|integer|digits_between:1,10',
            'start_date' => 'required|date|after_or_equal:today',
            'qualification' => 'nullable|integer|digits_between:1,1',
        ]);
        //$user = array('user_id' => 4);
        //$data = array_merge($data,  $user);
        $communication = Communication::create($data);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'communications.create', 'element' => getElementByName('communications'), 'element_id' => $communication->id, 'source' => 'communications.create']);

        if ($page_name == 'page_communications') {
            if (Auth::user()->role == 1) {
                $communications = Communication::all();
            } else if (Auth::user()->role == 2) {
                $users = DB::table('users')->select('id', 'username')->where('account_id', Auth::user()->account_id)->get();
                $users_id = [];
                foreach ($users as $user) {
                    array_push($users_id, $user->id);
                }
                $communications = Communication::whereIn('user_id', [$users_id])->get();
            } else {
                return response()->json(['message' => 'you do not have the necessary rights'], 300);
            }
        } else if ($page_name == 'page_users') {
            if (Auth::user()->role == 1) {
                $communications = Communication::where('user_id', $data['user_id'])->get();
            } else if (Auth::user()->role == 2) {
                $contacts = DB::table('contacts')->select('id')->where('account_id', Auth::user()->account_id)->get();
                $contact_id = [];
                foreach ($contacts as $contact) {
                    array_push($contact_id, $contact->id);
                }
                $communications = Communication::whereIn('contact_id', [$contact_id])->get();
            } else {
                return response()->json(['message' => 'you do not have the necessary rights'], 300);
            }
        } else if ($page_name == 'page_contacts') {
            if (Auth::user()->role == 1) {
                $communications = Communication::where('contact_id', $data['contact_id'])->get();
            } else if (Auth::user()->role == 2) {
                $users = DB::table('users')->select('id', 'username')->where('account_id', Auth::user()->account_id)->get();
                $users_id = [];
                foreach ($users as $user) {
                    array_push($users_id, $user->id);
                }
                $communications = Communication::where('contact_id', $data['contact_id'])->whereIn('user_id', [$users_id])->get();
            } else {
                return response()->json(['message' => 'you do not have the necessary rights'], 300);
            }
        }

        if (Auth::user()->role == 1) {
            $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select('contacts.id', 'contacts_companies.name')->get();
            $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->select('contacts.id', 'first_name', 'last_name')->get();
        } else if (Auth::user()->role == 2) {
            $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->where('account_id', Auth::user()->account_id)
                ->select('contacts.id', 'contacts_companies.name')->get();
            $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->where('account_id', Auth::user()->account_id)
                ->select('contacts.id', 'first_name', 'last_name')->get();
        } else {
            return response()->json(['message' => 'you do not have the necessary rights'], 300);
        }

        $returnHTML = view('communications/list', compact('communications', 'contacts_persons', 'contacts_companies'))->render();
        return response()->json(['success' => 'communication Created', 'html' => $returnHTML, 'communication' => $communication]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $element = $communication = Communication::find($id);
        $notes = DB::table('notes')->where('element_id', $communication->first()->id)->get();
        $contact = Contact::find($communication->contact_id);
        if ($contact->class == 1) {
            $contact = Contacts_person::find($communication->contact_id);
            $contact_name = $contact->first_name . ' ' . $contact->last_name;
        } else if ($contact->class == 2)
            $contact_name = Contacts_companie::find($communication->contact_id)->name;

        $returnHTML = view('communications/info', compact('communication', 'contact_name', 'element'))->render();
        return response()->json(['success' => 'Communication found', 'html' => $returnHTML, 'elementClass' => getElementByName('communications')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Communication  $communication
     * @return \Illuminate\Http\Response
     */
    public function edit(Communication $communication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Communication  $communication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Communication $communication)
    {
        //return $request;
        $data = $request->validate([
            'id' => 'required|exists:App\Models\Communication,id',
            'user_id' => 'required|exists:App\Models\User,id',
            'contact_id' => 'required|exists:App\Models\Contact,id',
            'class' => 'required|integer|digits_between:1,1',
            'channel' => 'required|integer|digits_between:1,10',
            'start_date' => 'required|date',
            'qualification' => 'nullable|integer|digits_between:1,1',
        ]);
        //$user = array('user_id' => 4);
        //$data = array_merge($data,  $user);

        $communication = Communication::find($request->id);
        $communication->update($data);

        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'communications.update', 'element' => getElementByName('communications'), 'element_id' => $communication->id, 'source' => 'communications.update']);

        $communication->user = $communication->user[0];
        $communication->contact = $communication->contact[0];
        if($communication->contact->class == 1){
            $contact_name = Contacts_person::find($communication->contact->id)->first_name .' '.Contacts_person::find($communication->contact->id)->last_name;
        }else if($communication->contact->class == 2){
            $contact_name = Contacts_companie::find($communication->contact->id)->name;
        }
        return response()->json(['success' => 'communication Updated', 'communication' => $communication, 'contact_name' => $contact_name]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $communication = Communication::find($id);
        $communication->status = 0;
        if ($communication->save()) {
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'communications.delete', 'element' => getElementByName('communications'), 'element_id' => $id, 'source' => 'communications.delete, ' . $id]);
            return response()->json(['success' => 'communication Deleted !!!', 'communication' => $communication]);
        } else
            return response()->json(['error' => 'Failed to delete this communication !!!']);
    }
}
