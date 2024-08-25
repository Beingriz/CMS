<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class TwilioWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Add your logic here to handle the webhook data
        return response()->json(['status' => 'success'], 200);
    }
    public function handle(Request $request)
    {
        dd('received');
        $messageBody = $request->input('Body');
        $from = $request->input('From');
        $mediaUrl = $request->input('MediaUrl0'); // Twilio sends media URLs this way

        // Store incoming message in the database
        Message::create([
            'user' => $from,
            'body' => $messageBody,
            'sent' => false,
            'read' => false,
            'attachment_url' => $mediaUrl,
        ]);

        // Emit event to Livewire component
        \Livewire\Livewire::dispatch('messageReceived', [
            'user' => $from,
            'body' => $messageBody,
            'sent' => false,
            'attachment_url' => $mediaUrl,
        ]);

        return response('Message received', 200);
    }
}
