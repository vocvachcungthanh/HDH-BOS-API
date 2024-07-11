<?php

namespace App\Http\Controllers;

use App\Models\AccountType;

class AccountTypeController extends Controller
{
    public function index()
    {
        $accountType = AccountType::select('id', 'name')->get();

        return response()->json([
            'code' => '200',
            'data' => $accountType
        ], 200);
    }
}
