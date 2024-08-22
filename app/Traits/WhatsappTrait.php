<?php

namespace App\Traits;

use Twilio\Rest\Client;

trait WhatsappTrait
{
    protected $twilio;
    protected $fromNo;

    public function __construct()
    {
        $this->twilio = new Client(getenv("TWILIO_SID"), getenv("TWILIO_AUTH_TOKEN"));
        $this->fromNo = "whatsapp:".getenv("TWILIO_PHONE_NUMBER");
    }

    private function sendMessage($mobile, $body, $contentSid, $contentVariables)
{
    $toNo = "whatsapp:+91" . $mobile;

    try {
        $this->twilio->messages->create($toNo, [
            "from" => $this->fromNo,
            "body" => $body,
            "contentSid" => $contentSid,
            "contentVariables" => json_encode($contentVariables)
        ]);

        session()->flash('Success', 'Message Sent!');
    } catch (\Exception $e) {
        session()->flash('Error', 'Message could not be sent: ' . $e->getMessage());
    }

    return redirect()->back();
}


    public function UserRegisterAlert($name, $mobile, $username)
    {
        $body = "🎉 **User Registration Success** 🎉\n\n"
            . "Hello *{$name}*,\n\n"
            . "👤 You are now officially registered with Digital Cyber!\n\n"
            . "📧 Username: {$username}\n"
            . "📱 Phone: {$mobile}\n\n"
            . "To access your account and explore our services, please log in to our website:\n"
            . "🔐 www.cyberpe.epizy.com\n\n"
            . "If you have any questions, feel free to reach out. Welcome to Digital Cyber!\n\n"
            . "Best regards,\n"
            . "*Digital Cyber.*\n"
            . "*+918892988334*";

            $contentSid=""; $contentVariables=[];

        return  $this->sendMessage($mobile, $body, $contentSid, $contentVariables);
    }

    public function EmployeeRegisterAlert($name, $mobile, $username)
    {
        $body = "🎉 **Welcome to Digital Cyber Family!** 🎉\n\n"
            . "Hello *{$name}*,\n\n"
            . "👤 You are now officially registered with Digital Cyber!\n\n"
            . "📧 Username: {$username}\n"
            . "📱 Phone: {$mobile}\n\n"
            . "To access your account and explore our services, please log in to our website:\n"
            . "🔐 www.cyberpe.epizy.com\n\n"
            . "If you have any questions, feel free to reach out. Welcome to Digital Cyber!\n\n"
            . "Best regards,\n"
            . "*Digital Cyber.*\n"
            . "*+918892988334*";
            $contentSid=""; $contentVariables=[];

        return  $this->sendMessage($mobile, $body, $contentSid, $contentVariables);

    }
    public function ApplicationRegisterAlert($mobile, $profileName, $applicantName, $service, $serviceType)
    {
        $contentSid = 'HXcdf92be43cbac16ae0b73cbb7600cc79'; // Replace with your actual ContentSid
        $contentVariables = [
            "1" => $profileName,
            "2" => $applicantName,
            "3" => $mobile,
            "4" => $service,
            "5" => $serviceType
        ];

        $body = "Hi *{{1}}*,\n\nCongratulations! 🎉\nA new application has been successfully registered with the following details:\n\n👤 Name: *{{2}}*\n📱 Phone: *+91{{3}}*\n📝 Service: *{{4}}*\n🔖 Type: *{{5}}*\n\nYou can log in to our website to track your application details:\n*Digital Cyber*.";

        $this->sendMessage($mobile, $body, $contentSid, $contentVariables);
    }



    public function ApplicationUpdateAlert($mobile, $applicantName, $service, $serviceType, $status, $reason)
    {
        $reasonText = $reason !== 'Not Available' ? "*Reason: {$reason}*" : "";
        $body = "Hi *{$applicantName}*,\n\n"
            . "🚀 Exciting news! 🚀\n"
            . "Your application status has been updated with the following details:\n\n"
            . "👤 Name: *{$applicantName}*\n"
            . "📱 Phone: *+91{$mobile}*\n"
            . "📝 Service: *{$service}*\n"
            . "🔖 Type: *{$serviceType}*\n"
            . "📊 New Status: *{$status}*\n"
            . "{$reasonText}\n\n"
            . "Thank you for choosing us!\n"
            . "You can log in to our website to track your application details:\n"
            . "🌐 www.cyberpe.epizy.com\n\n"
            . "*Digital Cyber*";

            $contentSid=""; $contentVariables=[];

            return  $this->sendMessage($mobile, $body, $contentSid, $contentVariables);
    }

    public function ApplicationByUserAlert($profileName, $mobile, $applicantName, $service, $serviceType)
    {
        $body = "Hi *{$profileName}*,\n\n"
            . "Congratulations! 🎉\n"
            . "A new application has been successfully submitted with the following details:\n\n"
            . "👤 Name: *{$applicantName}*\n"
            . "📱 Phone: *+91{$mobile}*\n"
            . "📝 Service: *{$service}*\n"
            . "🔖 Type: *{$serviceType}*\n\n"
            . "Thank you for choosing us!\n"
            . "You can log in to our website to track your application details:\n"
            . "🌐 www.cyberpe.epizy.com\n\n"
            . "*Digital Cyber*";

            $contentSid=""; $contentVariables=[];

            return  $this->sendMessage($mobile, $body, $contentSid, $contentVariables);    }
}
