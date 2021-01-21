<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $to_time = strtotime($request->session()->get('tokentime'));
$from_time = strtotime(date('Y-m-d H:i:s'));
    $a= round(abs($to_time - $from_time) / 60,2);
    // print_r($a);
    // die;
    if($request->session()->has('token') && $a<50)
    {
      $accessTokenValue = $request->session()->get('token');
      $tokentime = $request->session()->get('tokentime');
    }else{
      return redirect('checktoken');
    }
        //
        $customers = Customer::orderBy('id','desc')->get();

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://sandbox-quickbooks.api.intuit.com/v3/company/4620816365155681470/query?minorversion=14',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'Select * from Customer order by Id desc',
          CURLOPT_HTTPHEADER => array(
            'User-Agent: QBOV3-OAuth2-Postman-Collection',
            'Accept: application/json',
            'Content-Type: application/text',
            'Authorization: Bearer '. $accessTokenValue  ),
        ));

        $response = curl_exec($curl);
$response = json_decode($response);

        // curl_close($curl);
        // echo "<pre>";
        // print_r( $response);

//die();
        return view('pages.page-customers-list')->with('customers',$response);
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
      $to_time = strtotime($request->session()->get('tokentime'));
      $from_time = strtotime(date('Y-m-d H:i:s'));
          $a= round(abs($to_time - $from_time) / 60,2);
          // print_r($request->session()->get('token'));
          // die;
          if($request->session()->has('token') && $a<50)
          {
            $accessTokenValue = $request->session()->get('token');
            $tokentime = $request->session()->get('tokentime');
          }else{
            return redirect('checktoken');
          }
        $inputs = $request->all();
        $Customer = new Customer;
        $Customer->first_name = $inputs['first_name'];
        $Customer->last_name = $inputs['last_name'];
        $Customer->email = $inputs['email'];
        $Customer->phone = $inputs['phone'];
        $Customer->address = $inputs['address'];
        $Customer->company_name = $inputs['company_name'];
        $Customer->save();
        $email=$inputs['email'];
        $firstname=$inputs['first_name'];
        $lastname=$inputs['last_name'];
        $phone=$inputs['phone'];
        $address=$inputs['address'];
        $company=$inputs['company_name'];
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sandbox-quickbooks.api.intuit.com/v3/company/4620816365155681470/customer',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
        "FullyQualifiedName": "'.$firstname.'",
        "PrimaryEmailAddr": {
          "Address": "'.$email.'"
        },
        "DisplayName": "'.$firstname.'",
        "Suffix": "Jr",
        "Title": "Mr",
        "MiddleName": "'.$lastname.'",
        "Notes": "Here are other details.",
        "FamilyName": "'.$firstname.'",
        "PrimaryPhone": {
          "FreeFormNumber": "'.$phone.'"
        },
        "CompanyName": "'.$company.'",
        "BillAddr": {
          "CountrySubDivisionCode": "",
          "City": " ",
          "PostalCode": " ",
          "Line1": "'.$address.'",
          "Country": " "
        },
        "GivenName": "'.$firstname.'"
      }',
      CURLOPT_HTTPHEADER => array(
        'User-Agent: QBOV3-OAuth2-Postman-Collection',
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer '. $accessTokenValue
        ),
    ));
  $response = curl_exec($curl);
