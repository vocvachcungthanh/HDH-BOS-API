<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
// use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::getCompanyId($id);

        if ($company) {

            $hosting = $company->db_host . "%" . $company->db_port . "%" . $company->db_database . "%" . $company->db_user_name . "%" . $company->db_password;
            $company->db_h = Crypt::encryptString($hosting);

            return response()->json([
                'data' => [
                    'id'            => $company->id,
                    'name'          => $company->name,
                    'address'       => $company->address,
                    'phone'         => $company->phone,
                    'email'         => $company->email,
                    'logo'          => $company->logo,
                    'tin'           => $company->tin,
                    'website'       => $company->website,
                    'db_h'          => $company->db_h,
                    'created_at'    => $company->created_at,
                    'updated_at'    => $company->updated_at,
                ]
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' => "Công ty không tồn tại",

            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
