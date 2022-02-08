<?php

namespace App\Http\Controllers\Dashboard;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
class CompanyController extends Controller
{
    public function index(Request $request)
    {

      /*  $balancenational = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded'
        ])->post('https://taxes.like4app.com/online/check_balance', [
            'deviceId' => '4d2ec47930a1fe0706836fdd1157a8c320dfc962aa6d0b0df2f4dda40a27b2ba',
            'email' => 'sales@bn-plus.ly',
            'password' => '149e7a5dcc2b1946ebf09f6c7684ab2c',
            'securityCode' => '4d2ec47930a1fe0706836fdd1157a8c36bd079faa0810ff7562c924a23c3f415',
            'langId' => 1,
        ]);*/

       // return $balancenational ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMzI4OTk4NzZmNmM3YzQzMGM5ZDM0MjY2OWY4ZDVkYTI0Mjg3NzBkN2RkNTY0ZTk2YWFkOWVlZjQ3NjAxZTQ0M2JmZGU4NmM1OWNhOGIzN2EiLCJpYXQiOjE2NDQzNDIyOTcsIm5iZiI6MTY0NDM0MjI5NywiZXhwIjoxNzcwNTcyNjk3LCJzdWIiOiI3Iiwic2NvcGVzIjpbXX0.dIvjp4GiwF_OcixEk9MDV1qSJdkq4tKWC-WCLFU1TqIBxGRD4bmDv2TdBoG8s_b1w99-TliRDqtwDNZy0IjyO3j0-9YLBS4uHJ1Xmd9ouG1YVNGg424o4BkxQ4RMlBMVVDr5G5YBDn19Zjj0y-Qt-i8UGBmi4vDxZ1hvm5u7ZfNFV9lkbrg6SnUV54jeLJsf4RBYMRkrvA7Bbk3l_DfZEg65H8Kd3RPA2CYx3aSDus-dMtS3ZwRwbd0a1CpOmIuIjSTZmgD1GyzGGagKW1X-o997EYSYrf4SjjTx7nU7q9bgwaTNahmB3XKTErvYU2IP1MFKgKb1qvI2fu2zDTsnwOSFSGg6RSud6brIiWOZNNX1vjGKHR_o0XxVPKG8MmwjfGbhCS18JpJTIxYup4Ly-5FZOJILSa2O7SLZwbf5EdKSnu8kTixBXP6LPHJYRg-iM1awfpjzkDDKeo936gmFqDp3GikBsqzfAyFLCY0OdvphTGUoBhaHKPjsea6xwEKYuhLlpYe-UoUkmpW4p0HJ7WH6ZdOuViWw9rIqk-w1d9BBTqdRyx1pcoi90wjfIzYukFKus-S6AD4DJ5Z4ZVXF-S7kLxPoPSBLngW4azhUNdt8_b_7Dg-bhky3-pdJ9cQ70z7bG7Sl288lZ60Ae9XX_nkO-fS5a0rZEqFJsT3RkCI',
            'X-API-KEY' => '984adf4c-44e1-418f-829b'
        ])->post('https://api.plutus.ly/api/v1/transaction/sadadapi/verify', [
            'mobile_number' =>'201099922302',
            'birth_year' => '1993',
            'amount' => 20
        ]);
        return $response ;



        $Companies = Company::when($request->search, function ($q) use ($request) {

            return $q->where('name', '%' . $request->search . '%');

        })->latest()->paginate(5);

        return view('dashboard.Companies.index', compact('Companies'));

    }//end of index

    public function create()
    {
        return view('dashboard.Companies.create');

    }//end of create

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'kind'=>'required',
        ];
        
        $request->validate($rules);
        $request_data = $request->all();
        if ($request->company_image) {

            Image::make($request->company_image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/company/' . $request->company_image->hashName()));

            $request_data['company_image'] ='company/'. $request->company_image->hashName(); 

        }//end of if

        Company::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.Companies.index');

    }//end of store

    public function edit($id )
    {
        $category=Company::where('id',$id)->first();
        return view('dashboard.Companies.edit', compact('category'));

    }//end of edit

    public function update(Request $request,$id)
    {
        $category=Company::where('id',$id)->first();


        $request_data = $request->except(['_token', '_method']);
        if ($request->company_image) {

            if ($category->company_image != '') {

                Storage::disk('public_uploads')->delete('/company/' . $category->company_image);

            }//end of if

            Image::make($request->company_image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/company/' . $request->company_image->hashName()));

                $request_data['company_image'] ='company/'. $request->company_image->hashName(); 

        }//end of if



        Company::where('id',$id)->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.Companies.index');

    }//end of update

    public function destroy($id)
    {
        $category=Company::where('id',$id)->first();
        if ($category->company_image != '') {

            Storage::disk('public_uploads')->delete('/company/' . $category->company_image);

        }//end of if

        Company::where('id',$id)->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.Companies.index');

    }//end of destroy

}//end of controller
