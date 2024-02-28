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

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");

        // load user
        $user = $request->user();
        $personal_info = $user->personal_information;  
        $family_background = $user->family_background;       
        
        if($personal_info){
            // personal info
            $spreadsheet->getActiveSheet()->setCellValue('C2', $personal_info['surname']);
            $spreadsheet->getActiveSheet()->setCellValue('D11', $personal_info['first_name']);
            $spreadsheet->getActiveSheet()->setCellValue('D12', $personal_info['middle_name']);
            $spreadsheet->getActiveSheet()->setCellValue('N11', $personal_info['name_extension']);
            $spreadsheet->getActiveSheet()->setCellValue('D13', $personal_info['date_of_birth']);
            $spreadsheet->getActiveSheet()->setCellValue('D15', $personal_info['place_of_birth']);
            $spreadsheet->getActiveSheet()->setCellValue('D16', $personal_info['sex']);
            $spreadsheet->getActiveSheet()->setCellValue('D22', $personal_info['height']);
            $spreadsheet->getActiveSheet()->setCellValue('D24', $personal_info['weight']);
            $spreadsheet->getActiveSheet()->setCellValue('D25', $personal_info['blood_type']);
            $spreadsheet->getActiveSheet()->setCellValue('D27', $personal_info['gsis_id_number']);
            $spreadsheet->getActiveSheet()->setCellValue('D29', $personal_info['pagibig_id_number']);
            $spreadsheet->getActiveSheet()->setCellValue('D32', $personal_info['sss_number']);
            $spreadsheet->getActiveSheet()->setCellValue('D31', $personal_info['philhealth_number']);
            $spreadsheet->getActiveSheet()->setCellValue('D33', $personal_info['tin_number']);
            $spreadsheet->getActiveSheet()->setCellValue('D34', $personal_info['agency_employee_number']);
            $spreadsheet->getActiveSheet()->setCellValue('I17', $personal_info['r_address_house_block_lot_number']);
            $spreadsheet->getActiveSheet()->setCellValue('L17', $personal_info['r_address_street']);
            $spreadsheet->getActiveSheet()->setCellValue('I19', $personal_info['r_address_subdivision_village']);
            $spreadsheet->getActiveSheet()->setCellValue('L19', $personal_info['r_address_barangay']);
            $spreadsheet->getActiveSheet()->setCellValue('I22', $personal_info['r_address_city_municipality']);
            $spreadsheet->getActiveSheet()->setCellValue('I24', $personal_info['r_address_zipcode']);
            $spreadsheet->getActiveSheet()->setCellValue('L22', $personal_info['r_address_province']);
            $spreadsheet->getActiveSheet()->setCellValue('I25', $personal_info['p_address_house_block_lot_number']);
            $spreadsheet->getActiveSheet()->setCellValue('L25', $personal_info['p_address_street']);
            $spreadsheet->getActiveSheet()->setCellValue('I27', $personal_info['p_address_subdivision_village']);
            $spreadsheet->getActiveSheet()->setCellValue('L27', $personal_info['p_address_barangay']);
            $spreadsheet->getActiveSheet()->setCellValue('I29', $personal_info['p_address_city_municipality']);
            $spreadsheet->getActiveSheet()->setCellValue('I31', $personal_info['p_address_zipcode']);
            $spreadsheet->getActiveSheet()->setCellValue('L29', $personal_info['p_address_province']);
            $spreadsheet->getActiveSheet()->setCellValue('I32', $personal_info['telephone_number']);
            $spreadsheet->getActiveSheet()->setCellValue('I33', $personal_info['mobile_number']);
            $spreadsheet->getActiveSheet()->setCellValue('I34', $personal_info['email_address']);
            $spreadsheet->getActiveSheet()->setCellValue('D17', $personal_info['civil_status']);

            // end of personal info
            // checkbox not included
        }

        if($family_background){
            //family background
            $spreadsheet->getActiveSheet()->setCellValue('D36', $family_background['spouse_surname']);
            $spreadsheet->getActiveSheet()->setCellValue('D37', $family_background['spouse_first_name']);
            $spreadsheet->getActiveSheet()->setCellValue('H37', $family_background['spouse_name_extension']);
            $spreadsheet->getActiveSheet()->setCellValue('D38', $family_background['spouse_middle_name']);
            $spreadsheet->getActiveSheet()->setCellValue('D39', $family_background['spouse_occupation']);
            $spreadsheet->getActiveSheet()->setCellValue('D40', $family_background['spouse_employer_business_name']);
            $spreadsheet->getActiveSheet()->setCellValue('D41', $family_background['spouse_business_address']);
            $spreadsheet->getActiveSheet()->setCellValue('D42', $family_background['spouse_telephone_number']);

            $spreadsheet->getActiveSheet()->setCellValue('D43', $family_background['fathers_surname']);
            $spreadsheet->getActiveSheet()->setCellValue('D44', $family_background['fathers_first_name']);
            $spreadsheet->getActiveSheet()->setCellValue('H44', $family_background['fathers_name_extension']);
            $spreadsheet->getActiveSheet()->setCellValue('D45', $family_background['fathers_middle_name']);

            $spreadsheet->getActiveSheet()->setCellValue('D47', $family_background['mothers_surname']);
            $spreadsheet->getActiveSheet()->setCellValue('D48', $family_background['mothers_first_name']);
            $spreadsheet->getActiveSheet()->setCellValue('D49', $family_background['mothers_middle_name']);
        }



        $writer->save($path = storage_path('PDS.xlsx'));

        return response()->download($path);
    }
}
