<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\ShortCode;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShortCodeController extends Controller
{
    /**
     * retrieve all shortcodes.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllShortCodes()
    {
        if(Auth::user()->role == 1){
            $shortcodes = ShortCode::all();
            return response()->json($shortcodes);
        }else if(Auth::user()->role == 2){
            $shortcodes = ShortCode::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
            return response()->json($shortcodes);
        }else{
            return response()->json(['message' => 'you do not have the necessary rights'], 300);
        }
    }

    /**
     * retrieve shordcode by id.
     *
     * @param int $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function get(int $id)
    {
        $shortcode = shortcode::find($id);
        return response()->json(['shortcode' => $shortcode]);
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
            'account_id' => 'required|exists:App\Models\Account,id',
            'name' => 'required|string|max:128',
            'country' => 'string|nullable|min:2|max:2',
        ]);

        $start_date = array('start_date' => today());
        $data = array_merge($data,  $start_date);

        $shortcode = ShortCode::create($data);

        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'shortcodes.create', 'element' => getElementByName('shortcodes'), 'element_id' => $shortcode->id, 'source' => 'shortcodes.create']);

        if(Auth::user()->role == 1){
            $shortcodes = ShortCode::all();
        }else if(Auth::user()->role == 2){
            $shortcodes = ShortCode::where('status', 1)->where('account_id', Auth::user()->account_id)->get();
        }else{
            $shortcodes = [];
            return response()->json(['message' => 'you do not have the necessary rights'], 300);
        }

        $returnHTML = view('shortcodes/list', compact('shortcodes'))->render();
        return response()->json(['success' => 'ShortCode Created', 'html' => $returnHTML, 'shortcode' => $shortcode]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShortCode  $shortCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //return $request;
        $data = $request->validate([
            'id' => 'required|exists:App\Models\ShortCode,id',
            'account_id' => 'required|exists:App\Models\Account,id',
            'name' => 'required|string|max:128',
            'country' => 'string|nullable|min:2|max:2',
        ]);

        $shortcode = ShortCode::find($request->id);
        $shortcode->update($data);

        Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'shortcodes.update', 'element' => getElementByName('shortcodes'), 'element_id' => $shortcode->id, 'source' => 'shortcodes.update']);

        $shortcode->account_id = $shortcode->account[0]->name;
        $shortcode->country = getCountryName($shortcode->country);
        return response()->json(['success' => 'ShortCode Updated', 'shortcode' => $shortcode]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $shortcode = ShortCode::find($id);
        $shortcode->status = 0;
        $shortcode->end_date = today();
        if ($shortcode->save()) {
            Log::create(['user_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'shortcodes.delete', 'element' => getElementByName('shortcodes'), 'element_id' => $id, 'source' => 'shortcodes.delete, ' . $id]);

            $shortcodes = ShortCode::where('status', 1)->get();
            $returnHTML = view('shortcodes.list', compact('shortcodes'))->render();
            return response()->json(['success' => 'ShortCode Deleted !!!']);
        } else
            return response()->json(['error' => 'Failed to delete this ShortCode !!!']);
    }
}
