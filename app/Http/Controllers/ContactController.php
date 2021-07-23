<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Contacts_companie;
use App\Models\Contacts_person;
use App\Models\Group;
use App\Models\Log;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

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
        try {
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
        } catch (Throwable $e) {
            report($e);
            return null;
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
            try {
                $contact_person->save();
                Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contact_person.create', 'element' => 7, 'element_id' => $contact->id, 'source' => 'contact_person.create']);
                return response()->json(['contact_person' => $contact_person, 'success' => 'This person contact has been added']);
            } catch (Throwable $e) {
                report($e);
                Contact::find($contact->id)->delete();
                return response()->json(['error' => 'Error while adding that contact !!!'], 300);
            }
        } else if ($request->class == 2) //companies contact
        {
            $companies_data = $request->validate([
                'source_id' => 'required|integer|digits_between:0,10',
                'source' => 'required|integer|digits_between:1,1',
                'status' => 'required|integer|digits_between:1,1',
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
            try {
                $contact_companie->save();
                Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contact_companie.create', 'element' => 6, 'element_id' => $contact->id, 'source' => 'contact_companie.create']);
                return response()->json(['contact_companie' => $contact_companie, 'success' => 'This companie contact has been added']);
            } catch (Throwable $e) {
                report($e);
                Contact::find($contact->id)->delete();
                return response()->json(['error' => 'Error while adding that contact !!!'], 300);
            }
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
            Contact::find($request->input('id'))->update(['class' => $request->class, 'source_id' => $person_data['source_id'], 'source' => $person_data['source'], 'status' => $person_data['status'], 'account_id' => $person_data['account_id']]);
            $contact = Contact::find($request->input('id'));
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
            return response()->json(['contact' => $contact, 'success' => 'This person contact has been updated']);
        } else if ($request->class == 2) //companies contact
        {
            $companies_data = $request->validate([
                'source_id' => 'required|integer|digits_between:0,10',
                'source' => 'required|integer|digits_between:1,1',
                'status' => 'required|integer|digits_between:1,1',
                'account_id' => 'required|exists:App\Models\Account,id',
                'companies_class' => 'required|integer|digits_between:1,1',
                'name' => 'required|string|max:255',
                'registered_number' => 'integer|nullable|digits_between:0,128',
                'logo' => 'nullable|mimes:jpg,png,jpeg',
                'activity' => 'nullable|integer|digits_between:0,10',
                'companies_language' => 'nullable|string|min:2|max:2',
                'companies_country' => 'nullable|string|min:2|max:2',
            ]);
            Contact::find($request->input('id'))->update(['class' => $request->class, 'source_id' => $companies_data['source_id'], 'source' => $companies_data['source'], 'status' => $companies_data['status'], 'account_id' => $companies_data['account_id']]);
            $contact = Contact::find($request->input('id'));
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
            return response()->json(['contact' => $contact, 'success' => 'This companie contact has been updated']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $contact = Contact::find($id);
        //$contact->status = 3;
        if ($contact->delete()) {
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contacts.delete', 'element' => 16, 'element_id' => $contact->id, 'source' => 'contacts.delete, ' . $id]);
            return response()->json(['success' => 'This contact has been Disabled !!!', 'contact' => $contact]);
        } else
            return response()->json(['error' => 'Failed to delete this contact !!!']);
    }

    /**
     * Search contact
     * 
     * @return \Illuminate\Http\Response
     */
    public function searchForm()
    {
        $accounts = Account::all();
        $groups = Group::all();
        return view('/contacts/search', [
            'accounts' => $accounts,
            'groups' => $groups,
        ]);
    }

    /**
     * Search contact
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //return $request;
        $request->validate([
            //validate contact
            'id' => 'nullable|integer|digits_between:0,10',
            'source_id' => 'nullable|integer|digits_between:0,10',
            'source' => 'nullable|integer|digits_between:1,1',
            'status' => 'nullable|integer|digits_between:1,1',
            'account_id' => 'nullable|exists:App\Models\Account,id',
            //validate person contact data
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'nickname' => 'string|nullable|max:255',
            'profile' => 'nullable|integer|digits_between:1,1',
            'gender' => 'nullable|integer|min:1|max:2',
            'person_language' => 'string|nullable|min:2|max:2',
            'person_country' => 'string|nullable|min:2|max:2',
            'birthdate' => 'date|nullable|min:today',
            //validate companie contact data
            'companies_class' => 'nullable|integer|digits_between:1,1',
            'name' => 'nullable|string|max:255',
            'registered_number' => 'integer|nullable|digits_between:0,128',
            'activity' => 'nullable|integer|digits_between:0,10',
            'companies_language' => 'nullable|string|min:2|max:2',
            'companies_country' => 'nullable|string|min:2|max:2',
        ]);
        $contacts = DB::table('contacts')
            //->join('accounts', 'accounts.')
            // ->select('id', 'account_id.name as account', 'class', 'source', 'source_id', 'creation_date', 'status')
            ->where('id', 'like', '%'.$request->id.'%')
            ->where('source_id', 'like', '%' . $request->source_id . '%')
            ->where('source', 'like', '%' . $request->source . '%')
            ->where('status', 'like', '%' . $request->status . '%')
            ->where('account_id', 'like', '%' . $request->account_id . '%')
            ->get();
        $accounts = Account::All();
        //return $contacts;
        if ($request->class == 1) {
            $contacts = DB::table('contacts')
                ->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                //contact
                ->where('contacts.id', 'like', '%'.$request->id.'%')
                ->where('source_id', 'like', '%' . $request->source_id . '%')
                ->where('source', 'like', '%' . $request->source . '%')
                ->where('status', 'like', '%' . $request->status . '%')
                ->where('account_id', 'like', '%' . $request->account_id . '%')
                //person data
                ->where('first_name', 'like', '%' . $request->first_name . '%')
                ->where('last_name', 'like', '%' . $request->last_name . '%')
                ->where(function($query) use ($request){
                    $query->where('nickname', 'like', '%' . $request->nickname . '%')->orWhere('nickname', $request->nickname);
                })
                ->where('profile', 'like', '%' . $request->profile . '%')
                ->where('gender', 'like', '%' . $request->gender . '%')
                ->where(function($query) use ($request){
                    $query->where('language', 'like', '%' . $request->person_language . '%')->orWhere('language', $request->person_language);
                })
                ->where(function($query) use ($request){
                    $query->where('country', 'like', '%' . $request->person_country . '%')->orWhere('country', $request->person_country);
                })
                ->where(function($query) use ($request){
                    $query->where('birthdate', 'like', '%' . $request->birthdate . '%')->orWhere('birthdate', $request->birthdate);
                })
                ->get();
        } else if ($request->class == 2) {
            $contacts = DB::table('contacts')
                ->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select(
                    'contacts.*',
                    'contacts_companies.class as companies_class',
                    'contacts_companies.name',
                    'contacts_companies.registered_number',
                    'contacts_companies.logo',
                    'contacts_companies.activity',
                    'contacts_companies.country',
                    'contacts_companies.language'
                )
                //contact
                ->where('contacts.id', 'like', '%'.$request->id.'%')
                ->where('source_id', 'like', '%' . $request->source_id . '%')
                ->where('source', 'like', '%' . $request->source . '%')
                ->where('status', 'like', '%' . $request->status . '%')
                ->where('account_id', 'like', '%' . $request->account_id . '%')
                //companie data
                ->where('contacts_companies.class', 'like', '%' . $request->companies_class . '%')
                ->where('name', 'like', '%' . $request->name . '%')
                ->where(function($query) use ($request){
                    $query->where('registered_number', 'like', '%' . $request->registered_number . '%')->orWhere('registered_number', $request->registered_number);
                })
                ->where(function($query) use ($request){
                    $query->where('activity', 'like', '%' . $request->activity . '%')->orWhere('activity', $request->activity);
                })
                ->where(function($query) use ($request){
                    $query->where('language', 'like', '%' . $request->companies_language . '%')->orWhere('language', $request->companies_language);
                })
                ->where(function($query) use ($request){
                    $query->where('country', 'like', '%' . $request->companies_country . '%')->orWhere('country', $request->companies_country);
                })
                ->get();
        }
        if ($contacts->isEmpty()) {
            return response()->json([
                'success' => 'Data not found !!!',
                'html' =>  '<div class="row">
                                <div class="col-12">
                                    <div class="page-title-box">
                                        <h4 class="page-title">No Results Found</h4>
                                    </div>
                                </div>
                            </div>'
            ]);
        } else {
            $returnHTML = view('contacts/search-result', compact('contacts', 'accounts'))->render();
            return response()->json(['success' => 'Results found !!!', 'html' => $returnHTML]);
        }
    }
}
