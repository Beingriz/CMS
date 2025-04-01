<?php

namespace App\Traits;

use App\Http\Livewire\UserModule\QuickApply;
use App\Models\Application;
use App\Models\QuickApply as ModelsQuickApply;
use App\Models\Templates;
use Twilio\Rest\Client;

trait WhatsappTrait
{
    protected $twilio;
    protected $fromNo;

    // ✅ Setter method to initialize Twilio Client (since __construct is not allowed in traits)
    public function initTwilio()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->twilio = new Client($sid, $token);
        $this->fromNo = "whatsapp:" . config('services.twilio.from');
    }

    // ✅ Generic Function to Send WhatsApp Messages via Twilio
    private function sendMessage($contentSid, $application, $contentVariables, $media_url = null)
    {
        $this->initTwilio(); // Ensure Twilio is initialized

        $toNo = "whatsapp:+91" . $application->mobile_no;
        $template = Templates::where('template_sid', $contentSid)->first();

        try {
            $this->twilio->messages->create($toNo, [
                "from" => $this->fromNo,
                "body" => $template->body,
                "contentSid" => $contentSid,
                "contentVariables" => json_encode($contentVariables),
            ]);

            session()->flash('SuccessMsg', 'WhatsApp Message Sent!');
        } catch (\Exception $e) {
            session()->flash('Error', 'Message could not be sent: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    // ✅ User Registration Confirmation on WhatsApp
    public function userRegisterationAlert($mobile, $profileName, $username, $password)
    {
        $contentSid = 'HX362d409fe6a035e6b3480b3678f98478'; // Replace with your actual ContentSid
        $contentVariables = [
            "1" => trim($profileName),
            "2" => trim($username),
            "3" => trim($password),
        ];

        $application = (object) [
            'mobile_no' => $mobile
        ];

        return $this->sendMessage($contentSid, $application, $contentVariables);
    }

    // ✅ Employee Registration Alert
    public function EmployeeRegisterAlert($name, $mobile, $username)
    {
        $body = "🎉 *Welcome to Digital Cyber Family!* 🎉\n\n"
            . "Hello *{$name}*,\n\n"
            . "👤 You are now officially registered with Digital Cyber!\n\n"
            . "📧 Username: {$username}\n"
            . "📱 Phone: {$mobile}\n\n"
            . "To access your account, visit:\n"
            . "🔐 www.cyberpe.epizy.com\n\n"
            . "For support, contact us at *+918892988334*.\n\n"
            . "*Digital Cyber*";

        $contentSid = '';
        $contentVariables = [];

        $application = (object) [
            'mobile_no' => $mobile
        ];

        return $this->sendMessage($contentSid, $application, $contentVariables);
    }

    // ✅ Application Submission Alert
    public function ApplicationRegisterAlert($app_id, $profileName)
    {
        $contentSid = 'HX9b1a41eba71b6a27b8df5e1e0f287288'; // Replace with your actual ContentSid
        $template = Templates::where('template_sid', $contentSid)->first();
        $contentVariables = json_decode($template->variables, true);

        $application = Application::find($app_id);

        foreach ($contentVariables as $key => $value) {
            $contentVariables[$key] = !empty(trim($application->{$value})) ? trim($application->{$value}) : trim($profileName);
        }
        $application = (object) [
            'mobile_no' => $application->Mobile_No
        ];

        return $this->sendMessage($contentSid, $application, $contentVariables);
    }

    // ✅ Application Update Alert
    public function applicationUpdateAlert($app_id, $profileName)
    {
        $contentSid = 'HXf37986fb67759b5973e7d557d1c03cd8';
        $template = Templates::where('template_sid', $contentSid)->first();
        $contentVariables = json_decode($template->variables, true);

        $application = Application::find($app_id);

        foreach ($contentVariables as $key => $value) {
            $contentVariables[$key] = !empty(trim($application->{$value})) ? trim($application->{$value}) : trim($profileName);
        }

        return $this->sendMessage($contentSid, $application, $contentVariables);
    }
    // ✅ Order Creation by User Alert
    public function orderbyUserAlert($app_id, $profileName)
    {
        $contentSid = 'HXcee906d98c76c183ef231e3e875d4035';
        $template = Templates::where('template_sid', $contentSid)->first();
        $contentVariables = json_decode($template->variables, true);

        $application = ModelsQuickApply::find($app_id);

        foreach ($contentVariables as $key => $value) {
            $contentVariables[$key] = !empty(trim($application->{$value})) ? trim($application->{$value}) : trim($profileName);
        }

        return $this->sendMessage($contentSid, $application, $contentVariables);
    }

    // ✅ New Application Submission Alert
    public function ApplicationByUserAlert($profileName, $mobile, $applicantName, $service, $serviceType)
    {
        $body = "Hi *{$profileName}*,\n\n"
            . "🎉 A new application has been successfully submitted! 🎉\n\n"
            . "👤 Name: *{$applicantName}*\n"
            . "📱 Phone: *+91{$mobile}*\n"
            . "📝 Service: *{$service}*\n"
            . "🔖 Type: *{$serviceType}*\n\n"
            . "You can track your application here:\n"
            . "🌐 www.cyberpe.epizy.com\n\n"
            . "*Digital Cyber*";

        $contentSid = '';
        $contentVariables = [];

        $application = (object) [
            'mobile_no' => $mobile
        ];

        return $this->sendMessage($contentSid, $application, $contentVariables);
    }
}
