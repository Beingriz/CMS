<?php

namespace App\Http\Livewire\AdminModule\DataMigration;

use App\Http\Livewire\DebitLedger;
use Illuminate\Auth\Events\Registered;

use App\Models\Application;
use App\Models\Bookmark;
use App\Models\ClientRegister;
use App\Models\CreditLedger;
use App\Models\CreditSource;
use App\Models\CreditSources;
use App\Models\Debit;
use App\Models\DebitSource;
use App\Models\DebitSources;
use App\Models\MainServices;
use App\Models\Old_Bookmarks;
use App\Models\Old_CreditLedger;
use App\Models\Old_CreditSources;
use App\Models\Old_Cyber_Data;
use App\Models\Old_DebitLedger;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\Hash;


class DataMigration extends Component
{
    public $Table, $OldServiceList, $Application, $Application_Type, $App_Id, $clinetReg = 0, $appReg = 0, $UnitPrice, $Category;
    public $digitalcyber = false, $creditsource = false, $debitsource = false, $bookmarks = false, $creditledger = false, $debitledger = false;
    public $username, $Branch_Id, $Emp_Id;

    public function mount()
    {
        $this->Branch_Id = Auth::user()->branch_id;
        $this->Emp_Id = Auth::user()->Emp_Id;
    }

    // Function to generate a random unique username
    private function generateUsername($name, $dob)
    {
        $username = ucfirst(Str::slug($name));
        $uniqueIdentifier = substr(time(), -4) . substr($dob ?? '0000', -2);
        $generatedUsername = $username . $uniqueIdentifier;

        // Ensure uniqueness by appending a random number if needed
        while (User::where('username', $generatedUsername)->exists()) {
            $generatedUsername = $username . rand(10, 99);
        }

        return $generatedUsername;
    }

    public function Migrate()
    {
        switch ($this->Table) {
            case 'old_digial_cyber_db':
                $this->migrateDigitalCyberDb();
                break;

            case 'old_credit_ledger':
                $this->migrateCreditLedger();
                break;

            case 'old_bookmark':
                $this->migrateBookmarks();
                break;

            case 'old_debit_ledger':
                $this->migrateDebitLedger();
                break;

            default:
                session()->flash('ErrorMsg', 'Invalid Table Selected');
        }
    }

    private function migrateDigitalCyberDb()
    {
        $service = MainServices::find($this->Application);
        $this->Application = $service ? $service->Name : 'Unknown Service';

        $records = Old_Cyber_Data::where('services', $this->OldServiceList)->get();

        foreach ($records as $item) {
            $mobile = $item['mobile_no'];
            if (empty($mobile) || empty($item['customer_name']) || $mobile == 0) {
                continue;
            }

            $clientRecord = ClientRegister::where('Mobile_No', $mobile)->first();

            if (is_null($clientRecord)) {
                $this->registerNewClient($item);
            } else {
                $this->saveApplication($clientRecord->Id, $item);
            }
        }

        session()->flash('SuccessMsg', "Clients {$this->clinetReg} & Applications {$this->appReg} Registered");
        $this->updateOldServiceList();
        $this->resetCounters();
    }

    private function registerNewClient($item)
    {
        $Client_Id = 'DC' . date('Y') . strtoupper(Str::random(3)) . rand(1000, 9999);
        $username = $this->generateUsername($item['customer_name'], $item['dob']);

        User::create([
            'Client_Id' => $Client_Id,
            'branch_id' => $this->Branch_Id,
            'Emp_Id' => $this->Emp_Id,
            'name' => ucwords(strtolower(trim($item['customer_name']))),
            'username' => $username,
            'mobile_no' => trim($item['mobile_no']),
            'Status' => 'user',
            'role' => 'user',
            'email' => "{$username}@example.com",
            'profile_image' => 'account.png',
            'password' => Hash::make($username),
        ]);

        ClientRegister::create([
            'Id' => $Client_Id,
            'Branch_Id' => $this->Branch_Id,
            'Emp_Id' => $this->Emp_Id,
            'Name' => ucwords(strtolower(trim($item['customer_name']))),
            'Relative_Name' => 'Not Available',
            'Gender' => 'Not Declared',
            'DOB' => $item['dob'] == '0000-00-00' ? null : $item['dob'],
            'Mobile_No' => $item['mobile_no'],
            'Email_Id' => 'Not Available',
            'Address' => 'Not Available',
            'Profile_Image' => 'account.png',
            'Client_Type' => 'Old Client',
        ]);

        $this->clinetReg++;
        $this->saveApplication($Client_Id, $item);
    }

