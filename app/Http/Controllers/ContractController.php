<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ContractController extends Controller
{
    //contract 
    public function contract()
    {
        $contractList = DB::table('contract')
            ->join('companyinfo', 'companyinfo.id', '=', 'contract.companyID')
            ->join('users', 'users.id', '=', 'contract.staffID')
            ->select([
                'companyinfo.companyName', 'contract.contractName', 'contract.contractStartDate', 'contract.contractEndDate', 'users.name', 'contract.contractAmount',
                DB::raw('COUNT(contract.id) AS totalContract'),
                DB::raw('COUNT(companyinfo.id) AS totalCompanyInfo'),
                DB::raw('MAX(contract.id) AS contractID')
            ])
            ->groupBy('companyinfo.companyName', 'contract.contractName', 'contract.contractStartDate', 'contract.contractEndDate', 'users.name','contract.contractAmount')
            ->orderBy('contract.id', 'desc')
            ->get();

        return view('contract.list_contract', compact('contractList'));
    }

    public function registerContract()
    {
        $companylist = DB::table('companyinfo')
            ->orderBy('companyName', 'asc')
            ->get();

        $contractorlist = DB::table('users')
            ->orderBy('name', 'asc')
            ->where('category', 'Contractor')
            ->get();

        return view('contract.register_contract', compact('companylist', 'contractorlist'));
    }

    public function storecontract(Request $request)
    {

        // Store inspection details
        $contractName = $request->input('contractName');
        $companyID = $request->input('companyID');
        $contractStartDate = $request->input('contractStartDate');
        $contractEndDate = $request->input('contractEndDate');
        $contractAmount = $request->input('contractAmount');

        // Retrieve selected contractor IDs and split them using the delimiter "/"
        $contractorIDs = $request->input('contractorID');

        // Loop through each contractor ID and save the records
        foreach ($contractorIDs as $index => $contractorID) {

            $data = array(
                'contractName' => $contractName,
                'contractStartDate' => $contractStartDate,
                'contractEndDate' => $contractEndDate,
                'companyID' => $companyID,
                'contractorID' => $contractorID,
                'staffID' => Auth::user()->id,
                'contractAmount' => $contractAmount,
            );

            // insert query
            DB::table('contract')->insert($data);
        }

        return redirect()->route('contract');
    }

    public function contractdetails($id)
    {
        $contract = DB::table('contract')
            ->join('companyinfo', 'companyinfo.id', '=', 'contract.companyID')
            ->where('contract.id', '=', $id)
            ->first();

        $contractorInfo = DB::table('contract')
            ->join('users', 'users.id', '=', 'contract.contractorID')
            ->leftJoin('contractorinfo', 'contractorinfo.userID', '=', 'contract.contractorID')
            ->where('contract.contractName', '=', $contract->contractName)
            ->get();

        return view('contract.contract_details', compact('contract', 'contractorInfo'));
    }
}
