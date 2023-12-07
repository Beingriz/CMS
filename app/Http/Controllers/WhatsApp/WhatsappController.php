<?php

namespace App\Http\Controllers\WhatsApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;


class WhatsappController extends Controller
{
    //
    public function sendMessage($mobile,$name,$service,$time)
    {
        // $twilioSid = getenv("TWILIO_SID");;
        // $twilioToken = getenv("TWILIO_AUTH_TOKEN");
        // $twilioWhatsAppNumber = getenv("TWILIO_PHONE_NUMBER");
        // $recipientNumber = "+91".$mobile; // Replace with the recipient's phone number in WhatsApp format (e.g., "whatsapp:+1234567890")
        $body = "Dear *".$name."* 👋🏻😍
        ,
        ▶ Thank you for reaching out to us through our website with your Enquiry on *".$service." ".$time."* We appreciate your interest and would be more than happy to assist you.

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

        $message = $twilio->messages
                        ->create("whatsapp:".$mobile, // to
                                [
                                    "from" => "whatsapp:".$from,
                                    "body" => $body
                                ]
                        );

        return response()->json(['message' => 'WhatsApp message sent successfully'.$message]);
    }



}
