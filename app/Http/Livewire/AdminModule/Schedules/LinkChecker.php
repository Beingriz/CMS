<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LinkChecker extends Component
{
    public $url = 'https://ahara.karnataka.gov.in/nrc/PUBLIC_NEW_RATION_CARD/PUBLIC_NEW_RATION_CARD.aspx';  // URL to check
    public $keyword = 'form is open';            // Keyword to search
    public $statusMessage = '';                  // Status message
    public $subscribers = [];                    // List of subscribers
    public $newSubscriber = '';                  // New subscriber's Telegram ID

    public function mount()
    {
        $this->subscribers = DB::table('subscribers')->pluck('telegram_id')->toArray();
    }

    public function checkLink()
    {
        try {
            $response = Http::timeout(10)->get($this->url);

            if ($response->successful()) {
                $content = strtolower($response->body());

                if (strpos($content, strtolower($this->keyword)) !== false) {
                    $this->statusMessage = "✅ The form is available and open.";
                    $this->notifySubscribers($this->statusMessage);
                } else {
                    $this->statusMessage = "❌ The form is not available.";
                }
            } else {
                $this->statusMessage = "⚠️ The link is down. Status Code: " . $response->status();
            }
        } catch (\Exception $e) {
            $this->statusMessage = "❌ Error: " . $e->getMessage();
        }
    }

    public function notifySubscribers($message)
    {
        foreach ($this->subscribers as $subscriber) {
            $this->sendTelegramMessage($subscriber, $message);
        }
    }

    public function sendTelegramMessage($chatId, $message)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');

        Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }

    public function addSubscriber()
    {
        if (!in_array($this->newSubscriber, $this->subscribers)) {
            DB::table('subscribers')->insert(['telegram_id' => $this->newSubscriber]);
            $this->subscribers[] = $this->newSubscriber;
            $this->newSubscriber = '';
        }
    }
    public function render()
    {
        return view('livewire.admin-module.schedules.link-checker');
    }
}
