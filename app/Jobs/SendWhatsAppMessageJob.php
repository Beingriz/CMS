<?php

namespace App\Jobs;

use App\Models\ClientRegister;
use App\Models\Application;
use App\Models\BulkMessageReport;
use App\Models\Templates;
use App\Traits\WhatsappTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;

class SendWhatsAppMessageJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, WhatsappTrait;

    protected $client;
    protected $application;
    protected $template;
    protected $reportId;

    public function __construct(ClientRegister $client, Templates $template, $reportId)
    {
        $this->client = $client;
        $this->template = $template;
        $this->reportId = $reportId;
    }

    public function handle()
    {
        // Initialize Twilio client
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        try {
            // Get the content SID and JSON variables from the template
            $contentSid = $this->template->template_sid;
            $contentVariables = json_decode($this->template->variables, true); // Decode JSON to array

            // Replace variables with data from both ClientRegister and Application
            foreach ($contentVariables as $key => $value) {
                // First check in ClientRegister, then in Application
                $contentVariables[$key] = $this->client->{$value} ?? $value;
            }

            // Send the message with updated content variables
            $this->sendMessage(
                $this->client->phone,
                $this->template->body,
                $contentSid,
                $contentVariables
            );

            // Update BulkMessageReport on successful send
            BulkMessageReport::where('id', $this->reportId)->increment('successful_sends');
            \Log::info("WhatsApp message sent to {$this->client->phone}");

        } catch (\Exception $e) {
            \Log::error("Failed to send WhatsApp message to {$this->client->phone}. Error: {$e->getMessage()}");
        }
    }
}