    private function saveApplication($Client_Id, $item)
    {
        $App_Id = 'DCA' . date('Y') . strtoupper(Str::random(3)) . rand(1000, 9999);

        Application::create([
            'Id' => $App_Id,
            'Client_Id' => $Client_Id,
            'Branch_Id' => $this->Branch_Id,
            'Emp_Id' => $this->Emp_Id,
            'Received_Date' => $item['received_on'] == '0000-00-00' || $item['received_on'] == null ? date('Y-m-d') : $item['received_on'],
            'Name' => ucwords(strtolower(trim($item['customer_name']))),
            'Gender' => 'Not Declared',
            'Relative_Name' => 'Not Available',
            'Dob' => $item['dob'] == '0000-00-00' || $item['dob'] == null ? null : $item['dob'],
            'Mobile_No' => $item['mobile_no'],
            'Application' => $this->Application,
            'Application_Type' => $this->Application_Type,
            'Applied_Date' => $item['applied_on'] == '0000-00-00' || $item['applied_on'] == null ? null : $item['applied_on'],
            'Total_Amount' => $item['total_amount'],
            'Amount_Paid' => $item['amount_paid'],
            'Balance' => $item['balance'],
            'Payment_Mode' => $item['payment_mode'],
            'Status' => $item['status'] ?: 'Received',
            'Ack_No' => $item['ack_no'] ?: 'Not Available',
            'Registered' => 'Yes',
            'Delivered_Date' => $item['delivered_on'] == '' || $item['delivered_on'] == '0000-00-00' ? date('Y-m-d') : $item['delivered_on'],
            'created_at' => $item['received_on'] ?: null,
        ]);

        $this->appReg++;
    }

    // Function to migrate data from old credit ledger
    private function migrateCreditLedger()
    {
        $this->fetchCreditServiceData();
        $records = Old_CreditLedger::where('perticular', $this->OldServiceList)->get();
        foreach ($records as $item) {
            $this->migrateCreditRecord($item);
        }
        session()->flash('SuccessMsg', 'Entries ' . $this->appReg . ' Stored');
        $this->updateOldCreditSource();
        $this->resetCounters();
    }

    // Function to fetch credit service data
    private function fetchCreditServiceData()
    {
        $fetchserv = CreditSources::where('Source', $this->Application_Type)->where('CS_Id', $this->Application)->get();
        foreach ($fetchserv as $item) {
            $this->UnitPrice = $item['Unit_Price'];
        }
        $fetchserv = CreditSource::where('Id', $this->Application)->get();
        foreach ($fetchserv as $item) {
            $this->Application = $item['Name'];
        }
    }

    // Function to migrate a credit record
    private function migrateCreditRecord($item)
    {
        $Client_Id = 'DC' . date('Y') . strtoupper(Str::random(3)) . rand(000, 9999);
        $data = new CreditLedger();
        $data->fill([
            'Id' => 'DCCREDIT'. strtoupper(substr(md5(time() . rand()), 0, 16)),
            'Client_Id' => $Client_Id,
            'Branch_Id' => $this->Branch_Id,
            'Emp_Id' => $this->Emp_Id,
            $received_date = $item['date'],
            'Date' => $received_date,
            'Category' => $this->Application,
            'Sub_Category' => $this->Application_Type,
            'Unit_Price' => $this->UnitPrice,
            'Quantity' => $item['amount'] / $this->UnitPrice,
            'Total_Amount' => $item['amount'],
            'Amount_Paid' => $item['amount'],
            'Balance' => 0,
            'Description' => $item['description'],
            'Payment_Mode' => $item['payment_mode'],
            'Attachment' => 'no_image.jpg',
            'created_at' => $received_date ? \Carbon\Carbon::parse($received_date) : null,
        ]);
        $data->save();
        $this->appReg++;
    }

    // Function to migrate bookmarks
    private function migrateBookmarks()
    {
        $fetch = Old_Bookmarks::where('sl_no', $this->OldServiceList)->get();
        foreach ($fetch as $item) {
            $this->migrateBookmark($item);
        }
        session()->flash('SuccessMsg', 'Bookmarks ' . $this->appReg . ' Saved');
        $this->updateOldBookmark();
        $this->resetCounters();
    }

    // Function to migrate a single bookmark
    private function migrateBookmark($item)
    {
        $BM_Id = 'BM' . date('Y') . strtoupper(Str::random(3)) . rand(000, 9999);
        $save = new Bookmark();
        $save->fill([
            'BM_Id' => $BM_Id,
            'Name' => ucwords($item['name']),
            'Relation' => $this->Application,
            'Hyperlink' => $item['hyperlink'],
            'Thumbnail' => 'no_image.jpg',
        ]);
        $save->save();
        $this->appReg++;
    }

