<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FetchController extends Controller
{
    public function fetchCustomerType(){
        $customer_type = "[
  {
    \"CustomerTypeID\": 3,
    \"CustomerTypeName\": \"Lain\",
    \"CoUID\": \"2AD8CF8A-FC13-4921-BB18-DD579FDA5B08\",
    \"IsDisabled\": 0
  },
  {
    \"CustomerTypeID\": 6,
    \"CustomerTypeName\": \"Proyek\",
    \"CoUID\": \"43588D56-B90F-4F21-B93F-31BD7001E9AB\",
    \"IsDisabled\": 0
  },
  {
    \"CustomerTypeID\": 7,
    \"CustomerTypeName\": \"Pareto AP\",
    \"CoUID\": \"C744B49D-9279-447A-8281-CCFECAF4CE59\",
    \"IsDisabled\": 0
  },
  {
    \"CustomerTypeID\": 8,
    \"CustomerTypeName\": \"Pareto AR\",
    \"CoUID\": \"EA673877-43BC-4660-BA65-FBD14019FAEA\",
    \"IsDisabled\": 0
  },
  {
    \"CustomerTypeID\": 9,
    \"CustomerTypeName\": \"Toko AP\",
    \"CoUID\": \"10AEBD14-4FE6-42F5-B276-E7303A0FCE70\",
    \"IsDisabled\": 0
  },
  {
    \"CustomerTypeID\": 10,
    \"CustomerTypeName\": \"Toko AR\",
    \"CoUID\": \"0AB1A003-D0B3-43BA-906E-BAB912443945\",
    \"IsDisabled\": 0
  }
]";

        $json_result = json_decode($customer_type, true);


        return response()->json($json_result,200);
    }

    public function fecthSalesPerson(){
        $sales_person = "[
  {
    \"SalesPersonID\": 1,
    \"SalesPersonCode\": \"SF\",
    \"SalesPersonName\": \"Sufan\",
    \"Phone\": \"\",
    \"MobilePhone\": 77545658,
    \"Disabled\": 0,
    \"Remarks\": \"\",
    \"CoUID\": \"CDCDDBBB-42FF-41A9-B77A-ADD8342CFFED\",
    \"SalesPersonLevelID\": 2,
    \"SupervisorID\": 0,
    \"UserName\": \"\",
    \"StockCategoryID\": 0,
    \"Email\": \"\",
    \"CustomerAreaID\": 0,
    \"TeamID\": 0
  },
  {
    \"SalesPersonID\": 2,
    \"SalesPersonCode\": \"BS\",
    \"SalesPersonName\": \"Budi Salim\",
    \"Phone\": \"\",
    \"MobilePhone\": 8163112818,
    \"Disabled\": 0,
    \"Remarks\": \"\",
    \"CoUID\": \"32DE66B2-EC2B-4E85-A84F-25D9017A29ED\",
    \"SalesPersonLevelID\": 2,
    \"SupervisorID\": 0,
    \"UserName\": \"\",
    \"StockCategoryID\": 0,
    \"Email\": \"\",
    \"CustomerAreaID\": 0,
    \"TeamID\": 0
  },
  {
    \"SalesPersonID\": 3,
    \"SalesPersonCode\": \"AY\",
    \"SalesPersonName\": \"Adi Yamin\",
    \"Phone\": \"\",
    \"MobilePhone\": \"\",
    \"Disabled\": 0,
    \"Remarks\": \"\",
    \"CoUID\": \"A8B4C7DA-FD86-4AB2-9848-6970140DCEA5\",
    \"SalesPersonLevelID\": 2,
    \"SupervisorID\": 0,
    \"UserName\": \"\",
    \"StockCategoryID\": 0,
    \"Email\": \"\",
    \"CustomerAreaID\": 0,
    \"TeamID\": 0
  },
  {
    \"SalesPersonID\": 4,
    \"SalesPersonCode\": \"EF\",
    \"SalesPersonName\": \"Effendy\",
    \"Phone\": \"\",
    \"MobilePhone\": \"\",
    \"Disabled\": 0,
    \"Remarks\": \"\",
    \"CoUID\": \"DDDF79A9-1B44-47C8-87E0-06F5930FEEC6\",
    \"SalesPersonLevelID\": 2,
    \"SupervisorID\": 0,
    \"UserName\": \"\",
    \"StockCategoryID\": 0,
    \"Email\": \"\",
    \"CustomerAreaID\": 0,
    \"TeamID\": 0
  },
  {
    \"SalesPersonID\": 5,
    \"SalesPersonCode\": \"SH\",
    \"SalesPersonName\": \"Sim A Han\",
    \"Phone\": \"\",
    \"MobilePhone\": \"\",
    \"Disabled\": 0,
    \"Remarks\": \"\",
    \"CoUID\": \"03E191B9-DF89-4339-95AE-F29BD01D39D7\",
    \"SalesPersonLevelID\": 1,
    \"SupervisorID\": 0,
    \"UserName\": \"\",
    \"StockCategoryID\": 0,
    \"Email\": \"\",
    \"CustomerAreaID\": 0,
    \"TeamID\": 0
  },
  {
    \"SalesPersonID\": 6,
    \"SalesPersonCode\": \"H\",
    \"SalesPersonName\": \"Harry\",
    \"Phone\": \"\",
    \"MobilePhone\": \"\",
    \"Disabled\": 0,
    \"Remarks\": \"\",
    \"CoUID\": \"D1BB5496-960B-4452-8D57-83697531F1EC\",
    \"SalesPersonLevelID\": 3,
    \"SupervisorID\": 0,
    \"UserName\": \"\",
    \"StockCategoryID\": 0,
    \"Email\": \"\",
    \"CustomerAreaID\": 0,
    \"TeamID\": 0
  },
  {
    \"SalesPersonID\": 7,
    \"SalesPersonCode\": \"KW\",
    \"SalesPersonName\": \"Kwek Andy\",
    \"Phone\": \"\",
    \"MobilePhone\": \"\",
    \"Disabled\": 0,
    \"Remarks\": \"\",
    \"CoUID\": \"B606C34D-1CBA-44F9-99F2-D45F2F59049C\",
    \"SalesPersonLevelID\": 1,
    \"SupervisorID\": 0,
    \"UserName\": \"\",
    \"StockCategoryID\": 0,
    \"Email\": \"\",
    \"CustomerAreaID\": 0,
    \"TeamID\": 0
  }
]";
        $json_result = json_decode($sales_person, true);


        return response()->json($json_result,200);
    }

    public function fetchCustomer(){
        $customer = "[
  {
    \"CustomerID\": 1,
    \"CustomerCode\": \"A01\",
    \"CustomerName\": \"ADIL TOKO\",
    \"BillingAddressLine1\": \"JL. ASIA NO.186\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN (B)\",
    \"ShippingAddressLine1\": \"\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 4619000,
    \"MaxInvoiceAmount\": 1500000,
    \"Phone\": 617366887,
    \"Fax\": \"\",
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 9,
    \"CustomerAreaID\": 1,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 2,
    \"CustomerCode\": \"A05\",
    \"CustomerName\": \"ANTARA TOKO\",
    \"BillingAddressLine1\": \"JL. SUTRISNO.NO.83A/155\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN (B)\",
    \"ShippingAddressLine1\": \"JL. SUTRISNO.NO.83A/155\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"MEDAN (B)\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 15000000,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": 617368329,
    \"Fax\": 7320441,
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 9,
    \"CustomerAreaID\": 1,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 3,
    \"CustomerCode\": \"B06\",
    \"CustomerName\": \"BUKIT MAS TOKO (PADANG) GANTI KE R57-PAJAK\",
    \"BillingAddressLine1\": \"JL. HALIGO NO.2\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"PADANG\",
    \"ShippingAddressLine1\": \"JL. HALIGO NO.2\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"PADANG\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 40000000,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": \"075131781   F27985\",
    \"Fax\": \"\",
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 9,
    \"CustomerAreaID\": 2,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 4,
    \"CustomerCode\": \"C04\",
    \"CustomerName\": \"CAHAYA BARU TOKO\",
    \"BillingAddressLine1\": \"JL. G.SUBROTO NO. 148-A\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN (C)\",
    \"ShippingAddressLine1\": \"JL. G.SUBROTO NO. 148-A\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"MEDAN (C)\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 30000000,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": \"0614151174,082362130628, 0819615858\",
    \"Fax\": \"\",
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 9,
    \"CustomerAreaID\": 3,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 5,
    \"CustomerCode\": \"A08\",
    \"CustomerName\": \"ARIANTO DHARMAWAN PT\",
    \"BillingAddressLine1\": \"JL.S.PARMAN NO. 261 B\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN (C)\",
    \"ShippingAddressLine1\": \"JL.S.PARMAN NO. 261 B\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"MEDAN (C)\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 0,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": 614551777,
    \"Fax\": \"\",
    \"NPWP\": \"1.210.879.1.424\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 3,
    \"CustomerAreaID\": 2,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 6,
    \"CustomerCode\": \"K01\",
    \"CustomerName\": \"KARYA INDRA CV\",
    \"BillingAddressLine1\": \"JL. BAWEAN NO. 45\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN (B)\",
    \"ShippingAddressLine1\": \"\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 0,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": \"06177520478    0617031192\",
    \"Fax\": \"\",
    \"NPWP\": \"1.115.855.7.112\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 3,
    \"CustomerAreaID\": 4,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 7,
    \"CustomerCode\": \"L01\",
    \"CustomerName\": \"LARIZA PT\",
    \"BillingAddressLine1\": \"DI- TITI KUNING\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN\",
    \"ShippingAddressLine1\": \"\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 0,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": \"0617875428  0617875429\",
    \"Fax\": \"\",
    \"NPWP\": \"1.100.597.2.01\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 3,
    \"CustomerAreaID\": 4,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 8,
    \"CustomerCode\": \"N02\",
    \"CustomerName\": \"PT.NUSA RAYA CIPTA, Tbk\",
    \"BillingAddressLine1\": \"GRAHA CIPTA BUILDING LT.2\",
    \"BillingAddressLine2\": \"JL.DI.PANJAITAN NO.40\",
    \"BillingCity\": \"JAKARTA 13350\",
    \"ShippingAddressLine1\": \"GRAHA CIPTA BUILDING LT.2\",
    \"ShippingAddressLine2\": \"JL.DI.PANJAITAN NO.40\",
    \"ShippingCity\": \"JAKARTA 13350\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 1720000,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": \"061-4142284 pembelian Ibu Acu\",
    \"Fax\": \"0214157258, 061-4157258\",
    \"NPWP\": \"01.300.554.1-054.000\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 3,
    \"CustomerAreaID\": 5,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 9,
    \"CustomerCode\": \"N01\",
    \"CustomerName\": \"NAULI TOKO  (P. SIDEMPUAN)\",
    \"BillingAddressLine1\": \"JL.PATRICE LUMUMBA I NO. 7-E\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"P. SIDEMPUAN\",
    \"ShippingAddressLine1\": \"\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 150000000,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": \"0634-21082 - 715936\",
    \"Fax\": \"0634-22082\",
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 10,
    \"CustomerAreaID\": 6,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 10,
    \"CustomerCode\": \"N03\",
    \"CustomerName\": \"NAGA JAYA TOKO\",
    \"BillingAddressLine1\": \"JL. G.SUBROTO  150 FF\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN (C)\",
    \"ShippingAddressLine1\": \"JL. G.SUBROTO  150 FF\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"MEDAN (C)\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 265514000,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": \"0614525637 - 0614144426\",
    \"Fax\": 4148889,
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 7,
    \"CustomerAreaID\": 3,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 11,
    \"CustomerCode\": \"R02\",
    \"CustomerName\": \"RUSLIE TOKO\",
    \"BillingAddressLine1\": \"JLN. PERDANA NO. 87 (2126)\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN\",
    \"ShippingAddressLine1\": \"\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 5000000,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": 614514436,
    \"Fax\": \"\",
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 8,
    \"CustomerAreaID\": 3,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 12,
    \"CustomerCode\": \"R03\",
    \"CustomerName\": \"RAMAYANA PERABOT  (BINJEI)\",
    \"BillingAddressLine1\": \"JL. SUTOMO 51-53 BINJAI\",
    \"BillingAddressLine2\": \"A/K JL. SERDANG NO 19 A\",
    \"BillingCity\": \"MEDAN\",
    \"ShippingAddressLine1\": \"JL. SUTOMO 51-53 BINJAI\",
    \"ShippingAddressLine2\": \"A/K JL. SERDANG NO 19 A\",
    \"ShippingCity\": \"MEDAN\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 20000000,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": \"(T) 0618821929, 0618822534 ATUN -(P) 0618821125\",
    \"Fax\": \"\",
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 3,
    \"CustomerAreaID\": 4,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 13,
    \"CustomerCode\": \"R01\",
    \"CustomerName\": \"RAMAI TOKO\",
    \"BillingAddressLine1\": \"JL. SUN YET SEN NO. 32-H\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN (B)\",
    \"ShippingAddressLine1\": \"JL. SUN YET SEN NO. 32-H\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"MEDAN (B)\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 650000000,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": \"061-7320502/7367085\",
    \"Fax\": 7354004,
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 8,
    \"CustomerAreaID\": 1,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 14,
    \"CustomerCode\": \"S02\",
    \"CustomerName\": \"SAHABAT TOKO\",
    \"BillingAddressLine1\": \"JL. GANDHI NO. 39/19\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN (B)\",
    \"ShippingAddressLine1\": \"\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 50000000,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": \"617,367,174,085,100,000,000\",
    \"Fax\": \"\",
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 10,
    \"CustomerAreaID\": 1,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 15,
    \"CustomerCode\": \"S03\",
    \"CustomerName\": \"SAHABAT BARU TOKO\",
    \"BillingAddressLine1\": \"JL. G.SUBROTO  148 A/II (10B)\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN (C)\",
    \"ShippingAddressLine1\": \"JL. G.SUBROTO  148 A/II (10B)\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"MEDAN (C)\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 78160000,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": \"0614567968, 4568834, 06191240006\",
    \"Fax\": 4568834,
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 8,
    \"CustomerAreaID\": 3,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 16,
    \"CustomerCode\": \"S04\",
    \"CustomerName\": \"SEMPURNA TOKO (P.SIANTAR)\",
    \"BillingAddressLine1\": \"JL. SUTOMO NO. 280\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"P. SIANTAR\",
    \"ShippingAddressLine1\": \"\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 20000000,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": 62221666,
    \"Fax\": \"\",
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 9,
    \"CustomerAreaID\": 7,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 17,
    \"CustomerCode\": \"U01\",
    \"CustomerName\": \"UNITEX TOKO\",
    \"BillingAddressLine1\": \"JL PURI NO.49\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN (B)\",
    \"ShippingAddressLine1\": \"\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 0,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": 614572955,
    \"Fax\": \"\",
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 9,
    \"CustomerAreaID\": 8,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 18,
    \"CustomerCode\": \"A03\",
    \"CustomerName\": \"AGUNG JAYA U.D\",
    \"BillingAddressLine1\": \"JL. SUN YAT SEN NO. 16/28\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN\",
    \"ShippingAddressLine1\": \"JL. SUN YAT SEN NO. 16/28\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"MEDAN\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 0,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": \"0617347549  0617359934\",
    \"Fax\": \"\",
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 9,
    \"CustomerAreaID\": 1,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 19,
    \"CustomerCode\": \"S14\",
    \"CustomerName\": \"SUMATERA ROTANINDO P.T\",
    \"BillingAddressLine1\": \"JL. KL YOS SUDARSO KM 10,5\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN (A)\",
    \"ShippingAddressLine1\": \"\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 0,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": \"0616850140     0616850139\",
    \"Fax\": \"\",
    \"NPWP\": \"1.061.636.5.112\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 3,
    \"CustomerAreaID\": 4,
    \"NPPKP\": \"\"
  },
  {
    \"CustomerID\": 20,
    \"CustomerCode\": \"S15\",
    \"CustomerName\": \"SINAR SARI TOKO\",
    \"BillingAddressLine1\": \"JL. SUN YET SEN NO.33\",
    \"BillingAddressLine2\": \"\",
    \"BillingCity\": \"MEDAN (B)\",
    \"ShippingAddressLine1\": \"JL. SUN YET SEN NO.33\",
    \"ShippingAddressLine2\": \"\",
    \"ShippingCity\": \"MEDAN (B)\",
    \"PaymentTerm\": 30,
    \"CreditLimit\": 10000000,
    \"MaxInvoiceAmount\": 0,
    \"Phone\": 617368816,
    \"Fax\": 7369471,
    \"NPWP\": \"\",
    \"SalesPersonID\": 0,
    \"CustomerTypeID\": 9,
    \"CustomerAreaID\": 1,
    \"NPPKP\": \"\"
  }
]";
        $json_result = json_decode($customer, true);


        return response()->json($json_result,200);

    }

    public function fetchCustomerArea(){
        $customer_area = "[
  {
    \"CustomerAreaID\": 1,
    \"CustomerAreaName\": \"Medan02\",
    \"CoState\": \"New\",
    \"CoUID\": \"4B026CAB-BB4C-42D2-958A-8157C57BE262\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 2,
    \"CustomerAreaName\": \"DS\",
    \"CoState\": \"New\",
    \"CoUID\": \"4496F7BB-E82D-4EB9-A912-440E2960EB63\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 3,
    \"CustomerAreaName\": \"Medan05\",
    \"CoState\": \"New\",
    \"CoUID\": \"09784523-A525-416F-AA6D-9D23985D8E70\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 4,
    \"CustomerAreaName\": \"DS ProyInd\",
    \"CoState\": \"New\",
    \"CoUID\": \"D3C9B537-89FD-4D98-B35A-0F9E7106D87E\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 5,
    \"CustomerAreaName\": \"DS PJK\",
    \"CoState\": \"New\",
    \"CoUID\": \"9FB7B220-908E-450C-9AD9-EE81045714C5\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 6,
    \"CustomerAreaName\": \"S13\",
    \"CoState\": \"New\",
    \"CoUID\": \"5A7829F0-9915-44C8-8C21-300C07BD63F0\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 7,
    \"CustomerAreaName\": \"S17\",
    \"CoState\": \"New\",
    \"CoUID\": \"5B8050F9-7B4C-4FA0-8EC3-8E43B61E1168\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 8,
    \"CustomerAreaName\": \"Medan03\",
    \"CoState\": \"New\",
    \"CoUID\": \"27EB9D26-C43A-40F0-9438-1664892E9A19\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 9,
    \"CustomerAreaName\": \"Medan06\",
    \"CoState\": \"New\",
    \"CoUID\": \"57E45507-F61E-42FD-9BF7-918E810B7F9A\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 10,
    \"CustomerAreaName\": \"Medan01\",
    \"CoState\": \"New\",
    \"CoUID\": \"1BBB1357-CFC0-406E-A975-CA060476927A\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 11,
    \"CustomerAreaName\": \"S11\",
    \"CoState\": \"New\",
    \"CoUID\": \"704E2FBA-F2CE-45D1-A9AA-F69ABAAA0177\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 12,
    \"CustomerAreaName\": \"NAD\",
    \"CoState\": \"New\",
    \"CoUID\": \"1A0C5770-7EB3-48E0-A4FD-90A79CFBBD02\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 13,
    \"CustomerAreaName\": \"Yung Aceh\",
    \"CoState\": \"New\",
    \"CoUID\": \"9F1C40DA-79C1-46F5-AE9D-9098064196A3\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 14,
    \"CustomerAreaName\": \"Medan04\",
    \"CoState\": \"New\",
    \"CoUID\": \"991CB521-5C39-400D-9B34-97CFD296F908\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 15,
    \"CustomerAreaName\": \"S14\",
    \"CoState\": \"New\",
    \"CoUID\": \"B27926FC-5CF6-400A-8A16-6F26A8257746\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 16,
    \"CustomerAreaName\": \"S18\",
    \"CoState\": \"New\",
    \"CoUID\": \"D28B424A-828F-45B0-AEA4-97FE12EF0008\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 17,
    \"CustomerAreaName\": \"S15\",
    \"CoState\": \"New\",
    \"CoUID\": \"D9E7EBA4-8596-42F8-9EE1-C5E87A162A33\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 18,
    \"CustomerAreaName\": \"S12\",
    \"CoState\": \"New\",
    \"CoUID\": \"15B2ADC4-DC96-4029-9CDC-CEB796C4B002\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 19,
    \"CustomerAreaName\": \"DS AY\",
    \"CoState\": \"New\",
    \"CoUID\": \"D645BE7F-6FD9-47EC-8A70-C98AB0EA0681\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 20,
    \"CustomerAreaName\": \"S01\",
    \"CoState\": \"New\",
    \"CoUID\": \"8E187600-E0CF-4F62-AE0A-A067445A1ABF\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 21,
    \"CustomerAreaName\": \"S02\",
    \"CoState\": \"New\",
    \"CoUID\": \"BC8C7E36-3A15-4429-BFE2-99ABF7E713C5\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 22,
    \"CustomerAreaName\": \"S03\",
    \"CoState\": \"New\",
    \"CoUID\": \"8F7B37FA-4B5C-4B45-A3B5-05D4CB965342\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 23,
    \"CustomerAreaName\": \"S04\",
    \"CoState\": \"New\",
    \"CoUID\": \"D44421D2-FF40-45E0-97E4-1E858E5AF7FD\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 24,
    \"CustomerAreaName\": \"S05\",
    \"CoState\": \"New\",
    \"CoUID\": \"592D1D6E-E9BD-4C62-8C81-4BB8FB6C5595\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 25,
    \"CustomerAreaName\": \"S06\",
    \"CoState\": \"New\",
    \"CoUID\": \"5EF971DA-881E-48CE-ABD1-9C9028C36FA4\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 26,
    \"CustomerAreaName\": \"S07\",
    \"CoState\": \"New\",
    \"CoUID\": \"113B9449-A668-4E4E-B668-84F91CD24167\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 27,
    \"CustomerAreaName\": \"S08\",
    \"CoState\": \"New\",
    \"CoUID\": \"3E871BDE-C0A7-4574-AB3B-C0CA580FAF82\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 28,
    \"CustomerAreaName\": \"S09\",
    \"CoState\": \"New\",
    \"CoUID\": \"825E26C7-0BEB-40EB-9BB7-D7480F34AF1A\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 29,
    \"CustomerAreaName\": \"S10\",
    \"CoState\": \"New\",
    \"CoUID\": \"1BDB9FC7-17C8-40CD-90C7-27ABF6AEC37D\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 30,
    \"CustomerAreaName\": \"S19\",
    \"CoState\": \"New\",
    \"CoUID\": \"1EC79FB1-C789-474B-B246-9AD93A79394C\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 31,
    \"CustomerAreaName\": \"S20\",
    \"CoState\": \"New\",
    \"CoUID\": \"35275B08-DC47-4F89-BBE7-4DA606358556\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 32,
    \"CustomerAreaName\": \"B.ACEH\",
    \"CoState\": \"New\",
    \"CoUID\": \"94A91619-8CFC-4C24-9F42-0CED97057896\",
    \"CustomerAreaCode\": \"\",
    \"Kabupaten\": \"\"
  },
  {
    \"CustomerAreaID\": 33,
    \"CustomerAreaName\": \"S16\",
    \"CoState\": \"New\",
    \"CoUID\": \"02A2CECF-4A64-466E-A7B0-CD1CDFED3361\",
    \"CustomerAreaCode\": \"S16\",
    \"Kabupaten\": \"BINJAI,BRAHRANG,KUALA\"
  }
]";
        $json_result = json_decode($customer_area, true);


        return response()->json($json_result,200);
    }
}
