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
        
        if(!$request->user()){
            abort(403, 'Page expired');
        }

        
        $pdsfile='./pds/PDS.xlsx';
        /** Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($pdsfile);

        $spreadsheet->setActiveSheetIndexByName('A');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");

        // load user
        $user = $request->user();
        $personal_info = $user->personal_information;  
        $family_background = $user->family_background;       
        $children = $user->children;       
        $education = $user->college_graduate_studies()->with('academic_award')->get();
        $civil_service_eligibility = $user->civil_service_eligibility()->orderBy('date_of_exam_conferment', 'desc')->get();
        $work_experience= $user->work_experience()->orderBy('inclusive_date_from', 'desc')->get();
        $page_four_questions= $user->page_four_questions;
        $references_id= $user->references_id;
        $voluntary_work=$user->voluntary_work()->orderBy('inclusive_date_from', 'desc')->get();
        $learning_and_development=$user->learning_and_development()->orderBy('inclusive_date_from', 'desc')->get();
        $other_information=$user->other_information;
        


        $sheetA = $spreadsheet->getSheetByName('A');
        $sheetB = $spreadsheet->getSheetByName('B');
        $sheetC = $spreadsheet->getSheetByName('C');
        $sheetD = $spreadsheet->getSheetByName('D');
        
        
        if($personal_info){
            // personal info
            $sheetA->setCellValue('D10', strtoupper($personal_info['surname']));
            $sheetA->setCellValue('D11', strtoupper($personal_info['first_name']));
            $sheetA->setCellValue('D12', strtoupper($personal_info['middle_name']));
            $sheetA->setCellValue('N11', strtoupper($personal_info['name_extension']));
            $sheetA->setCellValue('D13', Carbon::parse($personal_info['date_of_birth'])->format('m-d-Y'));
            $sheetA->setCellValue('D15', strtoupper($personal_info['place_of_birth']));
            $sheetA->setCellValue('D16', strtoupper($personal_info['sex']));
            $sheetA->setCellValue('D22', strtoupper($personal_info['height']));
            $sheetA->setCellValue('D24', strtoupper($personal_info['weight']));
            $sheetA->setCellValue('D25', strtoupper($personal_info['blood_type']));
            $sheetA->setCellValue('D27', strtoupper($personal_info['gsis_id_number']));
            $sheetA->setCellValue('D29', strtoupper($personal_info['pagibig_id_number']));
            $sheetA->setCellValue('D32', strtoupper($personal_info['sss_number']));
            $sheetA->setCellValue('D31', strtoupper($personal_info['philhealth_number']));
            $sheetA->setCellValue('D33', strtoupper($personal_info['tin_number']));
            $sheetA->setCellValue('D34', strtoupper($personal_info['agency_employee_number']));
            $sheetA->setCellValue('I17', strtoupper($personal_info['r_address_house_block_lot_number']));
            $sheetA->setCellValue('L17', strtoupper($personal_info['r_address_street']));
            $sheetA->setCellValue('I19', strtoupper($personal_info['r_address_subdivision_village']));
            $sheetA->setCellValue('L19', strtoupper($personal_info['r_address_barangay']));
            $sheetA->setCellValue('I22', strtoupper($personal_info['r_address_city_municipality']));
            $sheetA->setCellValue('I24', strtoupper($personal_info['r_address_zipcode']));
            $sheetA->setCellValue('L22', strtoupper($personal_info['r_address_province']));
            $sheetA->setCellValue('I25', strtoupper($personal_info['p_address_house_block_lot_number']));
            $sheetA->setCellValue('L25', strtoupper($personal_info['p_address_street']));
            $sheetA->setCellValue('I27', strtoupper($personal_info['p_address_subdivision_village']));
            $sheetA->setCellValue('L27', strtoupper($personal_info['p_address_barangay']));
            $sheetA->setCellValue('I29', strtoupper($personal_info['p_address_city_municipality']));
            $sheetA->setCellValue('I31', strtoupper($personal_info['p_address_zipcode']));
            $sheetA->setCellValue('L29', strtoupper($personal_info['p_address_province']));
            $sheetA->setCellValue('I32', strtoupper($personal_info['telephone_number']));
            $sheetA->setCellValue('I33', strtoupper($personal_info['mobile_number']));
            $sheetA->setCellValue('I34', strtoupper($personal_info['email_address']));
            $sheetA->setCellValue('D17', strtoupper($personal_info['civil_status']));
            $sheetA->setCellValue('D17', 'Others: ' . strtoupper($personal_info['other_civil_status']));
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

            $spreadsheet->getActiveSheet()->setCellValue('D36', strtoupper($family_background['spouse_surname']) . $spouse_deceased);
            $sheetA->setCellValue('D37', strtoupper($family_background['spouse_first_name']));
            $sheetA->setCellValue('H37', strtoupper($family_background['spouse_name_extension']));
            $sheetA->setCellValue('D38', strtoupper($family_background['spouse_middle_name']));
            $sheetA->setCellValue('D39', strtoupper($family_background['spouse_occupation']));
            $sheetA->setCellValue('D40', strtoupper($family_background['spouse_employer_business_name']));
            $sheetA->setCellValue('D41', strtoupper($family_background['spouse_business_address']));
            $sheetA->setCellValue('D42', strtoupper($family_background['spouse_telephone_number']));

            $sheetA->setCellValue('D43', strtoupper($family_background['fathers_surname']) . $fathers_deceased);
            $sheetA->setCellValue('D44', strtoupper($family_background['fathers_first_name']));
            $sheetA->setCellValue('H44', strtoupper($family_background['fathers_name_extension']));
            $sheetA->setCellValue('D45', strtoupper($family_background['fathers_middle_name']));

            $sheetA->setCellValue('D47', strtoupper($family_background['mothers_surname']). $mothers_deceased);
            $sheetA->setCellValue('D48', strtoupper($family_background['mothers_first_name']));
            $sheetA->setCellValue('D49', strtoupper($family_background['mothers_middle_name']));

            // children
            foreach($children as $key => $child){
                $child_deceased = $child['deceased'] ? ' (deceased)' : '';
                // dd($child);
                $sheetA->setCellValue('I'. 37 + $key, strtoupper($child['fullname']) . $child_deceased);
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
                $sheetB->setCellValue('A'. 5 + $i, strtoupper($civil_service_eligibility[$i]->cs_board_bar_ces_csee_barangay_drivers));
                $sheetB->setCellValue('F'. 5 + $i, strtoupper($civil_service_eligibility[$i]->rating));
                $sheetB->setCellValue('G'. 5 + $i, self::formatDate($civil_service_eligibility[$i]->date_of_exam_conferment));
                $sheetB->setCellValue('I'. 5 + $i, strtoupper($civil_service_eligibility[$i]->place_of_exam_conferment));
                $sheetB->setCellValue('L'. 5 + $i, strtoupper($civil_service_eligibility[$i]->license_number));
                $sheetB->setCellValue('M'. 5 + $i, self::formatDate($civil_service_eligibility[$i]->license_date_of_validity));
            }
        }

        //code for work experiences
        if($work_experience){
            $work_start_row = $civil_service_eligibility->count() + 18;
            

            for($i = 0; $i < $work_experience->count() - 28; $i++){
                $sheetB->insertNewRowBefore($work_start_row);  
                $sheetB->mergeCells('A'. $work_start_row .':B'. $work_start_row);
                $sheetB->mergeCells('D'. $work_start_row .':F'. $work_start_row);
                $sheetB->mergeCells('G'. $work_start_row .':I'. $work_start_row);
            }

            if($civil_service_eligibility->count() > 0){
                $work_start_row = $work_start_row - 7;
            }

            for($i = 0; $i < $work_experience->count() ; $i++){
                $sheetB->setCellValue('A'. $work_start_row + $i,self::formatDate($work_experience[$i]->inclusive_date_from));

                if($work_experience[$i]->to_present=='1') $workstatus='TO PRESENT';    
                else{

                    $workstatus= self::formatDate($work_experience[$i]->inclusive_date_to);
                }

                $sheetB->setCellValue('C'. $work_start_row + $i, strtoupper($workstatus));
                $sheetB->setCellValue('D'. $work_start_row + $i, strtoupper($work_experience[$i]->position_title));
                $sheetB->setCellValue('G'. $work_start_row + $i, strtoupper($work_experience[$i]->dept_agency_office_company));
                $sheetB->setCellValue('J'. $work_start_row + $i, $work_experience[$i]->monthly_salary);
                $sheetB->setCellValue('K'. $work_start_row + $i, $work_experience[$i]->paygrade);
                $sheetB->setCellValue('L'. $work_start_row + $i, strtoupper($work_experience[$i]->status_of_appointment));

                
                if($work_experience[$i]->govt_service=='1') $govt_service='Y';
                else $govt_service ='N';;


                $sheetB->setCellValue('M'. $work_start_row + $i, $govt_service);
            }


        } // end of work exp


        // page four questions
        if($page_four_questions){
            $sheetD->setCellValue('G6', strtoupper($page_four_questions->thirty_four_a));
            $sheetD->setCellValue('G8', strtoupper($page_four_questions->thirty_four_b));
            $sheetD->setCellValue('H11', strtoupper($page_four_questions->thirty_four_a_b_if_yes));
            $sheetD->setCellValue('G13', strtoupper($page_four_questions->thirty_five_a));
            $sheetD->setCellValue('H15', strtoupper($page_four_questions->thirty_five_a_if_yes));
            $sheetD->setCellValue('G18', strtoupper($page_four_questions->thirty_five_b));
            $sheetD->setCellValue('K20', strtoupper($page_four_questions->thirty_five_b_if_yes_date));
            $sheetD->setCellValue('K21', strtoupper($page_four_questions->thirty_five_b_if_yes_case));
            $sheetD->setCellValue('G23', strtoupper($page_four_questions->thirty_six));
            $sheetD->setCellValue('H25', strtoupper($page_four_questions->thirty_six_if_yes));
            $sheetD->setCellValue('G27', strtoupper($page_four_questions->thirty_seven));
            $sheetD->setCellValue('H29', strtoupper($page_four_questions->thirty_seven_if_yes));
            $sheetD->setCellValue('G31', strtoupper($page_four_questions->thirty_eight_a));
            $sheetD->setCellValue('K32', strtoupper($page_four_questions->thirty_eight_a_if_yes));
            $sheetD->setCellValue('G34', strtoupper($page_four_questions->thirty_eight_b));
            $sheetD->setCellValue('K35', strtoupper($page_four_questions->thirty_eight_b_if_yes));
            $sheetD->setCellValue('G37', strtoupper($page_four_questions->thirty_nine));
            $sheetD->setCellValue('H39', strtoupper($page_four_questions->thirty_nine_if_yes));
            $sheetD->setCellValue('G43', strtoupper($page_four_questions->fourty_a));
            $sheetD->setCellValue('L44', strtoupper($page_four_questions->fourty_a_if_yes));
            $sheetD->setCellValue('G45', strtoupper($page_four_questions->fourty_b));
            $sheetD->setCellValue('L46', strtoupper($page_four_questions->fourty_b_if_yes));
            $sheetD->setCellValue('G47', strtoupper($page_four_questions->fourty_c));
            $sheetD->setCellValue('L48', strtoupper($page_four_questions->fourty_c_if_yes));
        }
        
        if($references_id){
            $sheetD->setCellValue('A52', strtoupper($references_id->references_name_one));
            $sheetD->setCellValue('F52', strtoupper($references_id->references_address_one));
            $sheetD->setCellValue('G52', strtoupper($references_id->references_telephone_one));
            $sheetD->setCellValue('A53', strtoupper($references_id->references_name_two));
            $sheetD->setCellValue('F53', strtoupper($references_id->references_address_two));
            $sheetD->setCellValue('G53', strtoupper($references_id->references_telephone_two));
            $sheetD->setCellValue('A54', strtoupper($references_id->references_name_three));
            $sheetD->setCellValue('F54', strtoupper($references_id->references_address_three));
            $sheetD->setCellValue('G54', strtoupper($references_id->references_telephone_three));
    
            $sheetD->setCellValue('D61', strtoupper($references_id->government_issued_id));
            $sheetD->setCellValue('D62', strtoupper($references_id->id_license_passport_number));
            $sheetD->setCellValue('D64', strtoupper($references_id->date_place_of_issuance));
        }

        //code for voluntary work
        if($voluntary_work){
            for($i = 0; $i < $voluntary_work->count() - 7; $i++){
                $sheetC->insertNewRowBefore(11);
                $sheetC->mergeCells('A'. 11 .':D'. 11 .'');
                $sheetC->mergeCells('H'. 11 .':K'. 11    .'');
            }

            for($i = 0; $i < $voluntary_work->count(); $i++){
                $sheetC->setCellValue('A'. 6 + $i, strtoupper($voluntary_work[$i]->name_address_of_org));
                $sheetC->setCellValue('E'. 6 + $i, self::formatDate($voluntary_work[$i]->inclusive_date_from));
                $sheetC->setCellValue('F'. 6 + $i, self::formatDate($voluntary_work[$i]->inclusive_date_to));
                $sheetC->setCellValue('G'. 6 + $i, $voluntary_work[$i]->number_of_hours);
                $sheetC->setCellValue('H'. 6 + $i, strtoupper($voluntary_work[$i]->position_work));
            }
        }
        // code for learning and dev
        if($learning_and_development){
            $lnd_row_start = $voluntary_work->count() + 18;

            for($i = 0; $i < $learning_and_development->count() - 21; $i++){
                $sheetC->insertNewRowBefore($lnd_row_start);  
                $sheetC->mergeCells('A'. $lnd_row_start .':D'. $lnd_row_start);
                $sheetC->mergeCells('I'. $lnd_row_start .':K'. $lnd_row_start);
                
            }

            if($voluntary_work->count() > 0){
                $lnd_row_start = $lnd_row_start - 7;
            }

            for($i = 0; $i < $learning_and_development->count() ; $i++){
                $sheetC->setCellValue('A'. $lnd_row_start + $i, strtoupper($learning_and_development[$i]->title_of_learning));
                $sheetC->setCellValue('E'. $lnd_row_start + $i, self::formatDate($learning_and_development[$i]->inclusive_date_from));
                $sheetC->setCellValue('F'. $lnd_row_start + $i, self::formatDate($learning_and_development[$i]->inclusive_date_to));
                $sheetC->setCellValue('G'. $lnd_row_start + $i, strtoupper($learning_and_development[$i]->number_of_hours));
                $sheetC->setCellValue('H'. $lnd_row_start + $i, strtoupper($learning_and_development[$i]->type_of_ld));
                $sheetC->setCellValue('I'. $lnd_row_start + $i, strtoupper($learning_and_development[$i]->conducted_sponsored_by));
            }
        }//end of learning and development

        $skills = [];
        $org = [];

        // other info
        if($other_information){
            $skills = explode(',', $other_information->special_skills_hobbies);
            $org = explode(',', $other_information->membership_in_assoc_org);
        }

        $non_academic_distinction=$user->non_academic_distinction;

        $number_of_rows = max([count($skills), count($org), count($non_academic_distinction)]);


        $other_row_start = 42;


        if($voluntary_work->count() > 7){
            $other_row_start = $other_row_start + ($voluntary_work->count() - 7);
        }

        if($learning_and_development->count() > 21){
            $other_row_start = $other_row_start + ($learning_and_development->count() - 21);
        }

        for($i = 0; $i < $number_of_rows - 7; $i++){
            $sheetC->insertNewRowBefore($other_row_start + 1);  
            $sheetC->mergeCells('A'. $other_row_start + 1 .':B'. $other_row_start + 1);
            $sheetC->mergeCells('C'. $other_row_start + 1 .':H'. $other_row_start + 1);
            $sheetC->mergeCells('I'. $other_row_start + 1 .':K'. $other_row_start + 1);
        }
        
        for($i = 0; $i < count($skills) ; $i++){
            $sheetC->setCellValue('A'. $other_row_start + $i, strtoupper($skills[$i])); 
        }

        for($i = 0; $i < count($non_academic_distinction) ; $i++){
            $sheetC->setCellValue('C'. $other_row_start + $i, strtoupper($non_academic_distinction[$i]->title)); 
        }
        
        for($i = 0; $i < count($org) ; $i++){
            $sheetC->setCellValue('I'. $other_row_start + $i, strtoupper($org[$i])); 
        }


            

        $writer->save($path = storage_path('PDS.xlsx'));

        return response()->download($path);


    }

    private static function formatDate($date){
        $date = Carbon::parse($date)->format('m/d/Y');

        return ($date);

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
                $sheet->setCellValue('D'.$rowNumber + $i, strtoupper($filteredEducation[$i]->name_of_school));
                $sheet->setCellValue('G'. $rowNumber + $i, strtoupper($filteredEducation[$i]->basic_ed_degree_course ));
                $sheet->setCellValue('J'. $rowNumber + $i, $filteredEducation[$i]->period_from );
                $sheet->setCellValue('K'. $rowNumber + $i, $filteredEducation[$i]->period_to );
                $sheet->setCellValue('L'. $rowNumber + $i, $filteredEducation[$i]->highest_lvl_units_earned );
                $sheet->setCellValue('M'. $rowNumber + $i, $filteredEducation[$i]->year_graduated );
                $sheet->setCellValue('N'. $rowNumber + $i, $filteredEducation[$i]->academic_award->pluck('title')->join(', '));
            }
        }
        
       
    }
    

}
   
