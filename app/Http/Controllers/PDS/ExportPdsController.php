<?php

namespace App\Http\Controllers\PDS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

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
        $children = $user->children;
        $education=$user->college_graduate_studies;       
        
        if($personal_info){
            // personal info
            $spreadsheet->getSheetByName('A')->setCellValue('D10', ucfirst($personal_info['surname']));
            $spreadsheet->getSheetByName('A')->setCellValue('D11', ucfirst($personal_info['first_name']));
            $spreadsheet->getSheetByName('A')->setCellValue('D12', ucfirst($personal_info['middle_name']));
            $spreadsheet->getSheetByName('A')->setCellValue('N11', ucfirst($personal_info['name_extension']));
            $spreadsheet->getSheetByName('A')->setCellValue('D13', Carbon::parse($personal_info['date_of_birth'])->format('m-d-Y'));
            $spreadsheet->getSheetByName('A')->setCellValue('D15', ucfirst($personal_info['place_of_birth']));
            $spreadsheet->getSheetByName('A')->setCellValue('D16', ucfirst($personal_info['sex']));
            $spreadsheet->getSheetByName('A')->setCellValue('D22', ucfirst($personal_info['height']));
            $spreadsheet->getSheetByName('A')->setCellValue('D24', ucfirst($personal_info['weight']));
            $spreadsheet->getSheetByName('A')->setCellValue('D25', ucfirst($personal_info['blood_type']));
            $spreadsheet->getSheetByName('A')->setCellValue('D27', ucfirst($personal_info['gsis_id_number']));
            $spreadsheet->getSheetByName('A')->setCellValue('D29', ucfirst($personal_info['pagibig_id_number']));
            $spreadsheet->getSheetByName('A')->setCellValue('D32', ucfirst($personal_info['sss_number']));
            $spreadsheet->getSheetByName('A')->setCellValue('D31', ucfirst($personal_info['philhealth_number']));
            $spreadsheet->getSheetByName('A')->setCellValue('D33', ucfirst($personal_info['tin_number']));
            $spreadsheet->getSheetByName('A')->setCellValue('D34', ucfirst($personal_info['agency_employee_number']));
            $spreadsheet->getSheetByName('A')->setCellValue('I17', ucfirst($personal_info['r_address_house_block_lot_number']));
            $spreadsheet->getSheetByName('A')->setCellValue('L17', ucfirst($personal_info['r_address_street']));
            $spreadsheet->getSheetByName('A')->setCellValue('I19', ucfirst($personal_info['r_address_subdivision_village']));
            $spreadsheet->getSheetByName('A')->setCellValue('L19', ucfirst($personal_info['r_address_barangay']));
            $spreadsheet->getSheetByName('A')->setCellValue('I22', ucfirst($personal_info['r_address_city_municipality']));
            $spreadsheet->getSheetByName('A')->setCellValue('I24', ucfirst($personal_info['r_address_zipcode']));
            $spreadsheet->getSheetByName('A')->setCellValue('L22', ucfirst($personal_info['r_address_province']));
            $spreadsheet->getSheetByName('A')->setCellValue('I25', ucfirst($personal_info['p_address_house_block_lot_number']));
            $spreadsheet->getSheetByName('A')->setCellValue('L25', ucfirst($personal_info['p_address_street']));
            $spreadsheet->getSheetByName('A')->setCellValue('I27', ucfirst($personal_info['p_address_subdivision_village']));
            $spreadsheet->getSheetByName('A')->setCellValue('L27', ucfirst($personal_info['p_address_barangay']));
            $spreadsheet->getSheetByName('A')->setCellValue('I29', ucfirst($personal_info['p_address_city_municipality']));
            $spreadsheet->getSheetByName('A')->setCellValue('I31', ucfirst($personal_info['p_address_zipcode']));
            $spreadsheet->getSheetByName('A')->setCellValue('L29', ucfirst($personal_info['p_address_province']));
            $spreadsheet->getSheetByName('A')->setCellValue('I32', ucfirst($personal_info['telephone_number']));
            $spreadsheet->getSheetByName('A')->setCellValue('I33', ucfirst($personal_info['mobile_number']));
            $spreadsheet->getSheetByName('A')->setCellValue('I34', ucfirst($personal_info['email_address']));
            $spreadsheet->getSheetByName('A')->setCellValue('D17', ucfirst($personal_info['civil_status']));
            $spreadsheet->getSheetByName('A')->setCellValue('D17', 'Others: ' . ucfirst($personal_info['other_civil_status']));
            $spreadsheet->getSheetByName('A')->setCellValue('J13', $personal_info['filipino'] ? 'Filipino' : '');

            if($personal_info['dual_citizenship'] == 1){
                $spreadsheet->getSheetByName('A')->setCellValue('J15', 'Dual Citizenship');

                if($personal_info['by_birth'] == 1){
                    $spreadsheet->getSheetByName('A')->setCellValue('J15', 'Dual Citizenship (by birth)');
                }else if($personal_info['by_naturalization'] == 1){
                    $spreadsheet->getSheetByName('A')->setCellValue('J15', 'Dual Citizenship (by birth)');
                }

                $spreadsheet->getSheetByName('A')->setCellValue('J16', $personal_info['country']);
            }
            // dd($personal_info['by_birth'] == 1 ? 'Dual Citizenship (by birth)' : 'Dual Citizenship' );
            // $spreadsheet->getSheetByName('A')->setCellValue('J15', $personal_info['by_naturalization'] == 1 ? 'Dual Citizenship (by naturalization)' : 'Dual Citizenship');
            

            // end of personal info
            // checkbox not included
        }

        if($family_background){
            //family background
            $spouse_deceased = $family_background['spouse_deceased'] ? ' (deceased)' : '';
            $mothers_deceased = $family_background['mothers_deceased'] ? ' (deceased)' : '';
            $fathers_deceased = $family_background['fathers_deceased'] ? ' (deceased)' : '';

            $spreadsheet->getActiveSheet()->setCellValue('D36', ucfirst($family_background['spouse_surname']) . $spouse_deceased);
            $spreadsheet->getSheetByName('A')->setCellValue('D37', ucfirst($family_background['spouse_first_name']));
            $spreadsheet->getSheetByName('A')->setCellValue('H37', ucfirst($family_background['spouse_name_extension']));
            $spreadsheet->getSheetByName('A')->setCellValue('D38', ucfirst($family_background['spouse_middle_name']));
            $spreadsheet->getSheetByName('A')->setCellValue('D39', ucfirst($family_background['spouse_occupation']));
            $spreadsheet->getSheetByName('A')->setCellValue('D40', ucfirst($family_background['spouse_employer_business_name']));
            $spreadsheet->getSheetByName('A')->setCellValue('D41', ucfirst($family_background['spouse_business_address']));
            $spreadsheet->getSheetByName('A')->setCellValue('D42', ucfirst($family_background['spouse_telephone_number']));

            $spreadsheet->getSheetByName('A')->setCellValue('D43', ucfirst($family_background['fathers_surname']) . $fathers_deceased);
            $spreadsheet->getSheetByName('A')->setCellValue('D44', ucfirst($family_background['fathers_first_name']));
            $spreadsheet->getSheetByName('A')->setCellValue('H44', ucfirst($family_background['fathers_name_extension']));
            $spreadsheet->getSheetByName('A')->setCellValue('D45', ucfirst($family_background['fathers_middle_name']));

            $spreadsheet->getSheetByName('A')->setCellValue('D47', ucfirst($family_background['mothers_surname']). $mothers_deceased);
            $spreadsheet->getSheetByName('A')->setCellValue('D48', ucfirst($family_background['mothers_first_name']));
            $spreadsheet->getSheetByName('A')->setCellValue('D49', ucfirst($family_background['mothers_middle_name']));

            // children
            foreach($children as $key => $child){
                $child_deceased = $child['deceased'] ? ' (deceased)' : '';
                // dd($child);
                $spreadsheet->getSheetByName('A')->setCellValue('I'. 37 + $key, ucfirst($child['fullname']) . $child_deceased);
                $spreadsheet->getSheetByName('A')->setCellValue('M'. 37 + $key, Carbon::parse($child['date_of_birth'])->format('m-d-Y'));
            }
        }

        //group college
        $college = $education->filter(function($value){
            return $value->type === 'BACHELOR';
        });
        //get length
        $length=count($college);
        //add row
        $spreadsheet->getActiveSheet()->insertNewRowBefore(58, $length-1);
        $spreadsheet->getSheetByName('A')->setCellValue('B58', "COLLEGE");

        $writer->save($path = storage_path('PDS.xlsx'));

        return response()->download($path);
    }
}
