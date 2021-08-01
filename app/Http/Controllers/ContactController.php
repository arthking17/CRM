<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Contact_data;
use App\Models\Contacts_companie;
use App\Models\Contacts_person;
use App\Models\Group;
use App\Models\Log;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        $contacts = Contact::All()->sortBy("id");
        $groups = Group::all();
        if ($contacts->count() > 0) {
            $accounts = Account::All();
            $contact_datas = Contact_data::all()->where('element_id', $contacts->first()->id);
            $notes = DB::table('notes')->where('element_id', $contacts->first()->id)->get();
            if ($contacts->first()->class == 1)
                $contact = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')->where('contacts.id', $contacts->first()->id)->get();
            else if ($contacts->first()->class == 2)
                $contact = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                    ->select('contacts.*', 'contacts_companies.class as companies_class', 'contacts_companies.name', 'contacts_companies.registered_number', 'contacts_companies.logo', 'contacts_companies.activity', 'contacts_companies.country', 'contacts_companies.language')
                    ->where('contacts.id', $contacts->first()->id)->get();
        }
        $contact = $contact[0];
        return view('contacts/list', [
            'contacts' => $contacts,
            'accounts' => $accounts,
            'contact' => $contact,
            'contact_datas' => $contact_datas,
            'notes' => $notes,
            'groups' => $groups,
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
        $accounts = Account::all();
        try {
            if ($contact->class == 1) {
                $contacts_person = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')->where('contacts.id', $id)->get();
                //dd($person);
                if (!$contacts_person->isEmpty()) {
                    $contact = $contacts_person[0];
                    if ($modal == 0) {
                        $returnHTML = view('contacts/contacts_person-info', compact('contact', 'accounts'))->render();
                        return response()->json(['success' => 'Contact Person found', 'html' => $returnHTML]);
                    } else if ($modal == 1)
                        return response()->json($contact);
                } else
                    return response()->json(['error' => 'Contact Not Found !!!', 300]);
            } else if ($contact->class == 2) {
                $contacts_companie = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                    ->select('contacts.*', 'contacts_companies.class as companies_class', 'contacts_companies.name', 'contacts_companies.registered_number', 'contacts_companies.logo', 'contacts_companies.activity', 'contacts_companies.country', 'contacts_companies.language')
                    ->where('contacts.id', $id)->get();
                if (!$contacts_companie->isEmpty()) {
                    $contact = $contacts_companie[0];
                    //dd($companie);
                    if ($modal == 0) {
                        $returnHTML = view('contacts/contacts_companie-info', compact('contact', 'accounts'))->render();
                        return response()->json(['success' => 'Contact Companie found', 'html' => $returnHTML]);
                    } else if ($modal == 1)
                        return response()->json($contact);
                } else
                    return response()->json(['error' => 'Contact Not Found !!!', 300]);
            }
        } catch (Throwable $e) {
            dd($e);
            report($e);
            return response()->json(['error' => 'Contact Not Found !!!', 300]);
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
        $contact = null;
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
                //return response()->json(['contact_person' => $contact_person, 'success' => 'This person contact has been added']);
                $contact = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')->where('contacts.id', $contact->id)->get();
            } catch (Throwable $e) {
                report($e);
                Contact::find($contact_person->id)->delete();
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
                //return response()->json(['contact_companie' => $contact_companie, 'success' => 'This companie contact has been added']);
                $contact = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                    ->select('contacts.*', 'contacts_companies.class as companies_class', 'contacts_companies.name', 'contacts_companies.registered_number', 'contacts_companies.logo', 'contacts_companies.activity', 'contacts_companies.country', 'contacts_companies.language')
                    ->where('contacts.id', $contact->id)->get();
            } catch (Throwable $e) {
                report($e);
                Contact::find($contact_companie->id)->delete();
                return response()->json(['error' => 'Error while adding that contact !!!'], 300);
            }
        }

        $contacts = Contact::All();
        $accounts = Account::All();
        $returnHTML = view('contacts/datatable-contacts', compact('contacts', 'accounts'))->render();
        return response()->json(['success' => 'This companie contact has been added', 'html' => $returnHTML, 'contact' => $contact[0]]);
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
            //return response()->json(['contact' => $contact, 'success' => 'This person contact has been updated']);
            $contact = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')->where('contacts.id', $request->id)->get();
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
                Storage::delete('public/images/logo/' . $contact->photo);
                $request->file('logo')->storePublicly('public/images/logo');
                $contact_companie->logo = $request->file('logo')->hashName();
            }
            $contact_companie->save();
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contact_companie.update', 'element' => 6, 'element_id' => $request->input('id'), 'source' => 'contact_companie.update']);
            //return response()->json(['contact' => $contact, 'success' => 'This companie contact has been updated']);
            $contact = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select('contacts.*', 'contacts_companies.class as companies_class', 'contacts_companies.name', 'contacts_companies.registered_number', 'contacts_companies.logo', 'contacts_companies.activity', 'contacts_companies.country', 'contacts_companies.language')
                ->where('contacts.id', $request->id)->get();
        }
        $contacts = Contact::All();
        $accounts = Account::All();
        $returnHTML = view('contacts/datatable-contacts', compact('contacts', 'accounts'))->render();
        return response()->json(['success' => 'This companie contact has been updated', 'html' => $returnHTML, 'contact' => $contact[0]]);
    }

    /**
     * Update contact companie logo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateContactCompanieLogo(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'logo' => 'required|mimes:jpg,png,jpeg',
        ]);
        $contact_companie = Contacts_companie::find($request->id);

        Storage::delete('public/images/logo/' . $contact_companie->photo);
        $request->file('logo')->storePublicly('public/images/logo');
        $contact_companie->logo = $request->file('logo')->hashName();

        $contact_companie->save();

        Log::create(['user_id' => 2, 'log_date' => new DateTime(), 'action' => 'contact_companie.logo.update', 'element' => 6, 'element_id' => $request->id, 'source' => 'contact_companie.logo.update, ' . $request->id]);
        return response()->json(['success' => 'This contact companie logo Updated', 'contact' => $contact_companie]);
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
            $contacts = Contact::All();
            $accounts = Account::All();
            $returnHTML = view('contacts/datatable-contacts', compact('contacts', 'accounts'))->render();
            return response()->json(['success' => 'This contact has been Disabled !!!', 'html' => $returnHTML]);
            //return response()->json(['success' => 'This contact has been Disabled !!!', 'contact' => $contact]);
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
        $accounts = Account::All();
        if ($request->class == 1) {
            $contacts = DB::table('contacts')
                ->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->join('contact_datas', 'contacts.id', '=', 'contact_datas.element_id')
                ->select('contacts.*', 'contacts_persons.*')
                //contact
                ->where('contacts.id', 'like', '%' . $request->id . '%')
                ->where('source_id', 'like', '%' . $request->source_id . '%')
                ->where('source', 'like', '%' . $request->source . '%')
                ->where('contacts.status', 'like', '%' . $request->status . '%')
                ->where('account_id', 'like', '%' . $request->account_id . '%')
                //person data
                ->where('first_name', 'like', '%' . $request->first_name . '%')
                ->where('last_name', 'like', '%' . $request->last_name . '%')
                ->where(function ($query) use ($request) {
                    $query->where('nickname', 'like', '%' . $request->nickname . '%')->orWhere('nickname', $request->nickname);
                })
                ->where('profile', 'like', '%' . $request->profile . '%')
                ->where('gender', 'like', '%' . $request->gender . '%')
                ->where(function ($query) use ($request) {
                    $query->where('language', 'like', '%' . $request->person_language . '%')->orWhere('language', $request->person_language);
                })
                ->where(function ($query) use ($request) {
                    $query->where('country', 'like', '%' . $request->person_country . '%')->orWhere('country', $request->person_country);
                })
                ->where(function ($query) use ($request) {
                    $query->where('birthdate', 'like', '%' . $request->birthdate . '%')->orWhere('birthdate', $request->birthdate);
                })
                ->get();
        } else if ($request->class == 2) {
            $contacts = DB::table('contacts')
                ->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->join('contact_datas', 'contacts.id', '=', 'contact_datas.element_id')
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
                ->where('contacts.id', 'like', '%' . $request->id . '%')
                ->where('source_id', 'like', '%' . $request->source_id . '%')
                ->where('source', 'like', '%' . $request->source . '%')
                ->where('contacts.status', 'like', '%' . $request->status . '%')
                ->where('account_id', 'like', '%' . $request->account_id . '%')
                //companie data
                ->where('contacts_companies.class', 'like', '%' . $request->companies_class . '%')
                ->where('name', 'like', '%' . $request->name . '%')
                ->where(function ($query) use ($request) {
                    $query->where('registered_number', 'like', '%' . $request->registered_number . '%')->orWhere('registered_number', $request->registered_number);
                })
                ->where(function ($query) use ($request) {
                    $query->where('activity', 'like', '%' . $request->activity . '%')->orWhere('activity', $request->activity);
                })
                ->where(function ($query) use ($request) {
                    $query->where('language', 'like', '%' . $request->companies_language . '%')->orWhere('language', $request->companies_language);
                })
                ->where(function ($query) use ($request) {
                    $query->where('country', 'like', '%' . $request->companies_country . '%')->orWhere('country', $request->companies_country);
                })
                ->get();
        } else {
            $contacts = DB::table('contacts')
                //->leftJoin('contact_datas', 'contacts.id', '=', 'contact_datas.element_id')
                ->select('contacts.*')
                ->where('contacts.id', 'like', '%' . $request->id . '%')
                ->where('source_id', 'like', '%' . $request->source_id . '%')
                ->where('source', 'like', '%' . $request->source . '%')
                ->where('contacts.status', 'like', '%' . $request->status . '%')
                ->where('account_id', 'like', '%' . $request->account_id . '%')
                ->where('creation_date', 'like', '%' . $request->creation_date . '%')
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
            $returnHTML = view('contacts/datatable-contacts', compact('contacts', 'accounts'))->render();
            return response()->json(['success' => 'Results found !!!', 'html' => $returnHTML]);
        }
    }

    /**
     * upload contact file
     * 
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        //return $request;
        $file = $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls',
        ]);
        return response()->json(['success' => 'Successful  Upload  !!!']);
    }
}
