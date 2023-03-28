<?php

namespace App\Http\Controllers\Api\Medicine;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\MedicineReminder;
use App\Http\Controllers\Controller;
use App\Models\ReminderLogs;

class MedicineController extends Controller
{
    public function createMedicine(Request $request)
    {

        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {
            $data = new Medicine();
            $data->medicine_name = $request->medicine_name;
            $data->medicine_type = $request->medicine_type;
            $data->medicine_color = $request->medicine_color;
            $data->potency_volume_medicine = $request->potency_volume_medicine;
            $data->medicine_name = $request->medicine_name;
            $data->medicine_quantity = $request->medicine_quantity;
            $data->before_afterMeal = $request->before_afterMeal;
            $data->interval = $request->interval;
            $data->notes = $request->notes;
            $data->created_by = auth()->user()->id;


            if ($request->has('medicine_prescription_picture')) {
                $fileName = time() . '_' . $request->medicine_prescription_picture->getClientOriginalName();
                $filePathAvatar = $request->file('medicine_prescription_picture')->storeAs('user/avatar', $fileName, 'public');
                $data->medicine_prescription_picture = $fileName;
            }
            if ($request->has('medicine_picture')) {
                $fileName = time() . '_' . $request->medicine_picture->getClientOriginalName();
                $filePathAvatar = $request->file('medicine_picture')->storeAs('user/avatar', $fileName, 'public');
                $data->medicine_picture = $fileName;
            }
            if ($data->save()) {
                return api_success('Medicine Created successfully', $data);
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }

    public function getMedicineList(Request $request)
    {

        $list = Medicine::where('created_by', auth()->user()->id)->where('medicine_name', 'like', '%' . $request->medicine_name . '%')->get();
        return response()->json(['status' => true, 'medicineList' => $list]);
    }

    public function getAppointmentDetails(Request $request)
    {

        $details = Medicine::where('id', $request->appointment_id)->where('created_by', auth()->user()->id)->first();
        if ($details) {
            return response()->json(['status' => true, 'data' => $details]);
        } else {
            return response()->json(['status' => false, 'data' => 'No Record Found.']);
        }
    }

    public function deleteMedicine(Request $request)
    {
        if (!auth('api')->check()) {
            return api_error('Message: Login required');
        }

        try {

            $data = Medicine::where('id', $request->medicine_id)->where('created_by', auth()->user()->id)->delete();
            $log_delete =  MedicineReminder::where('medicine_id', $request->medicine_id)->first();
            // MedicineReminder::where('medicine_id', $request->medicine_id)->delete();
            ReminderLogs::where('reminderable_id', $log_delete->id)->delete();
            $log_delete->delete();


            if (!empty($data)) {
                return api_success1('Medicine Deleted Successfully');
            } else {
                return api_success1('Medicine Not Found!');
            }
        } catch (\Exception $ex) {
            return api_error('message: ' . $ex->getMessage(), 500);
        }
    }
}
