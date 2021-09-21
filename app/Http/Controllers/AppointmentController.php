<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Contact;
use App\Models\Contacts_companie;
use App\Models\Contacts_person;
use App\Models\Log;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 1) {
            $contacts = DB::table('contacts')->select('id', 'class')->get();
            $users = DB::table('users')->select('id', 'username')->get();
            $appointments = Appointment::all();

            $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select('contacts.id', 'contacts_companies.name')->get();
            $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->select('contacts.id', 'first_name', 'last_name')->get();
        } else if (Auth::user()->role == 2) {
            //retrieve all the contacts and users belonging to the account id of the logged in user
            $users = DB::table('users')->select('id', 'username')->where('account_id', Auth::user()->account_id)->get();
            $contacts = DB::table('contacts')->select('id', 'class')->where('account_id', Auth::user()->account_id)->get();
            $users_id = [];
            foreach ($users as $user) {
                array_push($users_id, $user->id);
            }
            $contact_id = [];
            foreach ($contacts as $contact) {
                array_push($contact_id, $contact->id);
            }
            $appointments = Appointment::whereIn('user_id', $users_id)->whereIn('contact_id', $contact_id)->where('status', 1)->get();

            $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->where('account_id', Auth::user()->account_id)
                ->select('contacts.id', 'contacts_companies.name')->get();
            $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->where('account_id', Auth::user()->account_id)
                ->select('contacts.id', 'first_name', 'last_name')->get();
        }

        return view('/appointments/index', [
            'appointments' => $appointments,
            'contacts' => $contacts,
            'users' => $users,
            'contacts_persons' => $contacts_persons,
            'contacts_companies' => $contacts_companies,
        ]);
    }

    /**
     * get all appointments
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllAppointments()
    {
        $users = DB::table('users')->select('id', 'username')->where('account_id', Auth::user()->account_id)->get();
        $users_id = [];
        foreach ($users as $user) {
            array_push($users_id, $user->id);
        }
        $appointments = Appointment::whereIn('user_id', $users_id)->where('status', 1)->get();
        return response()->json($appointments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $type
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $type)
    {
        //return $request;
        $data = $request->validate([
            'user_id' => 'required|exists:App\Models\User,id',
            'contact_id' => 'required|exists:App\Models\Contact,id',
            'class' => 'required|integer|digits_between:1,1',
            'subject' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);
        //$user = array('user_id' => 4);
        //$data = array_merge($data,  $user);
        $appointment = Appointment::create($data);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'appointments.create', 'element' => getElementByName('appointments'), 'element_id' => $appointment->id, 'source' => 'appointments.create']);

        $users = DB::table('users')->select('id', 'username')->where('account_id', Auth::user()->account_id)->get();
        $users_id = [];
        foreach ($users as $user) {
            array_push($users_id, $user->id);
        }
        if ($type == 1)
            $appointments = Appointment::whereIn('user_id', $users_id)->where('status', 1)->get();
        else
            $appointments = Appointment::whereIn('user_id', $users_id)->where('contact_id', $appointment->contact_id)->where('status', 1)->get();

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

        $returnHTML = view('appointments/list', compact('appointments', 'contacts_persons', 'contacts_companies'))->render();
        return response()->json(['success' => 'Appointment Created', 'html' => $returnHTML, 'appointment' => $appointment]);
    }

    /**
     * get appointment by id.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getAppointment(int $id)
    {
        $appointment = Appointment::find($id);
        return response()->json(['appointment' => $appointment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $type)
    {
        //return $request;
        $data = $request->validate([
            'id' => 'required|exists:App\Models\Appointment,id',
            'user_id' => 'required|exists:App\Models\User,id',
            'contact_id' => 'required|exists:App\Models\Contact,id',
            'class' => 'required|integer|digits_between:1,1',
            'subject' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        //$user = array('user_id' => 4);
        //$data = array_merge($data,  $user);

        $appointment = Appointment::find($request->id);
        $appointment->update($data);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'appointments.update', 'element' => getElementByName('appointments'), 'element_id' => $appointment->id, 'source' => 'appointments.update']);

        $appointment->user = $appointment->user[0];
        $appointment->contact = $appointment->contact[0];
        if($appointment->contact->class == 1){
            $contact_name = Contacts_person::find($appointment->contact->id)->first_name .' '.Contacts_person::find($appointment->contact->id)->last_name;
        }else if($appointment->contact->class == 2){
            $contact_name = Contacts_companie::find($appointment->contact->id)->name;
        }
        return response()->json(['success' => 'Appointment Updated', 'appointment' => $appointment, 'contact_name' => $contact_name]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $appointment = Appointment::find($id);
        $appointment->status = 0;
        if ($appointment->save()) {
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'appointments.delete', 'element' => getElementByName('appointments'), 'element_id' => $id, 'source' => 'appointments.delete, ' . $id]);
            return response()->json(['success' => 'Appointment Deleted !!!', 'appointment' => $appointment]);
        } else
            return response()->json(['error' => 'Failed to delete this Appointment !!!']);
    }
}
