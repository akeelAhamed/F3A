<?php

namespace App\Controllers\Auth;

use App\Helpers\View;
use App\Helpers\Mail;
use App\Libraries\Utill;
use App\Models\{User, Candidate};

class RegisterController
{
    /**
     * Show register form
     */
    public function view()
    {
        return View::render('form.employer.register-basic', ['title'=>User::TITLES]);
    }

    /**
     * Show register form
     */
    public function view2()
    {
        return View::render('form.candidate.register-basic', ['title'=>User::TITLES]);
    }

    /**
     * Do register
     */
    public function register()
    {
        $request = request();
        $inputs = $request->input();
        $validate = \App\Libraries\Validate::validate($inputs);
        Utill::setSession('old_form', $inputs);
        if($validate->ok){
            // VALID DATA
            $count = User::where($inputs['email'], 'email')->orWhere($inputs['contact_number'], 'contact_number')->count();
            if($count == 0){
                // No already registered
                $inputs = Utill::unsetArray([CSRF_KEY, 'slug', 'confirm_email'], $inputs);
                $inputs['password'] = Utill::hashPassword($inputs['password']);
                User::create($inputs);
                $mail = new Mail();
                $mail->to($inputs['email'])->subject('Welcome to '.APP_NAME)->view('mail.welcome', $inputs)->send();
                return redirect('employer-login', 'Account created successfully', true);
            }else{
                $error = 'Email id or contact number is already registered.';
            }
        }else{
            $error = $validate->message;
        }
        return redirect('employer-register', $error);
    }

    /**
     * Do register for candidate
     */
    public function register2()
    {
        $request = request();
        $inputs = $request->input();
        $validate = \App\Libraries\Validate::validate($inputs);
        Utill::setSession('old_form', $inputs);
        if($validate->ok){
            // VALID DATA
            $count = Candidate::where($inputs['email'], 'email')->orWhere($inputs['contact'], 'contact')->count();
            if($count == 0){
                // No already registered
                $inputs = Utill::unsetArray([CSRF_KEY, 'slug', 'confirm_email'], $inputs);
                $inputs['password'] = Utill::hashPassword($inputs['password']);
                Candidate::create($inputs);
                $mail = new Mail();
                $mail->to($inputs['email'])->subject('Welcome to '.APP_NAME)->view('mail.welcome', $inputs)->send();
                return redirect('candidate-login', 'Account created successfully', true);
            }else{
                $error = 'Email id or contact number is already registered.';
            }
        }else{
            $error = $validate->message;
        }
        return redirect('candidate-register', $error);
    }

}