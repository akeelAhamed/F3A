<?php
namespace App\Libraries;

use App\Libraries\Classes\Validator;

/**
 * Validate for app
 */
class Validate{

    /**
	 * Validate user data
	 * 
	 * @param array  $inputs User data
	 * 
	 * @return Object | response
	 */
	public static function validate(array $inputs)
	{
		$error = ['something went wrong'];$ok = false;
		$ret = array('ok' => false, 'message' => $error);
		
		// Check for the slug field is available
        $flag = isset($inputs['slug'])?strtolower($inputs['slug']):'';
		
		if($flag !== ''){
			$validate = new Validator($inputs);
			$ok = true;

			switch ($flag) {
				case 'login': // Validate user for login
					$validate->rule('required', ['email', 'password']);
					$validate->rule('email', ['email']);
					$validate->rule('lengthBetween', 'password', 8, 15);
					break;
				
				case 'register': // create Users
					$validate->rule('required', ['company', 'address', 'title', 'email', 'confirm_email', 'contact_number', 'password', 'incorporat', 'hr', 'hr_email', 'hr_contact', 'about']);
					$validate->rule('alphaNum', ['name', 'title', 'employer_name']);
					$validate->rule('numeric', ['contact_number', 'hr_contact', 'incorporat']);
					$validate->rule('email', ['email', 'confirm_email', 'hr_email']);
					$validate->rule('equals', 'email', 'confirm_email');
					$validate->rule('in', 'title', \App\Models\User::TITLES);
					$validate->rule('lengthBetween', ['contact', 'hr_contact'] , 10, 15);
					$validate->rule('lengthBetween', 'password', 8, 15);
					$validate->rule('lengthBetween', ['address', 'about'] , 1, 150);
					break;

				case 'register-candidate': // create Users
					$validate->rule('required', ['name',  'email', 'confirm_email', 'contact', 'password']);
					$validate->rule('alphaNum', ['name']);
					$validate->rule('numeric', ['contact']);
					$validate->rule('email', ['email', 'confirm_email']);
					$validate->rule('equals', 'email', 'confirm_email');
					$validate->rule('lengthBetween', ['contact'] , 10, 15);
					$validate->rule('lengthBetween', 'password', 8, 15);
					break;

				case 'profile_update': // update  Users
					$validate->rule('required', ['company', 'address', 'title', 'email', 'contact_number', 'incorporat', 'hr', 'hr_email', 'hr_contact', 'about']);
					$validate->rule('alphaNum', ['name', 'title', 'employer_name', 'about']);
					$validate->rule('numeric', ['contact_number', 'hr_contact', 'incorporat']);
					$validate->rule('email', ['email', 'hr_email']);
					$validate->rule('in', 'title', \App\Models\User::TITLES);
					$validate->rule('lengthBetween', ['contact', 'hr_contact'] , 10, 15);
					$validate->rule('lengthBetween', ['address', 'about'] , 5, 150);
					break;

				case 'candidate_profile_update': // update  candidate
					$validate->rule('required', ['name', 'email', 'contact']);
					$validate->rule('alphaNum', ['name']);
					$validate->rule('numeric', ['contact']);
					$validate->rule('email', ['email']);
					$validate->rule('lengthBetween', ['contact'] , 10, 15);
					break;

				case 'candidate_education': // update  candidate education
					$validate->rule('required', ['institute', 'degree', 'location', 'ctype', 'percentage']);
					$validate->rule('numeric', ['percentage', 'passedout']);
					$validate->rule('email', ['email']);
					$validate->rule('lengthBetween', ['location', 'fos'] , 0, 150);
					break;

				case 'candidate_experience': // update  candidate experience
					$validate->rule('required', ['company', 'jtype', 'location', 'title', 'fmonth', 'fyear']);
					$validate->rule('requiredWithout', 'tmonth', 'present')->message('To month is requred');
					$validate->rule('requiredWithout', 'tyear', 'present')->message('To year is requred');
					$validate->rule('lengthBetween', ['location', 'title'] , 1, 100);
					break;

				case 'candidate_resume':  // update  candidate resume
					$validate->rule('requiredWithout', 'photo', 'update');
					$validate->rule('requiredWithout', 'resume', 'update');
					$validate->rule('mime', 'photo', ['jpg', 'png', 'jpeg']);
					$validate->rule('mime', 'resume', ['pdf', 'doc', 'docx']);
					$validate->rule('size', ['photo', 'resume'], '500');
					break;

				case 'vacancy': // update account
					$validate->rule('array', ['category', 'sub_category', 'job_title', 'qualification', 'experience', 'vacancy', 'salary', 'expiry', 'description'])->message('All fields are required');
					$validate->rule('required', 'category.*');
					$validate->rule('required', 'sub_category.*');
					$validate->rule('required', 'experience.*');
					$validate->rule('required', 'salary.*');
					$validate->rule('lengthBetween', ['job_title.*', 'qualification.*'], 3, 180);
					$validate->rule('in', 'experience*', \App\Models\Vacancy::EXPERIENCE);
					$validate->rule('in', 'salary*', \App\Models\Vacancy::SALARY);
					$validate->rule('required', 'vacancy.*');
					$validate->rule('numeric', 'category.*')->message('Enter a valid category');
					$validate->rule('numeric', 'sub_category.*')->message('Enter a valid sub category');
					$validate->rule('numeric', 'vacancy.*');
					$validate->rule('min', 'vacancy.*', 1);
					$validate->rule('dateAfter', 'expiry*', date('Y-m-d'));
					break;

				case 'vacancy_action_update': // update vacancy
					$validate->rule('required', ['category', 'sub_category', 'job_title', 'qualification', 'experience', 'vacancy', 'salary', 'expiry', 'description', 'key'])->message('All fields are required');
					$validate->rule('numeric', 'category')->message('Enter a valid category');
					$validate->rule('numeric', 'sub_category')->message('Enter a valid sub category');
					$validate->rule('lengthBetween', ['job_title', 'qualification'], 3, 180);
					$validate->rule('in', 'experience', \App\Models\Vacancy::EXPERIENCE);
					$validate->rule('min', 'vacancy', 1);
					$validate->rule('dateAfter', 'expiry', date('Y-m-d'));
					break;
	
				case 'new_category': // create category
					$validate->rule('required', ['name']);
					$validate->rule('alphaNum', 'name');
					break;

				case 'new_subcategory': // create sub category
					$validate->rule('required', ['category_id', 'name']);
					$validate->rule('alphaNum', 'name');
					$validate->rule('numeric', 'category_id')->message('Invalid category');
					break;

				case 'category_action_update': // update category
					$validate->rule('required', ['name', 'key']);
					$validate->rule('alphaNum', 'name');
					$validate->rule('numeric', 'key')->message('Invalid data');
					break;

				case 'subcategory_action_update': // update sub category
					$validate->rule('required', ['category_id', 'name']);
					$validate->rule('alphaNum', 'name');
					$validate->rule('numeric', ['category_id', 'key'])->message('Invalid category or data');
					break;
	
				case 'd': // Delete records
					$validate->rule('required', ['api', 'key']);
					$validate->rule('array', ['key']);
					$validate->rule('equals', 'confirm_password', 'new_password');
					break;
	
				case 'fx': // Filter from ajax
					$validate->rule('required', ['f', 'k']);
					break;
	
				case 'password': // Reset Password
					$validate->rule('required', ['old_password', 'new_password', 'confirm_password']);
					$validate->rule('lengthBetween', ['new_password', 'confirm_password'], 8, 20);
					$validate->rule('equals', 'confirm_password', 'new_password');
					break;
	
				case 'srp': // Send email to reset password
					$validate->rule('required', ['email']);
					$validate->rule('email', 'email');
					break;

				case 'rpv': // Validate otp
					$validate->rule('required', ['code', 'key']);
					$validate->rule('required', 'id')->message('Something went wrong. Try again later');
					$validate->rule('numeric', 'code');
					break;
	
				case 'rpw': // Reset Password from web
					$validate->rule('required', ['new_password', 'confirm_password']);
					$validate->rule('required', ['key'])->message('Something went wrong. Try again later');
					$validate->rule('lengthBetween', ['new_password', 'confirm_password'], 8, 20)->message('Minimum 8 characters required for password');
					$validate->rule('equals', 'confirm_password', 'new_password');
					break;

				default:
					$ok = !$ok;
					break;
				
			}
		}
        
        if($ok){
            if(!$validate->validate()) {
                $errors = $validate->errors();
                $error = [];
                $old_error = '';
                foreach ($errors as $key => $e) {
                    for ($i=0; $i < count($e) ; $i++) {
                        if($e[$i] != $old_error){
                            $old_error = $e[$i];
                            $key = str_replace('_', ' ', $e[$i]);
                            array_push($error, $key);
                        }
                    }
                }
                $ret = array('ok' => false, 'message' => $error);
            }else{
                $ret = array('ok' => true, 'message' => []);
            }
        }
        
        return json_decode(json_encode($ret));
	}
}