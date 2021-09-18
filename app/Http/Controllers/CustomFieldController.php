<?php

namespace App\Http\Controllers;

use App\Models\Contacts_field;
use App\Models\Custom_field;
use App\Models\Custom_select_field;
use App\Models\Log;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $custom_fields = Custom_field::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
        return view('contacts/custom-fields/list', compact('custom_fields'))->render();
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
            'name' => 'required|string|max:128',
            'tag' => 'required|string|max:64',
            'field_type' => 'required|string|max:32',
        ]);

        $account_id = array('account_id' => Auth::user()->account_id);
        $data = array_merge($data,  $account_id);
        
        if ($request->field_type == 'select') {
            $request->validate([
                'select_option' => 'required|string',
            ]);
            $custom_field = Custom_field::create($data);
            $options = explode(",", $request->select_option);
            foreach ($options as $key => $opt) {
                Custom_select_field::create(['field_id' => $custom_field->id, 'title' => $opt]);
            }
        } else
            $custom_field = Custom_field::create($data);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'custom-field.create', 'element' => getElementByName('custom_fields'), 'element_id' => $custom_field->id, 'source' => 'custom-field.create']);
        return response()->json(['success' => 'This Custom Field has been added !!!', 'custom-field' => $custom_field]);
    }

    /**
     * get custom_fied data for edit form.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $options = [];
        $custom_field = Custom_field::find($id);
        if($custom_field->field_type == 'select'){
            $options = Custom_select_field::where('field_id', $custom_field->id)->get();
        }
        return response()->json(['custom_field' => $custom_field, 'options' => $options]);
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
            'id' => 'required|exists:App\Models\Custom_field,id',
            'name' => 'required|string|max:128',
            'tag' => 'required|string|max:64',
            'field_type' => 'required|string|max:32',
        ]);
        $custom_field = Custom_field::find($request->id);

        $account_id = array('account_id' => Auth::user()->account_id);
        $data = array_merge($data,  $account_id);

        if ($request->field_type == 'select') {
            $request->validate([
                'select_option' => 'required|string',
            ]);
            $options = explode(",", $request->select_option);
            $select_options = Custom_select_field::where('field_id', $request->id)->get();
            foreach ($options as $key => $opt) {
                if($key < $select_options->count()){
                    $select_option = Custom_select_field::find($select_options[$key]->id);
                    $select_option->title = $opt;
                    $select_option->save();
                }else{
                    Custom_select_field::create(['field_id' => $custom_field->id, 'title' => $opt]);
                }
            }
        } else
            $custom_field->update($data);
        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'custom-field.update', 'element' => getElementByName('custom_fields'), 'element_id' => $custom_field->id, 'source' => 'custom-field.update']);
        return response()->json(['success' => 'This Custom Field has been Updated !!!', 'custom-field' => $custom_field]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $custom_field = Custom_field::find($id);
        $custom_field->status = 0;
        if ($custom_field->save()) {
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'custom-field.delete', 'element' => getElementByName('custom_fields'), 'element_id' => $id, 'source' => 'custom-field.delete, ' . $id]);
            return response()->json(['success' => 'This Custom Field has been Delete !!!', 'custom_field' => $custom_field]);
        } else
            return response()->json(['error' => 'Failed to disable this Field !!!']);
    }

    /**
     * Remove contact field.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteContactFieldFile(int $id)
    {
        $file = Contacts_field::find($id);
        Storage::delete('public/custom_field/' . $file->field_value);
        if ($file->delete()) {
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts_fields.delete', 'element' => getElementByName('contacts_fields'), 'element_id' => $id, 'source' => 'contacts_fields.delete, ' . $id]);
            return response()->json(['success' => 'This File has been Deleted !!!', 'file' => $file]);
        } else
            return response()->json(['error' => 'Failed to delete this file !!!']);
    }
}
