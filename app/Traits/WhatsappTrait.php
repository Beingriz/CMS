<?php

namespace App\Traits;

use App\Models\Application;
use App\Models\Templates;
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

    // Send a WhatsApp message using the Twilio API
    private function sendMessage($contentSid, $applicaiton, $contentVariables, $media_url=null)
    {
        $toNo = "whatsapp:+91".$applicaiton->Mobile_No;
        $template = Templates::where('template_sid', $contentSid)->first();
        try {
            $this->twilio->messages->create($toNo, [
                "from" => $this->fromNo,
                "body" => $template->body,
                "contentSid" => $contentSid,
                "mediaUrl" => $media_url,
                "contentVariables" => json_encode($contentVariables)
            ]);
            session()->flash('SuccessMsg', 'Message Sent!');
        } catch (\Exception $e) {
            session()->flash('Error', 'Message could not be sent: ' . $e->getMessage());
        }
        return redirect()->back();
    }


    public function userRegisterationAlert($mobile,$profileName, $username, $password)
    {
        $contentSid = 'HX362d409fe6a035e6b3480b3678f98478'; // Replace with your actual ContentSid
        $contentVariables = [
           "1" => trim($profileName),
            "2" => trim($username),
            "3" => trim($password),
        ];

        $body = "Hi *{{1}}*,\n\nWelcome to *Digital Cyber*! 🎉\n\nYour account has been successfully created. Here are your login details:\n\n🔑 *Login ID*: {{2}}\n🔒 *Password*: {{3}}\n\nYou can access your account Now.\n\nPlease keep your credentials secure and reach out if you have any questions.\n\n*Digital Cyber.*";

        $this->sendMessage($mobile, $body, $contentSid, $contentVariables);
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


    public function ApplicationRegisterAlert($app_id,$profileName)
    {

        $contentSid = 'HXf915685887d78e2aa3e8c9276b8fd8d2'; // Replace with your actual ContentSid

        // Get the template from the database
        $template = Templates::where('template_sid', $contentSid)->first();
        $contentVariables = json_decode($template->variables, true); // Decode JSON to array

        $application = Application::find($app_id);

        // Replace variables dynamically with client data
        foreach ($contentVariables as $key => $value) {
            // Replace each placeholder value with the corresponding client attribute
            $contentVariables[$key] = !empty(trim($application->{$value})) ? trim($application->{$value}) : trim($profileName);
            // Fallback to original value if attribute doesn't exist
        }
        $imageName = "leather-bag-gray.jpg";
        $media_url = "https://res.cloudinary.com/djgfhbe6o/image/upload/v1731178434/samples/ecommerce/{$imageName}";
        $this->sendMessage($contentSid, $application, $contentVariables, $media_url);
    }

    public function ApplicationUpdateAlert($mobile,$profileName, $applicantName, $service, $serviceType, $status, )
    {
        $contentSid = 'HX2220de0d0bffac9fa7d725dadd47e6f1'; // Replace with your actual ContentSid
        $contentVariables = [
            "1" => trim($profileName),
            "2" => trim($applicantName),
            "3" => trim($mobile),
            "4" => trim($service),
            "5" => trim($serviceType),
            "6" => trim($status)
        ];

        $body = "*Application Update Notification*\n\nDear *{{1}}*,\n\nWe are pleased to inform you of an update to your application. Please find the current details below:\n\n👤 **Name:** *{{2}}*\n📱 **Phone:** *+91{{3}}*\n📝 **Service:** *{{4}}*\n🔖 **Type:** *{{5}}*\n📋 **Status:** *{{6}}*\n\nTo review the status and track further progress, please log in to your account on our website.\n\n**Digital Cyber**\nThank you for trusting us to provide you with services.";

        $this->sendMessage($mobile, $body, $contentSid, $contentVariables);
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

            return  $this->sendMessage($mobile, $body, $contentSid, $contentVariables);
    }
}
