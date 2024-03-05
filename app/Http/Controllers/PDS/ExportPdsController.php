<?php

namespace App\Http\Controllers\PDS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpParser\Node\Stmt\Else_;

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
        $civil_service_eligibility = $user->civil_service_eligibility;
        $work_experience= $user->work_experience;
        $page_four_questions= $user->page_four_questions;
        $references_id= $user->references_id;

        $sheetA = $spreadsheet->getSheetByName('A');
        $sheetB = $spreadsheet->getSheetByName('B');
        $sheetD = $spreadsheet->getSheetByName('D');
        
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
        $SECONDARY = $education->filter(function($value){
            return $value->type == 'SECONDARY';
        });
        $VOCATIONAL = $education->filter(function($value){
            return $value->type == 'VOCATIONAL';
        });
        $COLLEGE = $education->filter(function($value){
            return $value->type == 'COLLEGE';
        });
        $GRADUATE = $education->filter(function($value){
            return $value->type == 'GRADUATE';
        });


        self::insertEducation($elementary->values(), $sheetA, 55);
        self::insertEducation($SECONDARY->values(), $sheetA, 55 + $elementary->count());
        self::insertEducation($VOCATIONAL->values(), $sheetA, 55 + $elementary->count() +  $SECONDARY->count());
        self::insertEducation($COLLEGE->values(), $sheetA, 55 + $elementary->count() +  $SECONDARY->count() + $VOCATIONAL->count());
        self::insertEducation($GRADUATE, $sheetA, 55 + $elementary->count() +  $SECONDARY->count() + $VOCATIONAL->count() + $COLLEGE->count());


        // code for  civil service eligibility
        if($civil_service_eligibility) {
            // add rows
            for($i = 0; $i < $civil_service_eligibility->count() - 7; $i++){
                $sheetB->insertNewRowBefore(11);
                $sheetB->mergeCells('A'. 11 .':E'. 11 .'');
                $sheetB->mergeCells('G'. 11 .':H'. 11 .'');
                $sheetB->mergeCells('I'. 11 .':K'. 11 .'');
                
            }
            for($i = 0; $i < $civil_service_eligibility->count(); $i++){
                $sheetB->setCellValue('A'. 5 + $i, $civil_service_eligibility[$i]->cs_board_bar_ces_csee_barangay_drivers);
                $sheetB->setCellValue('F'. 5 + $i, $civil_service_eligibility[$i]->rating);
                $sheetB->setCellValue('G'. 5 + $i, $civil_service_eligibility[$i]->date_of_exam_conferment);
                $sheetB->setCellValue('I'. 5 + $i, $civil_service_eligibility[$i]->place_of_exam_conferment);
                $sheetB->setCellValue('L'. 5 + $i, $civil_service_eligibility[$i]->license_number);
                $sheetB->setCellValue('M'. 5 + $i, $civil_service_eligibility[$i]->license_date_of_validity);
            }
        }

        //code for work experiences
        if($work_experience){
            $civil_rowcount = $civil_service_eligibility->count() + 18;
            

            for($i = 0; $i < $work_experience->count() - 28; $i++){
                $sheetB->insertNewRowBefore(19);  
                $sheetB->mergeCells('A'. 19 .':B'. 19);
                $sheetB->mergeCells('D'. 19 .':F'. 19);
                $sheetB->mergeCells('G'. 19 .':I'. 19);
            }

            if($civil_service_eligibility->count() > 0){
                $civil_rowcount = $civil_rowcount - 1;
            }

            for($i = 0; $i < $work_experience->count() ; $i++){
                $sheetB->setCellValue('A'. $civil_rowcount + $i, $work_experience[$i]->inclusive_date_from);

                if($work_experience[$i]->to_present=='1') $workstatus='TO PRESENT';    
                else{
                    $workstatus= $work_experience[$i]->inclusive_date_to;
                }

                $sheetB->setCellValue('C'. $civil_rowcount + $i, $workstatus);
                $sheetB->setCellValue('D'. $civil_rowcount + $i, $work_experience[$i]->position_title);
                $sheetB->setCellValue('G'. $civil_rowcount + $i, $work_experience[$i]->dept_agency_office_company);
                $sheetB->setCellValue('J'. $civil_rowcount + $i, $work_experience[$i]->monthly_salary);
                $sheetB->setCellValue('K'. $civil_rowcount + $i, $work_experience[$i]->paygrade);
                $sheetB->setCellValue('L'. $civil_rowcount + $i, $work_experience[$i]->status_of_appointment);
                
                if($work_experience[$i]->govt_service=='1') $govt_service='Y';
                else $govt_service ='N';;

                $sheetB->setCellValue('M'. $civil_rowcount + $i, $govt_service);
            }


        } // end of work exp


        // page four questions
        $sheetD->setCellValue('G6', $page_four_questions->thirty_four_a);
        $sheetD->setCellValue('G8', $page_four_questions->thirty_four_b);
        $sheetD->setCellValue('H11', $page_four_questions->thirty_four_a_b_if_yes);
        $sheetD->setCellValue('G13', $page_four_questions->thirty_five_a);
        $sheetD->setCellValue('H15', $page_four_questions->thirty_five_a_if_yes);
        $sheetD->setCellValue('G18', $page_four_questions->thirty_five_b);
        $sheetD->setCellValue('K20', $page_four_questions->thirty_five_b_if_yes_date);
        $sheetD->setCellValue('K21', $page_four_questions->thirty_five_b_if_yes_case);
        $sheetD->setCellValue('G23', $page_four_questions->thirty_six);
        $sheetD->setCellValue('H25', $page_four_questions->thirty_six_if_yes);
        $sheetD->setCellValue('G27', $page_four_questions->thirty_seven);
        $sheetD->setCellValue('H29', $page_four_questions->thirty_seven_if_yes);
        $sheetD->setCellValue('G31', $page_four_questions->thirty_eight_a);
        $sheetD->setCellValue('K32', $page_four_questions->thirty_eight_a_if_yes);
        $sheetD->setCellValue('G34', $page_four_questions->thirty_eight_b);
        $sheetD->setCellValue('K35', $page_four_questions->thirty_eight_b_if_yes);
        $sheetD->setCellValue('G37', $page_four_questions->thirty_nine);
        $sheetD->setCellValue('H39', $page_four_questions->thirty_nine_if_yes);
        $sheetD->setCellValue('G43', $page_four_questions->fourty_a);
        $sheetD->setCellValue('L44', $page_four_questions->fourty_a_if_yes);
        $sheetD->setCellValue('G45', $page_four_questions->fourty_b);
        $sheetD->setCellValue('L46', $page_four_questions->fourty_b_if_yes);
        $sheetD->setCellValue('G47', $page_four_questions->fourty_c);
        $sheetD->setCellValue('L48', $page_four_questions->fourty_c_if_yes);


        $sheetD->setCellValue('A52', $references_id->references_name_one);
        $sheetD->setCellValue('F52', $references_id->references_address_one);
        $sheetD->setCellValue('G52', $references_id->references_telephone_one);
        $sheetD->setCellValue('A53', $references_id->references_name_two);
        $sheetD->setCellValue('F53', $references_id->references_address_two);
        $sheetD->setCellValue('G53', $references_id->references_telephone_two);
        $sheetD->setCellValue('A54', $references_id->references_name_three);
        $sheetD->setCellValue('F54', $references_id->references_address_three);
        $sheetD->setCellValue('G54', $references_id->references_telephone_three);

        $sheetD->setCellValue('D61', $references_id->government_issued_id);
        $sheetD->setCellValue('D62', $references_id->id_license_passport_number);
        $sheetD->setCellValue('D64', $references_id->date_place_of_issuance);



        $writer->save($path = storage_path('PDS.xlsx'));

        return response()->download($path);


    }

    private static function insertEducation($filteredEducation, $sheet, $rowNumber){
        if($filteredEducation->count() !== 0){
            $filteredEducation->values();
       
            // add rows
            for($i = 0; $i < $filteredEducation->count() - 1; $i++){
                $sheet->insertNewRowBefore($rowNumber);
                $sheet->mergeCells('D'. $rowNumber .':F'. $rowNumber .'');
                $sheet->mergeCells('G'. $rowNumber .':I'. $rowNumber .'');
            }

            // insert to excel

            $rowNumber = $rowNumber - 1;

            for($i = 0; $i < $filteredEducation->count(); $i++){
                $sheet->setCellValue('D'.$rowNumber + $i, $filteredEducation[$i]->name_of_school);
                $sheet->setCellValue('G'. $rowNumber + $i, $filteredEducation[$i]->basic_ed_degree_course );
                $sheet->setCellValue('J'. $rowNumber + $i, $filteredEducation[$i]->period_from );
                $sheet->setCellValue('K'. $rowNumber + $i, $filteredEducation[$i]->period_to );
                $sheet->setCellValue('L'. $rowNumber + $i, $filteredEducation[$i]->highest_lvl_units_earned );
                $sheet->setCellValue('M'. $rowNumber + $i, $filteredEducation[$i]->year_graduated );
                $sheet->setCellValue('N'. $rowNumber + $i, $filteredEducation[$i]->academic_award->pluck('title')->join(', '));
            }
        }
        
       
    }
    

}
   
