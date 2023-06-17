<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\CompanyInfo;

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

    public function createcompany()
    {
        return view('company.create_company');
    }

    public function storecompanyinfo(Request $request)
    {
        // create company
        $name = $request->input('name');
        $email = $request->input('email');
        $phoneNo = $request->input('phoneNo');
        $address = $request->input('address');

        $Email = CompanyInfo::where('companyEmail', $email)->first();
        if ($Email) {
            return redirect()
                ->route('createcompany')
                ->with('message', 'Email is already exists.');
        }

        $data = array(
            'companyName' => $name,
            'companyEmail' => $email,
            'companyPhoneNo' => $phoneNo,
            'companyAddress' => $address,
        );

        // insert query
        DB::table('companyinfo')->insert($data);

        sleep(1);
        return redirect()->route('company');
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
