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
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $fromNo = "whatsapp:" . config('services.twilio.from');

        $this->twilio = new Client($sid, $token);
        $this->fromNo = "whatsapp:".config('services.twilio.from');
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

        $contentSid = 'HX9b1a41eba71b6a27b8df5e1e0f287288'; // Replace with your actual ContentSid

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
        $this->sendMessage($contentSid, $application, $contentVariables, null);
    }

    public function applicationUpdateAlert($app_id,$profileName)
    {
        $contentSid = 'HXf37986fb67759b5973e7d557d1c03cd8'; // Replace with your actual ContentSid
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
        $this->sendMessage($contentSid, $application, $contentVariables, null);
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
