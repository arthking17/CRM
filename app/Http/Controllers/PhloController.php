<?php

namespace App\Http\Controllers;

require '../vendor/autoload.php';
use Plivo\Resources\PHLO\PhloRestClient;
use Plivo\Exceptions\PlivoRestException;
use Illuminate\Http\Request;

class PhloController extends Controller
{
    public function triggerPhlo()
    {
        $client = new PhloRestClient("YOUR_AUTH_ID", "YOUR_AUTH_TOKEN");
        $phlo = $client->phlo->get("YOUR_PHLO_ID");
        try {
            $response = $phlo->run();
            echo json_encode($response);
        } catch (PlivoRestException $ex) {
            echo json_encode($ex);
        }
    }

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
        $client = new PhloRestClient("YOUR_AUTH_ID", "YOUR_AUTH_TOKEN");
        $phlo = $client->phlo->get("YOUR_PHLO_ID");
        try {
            $response = $phlo->run(["from" => $data['username'], "to" => $data['to'], "text" => $data['message']]); // username will be replace by phone number
            echo json_encode($response);
            return response()->json(['success' => 'SMS Sent to ' . $data['to']]);
        } catch (PlivoRestException $ex) {
            echo json_encode($ex);
            return response()->json(['error' => 'Error while sending that message !!!'], 300);
        }
    }
}
