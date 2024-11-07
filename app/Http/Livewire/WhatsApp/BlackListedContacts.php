<?php

namespace App\Http\Livewire\WhatsApp;

use App\Models\BlacklistedContact;
use App\Models\ClientRegister;
use Carbon\Carbon;
use Livewire\Component;

class BlackListedContacts extends Component
{
    public $mobile_no, $clientId, $reason, $blockId,$isUnblock,$created,$updated,$unRegistered=false;

    protected $rules = [
        'mobile_no' => 'required | Min:10 | Max:10 ',
        'reason' => 'required',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount(){
        $this->blockId = 'BL'.time();
    }

    public function BlockContact($id)
    {
        $this->validate();
        $block =  new BlacklistedContact();
        $block->id = $this->blockId;
        $block->client_id = $this->clientId;
        $block->mobile_no = $this->mobile_no;
        $block->reason = $this->reason;
        $block->save();
        session()->flash('SuccessMsg', 'Client has been added to the blacklist.');
        $this->resetInput();
    }
    public function ResetFields(){
        $this->resetInput();
    }



    public function unBlock($id){
        $blacklistedContact = BlacklistedContact::where('client_id', $id)->first();

        if ($blacklistedContact) {
            // If contact exists in blacklist, delete it
            $blacklistedContact->delete();
        }
        session()->flash('SuccessMsg', 'Unblocked Sucessfully!.');
        return redirect()->route('whatsapp.blocklist');

    }
    public function LastUpdate()
    {
        $latest = BlacklistedContact::latest('created_at')->first();
        if($latest !=NULL){
            $this->created = Carbon::parse($latest['created_at'])->diffForHumans();
            $this->updated = Carbon::parse($latest['updated_at'])->diffForHumans();
        }

    }

    public function render()
    {
        $this->LastUpdate();
        if($this->mobile_no){

            $client = ClientRegister::where('Mobile_No',$this->mobile_no)->first();
            if($client){
                $this->clientId = $client->Id;
            }else{
                $this->clientId = 'Sorry! no record found!';
                $this->unRegistered=true;
            }
            $blacklistedContact = BlacklistedContact::where('mobile_no', $this->mobile_no)->first();
            if ($blacklistedContact) {
                // If contact exists in blacklist, delete it
                $this->isUnblock = true;
                $this->clientId = $blacklistedContact->client_id;
            }
        }
        $blocklist = BlacklistedContact::join('client_register', 'blacklisted_contacts.client_id', '=', 'client_register.id')
        ->join('branches', 'client_register.branch_id', '=', 'branches.branch_id') // Join with branches table
        ->select('client_register.*', 'blacklisted_contacts.reason', 'blacklisted_contacts.created_at', 'branches.name as branch_name') // Select columns from both tables
        ->paginate(10);


        return view('livewire.whats-app.black-listed-contacts', ['blocklist'=>$blocklist]);
    }
    private function resetInput()
    {
        $this->reset(['mobile_no', 'reason', 'clientId']);
    }
}