//print_r($response);
    curl_close($curl);
   // die();

        Session::flash('message', 'Customer Created Successfully!');
        return redirect()->back();
    }

    public function storeajax(Request $request)
    {
        $inputs = $request->all();
        $Customer = new Customer;
        $Customer->first_name = $inputs['first_name'];
        $Customer->last_name = $inputs['last_name'];
        $Customer->email = $inputs['email'];
        $Customer->phone = $inputs['phone'];
        $Customer->address = $inputs['address'];
        $Customer->company_name = $inputs['company_name'];
        $Customer->save();
        return $Customer;
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Customre  $customre
     * @return \Illuminate\Http\Response
     */
    public function show(Customre $customre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customre  $customre
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $customer = Customer::where('id',$id)->first();
      if(!isset($customer->id))
      {
        Session::flash('message', 'Customre Not Found!');
        return redirect()->back();
      }else{
        return view('pages.page-customer-edit')->with('customer',$customer);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customre  $customre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $to_time = strtotime($request->session()->get('tokentime'));
      $from_time = strtotime(date('Y-m-d H:i:s'));
          $a= round(abs($to_time - $from_time) / 60,2);
          // print_r($a);
          // die;
          if($request->session()->has('token') && $a<50)
          {
            $accessTokenValue = $request->session()->get('token');
            $tokentime = $request->session()->get('tokentime');
          }else{
            return redirect('checktoken');
          }
        // Customer::where('id',$request->input('id'))->update(
        //   array(
        //     'first_name' => $request->input('first_name'),
        //     'last_name' => $request->input('last_name'),
        //     'email' => $request->input('email'),
        //     'company_name' => $request->input('company_name'),
        //     'address' => $request->input('address'),
        //     'phone' => $request->input('phone')
        //   )
        // );
        $id=$request->input('id');
        $firstname=$request->input('first_name');
        $lastname=$request->input('last_name');
        $email=$request->input('email');
        $company =$request->input('company_name');
        $address =$request->input('address');
         $phone=$request->input('phone');
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sandbox-quickbooks.api.intuit.com/v3/company/4620816365155681470/customer?minorversion=55',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "domain": "QBO",
    "PrimaryEmailAddr": {
      "Address": "'. $email.'"
    },
    "DisplayName": "'.$firstname.'",
    "PreferredDeliveryMethod": "Print",

    "FullyQualifiedName": "'.$firstname.$lastname.'",
    "BillWithParent": "",
    "Job": "",
    "BalanceWithJobs":"",
    "PrimaryPhone": {
      "FreeFormNumber": "'.$phone.'"
    },
    "Active": true,

    "BillAddr": {
      "City": "",
      "Line1": "'.$address.'",
      "PostalCode": "",
      "Lat": "",
      "Long": "",
      "CountrySubDivisionCode": ""

    },
    "MiddleName": "'.$lastname.'",
    "Taxable": "",
    "Balance":"",
    "CompanyName": "'.$company.'",
    "FamilyName": "'.$firstname.'",
    "Id": "'.$id.'"
  }',
  CURLOPT_HTTPHEADER => array(
    'User-Agent: QBOV3-OAuth2-Postman-Collection',
    'Accept: application/json',
    'Content-Type: application/json',
    'Authorization: Bearer '.$accessTokenValue ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
//die;
        Session::flash('message', 'Customer Updated Successfully!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customre  $customre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
  {
      //Customer::where('id',$id)->delete();
      $to_time = strtotime($request->session()->get('tokentime'));
      $from_time = strtotime(date('Y-m-d H:i:s'));
          $a= round(abs($to_time - $from_time) / 60,2);
          // print_r($a);
          // die;
          if($request->session()->has('token') && $a<50)
          {
            $accessTokenValue = $request->session()->get('token');
            $tokentime = $request->session()->get('tokentime');
          }else{
            return redirect('checktoken');
          }
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sandbox-quickbooks.api.intuit.com/v3/company/4620816365155681470/customer',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "domain": "QBO",
    "sparse": true,
    "Id": "'.$id.'",
    "SyncToken": "0",
    "Active": false
}',
  CURLOPT_HTTPHEADER => array(
    'User-Agent: QBOV3-OAuth2-Postman-Collection',
    'Accept: application/json',
    'Content-Type: application/json',
    'Authorization: Bearer '.$accessTokenValue

  ),
));

$response = curl_exec($curl);

curl_close($curl);
      Session::flash('message', 'Customer Deleted Successfully!');
      return redirect()->back();
  }
}
