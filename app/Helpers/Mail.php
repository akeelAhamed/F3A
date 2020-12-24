<?php
namespace App\Helpers;

require(ROOT_DIR."vendor/phpmailer/phpmailer/src/PHPMailer.php");
require(ROOT_DIR."vendor/phpmailer/phpmailer/src/Exception.php");

class Mail {

    /**
     * @var $view holds mail view
     */
    protected $view;

    /**
     * @var $data holds mail data
     */
    protected $data = [];

    /**
     * @var $mail holds mail object
     */
    protected $mail;

    /**
     * Mail error
     */
    public $error;

    /**
     * Init mail
     */
    public function __construct($e=true)
    {
        $this->mail = new \PHPMailer\PHPMailer\PHPMailer($e); // Passing `true` enables exceptions
        $this->mail->isHTML(true);                           // Set email format to HTML
        $this->mail->Subject = 'Mail from '. APP_NAME;
        $this->mail->Body    = 'Greeting from <b>'.APP_NAME.'!</b>';
    }

    /**
     * Build the message.
     *
     * @param string $view Html view
     * @param array  $data Data to view
     * 
     * @return $this
     */
    public function view($view, $data=[])
    {
        $this->view = $view;
        $this->data = $data;
        $this->mail->Body = \App\Helpers\View::render($view, $data, true);
        return $this;
    }

    /**
     * Add subject to mail
     * 
     * @param string $title Email subject
     */
    public function subject($title)
    {
        $this->mail->Subject = APP_NAME.' | '.$title;
        return $this;
    }

    /**
     * Add send to address
     * 
     * @param string $email Email to send
     */
    public function to($email)
    {
        $this->mail->addAddress($email);
        return $this;
    }
    

    /**
     * Attach file with mail
     * 
     * @param string $file File to attach
     */
    public function attach($file)
    {
        $this->mail->addAttachment($file);
        return $this;
    }

    /**
     * Final method to send email
     *
     * @param boolean $send
     * @return void
     */
    public function send($send=true)
    {
        if(!$send){
            return \App\Helpers\View::render($this->view, $this->data);
        }
        try {
            //Server settings
            $this->mail->SMTPDebug = 0;                             // Enable verbose debug output
            $this->mail->isSMTP();                                  // Set mailer to use SMTP
            $this->mail->Host = 'mail.hellobuilder.net';            // Specify main and backup SMTP servers
            $this->mail->SMTPAuth = true;                           // Enable SMTP authentication
            $this->mail->Username = 'support@hellobuilder.net';     // SMTP username
            $this->mail->Password = 'M2fmB9YdEaQS';                  // SMTP password
            $this->mail->SMTPSecure = 'tls';                        // Enable TLS encryption, `ssl` also accepted

            // $this->mail->Host = 'steel.arcfense.com';            // Specify main and backup SMTP servers
            // $this->mail->Host = 'steel.arcfense.com';    
            // $this->mail->Username = 'support@erodespiceroundtable.org';     // SMTP username
            // $this->mail->Password = 'support@erodespiceroundtable.org';     // SMTP password
            // $this->mail->SMTPSecure = 'tls';
            

            $this->mail->Port = 587;                                // TCP port to connect to

            //Recipients
            $this->mail->setFrom('support@erodespiceroundtable.org');
            // $this->mail->addAddress('someone@example.com');      // Add a recipient // Name is optional

            
            $this->mail->AltBody = \strip_tags($this->mail->Body);

            return $this->mail->send();
        } catch (\Exception $e) {
            $this->error = $this->mail->ErrorInfo;
            return false;
        }
    }
}