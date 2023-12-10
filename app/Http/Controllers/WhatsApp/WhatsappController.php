<?php

namespace App\Http\Controllers\WhatsApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;



class WhatsappController extends Controller
{
    //
    public function sendMessage($mobile, $name, $service, $time, $page)
    {

        $body = "Hi ".$name.",

        Exciting news! 🎉
        A new application ".$service." registered:
        👤 ".$name."
        📱 ".$mobile."

        Thank you for choosing us!

        Digital Cyber";

        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $from = getenv("TWILIO_PHONE_NUMBER");
        $twilio = new Client($sid, $token);

        $to_no = "whatsapp:+91" . $mobile;
        $from_no = "whatsapp:$from";
        $twilio->messages
            ->create(
                $to_no, // to
                array(
                    "from" => $from_no,
                    "body" => $body
                )
            );

        // $notification = array(
        //     'message' => 'Message sent Successfully!',
        //     'alert-type' => 'success'
        // );
        session()->flash('Success', 'Message Sent!');
        return redirect()->back();
    }
    public function RegisteredAlert($mobile, $name, $service)
    {

        $body = "Hi ".$name.",

        Exciting news! 🎉
        A new application ".$service." registered:
        👤 ".$name."
        📱 ".$mobile."

        Thank you for choosing us!

        Digital Cyber";

        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $from = getenv("TWILIO_PHONE_NUMBER");
        $twilio = new Client($sid, $token);

        $to_no = "whatsapp:+91" . $mobile;
        $from_no = "whatsapp:$from";
        $twilio->messages
            ->create(
                $to_no, // to
                array(
                    "from" => $from_no,
                    "body" => $body
                )
            );

        // $notification = array(
        //     'message' => 'Message sent Successfully!',
        //     'alert-type' => 'success'
        // );
        session()->flash('Success', 'Message Sent!');
        return redirect()->back();
    }


}