    // Function to migrate data from old debit ledger
    private function migrateDebitLedger()
    {
        $this->fetchDebitServiceData();
        $records = Old_DebitLedger::where('particular', $this->OldServiceList)->get();
        foreach ($records as $item) {
            $this->migrateDebitRecord($item);
        }
        session()->flash('SuccessMsg', 'Entries ' . $this->appReg . ' Stored');
        $this->updateOldDebitSource();
        $this->resetCounters();
    }

    // Function to fetch debit service data
    private function fetchDebitServiceData()
    {
        $fetchserv = DebitSource::where('Id', $this->Application)->get();
        foreach ($fetchserv as $item) {
            $this->Application = $item['Name'];
            $this->Category = $item['Category'];
        }

        $fetchserv = DebitSources::where('Name', $this->Application_Type)->where('DS_Name', $this->Application)->get();
        foreach ($fetchserv as $item) {
            $this->UnitPrice = $item['Unit_Price'];
        }
    }

    // Function to migrate a debit record
    private function migrateDebitRecord($item)
    {
        $Client_Id = 'DC' . date('Y') . strtoupper(Str::random(3)) . rand(000, 9999);
        $data = new Debit();
        $data->fill([
            'Id' => 'DCDEBIT' . strtoupper(substr(md5(time() . rand()), 0, 16)),
            'Client_Id' => $Client_Id,
            'Branch_Id' => $this->Branch_Id,
            'Emp_Id' => $this->Emp_Id,
            $received_date = $item['date'],
            'Date' => $received_date,
            'Category' => $this->Category,
            'Source' => $this->Application,
            'Name' => $this->Application_Type,
            'Unit_Price' => $this->UnitPrice,
            'Quantity' => $item['amount'] / ($this->UnitPrice == 0 ? 1 : $this->UnitPrice),
            'Total_Amount' => $item['amount'],
            'Amount_Paid' => $item['amount'],
            'Balance' => 0,
            'Description' => $item['description'],
            'Payment_Mode' => $item['payment_mode'],
            'Attachment' => 'no_image.jpg',
            'created_at' => $received_date ? \Carbon\Carbon::parse($received_date) : now(),
        ]);
        $data->save();
        $this->appReg++;
    }

    // Helper function to update the old service list status
    private function updateOldServiceList()
    {
        DB::table('old_service_list')->where('service_name', $this->OldServiceList)->update(['status' => 'Done']);
    }

    // Helper function to update the old credit source status
    private function updateOldCreditSource()
    {
        DB::table('old_credit_sources')->where('particular', $this->OldServiceList)->update(['Status' => 'Done']);
    }

    // Helper function to update the old bookmark status
    private function updateOldBookmark()
    {
        DB::table('old_bookmarks')->where('sl_no', $this->OldServiceList)->update(['status' => 'Done']);
    }

    // Helper function to update the old debit source status
    private function updateOldDebitSource()
    {
        DB::table('old_debit_source')->where('particular', $this->OldServiceList)->update(['Status' => 'Done']);
    }

    private function resetCounters()
    {
        $this->clinetReg = 0;
        $this->appReg = 0;
    }

    // Render function to determine the active section and fetch data for the view
    public function render()
    {
        $this->determineActiveSection();

        $old_servicelist = DB::table('old_service_list')->where('status', '!=', 'Done')->get();
        $old_creditsources = DB::table('old_credit_sources')->where('Status', '!=', 'Done')->get();
        $old_debitsources = DB::table('old_debit_source')->where('Status', '!=', 'Done')->get();
        $mainservices = DB::table('service_list')->get();
        $newSources = DB::table('credit_source')->get();
        $newDebitSources = DB::table('debit_source')->get();
        $subservices = DB::table('sub_service_list')->where('Service_Id', $this->Application)->get();
        $subSources = DB::table('credit_sources')->where('CS_Id', $this->Application)->get();
        $subDebitSources = DB::table('debit_sources')->where('DS_Id', $this->Application)->get();
        $old_bookmarks = DB::table('old_bookmarks')->where('status', '!=', 'Done')->get();

        return view('livewire.admin-module.data-migration.data-migration', compact('old_servicelist', 'mainservices', 'subservices', 'old_creditsources', 'old_debitsources', 'newSources', 'newDebitSources', 'subSources', 'subDebitSources', 'old_bookmarks'));
    }

    // Helper function to determine the active section based on the selected table
    private function determineActiveSection()
    {
        $this->digitalcyber = $this->Table == 'old_digial_cyber_db';
        $this->creditsource = $this->Table == 'old_credit_source';
        $this->debitsource = $this->Table == 'old_debit_source';
        $this->bookmarks = $this->Table == 'old_bookmark';
        $this->creditledger = $this->Table == 'old_credit_ledger';
        $this->debitledger = $this->Table == 'old_debit_ledger';
    }
}

