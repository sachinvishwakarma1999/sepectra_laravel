<?php

namespace App\Http\Controllers;
//require 'vendor/autoload.php';

use App\InventoryProject;
use App\InventoryProjectItem;
use App\invoice;
use Illuminate\Http\Request;
use QuickBooksOnline\API\DataService\DataService;
use Session;

class InvoiceController extends Controller
{

  public function checktoken()
  {
    $dataService = DataService::Configure(array(
      'auth_mode' => 'OAUTH2',
      'ClientID' => "ABiQ3cuHAzfv8yLpNt3cWJyjOVi6XvGXTA1DxGCoGvyQp8pt1Z",
      'ClientSecret' => "R1kzzlXLSvwx5jxlBrLkS34CpstQDo6T2rAwp3aw",
      'RedirectURI' => "http://localhost:8000/page-customer-invoice",
      'scope' => "com.intuit.quickbooks.accounting",
      'baseUrl' => "Development"
    ));
    $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
    $authorizationCodeUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();
    header('Location: ' . $authorizationCodeUrl);
    die;
  }
  public function generate_pdf(Request $request)
  {

    // print_r($request->input('price'));
    // die;
    if (!empty($request->input('price'))) {
      $id = $request->input('updateid');
      $tooken = $request->input('updatetooken');
      $SyncToken = $request->input('updateSyncToken');
      $name = $request->input('name');
      $price = $request->input('price');
      $realmId = $request->input('realmId');

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sandbox-quickbooks.api.intuit.com/v3/company/4620816365155681470/invoice?minorversion=14',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "Deposit": 0,
    "AllowIPNPayment": false,
    "AllowOnlinePayment": false,
    "AllowOnlineCreditCardPayment": false,
    "AllowOnlineACHPayment": false,
    "domain": "QBO",
    "sparse": false,
    "Id": "'.$id.'",
    "SyncToken": "'.$SyncToken.'",
    "CustomField": [
      {
        "DefinitionId": "1",
        "Name": "Crew #",
        "Type": "StringType"
      }
    ],
    "DocNumber": "1041-Updated",
    "TxnDate": "2016-08-18",
    "CurrencyRef": {
      "value": "USD",
      "name": "United States Dollar"
    },
    "ExchangeRate": 1,
    "LinkedTxn": [],
    "Line": [
      {
        "Id": "1",
        "LineNum": 1,
        "Amount": "'.$price.'",
        "DetailType": "SalesItemLineDetail",
        "SalesItemLineDetail": {
          "ItemRef": {
            "value": "1",
            "name": "Services"
          },
          "TaxCodeRef": {
            "value": "NON"
          }
        }
      },
      {
        "Amount": "'.$price.'",
        "DetailType": "SubTotalLineDetail",
        "SubTotalLineDetail": {}
      }
    ],
    "TxnTaxDetail": {
      "TotalTax": 0
    },
    "CustomerRef": {
      "value": "1",
      "name": "Amy\'s Bird Sanctuary"
    },
    "BillAddr": {
      "Id": "2",
      "Line1": "4581 Finch St.",
      "City": "Bayshore",
      "CountrySubDivisionCode": "CA",
      "PostalCode": "94326",
      "Lat": "INVALID",
      "Long": "INVALID"
    },
    "ShipAddr": {
      "Id": "2",
      "Line1": "4581 Finch St.",
      "City": "Bayshore",
      "CountrySubDivisionCode": "CA",
      "PostalCode": "94326",
      "Lat": "INVALID",
      "Long": "INVALID"
    },
    "DueDate": "2016-09-17",
    "TotalAmt": 100,
    "HomeTotalAmt": 100,
    "ApplyTaxAfterDiscount": false,
    "PrintStatus": "NeedToPrint",
    "EmailStatus": "NotSet",
    "Balance": 100
  }',
  CURLOPT_HTTPHEADER => array(
    'User-Agent: QBOV3-OAuth2-Postman-Collection',
    'Accept: application/json',
    'Content-Type: application/json',
    'Authorization: Bearer ' . $tooken
   ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;$response;
Session::flash('message', 'Update Invoice Successfully!');
return redirect()->back();
//return redirect('checktoken');
die;
    }


    if (!empty($request->input('t'))) {
      $id = $request->input('id');
      $tooken = $request->input('t');
      $SyncToken = $request->input('st');
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sandbox-quickbooks.api.intuit.com//v3/company/4620816365155681470/invoice?operation=delete&minorversion=55',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
    "Id": "' . $id . '",
    "SyncToken": "' . $SyncToken . '"
}',
        CURLOPT_HTTPHEADER => array(
          'User-Agent: QBOV3-OAuth2-Postman-Collection',
          'Accept: application/json',
          'Content-Type: application/json',
          'Authorization: Bearer ' . $tooken
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      Session::flash('message', 'Delete Invoice Successfully!');
      return redirect()->back();
    }

    $id = $request->input('id');
    $tooken = $request->input('tooken');
    $SyncToken = $request->input('SyncToken');
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sandbox-quickbooks.api.intuit.com/v3/company/4620816365155681470/invoice/' . $id . '/pdf?minorversion=55',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_POSTFIELDS => '{
    "Id": "' . $id . '",
    "SyncToken": "' . $SyncToken . '"
}',
      CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer' . $tooken

      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
    die;
  }
  public function projectinventoryitem(Request $request)
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
      $dataService = DataService::Configure(array(
        'auth_mode' => 'OAUTH2',
        'ClientID' => "ABiQ3cuHAzfv8yLpNt3cWJyjOVi6XvGXTA1DxGCoGvyQp8pt1Z",
        'ClientSecret' => "R1kzzlXLSvwx5jxlBrLkS34CpstQDo6T2rAwp3aw",
        'RedirectURI' => "http://localhost:8000/page-customer-invoice",
        'scope' => "com.intuit.quickbooks.accounting",
        'baseUrl' => "Development"
      ));
      $code = $request->input('code');
      $realmId = $request->input('realmId');
      $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
      $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($code, $realmId);
      $accessTokenValue = $accessToken->getAccessToken();
      $request->session()->put('token', $accessTokenValue);
      $request->session()->put('tokentime', date('Y-m-d H:i:s'));
    }




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
      CURLOPT_POSTFIELDS => 'select * from invoice ',
      CURLOPT_HTTPHEADER => array(
        'User-Agent: QBOV3-OAuth2-Postman-Collection',
        'Accept: application/json',
        'Content-Type: application/text',
        'Authorization: Bearer ' . $accessTokenValue,
      ),
    ));

    $response = curl_exec($curl);


    $response = json_decode($response);

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sandbox-quickbooks.api.intuit.com/v3/company/4620816365155681470/query?minorversion=14',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'Select * from Customer ',
      CURLOPT_HTTPHEADER => array(
        'User-Agent: QBOV3-OAuth2-Postman-Collection',
        'Accept: application/json',
        'Content-Type: application/text',
        'Authorization: Bearer ' . $accessTokenValue,
       ),
    ));

    $customer = curl_exec($curl);
