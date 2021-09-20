<?php

namespace App\Http\Controllers;

require 'vendor/autoload.php';

use Illuminate\Http\Request;
use Plivo\RestClient;

class PhloController extends Controller
{
    /**
     * Send SMS via plivo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendSMS(Request $request)
    {
        //return $request;
        $data = $request->validate([
            'username' => 'required|exists:App\Models\Sms_account,username',
            'to' => 'required|string|max:128',
            'message' => 'required|string',
        ]);
        //$msg = plivo_send_text($data['to'], $data['message'], $data['from']);
        $client = new RestClient();
        $message_created = $client->messages->create(
            'the_source_number',
            ['the_destination_number'],
            'Hello, world!'
        );
        return response()->json(['success' => 'SMS Sent to ' . $data['to']]);
    }
}
