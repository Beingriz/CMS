<?php

namespace App\Http\Livewire\WhatsApp;

use Livewire\Component;
use Twilio\Rest\Client;
use App\Models\Message;
use Livewire\WithFileUploads;

class WhatsAppChatResponder extends Component
{
    use WithFileUploads;

    public $messages = [];
    public $messageBody = '';
    public $selectedUser = null;
    public $attachment;

    protected $listeners = ['messageReceived' => 'addMessage'];

    public function mount()
    {
        // Fetch existing messages from the database for the selected user
        $this->messages = Message::orderBy('created_at', 'asc')->get()->toArray();
    }

    public function sendMessage()
    {
        if (!$this->messageBody && !$this->attachment) {
            return;
        }

        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        $mediaUrl = null;

        // Handle attachment upload
        if ($this->attachment) {
            $path = $this->attachment->store('attachments', 'public');
            $mediaUrl = asset('storage/' . $path);
        }

        try {
            $messageOptions = [
                'from' => env('TWILIO_WHATSAPP_NUMBER'),
                'body' => $this->messageBody,
            ];

            // If there's an attachment, add media URL
            if ($mediaUrl) {
                $messageOptions['mediaUrl'] = [$mediaUrl];
            }

            $twilio->messages->create("whatsapp:" . $this->selectedUser, $messageOptions);

            // Store the message in the database
            Message::create([
                'user' => $this->selectedUser,
                'body' => $this->messageBody,
                'sent' => true,
                'attachment_url' => $mediaUrl,
                'read' => true, // Automatically mark sent messages as read
            ]);

            // Clear the form inputs
            $this->messageBody = '';
            $this->attachment = null;

            // Refresh message list
            $this->mount();
        } catch (\Exception $e) {
            session()->flash('error', 'Message failed to send: ' . $e->getMessage());
        }
    }

    public function addMessage($message)
    {
        // Store incoming message in the database
        Message::create([
            'user' => $message['user'],
            'body' => $message['body'],
            'sent' => false,
            'read' => false,
        ]);

        // Refresh message list
        $this->mount();

        // Notify the user
        $this->dispatchBrowserEvent('message-received', ['message' => $message]);
    }

    public function markAsRead($messageId)
    {
        $message = Message::find($messageId);
        $message->read = true;
        $message->save();

        // Refresh message list
        $this->mount();
    }

    public function render()
    {
        return view('livewire.whats-app.whats-app-responder');
    }
}
