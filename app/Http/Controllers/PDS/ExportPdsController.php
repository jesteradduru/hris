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
        $education = $user->college_graduate_studies()->with('academic_award')->get();

        $sheetA = $spreadsheet->getSheetByName('A');
        
        if($personal_info){
            // personal info
            $sheetA->setCellValue('D10', ucfirst($personal_info['surname']));
            $sheetA->setCellValue('D11', ucfirst($personal_info['first_name']));
            $sheetA->setCellValue('D12', ucfirst($personal_info['middle_name']));
            $sheetA->setCellValue('N11', ucfirst($personal_info['name_extension']));
            $sheetA->setCellValue('D13', Carbon::parse($personal_info['date_of_birth'])->format('m-d-Y'));
            $sheetA->setCellValue('D15', ucfirst($personal_info['place_of_birth']));
            $sheetA->setCellValue('D16', ucfirst($personal_info['sex']));
            $sheetA->setCellValue('D22', ucfirst($personal_info['height']));
            $sheetA->setCellValue('D24', ucfirst($personal_info['weight']));
            $sheetA->setCellValue('D25', ucfirst($personal_info['blood_type']));
            $sheetA->setCellValue('D27', ucfirst($personal_info['gsis_id_number']));
            $sheetA->setCellValue('D29', ucfirst($personal_info['pagibig_id_number']));
            $sheetA->setCellValue('D32', ucfirst($personal_info['sss_number']));
            $sheetA->setCellValue('D31', ucfirst($personal_info['philhealth_number']));
            $sheetA->setCellValue('D33', ucfirst($personal_info['tin_number']));
            $sheetA->setCellValue('D34', ucfirst($personal_info['agency_employee_number']));
            $sheetA->setCellValue('I17', ucfirst($personal_info['r_address_house_block_lot_number']));
            $sheetA->setCellValue('L17', ucfirst($personal_info['r_address_street']));
            $sheetA->setCellValue('I19', ucfirst($personal_info['r_address_subdivision_village']));
            $sheetA->setCellValue('L19', ucfirst($personal_info['r_address_barangay']));
            $sheetA->setCellValue('I22', ucfirst($personal_info['r_address_city_municipality']));
            $sheetA->setCellValue('I24', ucfirst($personal_info['r_address_zipcode']));
            $sheetA->setCellValue('L22', ucfirst($personal_info['r_address_province']));
            $sheetA->setCellValue('I25', ucfirst($personal_info['p_address_house_block_lot_number']));
            $sheetA->setCellValue('L25', ucfirst($personal_info['p_address_street']));
            $sheetA->setCellValue('I27', ucfirst($personal_info['p_address_subdivision_village']));
            $sheetA->setCellValue('L27', ucfirst($personal_info['p_address_barangay']));
            $sheetA->setCellValue('I29', ucfirst($personal_info['p_address_city_municipality']));
            $sheetA->setCellValue('I31', ucfirst($personal_info['p_address_zipcode']));
            $sheetA->setCellValue('L29', ucfirst($personal_info['p_address_province']));
            $sheetA->setCellValue('I32', ucfirst($personal_info['telephone_number']));
            $sheetA->setCellValue('I33', ucfirst($personal_info['mobile_number']));
            $sheetA->setCellValue('I34', ucfirst($personal_info['email_address']));
            $sheetA->setCellValue('D17', ucfirst($personal_info['civil_status']));
            $sheetA->setCellValue('D17', 'Others: ' . ucfirst($personal_info['other_civil_status']));
            $sheetA->setCellValue('J13', $personal_info['filipino'] ? 'Filipino' : '');

            if($personal_info['dual_citizenship'] == 1){
                $sheetA->setCellValue('J15', 'Dual Citizenship');

                if($personal_info['by_birth'] == 1){
                    $sheetA->setCellValue('J15', 'Dual Citizenship (by birth)');
                }else if($personal_info['by_naturalization'] == 1){
                    $sheetA->setCellValue('J15', 'Dual Citizenship (by birth)');
                }

                $sheetA->setCellValue('J16', $personal_info['country']);
            }
            // dd($personal_info['by_birth'] == 1 ? 'Dual Citizenship (by birth)' : 'Dual Citizenship' );
            // $sheetA->setCellValue('J15', $personal_info['by_naturalization'] == 1 ? 'Dual Citizenship (by naturalization)' : 'Dual Citizenship');
            

            // end of personal info
            // checkbox not included
        }

        if($family_background){
            //family background
            $spouse_deceased = $family_background['spouse_deceased'] ? ' (deceased)' : '';
            $mothers_deceased = $family_background['mothers_deceased'] ? ' (deceased)' : '';
            $fathers_deceased = $family_background['fathers_deceased'] ? ' (deceased)' : '';

            $spreadsheet->getActiveSheet()->setCellValue('D36', ucfirst($family_background['spouse_surname']) . $spouse_deceased);
            $sheetA->setCellValue('D37', ucfirst($family_background['spouse_first_name']));
            $sheetA->setCellValue('H37', ucfirst($family_background['spouse_name_extension']));
            $sheetA->setCellValue('D38', ucfirst($family_background['spouse_middle_name']));
            $sheetA->setCellValue('D39', ucfirst($family_background['spouse_occupation']));
            $sheetA->setCellValue('D40', ucfirst($family_background['spouse_employer_business_name']));
            $sheetA->setCellValue('D41', ucfirst($family_background['spouse_business_address']));
            $sheetA->setCellValue('D42', ucfirst($family_background['spouse_telephone_number']));

            $sheetA->setCellValue('D43', ucfirst($family_background['fathers_surname']) . $fathers_deceased);
            $sheetA->setCellValue('D44', ucfirst($family_background['fathers_first_name']));
            $sheetA->setCellValue('H44', ucfirst($family_background['fathers_name_extension']));
            $sheetA->setCellValue('D45', ucfirst($family_background['fathers_middle_name']));

            $sheetA->setCellValue('D47', ucfirst($family_background['mothers_surname']). $mothers_deceased);
            $sheetA->setCellValue('D48', ucfirst($family_background['mothers_first_name']));
            $sheetA->setCellValue('D49', ucfirst($family_background['mothers_middle_name']));

            // children
            foreach($children as $key => $child){
                $child_deceased = $child['deceased'] ? ' (deceased)' : '';
                // dd($child);
                $sheetA->setCellValue('I'. 37 + $key, ucfirst($child['fullname']) . $child_deceased);
                $sheetA->setCellValue('M'. 37 + $key, Carbon::parse($child['date_of_birth'])->format('m-d-Y'));
            }
        }

        $elementary = $education->filter(function($value){
            return $value->type == 'ELEMENTARY';
        });

        // dd($elementary->count());
        // add rows
        for($i = 0; $i < $elementary->count() - 1; $i++){
            $sheetA->insertNewRowBefore(55);
            $sheetA->mergeCells('D55:F55');
            $sheetA->mergeCells('G55:I55');
        }

        // add data
        for($i = 0; $i < $elementary->count(); $i++){
            dd($elementary[$i]);
            $sheetA->setCellValue('D'. 54 + $i, $elementary[$i]->name_of_school );
            $sheetA->setCellValue('G'. 54 + $i, $elementary[$i]->basic_ed_degree_course );
            $sheetA->setCellValue('J'. 54 + $i, $elementary[$i]->period_from );
            $sheetA->setCellValue('K'. 54 + $i, $elementary[$i]->period_to );
            $sheetA->setCellValue('L'. 54 + $i, $elementary[$i]->highest_lvl_units_earned );
            $sheetA->setCellValue('M'. 54 + $i, $elementary[$i]->year_graduated );
            $sheetA->setCellValue('N'. 54 + $i, $elementary[$i]->type );
        }

        // if($elementary->count() > 1){
        //     $sheet = $sheetA;
            
        //     $sheet->insertNewRowBefore(55);
        //     $sheet->setCellValue('A1', 'Updated');
        // }



        // dd($elementary);




        $writer->save($path = storage_path('PDS.xlsx'));

        return response()->download($path);
    }
}
