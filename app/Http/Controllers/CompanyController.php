<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CompanyInfo;
use App\Models\User;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function company()
    {
        $companylist = DB::table('companyinfo')
            ->orderBy('companyName', 'asc')
            ->get();

        return view('company.list_company', compact('companylist'));
    }

    public function companydetail(Request $request)
    {
        return view('company.company_detail');
    }

    public function createcompany()
    {
        return view('company.create_company');
    }

    public function storecompanyinfo(Request $request)
    {
        // create company
        $userID = Auth::user()->id;
        $companyName = $request->input('companyName');
        $companyPhoneNo = $request->input('companyPhoneNo');
        $companyAddress = $request->input('companyAddress');
        $companyIndustries = $request->input('companyIndustries');

        //update name
        $userinfo = User::where('id', $userID)->first();
        $userinfo->name = $request->input('companyName');
        // upadate query in the database
        $userinfo->update();

        $data = array(
            'companyName' => $companyName,
            'companyPhoneNo' => $companyPhoneNo,
            'companyEmail' => $userinfo->email,
            'companyAddress' => $companyAddress,
            'companyIndustries' => $companyIndustries,
        );
        
        // Update query
        DB::table('companyinfo')->where('userID', $userID)->update($data);
        

        sleep(1);
        return redirect()->route('finishform');
    }

    public function editcompany($id)
    {
        $companyinfo = DB::table('companyinfo')
            ->orderBy('companyName', 'asc')
            ->where('id', $id)
            ->first();
        return view('company.edit_company', compact('companyinfo'));
    }

    public function updatecompany(Request $request, $id)
    {
        $companyinfo = CompanyInfo::find($id);
        $companyinfo->companyName = $request->input('companyName');
        $companyinfo->companyEmail = $request->input('companyEmail');
        $companyinfo->companyPhoneNo = $request->input('companyPhoneNo');
        $companyinfo->companyAddress = $request->input('companyAddress');

        // upadate query in the database
        $companyinfo->update();

        // display message box in the same page
        return redirect()->back()->with('message', 'Company Info Updated Successfully');

    }
}
