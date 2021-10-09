<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Group;
use App\Models\Log;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 1) {
            $groups = Group::All();
            $accounts = Account::all();
            return view('groups.list', [
                'groups' => $groups,
                'accounts' => $accounts,
            ]);
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
        $data = $request->validate([
            'name' => 'required|min:3|unique:groups',
            'account_id' => 'required|exists:App\Models\Account,id',
        ]);
        $group = Group::create($data);
        Log::create(['contact_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts.groups.create', 'element' => getElementByName('groups'), 'element_id' => $group->id, 'source' => 'contacts.groups.create']);
        //return response()->json(['success' => 'New Group created !!!', 'group' => $group]);
        $groups = Group::orderBy('id', 'DESC')->get();
        $returnHTML = view('groups/datatable-groups', compact('groups'))->render();
        return response()->json(['success' => 'This group has been Added', 'html' => $returnHTML, 'group' => $group]);
    }

    /**
     * Get Group by id with json response.
     *
     * @param int $id
     * @param int $modal
     * @return \Illuminate\Http\Response
     */
    public function getGroupJsonById(int $id, int $modal)
    {
        $group = Group::all()
            ->find($id);
        //return $group;
        $contacts = Contact::orderBy('id', 'DESC')->where('account_id', $group->account_id)->take(10)->get();
        if ($modal == 0) {
            $contacts_companies = DB::table('contacts')->join('contacts_companies', 'contacts.id', '=', 'contacts_companies.id')
                ->select('contacts.id', 'contacts_companies.name', 'logo', 'activity')->get();
            $contacts_persons = DB::table('contacts')->join('contacts_persons', 'contacts.id', '=', 'contacts_persons.id')
                ->select('contacts.id', 'first_name', 'last_name', 'gender')->get();
            $html = view('groups.group-info', compact('group', 'contacts', 'contacts_persons', 'contacts_companies'))->render();
            return response()->json(['success' => 'Group Found !!!', 'html' => $html]);
        }
        if ($modal == 1)
            return response()->json($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'min:3',
                Rule::unique('groups')->ignore($request->id)
            ],
            'account_id' => 'required|exists:App\Models\Account,id',
        ]);
        Group::find($request->id)->update($data);
        Log::create(['contact_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts.groups.create', 'element' => getElementByName('groups'), 'element_id' => $request->id, 'source' => 'contacts.groups.create']);
        $group = Group::find($request->id);
        $group->account = $group->account[0];
        return response()->json(['success' => 'This group has been Updated', 'group' => $group]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $group = Group::find($id);
        if ($group->delete()) {
            Log::create(['contact_id' => Auth::id(), 'log_date' => new DateTime(), 'action' => 'contacts.groups.delete', 'element' => getElementByName('groups'), 'element_id' => $id, 'source' => 'contacts.groups.delete, ' . $id]);
            //return response()->json(['success' => 'Group Deleted !!!', 'group' => $group]);
            $groups = Group::All();
            $returnHTML = view('groups/datatable-groups', compact('groups'))->render();
            return response()->json(['success' => 'This group has been deleted', 'html' => $returnHTML, 'group' => $group]);
        } else
            return response()->json(['error' => 'Failed to delete this group !!!']);
    }
}
