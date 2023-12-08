<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;

class Services extends Controller
{
    //
    public function index()
    {
        return view('Admin.Services.add_service');
    }
    public function Save(Request $request)
    {
        $id = 'DCS' . date("Y") . mt_rand(100, 999);
        $validate = $request->input();
        $thumbnail = $request->file('Thumbnail');
        $validate_rule = ['Name' => 'required'];
        $validation = Validator::make($request->input(), $validate_rule);
        if ($validation->fails()) {
            return redirect('add_service')->withInput()->withErrors($validation);
        } else {
            $save_service = new Service;
            $save_service->Id = $id;
            $save_service->Service_Name = $request->Name;
            $save_service->Total_Amount = 0;
            $save_service->Total_Applications = 0;
            $path = $request->file('Thumbnail')->store('Service_Thumbnails');
            $save_service->Thumbnail = "storage/app/" . $path;
            $save_service->save();
            return redirect('add_service')->with('SuccessMsg', 'Service
            Added Successfuly');
        }
    }
    public function Update(Request $request, $id)
    {
        $validate = $request->input();
        $details = DB::table('services')->where('Id', '=', $id)->get();
        foreach ($details as $key) {
            $key = get_object_vars($key); {
                $name = $key['Service_Name'];
            }
        }
        $thumbnail = $request->file('Thumbnail');
        $validate_rule = ['Name' => 'required'];
        $validation = Validator::make($request->input(), $validate_rule);
        if ($validation->fails()) {
            return redirect('add_service')->withInput()->withErrors($validation);
        } else {
            $path = $request->file('Thumbnail')->store('Service_Thumbnails');
            $path = "storage/app/" . $path;
            DB::update('update services set Service_Name=?, Thumbnail=? where Id=?', [$validate['Name'], $path, $id]);
            DB::update('update digital_cyber_db set Application_Type=? where Application_Type=?', [$validate['Name'], $name]);
            return redirect('add_service')->with('SuccessUpdate', 'Service Detials Updated Successfully');
        }
    }
    public function List()
    {
        $services = Service::paginate(5);
        $sl_no = Service::all()->count();
        $n = 1;
        return view('Admin.Services.add_service', ['services' => $services, 'n' => $n, 'sl_no' => $sl_no]);
    }
    public function View($id)
    {
        $services = Service::paginate(5);
        $service_view = Service::find($id);
        $sl_no = Service::all()->count();
        $n = 1;
        return view('Admin.Services.view_service', ['services' => $services, 'service_view' => $service_view, 'n' => $n, 'id' => $id, 'sl_no' => $sl_no]);
    }

    public function Delete($id)
    {
        DB::delete('delete from services where Id = ?', [$id]);
        return redirect('add_service')->with('SuccessMsg', 'Service Deleted Successfully');
    }
}
