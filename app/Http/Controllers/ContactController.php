<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Contacts_companie;
use App\Models\Contacts_person;
use App\Models\Log;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::All();
        $contacts_person = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')->first();
        $contacts_companie = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
            ->select('contacts.*', 'contacts_companies.class as companies_class', 'contacts_companies.name', 'contacts_companies.registered_number', 'contacts_companies.logo', 'contacts_companies.activity', 'contacts_companies.country', 'contacts_companies.language')
            ->first();
        $accounts = Account::All();
        return view('contacts/list', [
            'contacts' => $contacts,
            'accounts' => $accounts,
            'contacts_person' => $contacts_person,
            'contacts_companie' => $contacts_companie,
        ]);
    }

    /**
     * Get contact by id with json response.
     *
     * @param int $id
     * @param int $modal
     * @return \Illuminate\Http\Response
     */
    public function getContactJsonById(int $id, int $modal)
    {
        $contact = Contact::all()
            ->find($id);
        if ($contact->class == 1) {
            $contacts_person = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')->where('contacts.id', $id)->get();
            //dd($person);
            if ($modal == 0) {
                if (!$contacts_person->isEmpty()) {
                    $contacts_person = $contacts_person[0];
                    return view('contacts/contacts_person-info', compact('contacts_person'))->render();
                }
                return null;
            }
            if ($modal == 1)
                return response()->json($contacts_person);
        } else if ($contact->class == 2) {
            $contacts_companie = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select('contacts.*', 'contacts_companies.class as companies_class', 'contacts_companies.name', 'contacts_companies.registered_number', 'contacts_companies.logo', 'contacts_companies.activity', 'contacts_companies.country', 'contacts_companies.language')
                ->where('contacts.id', $id)->get();
            //dd($companie);
            if ($modal == 0) {
                if (!$contacts_companie->isEmpty()) {
                    $contacts_companie = $contacts_companie[0];
                    return view('contacts/contacts_companie-info', compact('contacts_companie'))->render();
                }
                return null;
            }
            if ($modal == 1)
                return response()->json($contacts_companie);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'class' => 'required|string|min:1|max:2',
        ]);
        if ($request->class == 1) //person contact
        {
            $person_data = $request->validate([
                'source_id' => 'required|integer|digits_between:0,10',
                'source' => 'required|integer|digits_between:1,1',
                'status' => 'required|integer|digits_between:1,1',
                'account_id' => 'required|exists:App\Models\Account,id',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'nickname' => 'string|nullable|max:255',
                'profile' => 'required|integer|digits_between:1,1',
                'gender' => 'required|integer|min:1|max:2',
                'person_language' => 'string|nullable|min:2|max:2',
                'person_country' => 'string|nullable|min:2|max:2',
                'birthdate' => 'date|nullable|min:today',
            ]);
            $contact = Contact::create(['class' => $request->class, 'source_id' => $person_data['source_id'], 'source' => $person_data['source'], 'status' => $person_data['status'], 'account_id' => $person_data['account_id']]);
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contact.create', 'element' => 5, 'element_id' => $contact->id, 'source' => 'contact.create']);
            $contact_person = new Contacts_person();
            $contact_person->id = $contact->id;
            $contact_person->profile = $person_data['profile'];
            $contact_person->first_name = $person_data['first_name'];
            $contact_person->last_name = $person_data['last_name'];
            $contact_person->nickname = $person_data['nickname'];
            $contact_person->gender = $person_data['gender'];
            $contact_person->language = $person_data['person_language'];
            $contact_person->country = $person_data['person_country'];
            $contact_person->birthdate = $person_data['birthdate'];
            $contact_person->save();
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contact_person.create', 'element' => 7, 'element_id' => $contact->id, 'source' => 'contact_person.create']);
            return response()->json(['contact_person' => $contact_person, 'success' => 'This person contact has been added']);
        } else if ($request->class == 2) //companies contact
        {
            $companies_data = $request->validate([
                'source_id' => 'required|integer|digits_between:0,10',
                'source' => 'required|integer|digits_between:1,1',
                'status' => 'required|integer|min:1|max:1',
                'account_id' => 'required|exists:App\Models\Account,id',
                'companies_class' => 'required|integer|digits_between:1,1',
                'name' => 'required|string|max:255',
                'registered_number' => 'integer|nullable|digits_between:0,128',
                'logo' => 'nullable|mimes:jpg,png,jpeg',
                'activity' => 'nullable|integer|digits_between:0,10',
                'companies_language' => 'nullable|string|min:2|max:2',
                'companies_country' => 'nullable|string|min:2|max:2',
            ]);
            $contact = Contact::create(['class' => $request->class, 'source_id' => $companies_data['source_id'], 'source' => $companies_data['source'], 'status' => $companies_data['status'], 'account_id' => $companies_data['account_id']]);
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contact.create', 'element' => 5, 'element_id' => $contact->id, 'source' => 'contact.create']);
            $contact_companie = new Contacts_companie();
            $contact_companie->id = $contact->id;
            $contact_companie->class = $companies_data['companies_class'];
            $contact_companie->name = $companies_data['name'];
            $contact_companie->registered_number = $companies_data['registered_number'];
            //$contact_companie->logo = $companies_data['logo'];
            $contact_companie->activity = $companies_data['activity'];
            $contact_companie->language = $companies_data['companies_language'];
            $contact_companie->country = $companies_data['companies_country'];

            if ($request->hasFile('logo')) {
                $request->file('logo')->storePublicly('public/images/logo');
                $contact_companie->logo = $request->file('logo')->hashName();
            }
            $contact_companie->save();
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contact_companie.create', 'element' => 6, 'element_id' => $contact->id, 'source' => 'contact_companie.create']);
            return response()->json(['contact_companie' => $contact_companie, 'success' => 'This companie contact has been added']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //return $request->all();
        $request->validate([
            'class' => 'required|string|min:1|max:2',
        ]);
        if ($request->class == 1) //person contact
        {
            $person_data = $request->validate([
                'source_id' => 'required|integer|digits_between:0,10',
                'source' => 'required|integer|digits_between:1,1',
                'status' => 'required|integer|digits_between:1,1',
                'account_id' => 'required|exists:App\Models\Account,id',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'nickname' => 'string|nullable|max:255',
                'profile' => 'required|integer|digits_between:1,1',
                'gender' => 'required|integer|min:1|max:2',
                'person_language' => 'string|nullable|min:2|max:2',
                'person_country' => 'string|nullable|min:2|max:2',
                'birthdate' => 'date|nullable|min:today',
            ]);
            $contact = Contact::find($request->input('id'));
            $contact = Contact::find($request->input('id'))->update(['class' => $request->class, 'source_id' => $person_data['source_id'], 'source' => $person_data['source'], 'status' => $person_data['status'], 'account_id' => $person_data['account_id']]);
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contact.update', 'element' => 5, 'element_id' => $request->input('id'), 'source' => 'contact.update']);
            $contact_person = Contacts_person::find($request->input('id'));
            $contact_person->profile = $person_data['profile'];
            $contact_person->first_name = $person_data['first_name'];
            $contact_person->last_name = $person_data['last_name'];
            $contact_person->nickname = $person_data['nickname'];
            $contact_person->gender = $person_data['gender'];
            $contact_person->language = $person_data['person_language'];
            $contact_person->country = $person_data['person_country'];
            $contact_person->birthdate = $person_data['birthdate'];
            $contact_person->save();
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contact_person.update', 'element' => 7, 'element_id' => $request->input('id'), 'source' => 'contact_person.update']);
            return response()->json(['contact_person' => $contact_person, 'success' => 'This person contact has been updated']);
        } else if ($request->class == 2) //companies contact
        {
            $companies_data = $request->validate([
                'source_id' => 'required|integer|digits_between:0,10',
                'source' => 'required|integer|digits_between:1,1',
                'status' => 'required|integer|min:1|max:1',
                'account_id' => 'required|exists:App\Models\Account,id',
                'companies_class' => 'required|integer|digits_between:1,1',
                'name' => 'required|string|max:255',
                'registered_number' => 'integer|nullable|digits_between:0,128',
                'logo' => 'nullable|mimes:jpg,png,jpeg',
                'activity' => 'nullable|integer|digits_between:0,10',
                'companies_language' => 'nullable|string|min:2|max:2',
                'companies_country' => 'nullable|string|min:2|max:2',
            ]);
            $contact = Contact::find($request->input('id'));
            $contact = Contact::find($request->input('id'))->update(['class' => $request->class, 'source_id' => $companies_data['source_id'], 'source' => $companies_data['source'], 'status' => $companies_data['status'], 'account_id' => $companies_data['account_id']]);
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contact.update', 'element' => 5, 'element_id' => $request->input('id'), 'source' => 'contact.update']);
            $contact_companie = Contacts_companie::find($request->input('id'));
            $contact_companie->class = $companies_data['companies_class'];
            $contact_companie->name = $companies_data['name'];
            $contact_companie->registered_number = $companies_data['registered_number'];
            //$contact_companie->logo = $companies_data['logo'];
            $contact_companie->activity = $companies_data['activity'];
            $contact_companie->language = $companies_data['companies_language'];
            $contact_companie->country = $companies_data['companies_country'];

            if ($request->hasFile('logo')) {
                $request->file('logo')->storePublicly('public/images/logo');
                $contact_companie->logo = $request->file('logo')->hashName();
            }
            $contact_companie->save();
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contact_companie.update', 'element' => 6, 'element_id' => $request->input('id'), 'source' => 'contact_companie.update']);
            return response()->json(['contact_companie' => $contact_companie, 'success' => 'This companie contact has been updated']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $contact = Contact::find($id);
        $contact->status = 3;
        if ($contact->save()) {
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contacts.delete', 'element' => 16, 'element_id' => $contact->id, 'source' => 'contacts.delete, ' . $id]);
            return response()->json(['success' => 'This contact has been Disabled !!!', 'contact' => $contact]);
        } else
            return response()->json(['error' => 'Failed to delete this contact !!!']);
    }
}
