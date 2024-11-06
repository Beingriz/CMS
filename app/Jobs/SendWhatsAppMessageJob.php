<?php

namespace App\Jobs;

use App\Models\ClientRegister;
use App\Models\BulkMessageReport;
use App\Models\Templates;
use Twilio\Rest\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsAppMessageJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $client;
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
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        try {
            $message = $twilio->messages->create(
                "whatsapp:{$this->client->phone}",
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'body' => $this->template->template_body,
                    'mediaUrl' => $this->template->media_url ? [$this->template->media_url] : null,
                ]
            );

            BulkMessageReport::where('id', $this->reportId)->increment('successful_sends');

            \Log::info("WhatsApp message sent to {$this->client->phone}, Message SID: {$message->sid}");

        } catch (\Exception $e) {
            \Log::error("Failed to send WhatsApp message to {$this->client->phone}. Error: {$e->getMessage()}");
        }
    }
}
