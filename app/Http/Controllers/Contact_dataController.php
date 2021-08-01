<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Contact_data;
use App\Models\Log;
use DateTime;
use Illuminate\Http\Request;
use Throwable;

class Contact_dataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //return $request;
        $data = $request->validate([
            'class' => 'required|integer|digits_between:1,1',
            'data' => 'required',
            'element' => 'required|integer|min:0|max:16',
            'element_id' => 'required|integer|digits_between:1,10',
        ]);
        $contact_data = Contact_data::create($data);
        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contact.data.create', 'element' => 4, 'element_id' => $contact_data->id, 'source' => 'contact.data.create']);
        return response()->json(['contact_data' => $contact_data, 'success' => 'Contact Data Added']);
    }

    /**
     * Get contact by id with json response.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getContactDataJsonById(int $id)
    {
        $contact_datas = Contact_data::all()->where('element_id', $id);
        $contact = Contact::find($id);
            try {
                return view('contacts/contact_data', compact('contact_datas', 'contact'))->render();
            } catch (Throwable $e) {
                report($e);
                return view('contacts/contact_data')->render();
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact_data  $contact_data
     * @return \Illuminate\Http\Response
     */
    public function show(Contact_data $contact_data)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $contact_data = Contact_data::find($id);
        return response()->json($contact_data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact_data  $contact_data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact_data $contact_data)
    {
        //return $request;
        $data = $request->validate([
            'id' => 'required',
            'class' => 'required|integer|digits_between:1,1',
            'data' => 'required',
            'element' => 'required|integer|min:0|max:16',
            'element_id' => 'required|integer|digits_between:1,10',
        ]);
        Contact_data::find($request->id)->update($data);
        $contact_data = Contact_data::find($request->id);
        Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contact.data.update', 'element' => 4, 'element_id' => $contact_data->id, 'source' => 'contact.data.update']);
        return response()->json(['contact_data' => $contact_data, 'success' => 'Contact Data Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $contact_data = Contact_data::find($id);
        //$contact->status = 3;
        if ($contact_data->delete()) {
            Log::create(['user_id' => 4, 'log_date' => new DateTime(), 'action' => 'contacts.data.delete', 'element' => 4, 'element_id' => $id, 'source' => 'contacts.data.delete, ' . $id]);
            return response()->json(['success' => 'This contact data has been Disabled !!!', 'contact_data' => $contact_data]);
        } else
            return response()->json(['error' => 'Failed to delete this contact !!!']);
    }
}
