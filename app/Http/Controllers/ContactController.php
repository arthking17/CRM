<?php

namespace App\Http\Controllers;

use App\Imports\ContactImport;
use App\Models\Account;
use App\Models\Appointment;
use App\Models\Communication;
use App\Models\Contact;
use App\Models\Contact_data;
use App\Models\Contacts_companie;
use App\Models\Contacts_field;
use App\Models\Contacts_person;
use App\Models\Custom_field;
use App\Models\Custom_select_field;
use App\Models\Email_account;
use App\Models\Group;
use App\Models\Import;
use App\Models\Log;
use App\Models\Sip_account;
use App\Models\Sms_account;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ipinfo\ipinfo\IPinfo;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
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
        if (Auth::user()->role == 1) {
            $contacts = Contact::all();
            $accounts = Account::All();
            $email_accounts = Email_account::where('status', 1)->get();
            $sip_accounts = Sip_account::where('status', 1)->get();
            $sms_accounts = Sms_account::where('status', 1)->get();
            $custom_fields = Custom_field::where('status', 1)->get();
            $select_options = DB::table('custom_select_fields')->join('custom_fields', 'field_id', '=', 'custom_fields.id')
                ->select('custom_select_fields.*')->where('status', 1)->get();
            $users = DB::table('users')->select('id', 'username')->get();
            $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select('contacts.id', 'contacts_companies.name')->get();
            $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->select('contacts.id', 'first_name', 'last_name')->get();
        } else if (Auth::user()->role == 2) {
            $contacts = Contact::where('status', 1)->where('account_id', Auth::user()->account_id);
            $email_accounts = Email_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $sip_accounts = Sip_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $sms_accounts = Sms_account::where('status', 1)->where('account_id', Auth::user())->get();
            $custom_fields = Custom_field::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $select_options = DB::table('custom_select_fields')->join('custom_fields', 'field_id', '=', 'custom_fields.id')
                ->select('custom_select_fields.*')->where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $users = DB::table('users')->select('id', 'username')->where('account_id', Auth::user()->account_id)->get();
            $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select('contacts.id', 'contacts_companies.name')->where('account_id', Auth::user()->account_id)->get();
            $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->select('contacts.id', 'first_name', 'last_name')->where('account_id', Auth::user()->account_id)->get();
        } else {
            return response()->json(['message' => 'you do not have the necessary rights'], 300);
        }
        $groups = Group::all();
        $imports = DB::table('imports')->select('id')->get();
        return view('contacts/list', [
            'contacts' => $contacts,
            'accounts' => $accounts,
            'groups' => $groups,
            'imports' => $imports,
            'custom_fields' => $custom_fields,
            'select_options' => $select_options,
            'users' => $users,
            'elementClass' => getElementByName('contacts'),
            'email_accounts' => $email_accounts,
            'sip_accounts' => $sip_accounts,
            'sms_accounts' => $sms_accounts,
            'contacts_persons' => $contacts_persons,
            'contacts_companies' => $contacts_companies,
        ]);
    }

    /**
     * Get all contact id for selectize input (tagsinput).
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function findContactId(int $id)
    {
        $contactsId = DB::table('contacts')->select('id')->where('id', 'like', $id . '%')->get();
        return response()->json([$contactsId]);
    }

    /**
     * Get all contact source_id for selectize input (tagsinput).
     *
     * @param int $source_id
     * @return \Illuminate\Http\Response
     */
    public function getContactsSourceId(int $source_id)
    {
        $source_id = DB::table('contacts')->select('source_id')->where('source_id', 'like', $source_id . '%')->get();
        return response()->json([$source_id]);
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
        if (Auth::user()->role == 1) {
            $accounts = Account::all();
            $custom_fields = Custom_field::where('status', 1)->get();
            $contact_field = Contacts_field::join('custom_fields', 'field_id', '=', 'custom_fields.id')->where('contact_id', $id)
                ->where('status', 1)->select('contacts_fields.id', 'field_type', 'custom_fields.tag', 'field_value', 'custom_fields.name')->get();
            $email_accounts = Email_account::where('status', 1)->get();
            $sip_accounts = Sip_account::where('status', 1)->get();
        } else if (Auth::user()->role == 2) {
            $custom_fields = Custom_field::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $contact_field = Contacts_field::join('custom_fields', 'field_id', '=', 'custom_fields.id')->where('contact_id', $id)
                ->where('status', 1)->where('account_id', Auth::user()->account_id)->select('contacts_fields.id', 'field_type', 'custom_fields.tag', 'field_value', 'custom_fields.name')->get();
            $email_accounts = Email_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $sip_accounts = Sip_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
        } else {
            return response()->json(['message' => 'you do not have the necessary rights'], 300);
        }
        $contact = Contact::find($id);
        try {
            if ($contact->class == 1) {
                $contacts_person = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')->where('contacts.id', $id)->get();
                //dd($person);
                if (!$contacts_person->isEmpty()) {
                    $contact = $contacts_person[0];
                    if ($modal == 0) {
                        $returnHTML = view('contacts/contacts_person-info', compact('contact', 'accounts', 'contact_field', 'email_accounts', 'sip_accounts'))->render();
                        return response()->json(['success' => 'Contact Person found', 'html' => $returnHTML, 'elementClass' => getElementByName('contacts')]);
                    } else if ($modal == 1)
                        return response()->json(['contact' => $contact, 'contact_field' => $contact_field, 'custom_fields' => $custom_fields]);
                } else
                    return response()->json(['error' => 'Contact Not Found !!!'], 300);
            } else if ($contact->class == 2) {
                $contacts_companie = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                    ->select('contacts.*', 'contacts_companies.class as companies_class', 'contacts_companies.name', 'contacts_companies.registered_number', 'contacts_companies.logo', 'contacts_companies.activity', 'contacts_companies.country', 'contacts_companies.language')
                    ->where('contacts.id', $id)->get();
                if (!$contacts_companie->isEmpty()) {
                    $contact = $contacts_companie[0];
                    //dd($companie);
                    if ($modal == 0) {
                        $returnHTML = view('contacts/contacts_companie-info', compact('contact', 'accounts', 'contact_field', 'email_accounts', 'sip_accounts'))->render();
                        return response()->json(['success' => 'Contact Companie found', 'html' => $returnHTML, 'elementClass' => getElementByName('contacts')]);
                    } else if ($modal == 1)
                        return response()->json(['contact' => $contact, 'contact_field' => $contact_field, 'custom_fields' => $custom_fields]);
                } else
                    return response()->json(['error' => 'Contact Not Found !!!'], 300);
            }
        } catch (Throwable $e) {
            dd($e);
            report($e);
            return response()->json(['error' => 'Contact Not Found !!!'], 300);
        }
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
            'class' => 'required|integer|min:1|max:2',
        ]);
        $contact = null;
        if ($request->class == 1) //person contact
        {
            $person_data = $request->validate([
                'source_id' => 'required|integer|digits_between:0,10',
                'source' => 'required|integer|digits_between:1,1',
                'status' => 'required|integer|digits_between:1,1',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'nickname' => 'string|nullable|max:255',
                'profile' => 'required|integer|digits_between:1,1',
                'gender' => 'required|integer|min:1|max:2',
                'person_language' => 'string|nullable|min:2|max:2',
                'person_country' => 'string|nullable|min:2|max:2',
                'birthdate' => 'date|nullable|min:today',
            ]);

            $account_id = array('account_id' => Auth::user()->account_id);
            $person_data = array_merge($person_data,  $account_id);

            $contact = Contact::create(['class' => $request->class, 'source_id' => $person_data['source_id'], 'source' => $person_data['source'], 'status' => $person_data['status'], 'account_id' => $person_data['account_id']]);
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
                $custom_fields = Custom_field::where('account_id', Auth::user()->account_id)->get();
                foreach ($custom_fields as $key => $custom_field) {
                    if ($request->input($custom_field->tag)) {
                        $contacts_field = Contacts_field::create(['contact_id' => $contact->id, 'field_id' => $custom_field->id, 'field_value' => $request->input($custom_field->tag)]);
                        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts_fields.create', 'element' => getElementByName('contacts_fields'), 'element_id' => $contacts_field->id, 'source' => 'contacts_fields.create']);
                    }
                    if ($request->file($custom_field->tag)) {
                        $request->file($custom_field->tag)->storePublicly('public/custom_field');
                        $custom_file_name = $request->file($custom_field->tag)->hashName();
                        $contacts_field = Contacts_field::create(['contact_id' => $contact->id, 'field_id' => $custom_field->id, 'field_value' => $custom_file_name]);
                        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts_fields.create', 'element' => getElementByName('contacts_fields'), 'element_id' => $contacts_field->id, 'source' => 'contacts_fields.create']);
                    }
                }
                Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contact_person.create', 'element' => getElementByName('contacts'), 'element_id' => $contact->id, 'source' => 'contact_person.create']);
                //return response()->json(['contact_person' => $contact_person, 'success' => 'This person contact has been added']);
                $contact = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')->where('contacts.id', $contact->id)->get();
            } catch (Throwable $e) {
                report($e);
                Contact::find($contact_person->id)->delete();
                Contacts_field::where('contact_id', $contact_person->id)->delete();
                return response()->json(['error' => 'Error while adding that contact !!!'], 300);
            }
        } else if ($request->class == 2) //companies contact
        {
            $companies_data = $request->validate([
                'source_id' => 'required|integer|digits_between:0,10',
                'source' => 'required|integer|digits_between:1,1',
                'status' => 'required|integer|digits_between:1,1',
                'companies_class' => 'required|integer|digits_between:1,1',
                'name' => 'required|string|max:255',
                'registered_number' => 'integer|nullable|digits_between:0,128',
                'logo' => 'nullable|mimes:jpg,png,jpeg',
                'activity' => 'nullable|integer|digits_between:0,10',
                'companies_language' => 'nullable|string|min:2|max:2',
                'companies_country' => 'nullable|string|min:2|max:2',
            ]);

            $account_id = array('account_id' => Auth::user()->account_id);
            $companies_data = array_merge($companies_data,  $account_id);

            $contact = Contact::create(['class' => $request->class, 'source_id' => $companies_data['source_id'], 'source' => $companies_data['source'], 'status' => $companies_data['status'], 'account_id' => $companies_data['account_id']]);
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
                $custom_fields = Custom_field::where('account_id', Auth::user()->account_id)->get();
                foreach ($custom_fields as $key => $custom_field) {
                    if ($request->input($custom_field->tag)) {
                        $contacts_field = Contacts_field::create(['contact_id' => $contact->id, 'field_id' => $custom_field->id, 'field_value' => $request->input($custom_field->tag)]);
                        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts_fields.create', 'element' => getElementByName('contacts_fields'), 'element_id' => $contacts_field->id, 'source' => 'contacts_fields.create']);
                    }
                    if ($request->file($custom_field->tag)) {
                        $request->file($custom_field->tag)->storePublicly('public/custom_field');
                        $custom_file_name = $request->file($custom_field->tag)->hashName();
                        $contacts_field = Contacts_field::create(['contact_id' => $contact->id, 'field_id' => $custom_field->id, 'field_value' => $custom_file_name]);
                        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts_fields.create', 'element' => getElementByName('contacts_fields'), 'element_id' => $contacts_field->id, 'source' => 'contacts_fields.create']);
                    }
                }
                Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contact_companie.create', 'element' => getElementByName('contacts'), 'element_id' => $contact->id, 'source' => 'contact_companie.create']);
                //return response()->json(['contact_companie' => $contact_companie, 'success' => 'This companie contact has been added']);
                $contact = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                    ->select('contacts.*', 'contacts_companies.class as companies_class', 'contacts_companies.name', 'contacts_companies.registered_number', 'contacts_companies.logo', 'contacts_companies.activity', 'contacts_companies.country', 'contacts_companies.language')
                    ->where('contacts.id', $contact->id)->get();
            } catch (Throwable $e) {
                report($e);
                Contact::find($contact_companie->id)->delete();
                Contacts_field::where('contact_id', $contact_companie->id)->delete();
                return response()->json(['error' => 'Error while adding that contact !!!'], 300);
            }
        }

        if (Auth::user()->role == 1) {
            $accounts = Account::All();
            $contacts = Contact::All();
            $sip_accounts = Sip_account::where('status', 1)->get();
        } else if (Auth::user()->role == 2) {
            $accounts = [];
            $contacts = Contact::where('account_id', Auth::user()->account_id)->get();
            $sip_accounts = Sip_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
        } else {
            return response()->json(['message' => 'you do not have the necessary rights'], 300);
        }
        $returnHTML = view('contacts/datatable-contacts', compact('contacts', 'accounts', 'sip_accounts'))->render();
        return response()->json(['success' => 'This companie contact has been added', 'html' => $returnHTML, 'contact' => $contact[0]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $page)
    {
        //return $request->all();
        $request->validate([
            'class' => 'required|integer|min:1|max:2',
        ]);
        if ($request->class == 1) //person contact
        {
            $person_data = $request->validate([
                'source_id' => 'required|integer|digits_between:0,10',
                'source' => 'required|integer|digits_between:1,1',
                'status' => 'required|integer|digits_between:1,1',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'nickname' => 'string|nullable|max:255',
                'profile' => 'required|integer|digits_between:1,1',
                'gender' => 'required|integer|min:1|max:2',
                'person_language' => 'string|nullable|min:2|max:2',
                'person_country' => 'string|nullable|min:2|max:2',
                'birthdate' => 'date|nullable|min:today',
            ]);

            $account_id = array('account_id' => Auth::user()->account_id);
            $person_data = array_merge($person_data,  $account_id);

            Contact::find($request->input('id'))->update(['class' => $request->class, 'source_id' => $person_data['source_id'], 'source' => $person_data['source'], 'status' => $person_data['status'], 'account_id' => $person_data['account_id']]);
            $contact = Contact::find($request->input('id'));
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

            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contact_person.update', 'element' => getElementByName('contacts'), 'element_id' => $request->input('id'), 'source' => 'contact_person.update']);
            //return response()->json(['contact' => $contact, 'success' => 'This person contact has been updated']);
            $contact = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')->where('contacts.id', $request->id)->get();
        } else if ($request->class == 2) //companies contact
        {
            $companies_data = $request->validate([
                'source_id' => 'required|integer|digits_between:0,10',
                'source' => 'required|integer|digits_between:1,1',
                'status' => 'required|integer|digits_between:1,1',
                'companies_class' => 'required|integer|digits_between:1,1',
                'name' => 'required|string|max:255',
                'registered_number' => 'integer|nullable|digits_between:0,128',
                'logo' => 'nullable|mimes:jpg,png,jpeg',
                'activity' => 'nullable|integer|digits_between:0,10',
                'companies_language' => 'nullable|string|min:2|max:2',
                'companies_country' => 'nullable|string|min:2|max:2',
            ]);

            $account_id = array('account_id' => Auth::user()->account_id);
            $companies_data = array_merge($companies_data,  $account_id);

            Contact::find($request->input('id'))->update(['class' => $request->class, 'source_id' => $companies_data['source_id'], 'source' => $companies_data['source'], 'status' => $companies_data['status'], 'account_id' => $companies_data['account_id']]);
            $contact = Contact::find($request->input('id'));
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

            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contact_companie.update', 'element' => getElementByName('contacts'), 'element_id' => $request->input('id'), 'source' => 'contact_companie.update']);
            //return response()->json(['contact' => $contact, 'success' => 'This companie contact has been updated']);
            $contact = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select('contacts.*', 'contacts_companies.class as companies_class', 'contacts_companies.name', 'contacts_companies.registered_number', 'contacts_companies.logo', 'contacts_companies.activity', 'contacts_companies.country', 'contacts_companies.language')
                ->where('contacts.id', $request->id)->get();
        }

        $custom_fields = Custom_field::where('account_id', Auth::user()->account_id)->get();
        foreach ($custom_fields as $key => $custom_field) {
            $contact_field = Contacts_field::where('contact_id', $request->id)->where('field_id', $custom_field->id)->first();
            if ($contact_field) {
                if ($request->file($custom_field->tag)) {
                    if ($contact_field->field_value != $request->input($custom_field->tag)) {
                        Storage::delete('public/custom_field/' . $custom_field->field_value);
                        $request->file($custom_field->tag)->storePublicly('public/custom_field');
                        $custom_file_name = $request->file($custom_field->tag)->hashName();
                        $contact_field->field_value = $custom_file_name;
                        $contact_field->save();
                        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts_fields.update', 'element' => getElementByName('contacts_fields'), 'element_id' => $contact_field->id, 'source' => 'contacts_fields.update']);
                    }
                } else {
                    if ($custom_field->field_type != 'file') {
                        if ($request->input($custom_field->tag)) {
                            if ($contact_field->field_value != $request->input($custom_field->tag)) {
                                $contact_field->field_value = $request->input($custom_field->tag);
                                $contact_field->save();
                                Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts_fields.update', 'element' => getElementByName('contacts_fields'), 'element_id' => $contact_field->id, 'source' => 'contacts_fields.update']);
                            }
                        } else {
                            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts_fields.delete', 'element' => getElementByName('contacts_fields'), 'element_id' => $contact_field->id, 'source' => 'contacts_fields.delete']);
                            $contact_field->delete();
                        }
                    }
                }
            } else {
                if ($request->input($custom_field->tag)) {
                    $contacts_field = Contacts_field::create(['contact_id' => $request->id, 'field_id' => $custom_field->id, 'field_value' => $request->input($custom_field->tag)]);
                    Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts_fields.create', 'element' => getElementByName('contacts_fields'), 'element_id' => $contacts_field->id, 'source' => 'contacts_fields.create']);
                }
                if ($request->file($custom_field->tag)) {
                    $request->file($custom_field->tag)->storePublicly('public/custom_field');
                    $custom_file_name = $request->file($custom_field->tag)->hashName();
                    $contacts_field = Contacts_field::create(['contact_id' => $request->id, 'field_id' => $custom_field->id, 'field_value' => $custom_file_name]);
                    Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts_fields.create', 'element' => getElementByName('contacts_fields'), 'element_id' => $contacts_field->id, 'source' => 'contacts_fields.create']);
                }
            }
        }

        if ($page == 'page_list') {
            if (Auth::user()->role == 1) {
                $accounts = Account::All();
                $contacts = Contact::All();
                $sip_accounts = Sip_account::where('status', 1)->get();
            } else if (Auth::user()->role == 2) {
                $accounts = [];
                $contacts = Contact::where('account_id', Auth::user()->account_id)->get();
                $sip_accounts = Sip_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            } else {
                return response()->json(['message' => 'you do not have the necessary rights'], 300);
            }
            $returnHTML = view('contacts/datatable-contacts', compact('contacts', 'accounts', 'sip_accounts'))->render();
            return response()->json(['success' => 'This companie contact has been updated', 'html' => $returnHTML, 'contact' => $contact[0], 'page_name' => 'page_list']);
        } else if ($page == 'page_view') {
            $contact = $contact[0];
            $contact->account_id = (Contact::find($contact->id))->account[0]->name;
            if (Auth::user()->role == 1) {
                $sip_accounts = Sip_account::where('status', 1)->get();
                $contact_field = Contacts_field::join('custom_fields', 'field_id', '=', 'custom_fields.id')->where('contact_id', $contact->id)
                    ->where('status', 1)->select('contacts_fields.id', 'field_type', 'custom_fields.tag', 'field_value', 'custom_fields.name')->get();
            } else if (Auth::user()->role == 2) {
                $sip_accounts = Sip_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
                $contact_field = Contacts_field::join('custom_fields', 'field_id', '=', 'custom_fields.id')->where('contact_id', $contact->id)->where('status', 1)
                    ->where('account_id', Auth::user()->account_id)->select('contacts_fields.id', 'field_type', 'custom_fields.tag', 'field_value', 'custom_fields.name')->get();
            } else {
                return response()->json(['message' => 'you do not have the necessary rights'], 300);
            }
            if ($contact->class == 1)
                $returnHTML = view('contacts.contacts_person-tab', compact('contact', 'contact_field', 'sip_accounts'))->render();
            else if ($contact->class == 2)
                $returnHTML = view('contacts.contacts_companie-tab', compact('contact', 'contact_field', 'sip_accounts'))->render();
            return response()->json(['success' => 'This companie contact has been updated', 'html' => $returnHTML, 'contact' => $contact, 'page_name' => 'page_view']);
        }
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

        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contact_companie.logo.update', 'element' => getElementByName('contacts'), 'element_id' => $request->id, 'source' => 'contact_companie.logo.update, ' . $request->id]);
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
        if ($contact->class == 1)
            $contact_1 = Contacts_person::find($id);
        else if ($contact->class == 2)
            $contact_1 = Contacts_companie::find($id);
        //$contact->status = 3;
        if ($contact->delete() && $contact_1->delete()) {
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts.delete', 'element' => getElementByName('contacts'), 'element_id' => $contact->id, 'source' => 'contacts.delete, ' . $id]);

            if (Auth::user()->role == 1) {
                $accounts = Account::All();
                $contacts = Contact::All();
                $sip_accounts = Sip_account::where('status', 1)->get();
            } else if (Auth::user()->role == 2) {
                $accounts = [];
                $contacts = Contact::where('account_id', Auth::user()->account_id)->get();
                $sip_accounts = Sip_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            } else {
                return response()->json(['message' => 'you do not have the necessary rights'], 300);
            }
            $returnHTML = view('contacts/datatable-contacts', compact('contacts', 'accounts', 'sip_accounts'))->render();
            $infoCard = view('contacts/contacts_person-info')->render();
            return response()->json(['success' => 'This contact has been Disabled !!!', 'html' => $returnHTML, 'infoCard' => $infoCard, 'contact' => $contact]);
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
        $contacts = DB::table('contacts')->select('id', 'class')->get();
        $groups = Group::all();
        $imports = DB::table('imports')->select('id')->get();
        $custom_fields = Custom_field::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
        $select_options = DB::table('custom_select_fields')->join('custom_fields', 'field_id', '=', 'custom_fields.id')->select('custom_select_fields.*')->where('status', 1)->where('account_id', Auth::user()->account_id)->get();
        $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
            ->select('contacts.id', 'contacts_companies.name')->get();
        $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
            ->select('contacts.id', 'first_name', 'last_name')->get();
        $users = DB::table('users')->select('id', 'username')->where('account_id', Auth::user()->account_id)->get();
        $email_accounts = Email_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
        $sip_accounts = Sip_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
        $sms_accounts = Sms_account::where('status', 1)->get();
        return view('/contacts/search', [
            'accounts' => $accounts,
            'groups' => $groups,
            'imports' => $imports,
            'custom_fields' => $custom_fields,
            'select_options' => $select_options,
            'contacts' => $contacts,
            'contacts_persons' => $contacts_persons,
            'contacts_companies' => $contacts_companies,
            'users' => $users,
            'email_accounts' => $email_accounts,
            'email_accounts' => $email_accounts,
            'sip_accounts' => $sip_accounts,
            'sms_accounts' => $sms_accounts,
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
            'id' => 'nullable|string',
            'source_id' => 'nullable|integer|digits_between:0,10',
            'source' => 'nullable|integer|digits_between:1,1',
            'status' => 'nullable|integer|digits_between:1,1',
            'account_id' => 'nullable|exists:App\Models\Account,id',
            'import_id' => 'nullable|integer|digits_between:0,10',
            'adding_method' => 'integer|min:0|max:2',
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
                ->leftjoin('contact_data', 'contacts.id', '=', 'contact_data.element_id')
                ->select('contacts.*', 'contacts_persons.*')
                //contact
                ->where(function ($query) use ($request) {
                    if ($request->id)
                        $query->whereIn('contacts.id', explode(",", $request->id));
                })
                ->where('source_id', 'like', '%' . $request->source_id . '%')
                ->where('source', 'like', '%' . $request->source . '%')
                ->where('contacts.status', 'like', '%' . $request->status . '%')
                ->where('account_id', 'like', '%' . $request->account_id . '%')
                ->where(function ($query) use ($request) {
                    if ($request->creation_date)
                        $query->whereBetween('creation_date', explode("to", $request->creation_date));
                })
                ->where(function ($query) use ($request) {
                    if ($request->adding_method == 2)
                        $query->where('import_id', $request->import_id)->Where('import_id', '!=', null);
                    else if ($request->adding_method == 1)
                        $query->Where('import_id', null);
                })
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
                    if ($request->birthdate)
                        $query->whereDate('birthdate', $request->birthdate);
                })
                ->get();
        } else if ($request->class == 2) {
            $contacts = DB::table('contacts')
                ->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->leftjoin('contact_data', 'contacts.id', '=', 'contact_data.element_id')
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
                ->where(function ($query) use ($request) {
                    if ($request->id)
                        $query->whereIn('contacts.id', explode(",", $request->id));
                })
                ->where('source_id', 'like', '%' . $request->source_id . '%')
                ->where('source', 'like', '%' . $request->source . '%')
                ->where('contacts.status', 'like', '%' . $request->status . '%')
                ->where('account_id', 'like', '%' . $request->account_id . '%')
                ->where(function ($query) use ($request) {
                    if ($request->creation_date)
                        $query->whereBetween('creation_date', explode("to", $request->creation_date));
                })
                ->where(function ($query) use ($request) {
                    if ($request->adding_method == 2)
                        $query->where('import_id', $request->import_id)->Where('import_id', '!=', null);
                    else if ($request->adding_method == 1)
                        $query->Where('import_id', null);
                })
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
                //->leftJoin('contact_data', 'contacts.id', '=', 'contact_data.element_id')
                ->select('contacts.*')
                ->where(function ($query) use ($request) {
                    if ($request->id)
                        $query->whereIn('contacts.id', explode(",", $request->id));
                })
                ->where(function ($query) use ($request) {
                    if ($request->source_id)
                        $query->whereIn('contacts.source_id', explode(",", $request->source_id));
                })
                ->where('source', 'like', '%' . $request->source . '%')
                ->where(function ($query) use ($request) {
                    if ($request->status)
                        $query->whereIn('contacts.status', explode(",", $request->status));
                })
                ->where(function ($query) use ($request) {
                    if ($request->account_id)
                        $query->whereIn('contacts.account_id', explode(",", $request->account_id));
                })
                ->where(function ($query) use ($request) {
                    if ($request->creation_date)
                        $query->whereBetween('creation_date', explode("to", $request->creation_date));
                })
                ->where(function ($query) use ($request) {
                    if ($request->adding_method == 2)
                        $query->where('import_id', $request->import_id)->Where('import_id', '!=', null);
                    else if ($request->adding_method == 1)
                        $query->Where('import_id', null);
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
            $returnHTML = view('contacts/datatable-contacts', compact('contacts', 'accounts'))->render();
            return response()->json(['success' => 'Results found !!!', 'html' => $returnHTML]);
        }
    }

    /**
     * display upload form
     * 
     * @return \Illuminate\Http\Response
     */
    public function uploadForm()
    {
        $accounts = Account::all();
        return view('/contacts/import/upload', [
            'accounts' => $accounts,
        ]);
    }

    /**
     * preview 10 rows with select option to choose column
     * 
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function previewContactsImport(Request $request)
    {
        $data = $request->validate([
            'account_id' => 'nullable|exists:App\Models\Account,id',
            'file' => 'required|mimes:csv,txt,xlsx,xls',
            'class' => 'required|integer|min:1|max:2',
        ]);

        if (Auth::user()->role === 2) {
            $account_id = array('account_id' => Auth::user()->account_id);
            $data = array_merge($data,  $account_id);
        }

        $class = $request->class;

        $request->file->storePublicly('public/contact');
        $file_name = $request->file->hashName();
        $file_path = 'public/contact/' . $file_name;

        //return $request->file->extension();
        //return $collection = Excel::toCollection(new ContactImport, $file_path);
        /*$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($request->file);
        return $sheetData = $spreadsheet->getActiveSheet()->toArray();*/

        $import = Import::create(['start_date' => new DateTime()]);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts.import', 'element' => getElementByName('imports'), 'element_id' => $import->id, 'source' => 'contacts.import']);

        if ($request->header) {
            $headings = (new HeadingRowImport())->toArray($file_path);
            $contactImport = new ContactImport($headings);
        } else {
            $headings = null;
            $contactImport = new ContactImport();
        }

        $contacts = Excel::import($contactImport, $file_path);

        $contacts = $contactImport->get10FirstRows();

        $columnCount = $contactImport->getColumnCount();

        $rowCount = $contactImport->getRowCount();

        $returnHTML = view('contacts/import/preview', compact('contacts', 'columnCount', 'headings', 'class', 'rowCount'))->render();

        return response()->json(['success' => 'preview 10 rows success  !!!', 'html' => $returnHTML, 'import' => $import, 'file_path' => $file_path, 'account_id' => $data['account_id'], 'headings' => $headings]);
    }

    /**
     * upload contact file
     * 
     * @param \Illuminate\Http\Request  $request
     * @param int $skipErrors
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, int $skipErrors)
    {
        //return $request;
        $data = $request->validate([
            'account_id' => 'exists:App\Models\Account,id',
            'import_id' => 'exists:App\Models\Import,id',
            'file_path' => 'required:filepath',
            'class' => 'required|integer|min:1|max:2',
            'heading' => 'required|integer|min:0|max:1',
            //'column-1' => 'required|string',
        ]);

        $contactImport = new ContactImport();
        $contacts = Excel::import($contactImport, $request->file_path);
        $columnCount = $contactImport->getColumnCount();
        if ($request->class == 1)
            $column = ['source' => 0, 'source_id' => 0, 'status' => 0, 'profile' => 0, 'gender' => 0, 'first_name' => 0, 'last_name' => 0, 'nickname' => 0, 'birthdate' => 0, 'country' => 0, 'language' => 0];
        else if ($request->class == 2)
            $column = ['source' => 0, 'source_id' => 0, 'status' => 0, 'class' => 0, 'name' => 0, 'registered_number' => 0, 'logo' => 0, 'activity' => 0, 'country' => 0, 'language' => 0];

        $error = 0;
        foreach ($column as $key => $c) {
            for ($i = 0; $i < $columnCount; $i++) {
                if ($key == $request->input('column-' . $i)) {
                    $column[$key]++;
                }
            }
        }
        if ($column['source'] == 0)
            return response()->json(['errors' => 'Select column name for source  !!!'], 300);
        else if ($column['source'] > 1)
            return response()->json(['errors' => 'Multiple column source select  !!!'], 300);

        else if ($column['source_id'] == 0)
            return response()->json(['errors' => 'Select column name for source_id  !!!'], 300);
        else if ($column['source_id'] > 1)
            return response()->json(['errors' => 'Multiple column source_id select  !!!'], 300);

        else if ($column['status'] == 0)
            return response()->json(['errors' => 'Select column name for status  !!!'], 300);
        else if ($column['status'] > 1)
            return response()->json(['errors' => 'Multiple column status select  !!!'], 300);

        else if ($column['country'] > 1)
            return response()->json(['errors' => 'Multiple column country select  !!!'], 300);

        else if ($column['language'] > 1)
            return response()->json(['errors' => 'Multiple column language select  !!!'], 300);

        if ($request->class == 1) {
            if ($column['profile'] == 0)
                return response()->json(['errors' => 'Select column name for profile  !!!'], 300);
            else if ($column['profile'] > 1)
                return response()->json(['errors' => 'Multiple column profile select  !!!'], 300);

            else if ($column['gender'] == 0)
                return response()->json(['errors' => 'Select column name for gender  !!!'], 300);
            else if ($column['gender'] > 1)
                return response()->json(['errors' => 'Multiple column gender select  !!!'], 300);

            else if ($column['first_name'] == 0)
                return response()->json(['errors' => 'Select column name for first_name  !!!'], 300);
            else if ($column['first_name'] > 1)
                return response()->json(['errors' => 'Multiple column first_name select  !!!'], 300);

            else if ($column['last_name'] == 0)
                return response()->json(['errors' => 'Select column name for last_name  !!!'], 300);
            else if ($column['last_name'] > 1)
                return response()->json(['errors' => 'Multiple column last_name select  !!!'], 300);

            else if ($column['nickname'] > 1)
                return response()->json(['errors' => 'Multiple column nickname select  !!!'], 300);

            else if ($column['birthdate'] > 1)
                return response()->json(['errors' => 'Multiple column birthdate select  !!!'], 300);
        } else if ($request->class == 2) {
            if ($column['class'] == 0)
                return response()->json(['errors' => 'Select column name for class  !!!'], 300);
            else if ($column['class'] > 1)
                return response()->json(['errors' => 'Multiple column class select  !!!'], 300);

            if ($column['name'] == 0)
                return response()->json(['errors' => 'Select column name for name  !!!'], 300);
            else if ($column['name'] > 1)
                return response()->json(['errors' => 'Multiple column name select  !!!'], 300);

            else if ($column['registered_number'] > 1)
                return response()->json(['errors' => 'Multiple column registered_number select  !!!'], 300);

            else if ($column['logo'] > 1)
                return response()->json(['errors' => 'Multiple column logo select  !!!'], 300);

            else if ($column['activity'] > 1)
                return response()->json(['errors' => 'Multiple column activity select  !!!'], 300);
        }

        $column = ['source' => null, 'source_id' => null, 'status' => null, 'profile' => null, 'gender' => null, 'first_name' => null, 'last_name' => null, 'nickname' => null, 'birthdate' => null, 'class' => null, 'name' => null, 'registered_number' => null, 'logo' => null, 'activity' => null, 'country' => null, 'language' => null];

        foreach ($column as $key => $c) {
            for ($i = 0; $i < $columnCount; $i++) {
                if ($key == $request->input('column-' . $i)) {
                    $column[$key] = $i;
                }
            }
        }

        $contactImport = new ContactImport($request->heading, $column, $request->account_id, $request->import_id, $skipErrors);
        Excel::import($contactImport, $data['file_path']);

        if ($request->class == 1) {
            $contacts = $contactImport->insertPersonContactInDB();
        } else if ($request->class == 2) {
            $contacts = $contactImport->insertCompanieContactInDB();
        }

        if ($contactImport->containErrors())
            return response()->json(['error' => 'failed to Upload  !!!'], 300);
        else {
            Storage::delete($request->file_path);
            return response()->json(['success' => 'Successful Upload  !!!', 'import' => $data['import_id'], 'contacts' => $contacts, $column]);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function view(int $id)
    {
        $groups = Group::all();
        $contact = Contact::find($id);
        if ($contact->class == 1) {
            $contact = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')->where('contacts.id', $contact->id)->get();
            $name = $contact[0]->first_name;
        } else if ($contact->class == 2) {
            $contact = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select('contacts.*', 'contacts_companies.class as companies_class', 'contacts_companies.name', 'contacts_companies.registered_number', 'contacts_companies.logo', 'contacts_companies.activity', 'contacts_companies.country', 'contacts_companies.language')
                ->where('contacts.id', $contact->id)->get();
            $name = $contact[0]->name;
        }
        $contact = $contact[0];

        $contact_datas = [];
        $notes = [];
        $users = DB::table('users')->select('id', 'username')->where('account_id', Auth::user()->account_id)->get();
        $contact_datas = Contact_data::all()->where('element_id', $contact->id);
        $notes = DB::table('notes')->where('element_id', $contact->id)->where('element', getElementByName('contacts'))->get();

        if (Auth::user()->role == 1) {
            $contacts = Contact::all();
            $accounts = Account::All();
            $email_accounts = Email_account::where('status', 1)->get();
            $sip_accounts = Sip_account::where('status', 1)->get();
            $sms_accounts = Sms_account::where('status', 1)->get();
            $custom_fields = Custom_field::where('status', 1)->get();
            $select_options = DB::table('custom_select_fields')->join('custom_fields', 'field_id', '=', 'custom_fields.id')
                ->select('custom_select_fields.*')->where('status', 1)->get();
            $users = DB::table('users')->select('id', 'username')->get();
            $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select('contacts.id', 'contacts_companies.name')->get();
            $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->select('contacts.id', 'first_name', 'last_name')->get();

            $users = DB::table('users')->select('id', 'username')->get();
            $users_id = [];
            foreach ($users as $user) {
                array_push($users_id, $user->id);
            }
            $appointments = Appointment::whereIn('user_id', $users_id)->where('contact_id', $id)->where('status', 1)->get();
            $communications = Communication::whereIn('user_id', $users_id)->where('contact_id', $id)->where('status', 1)->get();

            $custom_fields = Custom_field::where('status', 1)->get();
            $select_options = DB::table('custom_select_fields')->join('custom_fields', 'field_id', '=', 'custom_fields.id')
                ->select('custom_select_fields.*')->where('status', 1)->get();

            $contact_field = Contacts_field::join('custom_fields', 'field_id', '=', 'custom_fields.id')->where('contact_id', $contact->id)
                ->where('status', 1)->select('contacts_fields.id', 'field_type', 'custom_fields.tag', 'field_value', 'custom_fields.name')->get();
        } else if (Auth::user()->role == 2) {
            $contacts = Contact::where('status', 1)->where('account_id', Auth::user()->account_id);
            $email_accounts = Email_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $sip_accounts = Sip_account::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $sms_accounts = Sms_account::where('status', 1)->where('account_id', Auth::user())->get();
            $custom_fields = Custom_field::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $select_options = DB::table('custom_select_fields')->join('custom_fields', 'field_id', '=', 'custom_fields.id')
                ->select('custom_select_fields.*')->where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $users = DB::table('users')->select('id', 'username')->where('account_id', Auth::user()->account_id)->get();
            $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select('contacts.id', 'contacts_companies.name')->where('account_id', Auth::user()->account_id)->get();
            $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->select('contacts.id', 'first_name', 'last_name')->where('account_id', Auth::user()->account_id)->get();

            $users = DB::table('users')->select('id', 'username')->where('account_id', Auth::user()->account_id)->get();
            $users_id = [];
            foreach ($users as $user) {
                array_push($users_id, $user->id);
            }
            $appointments = Appointment::whereIn('user_id', $users_id)->where('contact_id', $id)->where('status', 1)->get();
            $communications = Communication::whereIn('user_id', $users_id)->where('contact_id', $id)->where('status', 1)->get();

            $custom_fields = Custom_field::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            $select_options = DB::table('custom_select_fields')->join('custom_fields', 'field_id', '=', 'custom_fields.id')
                ->select('custom_select_fields.*')->where('status', 1)->where('account_id', Auth::user()->account_id)->get();

            $contact_field = Contacts_field::join('custom_fields', 'field_id', '=', 'custom_fields.id')->where('contact_id', $contact->id)
                ->where('status', 1)->where('account_id', Auth::user()->account_id)->select('contacts_fields.id', 'field_type', 'custom_fields.tag', 'field_value', 'custom_fields.name')->get();
        } else {
            return response()->json(['message' => 'you do not have the necessary rights'], 300);
        }
        $contact->account_id = (Contact::find($contact->id))->account[0]->name;
        return view('contacts/view', [
            'name' => $name,
            'accounts' => $accounts,
            'contact' => $contact,
            'contact_datas' => $contact_datas,
            'notes' => $notes,
            'groups' => $groups,
            'custom_fields' => $custom_fields,
            'select_options' => $select_options,
            'contact_field' => $contact_field,
            'users' => $users,
            'elementClass' => getElementByName('contacts'),
            'email_accounts' => $email_accounts,
            'sip_accounts' => $sip_accounts,
            'sms_accounts' => $sms_accounts,
            'appointments' => $appointments,
            'communications' => $communications,
            'contacts' => $contacts,
            'contacts_persons' => $contacts_persons,
            'contacts_companies' => $contacts_companies,
        ]);
    }
}
