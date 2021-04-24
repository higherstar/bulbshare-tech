<?php

namespace App\Http\Controllers;

use App\models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $CustomerCols = ['id', 'company', 'first_name', 'last_name', 'email_address', 'job_title', 'business_phone', 'address', 'city', 'zip_postal_code', 'country_region'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $customers = Customer::get();
        $cols = ['company' => 'Company', 'first_name' => 'First Name', 'last_name' => 'Last Name', 'email_address' => 'Email Address', 'job_title' => 'Job Title',
            'business_phone' => 'Business Phone', 'address' => 'Address', 'city' => 'City', 'zip_postal_code' => 'Zip Postal Code', 'country_region' => 'Country Region', 'id' => 'Action'];
        $data = compact('cols', 'customers');
        return view('customer', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    /*
     * Return Vendor list in json form
     */
    public function listCustomer()
    {
        extract(request()->all());
        $customers = Customer::query()
            ->orderBy($this->CustomerCols[$order[0]['column']], $order[0]['dir'])
            ->skip($start)
            ->where('first_name', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('last_name', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('company', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('address', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('city', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('country_region', 'LIKE', '%' . $search['value'] . '%')
            ->take($length)
            ->get();
        $count =Customer::query()
            ->orderBy($this->CustomerCols[$order[0]['column']], $order[0]['dir'])
            ->where('first_name', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('last_name', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('company', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('address', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('city', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('country_region', 'LIKE', '%' . $search['value'] . '%')
            ->count();
        $data = [
            'draw' => $draw,
            'recordsTotal' => Customer::count(),
            'recordsFiltered' => $count,
            'data' => $customers
        ];
        return response()->json($data);
    }
}