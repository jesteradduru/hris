<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportPdsController extends Controller
{
    public function __invoke(Request $request)
    {
        $pdsfile='./pds/PDS.xlsx';
        /** Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($pdsfile);
        //dd($spreadsheet);
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        dd($request->user);
        $user = $request->user;
        $personal_info = $user->personal_information;

        dd($personal_info);

        //personal information
        $surName="Alvarez";
        $firstName="";
        $middleName= "";
        $nameExtension="";
        $dateofBirth="";
        $placeOfBirth= "";
        $height="";
        $weight="";
        $bloodtype= "";
        $gsis="";
        $pagibig= "";
        $bloodtype="";
        $philhealth="";
        $sss="";
        $tin="";
        $employeeNumber= "";
        $citizenship= "";
        $indicateCitizenship="";
        $telephoneNumber= "";
        $mobileNumber="";
        $emailAddress= "";
        
        //permanent address
        $phouseblock= "";
        $pstreet= "";
        $psubdvision = "";
        $pbarangay="";
        $pcity= "";
        $pprovince="";
        $pzipcode="";

        //residential address
        $rhouseblock= "";
        $rstreet= "";
        $rsubdvision = "";
        $rbarangay="";
        $rcity= "";
        $rprovince="";
        $rzipcode="";

        //family background
        


        



        $spreadsheet->getActiveSheet()->setCellValue('D10', $surName);






        $writer->save($path = storage_path('PDS.xlsx'));

        return response()->download($path);
    }
}
