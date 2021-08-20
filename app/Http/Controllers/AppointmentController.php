<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Contact;
use App\Models\Log;
use App\Models\User;
use DateTime;
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
        $appointments = Appointment::all();
        $contacts = Contact::all();
        $users = DB::table('users')->select('id', 'username')->get();
        return view('/appointments/index', [
            'appointments' => $appointments,
            'contacts' => $contacts,
            'users' => $users,
        ]);
    }

    /**
     * get all appointments
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllAppointments()
    {
        $appointments = Appointment::where('status', 1)->get();
        return response()->json($appointments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        
        $appointments = Appointment::all();
        $returnHTML = view('appointments/list', compact('appointments'))->render();
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
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
        //return $request;
        $data = $request->validate([
            'id' => 'required|exists:App\Models\Appointment,id',
            'user_id' => 'required|exists:App\Models\User,id',
            'contact_id' => 'required|exists:App\Models\Contact,id',
            'class' => 'required|integer|digits_between:1,1',
            'subject' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);
        //$user = array('user_id' => 4);
        //$data = array_merge($data,  $user);
        
        $appointment = Appointment::find($request->id);
        $appointment->update($data);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'appointments.update', 'element' => getElementByName('appointments'), 'element_id' => $appointment->id, 'source' => 'appointments.update']);
        
        $appointments = Appointment::all();
        $returnHTML = view('appointments/list', compact('appointments'))->render();
        return response()->json(['success' => 'Appointment Updated', 'html' => $returnHTML, 'appointment' => $appointment]);
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
