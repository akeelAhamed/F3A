<?php

namespace App\Controllers\Auth;

use App\Helpers\View;
use App\Helpers\Mail;
use App\Libraries\Utill;
use \App\Models\{User, Candidate};

class LoginController
{
    /**
     * Show login form
     */
    public function view()
    {
        return View::render('form.employer.login');
    }

    /**
     * Show login form for candidate
     */
    public function view2()
    {
        return View::render('form.candidate.login');
    }

    /**
     * Do login
     */
    public function login()
    {
        return \App\Controllers\Auth\AuthController::login();
    }

    /**
     * Do candidate login
     */
    public function login2()
    {
        return \App\Controllers\Auth\AuthController::login(true);
    }

    /**
     * Send email to reset password
     * 
     * @param bool $candidate
     */
    public function sendResetPassword($candidate=false)
    {
        $request = request();
        $inputs = $request->input();
        $error = ['Unable to sent email'];
        $validate = \App\Libraries\Validate::validate($inputs);
        $route = ($candidate)?'candidate':'employer';

        if($validate->ok){
            $model = $candidate? new Candidate():new User();
            $found = $model->where($inputs['email'], 'email')->where(1, 'status')->count();
            if($found == 1){
                $code = mt_rand(00000, 99999);
                $coden = en($code, false);
                Utill::setSession('rpcode', $coden);
                Utill::setSession('rpcodeU', en($inputs['email'], false)); // U- user
                Utill::setSession('rpcodeT', time()); // T- time
                Utill::setSession('rpcodeTY', $candidate); // TY- type
                $mail = new Mail();
                $mail->to($inputs['email'])->subject('Request to reset password')->view('mail.reset', ['code' => $code])->send();
                return redirect($route.'-reset/'.urlencode(base64_encode($coden)));
            }else{
                $error = ['Email id not registered/This account may be suspended. '];
            }
        }else{
            $error = $validate->message;
        }
        return redirect($route.'-login', $error);
    }

    /**
     * Send email to reset password for candidate
     */
    public function sendResetPassword2()
    {
        return $this->sendResetPassword(true);
    }

    /**
     * Show verify otp form for reset password
     * 
     */
    public function verify()
    {
        if(Utill::hasSession('rpcode') && Utill::hasSession('rpcodeT') && Utill::hasSession('rpcodeTY')){
            $key = Utill::getSession('rpcode');
            $time = Utill::dateDiff(date('Y-m-d H:i:s', Utill::getSession('rpcodeT')), '%i');
            if($time < 30){
                return View::render('reset.verify', ['key'=> $key, 'id'=>Utill::getSession('rpcodeU')]);
            }
        }
        Utill::unsetSession();
        return View::render('errors.404');
    }

    /**
     * Show verify otp form for candidate reset password
     */
    public function verify2()
    {
        return $this->verify();
    }

}