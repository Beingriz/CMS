<?php

namespace App\Traits;

use Twilio\Rest\Client;


trait WhatsappTrait
{

    public $fromNo,$twilio;
    public function validateTwilio(){
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $this->fromNom = getenv("TWILIO_PHONE_NUMBER");
        $this->twilio = new Client($sid, $token);

    }
    public function UserRegisterAlert($name, $mobile, $username){
        $body = "🎉 **User Registration Success** 🎉\n\nHello *".$name."*\n\n,👤 You are now officially registered with Digital Cyber!\n\n📧 Username: ".$username."\n📱 Phone: ".$mobile."\n\nTo access your account and explore our services, please log in to our website:\n🔐 www.cyberpe.epizy.com\n\n\nIf you have any questions, feel free to reach out. Welcome to Digital Cyber!\n\nBest regards,\n*Digital Cyber.*\n*+918892988334*";
        $this->validateTwilio();

        $to_no = "whatsapp:+91" . $mobile;
        $from_no = "whatsapp:$this->fromNo";
        $this->twilio->messages
            ->create(
                $to_no, // to
                array(
                    "from" => $from_no,
                    "body" => $body
                )
            );
        session()->flash('Success', 'Message Sent!');
        return redirect()->back();

    }

    public function ApplicaitonRegisterAlert($mobile, $profile_name, $applicant_name, $service, $service_type)
    {
        $body = "Hi *" .trim($profile_name)."*,\n\nCongratulation! 🎉 \nA new application has been successfully registered with the following details:\n\n👤 Name : *" .trim($applicant_name)."* \n📱Ph : *+91" . trim($mobile)."* \n📝 Service :  *".trim($service)."* \n🔖 Type : *".trim($service_type)."* \n\nThank you for choosing us!\nFor your convenience, you can log in to our website to track your application details:\n🌐 www.cyberpe.epizy.com \n*Digital Cyber* ";

        $this->validateTwilio();

        $to_no = "whatsapp:+91" . $mobile;
        $from_no = "whatsapp:$this->fromNo";
        $this->twilio->messages
            ->create(
                $to_no, // to
                array(
                    "from" => $from_no,
                    "body" => $body
                )
            );
        session()->flash('Success', 'Message Sent!');
        return redirect()->back();
    }

    public function ApplicaitonUpdateAlert($mobile, $applicant_name, $service, $service_type,$status,$reason)
    {
        if($reason == 'Not Available'){
            $reason = "";
        }else{
            $reason = "*Reason: ".$reason."*";
        }
        $body = "Hi *" .trim($applicant_name)."*,\n\n🚀 Exciting news! 🚀 \nYour *application status* has been updated with following details:\n\n👤 Name : *" .trim($applicant_name)."* \n📱 Ph : *+91" . trim($mobile)."* \n📝 Service :  *".trim($service)."* \n🔖 Type : *".trim($service_type)."*\n📊 *New Status:* *".trim($status)."*  \n".$reason."\n\nThank you for choosing us!\nFor your convenience, you can log in to our website to track your application details:\n\n🌐 www.cyberpe.epizy.com \n\n*Digital Cyber* ";

        $this->validateTwilio();

        $to_no = "whatsapp:+91" . $mobile;
        $from_no = "whatsapp:$this->fromNo";
        $this->twilio->messages
            ->create(
                $to_no, // to
                array(
                    "from" => $from_no,
                    "body" => $body
                )
            );
        session()->flash('Success', 'Message Sent!');
        return redirect()->back();
    }
    public function ApplicationbyUserAlert($profile_name,$mobile, $applicant_name, $service, $service_type)
    {
       
        $body = "Hi *" .trim($profile_name)."*,\n\nCongratulation! 🎉 \nA new application has been successfully Submitted with the following details:\n\n👤 Name : *" .trim($applicant_name)."* \n📱Ph : *+91" . trim($mobile)."* \n📝 Service :  *".trim($service)."* \n🔖 Type : *".trim($service_type)."* \n\nThank you for choosing us!\nFor your convenience, you can log in to our website to track your application details:\n🌐 www.cyberpe.epizy.com \n*Digital Cyber* ";

        $this->validateTwilio();

        $to_no = "whatsapp:+91" . $mobile;
        $from_no = "whatsapp:$this->fromNo";
        $this->twilio->messages
            ->create(
                $to_no, // to
                array(
                    "from" => $from_no,
                    "body" => $body
                )
            );
        return redirect()->back();
    }
}
