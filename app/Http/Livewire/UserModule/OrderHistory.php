<?php

namespace App\Http\Livewire\UserModule;

use App\Models\QuickApply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class OrderHistory extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $client_id, $service_count, $available;

    public function mount($client_id,$deleteId)
    {
        $this->client_id = $client_id;
        if(!empty($deleteId)){
            $this->deleteUserOrder($deleteId);
        }
    }

    public function deleteUserOrder($id)
    {
        dd($id);
        $order = QuickApply::find($id);
        $user = Auth::user();
        if ($order) {
            // Delete file if it exists
            if ($order->file) {
                $filePath = public_path('storage/' . $order->file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Delete the order
            $order->delete();

            $this->dispatchBrowserEvent('swal:success', [
            'title' => 'Deleted!',
            'text' => 'Your application has been successfully submitted.',
            'icon' => 'success',
            'confirmButtonText' => 'OK',
            'redirectUrl' => route('orders', $user->Client_Id) // ✅ Correct redirect URL
        ]);
        }
    }


    public function render()
    {
        // $Services = DB::table('quick_apply')
        //         ->join('users', 'quick_apply.client_id', '=', 'users.Client_Id') // Fixed typo
        //         ->where('users.Client_Id', Auth::user()->Client_Id) // Filter by authenticated user
        //         ->where('quick_apply.status', 'Received') // Added status filter
        //         ->select('quick_apply.*')
        //         ->orderBy('quick_apply.created_at', 'desc')
        //         ->paginate(10);
        $Services = QuickApply::where('client_id', $this->client_id)->paginate(10);
        $this->service_count =  $Services->total();
        return view('livewire.user-module.order-history', compact('Services'));
    }
}
