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

        $body = "Dear *" . $name . "* 👋🏻😍
        ,
        ▶ Thank you for reaching out to us through our website with your Enquiry on *" . $service . " " . $time . "* We appreciate your interest and would be more than happy to assist you.

        ▶ Our team is currently reviewing your inquiry and will provide you with a detailed response as soon as possible. We understand the importance of your questions and aim to address them thoroughly and accurately.


        Best regards,
        *Digital Cyber*
        _The power to Empowe_
        *Call : +91 8892988334*
        *Call : +91 8951775912*";

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

        $notification = array(
            'message' => 'Message sent Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('update.dashboard', $page)->with($notification);
    }
}