$customer = json_decode($customer);
//print_r($customer);


//die;
    $allprojects = InventoryProject::all();
    //$inventoryitems = InventoryProjectItem::orderBy('id')->get();
    return view('pages.customer-invoicePage')->with('allprojects', $allprojects)->with('invoicelist', $response)->with('token', $accessTokenValue)->with('customer', $customer);
  }


  public function getitemsproject(Request $request, $id)
  {

    $InventoryProjectItem = InventoryProjectItem::where('inventory_project_id', $id)->get();
    return $InventoryProjectItem;
  }

  public function store_invoice(Request $request)
  {

    // $dataService = DataService::Configure(array(
    //   'auth_mode' => 'OAUTH2',
    //   'ClientID' => "ABiQ3cuHAzfv8yLpNt3cWJyjOVi6XvGXTA1DxGCoGvyQp8pt1Z",
    //   'ClientSecret' => "R1kzzlXLSvwx5jxlBrLkS34CpstQDo6T2rAwp3aw",
    //   'RedirectURI' => "http://localhost:8000/page-customer-invoice",
    //   'scope' => "com.intuit.quickbooks.accounting",
    //   'baseUrl' => "Development"
    // ));
    // $code = $request->input('code');
    // $realmId = $request->input('realmId');

    $addinvoice = new invoice;
    $tooken = $request->input('tooken');
    $addinvoice->name = $request->input('name');
    $name = $request->input('name');
    $addinvoice->project_id = $request->input('project_id');
    $addinvoice->item_id = $request->input('item_id');
    $itemid = $request->input('item_id');
    $addinvoice->price = $request->input('price');
    $price = $request->input('price');
    $addinvoice->Total_Linear_FT = $request->input('Total_Linear_FT');
    $addinvoice->save();
    /* invoice create */

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sandbox-quickbooks.api.intuit.com/v3/company/4620816365155681470/invoice?minorversion=14',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
          "Line": [
            {
              "Amount": "' . $price . '",
              "DetailType": "SalesItemLineDetail",
              "SalesItemLineDetail": {
                "ItemRef": {
                  "value": "1",
                  "name": "' . $itemid . '"
                }
              }
            }
          ],
          "CustomerRef": {
            "value": "'.$name.'"
          }
        }',
      CURLOPT_HTTPHEADER => array(
        'User-Agent: QBOV3-OAuth2-Postman-Collection',
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer ' . $tooken,
        'Cookie: ivid_b=bfc04eb4-1f16-47d8-b0ad-9914f7472658; ajs_user_id=null; ajs_group_id=null; provisional_ivid=5d3595cf-6539-4606-95e2-489d485ee37f; ivid=476ca758-2380-4402-b28f-e7c6a18853c4; did=SHOPPER2_547dc515d17d62080efac0de74a2add0d0714184160323a268412bcc24b2375bfba691cbbb750b33a5368f94d81aec6a; s_fid=63FF2B9145DF6F9B-27FDC4E749354EC0; s_vi=[CS]v1|2FE0FCCE8515E60E-40000BC544EDF24D[CE]; ajs_anonymous_id=%22476ca758-2380-4402-b28f-e7c6a18853c4%22'
      ),
    ));
    $response = curl_exec($curl);
// print_r($response);
// die;
    curl_close($curl);
    Session::flash('message', 'Create Invoice Successfully!');
    return redirect()->back();
   // return redirect('checktoken');
  }
}
