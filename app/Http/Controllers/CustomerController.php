<?php

namespace App\Http\Controllers;

use App\models\Customer;
use App\models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCustomerRequest;

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
            'business_phone' => 'Business Phone', 'address' => 'Address', 'city' => 'City', 'zip_postal_code' => 'Zip Postal Code', 'country_region' => 'Country Region',
            'orders_count' => 'Orders Total', 'total_value' => 'Orders Total Value', 'id' => 'Action'];
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
     * @param CreateCustomerRequest $request
     * @return array
     */
    public function store(CreateCustomerRequest $request)
    {
        $data = $request->validated();
        $customer = Customer::create($data);

        $customer->save();

        return [
            'error' => false,
            'message' => 'Customer is created.',
        ];
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

    public function edit(int $id)
    {
        return Customer::findorfail($id);
    }

    public function update(int $id, CreateCustomerRequest $request)
    {
        //
        $data = $request->validated();
        $customer = Customer::find($id);

        try {
            $customer->fill($data);
            $customer->save();

            if($request->ajax()){
                $data = array(
                    'error' => false,
                    'message' => 'Customer is saved.'
                );
                return response()->json($data);
            }
        } catch (\Exception $e) {
            if($request->ajax()){
                $data = array(
                    'error' => true,
                    'message' => 'Error in saving Customer!.'
                );
                return response()->json($data);
            }
        }
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

        $query = Customer::query()
            ->withCount('orders')
            ->orderBy($this->CustomerCols[$order[0]['column']], $order[0]['dir'])
            ->where('first_name', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('last_name', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('company', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('address', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('city', 'LIKE', '%' . $search['value'] . '%')
            ->orWhere('country_region', 'LIKE', '%' . $search['value'] . '%');

        $count = $query->count();

        $customers = $query
            ->skip($start)
            ->take($length)
            ->get();

        foreach ($customers as $customer) {
            $customer->total_value = $customer->getTotalPrice();
        }

        $data = [
            'draw' => $draw,
            'recordsTotal' => Customer::count(),
            'recordsFiltered' => $count,
            'data' => $customers
        ];
        return response()->json($data);
    }

    /*
     * Delete Customer
     */
    public function delete (int $id, Request $request) {
        try {
            Order::query()
                ->where("customer_id", $id)
                ->update([
                    "customer_id" => null
                ]);

            $customer = Customer::findorfail($id);
            $customer->delete();

            if($request->ajax()){
                $data = array(
                    'error' => false,
                    'message' => 'Customer is removed.'
                );
                return response()->json($data);
            }
        } catch (\Exception $e) {

            if($request->ajax()){
                $data = array(
                    'error' => true,
                    'message' => 'Error in deleting Customer!'
                );
                return response()->json($data);
            }
        }
    }
}
