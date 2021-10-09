<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Contact_data;
use App\Models\Log;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class Contact_dataController extends Controller
{
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
            'element' => 'required|integer|min:0|max:19',
            'element_id' => 'required|integer|digits_between:1,10',
        ]);
        $contact_data = Contact_data::create($data);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contact.data.create', 'element' => getElementByName('contact_data'), 'element_id' => $contact_data->id, 'source' => 'contact.data.create']);
        return response()->json(['contact_data' => $contact_data, 'success' => 'Contact Data Added']);
    }

    /**
     * Get contact by id with json response.
     *
     * @param int $element_id
     * @param int $element
     * @return \Illuminate\Http\Response
     */
    public function getContactDataJsonByElementId(int $element_id, int $element)
    {
        $contact_datas = Contact_data::where('status', 1)->where('element', $element)->where('element_id', $element_id)->get();
        try {
            return view('contact_data.contact_data', compact('contact_datas'))->render();
        } catch (Throwable $e) {
            report($e);
            return view('contact_data.contact_data')->render();
        }
    }

    /**
     * Get contact by id with json response.
     *
     * @param int $element_id
     * @param int $element
     * @param string $class
     * @return \Illuminate\Http\Response
     */
    public function getContactDataByElement(int $element_id, int $element, string $class)
    {
        if ($class == 'sms')
            $class = [0, 1];
        else if ($class == 'email')
            $class = [3];
        else if ($class == 'call')
            $class = [0, 1, 2];

        if ($element == -1 || $element_id == -1) {
            $contact_datas = Contact_data::whereIn('class', $class)->get();
        } else {
            $contact_datas = Contact_data::where('element_id', $element_id)->where('element', $element)->whereIn('class', $class)->get();
        }

        return response()->json([$contact_datas]);
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
            'element' => 'required|integer|min:0|max:19',
            'element_id' => 'required|integer|digits_between:1,10',
        ]);
        Contact_data::find($request->id)->update($data);
        $contact_data = Contact_data::find($request->id);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contact.data.update', 'element' => getElementByName('contact_data'), 'element_id' => $contact_data->id, 'source' => 'contact.data.update']);
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
        $contact_data->status = 0;
        if ($contact_data->save()) {
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts.data.delete', 'element' => getElementByName('contact_data'), 'element_id' => $id, 'source' => 'contacts.data.delete, ' . $id]);
            return response()->json(['success' => 'This contact data has been Disabled !!!', 'contact_data' => $contact_data]);
        } else
            return response()->json(['error' => 'Failed to delete this contact data !!!']);
    }
}
