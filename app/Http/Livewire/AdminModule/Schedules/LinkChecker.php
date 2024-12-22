<?php

namespace App\Http\Livewire\AdminModule\Schedules;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LinkChecker extends Component
{
    public $url = 'https://ahara.karnataka.gov.in/nrc/PUBLIC_NEW_RATION_CARD/PUBLIC_NEW_RATION_CARD.aspx';  // URL to check
    public $keyword = 'suspended';    // Keyword to search
    public $statusMessage = '';       // Status message
    public $newSubscriber = '';       // New subscriber's Telegram ID

    /**
     * Check the status of the link and notify fetched chat IDs
     */
    public function checkLink()
    {
        try {
            $response = Http::timeout(10)->get($this->url);

            if ($response->successful()) {
                $content = strtolower($response->body());

                // Check if the keyword exists
                $currentStatus = (strpos($content, strtolower($this->keyword)) !== false) ? 'closed' : 'open';

                // Retrieve the last status from the database
                $previousStatus = DB::table('link_status')->where('url', $this->url)->value('status');

                // If status has changed, notify subscribers and update the status
                if ($currentStatus !== $previousStatus) {
                    $this->statusMessage = $this->generateStatusMessage($currentStatus);
                    $this->notifySubscribers($this->statusMessage);

                    // Update the stored status in the database
                    DB::table('link_status')->updateOrInsert(
                        ['url' => $this->url],
                        ['status' => $currentStatus, 'updated_at' => Carbon::now()]
                    );
                }
            } else {
                $this->statusMessage = "⚠️ The link is down. Status Code: " . $response->status();
            }
        } catch (\Exception $e) {
            $this->statusMessage = "❌ Error: " . $e->getMessage();
        }
    }
    // Generate the status message based on the current status
    private function generateStatusMessage($status)
    {
        $timestamp = Carbon::now()->format('F j, Y g:i A');

        if ($status === 'closed') {
            return "❌ The server is closed🔒 \n {$timestamp}. ";
        } else {
            return "✅ The server is open! You can Apply BPL or APL Ration Card now. 🎉\n\nTime: {$timestamp}";
        }
    }


    /**
     * Notify only fetched chat IDs
     */
    private function notifySubscribers($message)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatIds = $this->fetchChatIds();

        foreach ($chatIds as $chatId) {
            try {
                $this->sendTelegramMessage($chatId, $message);
            } catch (\Exception $e) {
                logger()->error("Failed to notify chat ID $chatId: " . $e->getMessage());
            }
        }
    }

    /**
     * Fetch chat IDs of users who interacted with the bot
     */
    private function fetchChatIds()
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot{$botToken}/getUpdates";

        try {
            $response = Http::get($url);
            $data = $response->json();

            $chatIds = [];

            if (isset($data['result']) && is_array($data['result'])) {
                foreach ($data['result'] as $update) {
                    if (isset($update['message']['chat']['id']) && $update['message']['chat']['type'] === 'private') {
                        $chatIds[] = $update['message']['chat']['id'];
                    }
                }
            }

            return array_unique($chatIds);
        } catch (\Exception $e) {
            logger()->error("Failed to fetch chat IDs: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Send a Telegram message to a specific chat ID
     */
    private function sendTelegramMessage($chatId, $message)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

        Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }

    public function render()
    {
        return view('livewire.admin-module.schedules.link-checker');
    }
}
