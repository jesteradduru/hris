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
        $voluntary_work=$user->voluntary_work;
        $learning_and_development=$user->learning_and_development;
        $other_information=$user->other_information;
        $non_academic_distinction=$user->non_academic_distinction;

        $sheetA = $spreadsheet->getSheetByName('A');
        $sheetB = $spreadsheet->getSheetByName('B');
        $sheetC = $spreadsheet->getSheetByName('C');
        
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

            //code for work experiences
            if($work_experience){
                $civil_rowcount = $civil_service_eligibility->count() + 12;
                

                for($i = 0; $i < $work_experience->count() - 28; $i++){
                    $sheetB->insertNewRowBefore(45);  
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
            }

            //code for voluntary work
            if($voluntary_work){
                for($i = 0; $i < $voluntary_work->count() - 7; $i++){
                    $sheetC->insertNewRowBefore(12);
                    $sheetC->mergeCells('A'. 12 .':D'. 12 .'');
                    $sheetC->mergeCells('H'. 12 .':K'. 12    .'');
                }

                for($i = 0; $i < $voluntary_work->count(); $i++){
                    $sheetC->setCellValue('A'. 6 + $i, strtoupper($voluntary_work[$i]->name_address_of_org));
                    $sheetC->setCellValue('E'. 6 + $i, $voluntary_work[$i]->inclusive_date_from);
                    $sheetC->setCellValue('F'. 6 + $i, $voluntary_work[$i]->inclusive_date_to);
                    $sheetC->setCellValue('G'. 6 + $i, $voluntary_work[$i]->number_of_hours);
                    $sheetC->setCellValue('H'. 6 + $i,strtoupper($voluntary_work[$i]->position_work));
                }
            }
            // code for learning and dev
            if($learning_and_development){
                $vol_rowcount = $voluntary_work->count() + 12;

                for($i = 0; $i < $learning_and_development->count() -   21; $i++){
                    $sheetC->insertNewRowBefore(40);  
                    $sheetC->mergeCells('A'. 40 .':D'. 40);
                    $sheetC->mergeCells('I'. 40 .':K'. 40);
                    
                }
                if($learning_and_development->count() > 0){
                    $vol_rowcount = $vol_rowcount - 1;
                }
                for($i = 0; $i < $learning_and_development->count() ; $i++){
                    $sheetC->setCellValue('A'. $vol_rowcount + $i, $learning_and_development[$i]->title_of_learning);
                    $sheetC->setCellValue('E'. $vol_rowcount + $i, $learning_and_development[$i]->inclusive_date_from);
                    $sheetC->setCellValue('F'. $vol_rowcount + $i, $learning_and_development[$i]->inclusive_date_to);
                    $sheetC->setCellValue('G'. $vol_rowcount + $i, $learning_and_development[$i]->number_of_hours);
                    $sheetC->setCellValue('H'. $vol_rowcount + $i, $learning_and_development[$i]->type_of_ld);
                    $sheetC->setCellValue('I'. $vol_rowcount + $i, $learning_and_development[$i]->conducted_sponsored_by);    
                }
            }
            //end of learning and development


            //non acad
            $special_skills_hobbies=explode(',',$other_information->special_skills_hobbies);
            $membership_in_assoc_org=explode(',',$other_information->membership_in_assoc_org);
            $other_information_count->$other_information->count;

            $array_counts = [
                'special_skills_hobbies' => count($special_skills_hobbies),
                'membership_in_assoc_org' => count($membership_in_assoc_org),
                'other_information_count' => $other_information_count,
            ];

            $max_array = max($array_counts);

            if ($max_array == $array_counts['special_skills_hobbies']) {
                $result_array = $special_skills_hobbies;
            } elseif ($max_array == $array_counts['membership_in_assoc_org']) {
                $result_array = $membership_in_assoc_org;
            } else {
                $result_array = [$other_information_count];
            }
            
            }

            if($non_academic_distinction){
                $nonacadrow=$result_array()+ 35;


                for($i = 0; $i < $non_academic_distinction->count() -   21; $i++){
                    $sheetC->insertNewRowBefore(48);  
                    $sheetC->mergeCells('C'. 48 .':H'. 48);
                }
                if($non_academic_distinction->count() > 0){
                    $nonacadrow = $nonacadrow - 1;
                }
                for($i = 0; $i < $non_academic_distinction->count() ; $i++){
                    $sheetC->setCellValue('C'. $nonacadrow + $i, "testing lester");
                }   
                
            }


            
        
        $writer->save($path = storage_path('PDS.xlsx'));

        return response()->download($path);


    }
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
   
