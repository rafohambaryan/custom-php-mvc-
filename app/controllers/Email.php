<?php

class Email extends Controller
{
//    public $to;
//    public $subject;
//    public $message;
//    public $headers;
//

    public function init($data)
    {
        $this->to = $data['to'];
//        $this->subject = $subject;
//        $this->message = $message;
//        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function sendEmail($data)
    {

        return mail($data['to'],
            $data['subject'],
            $data['message'],
            $data['headers']);
    }

    public function sendEmailHTML($data)
    {

        return mail($data['to'],
            $data['subject'],
            $data['message'],
            $data['headers']);
    }
    public function content_html($href, $name='',$surename=''){
        $text = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        #active{
            width: 150px;
            height: 50px;
            border-radius: 15px;
            border: none;
            background-color: #00923F;
            font-size: 30px;
            font-weight: 600;
            font-family: "Blackadder ITC";
            color: #fffdfb;
        }
    </style>
</head>
<body>
<div style="text-align: center"><img src="https://rafogitc.tk/public/images/logo.png" alt=""></div>

<div style="text-align: center">
    <h2>Hello dear $name  $surename You have successfully registered to our system. Please activate your account</h2>
    <a href="$href"><button id="active">Activate</button></a>
    <p>Thank you for using our application! Regards,</p>
</div>
<div>
    <h2>contact:</h2>
    <p>Site: <i>rafogitc.tk</i></p>
    <p>E-mail: <i>info@rafogitc.tk</i></p>
    <p>Phone: <i>+37493646583</i></p>
    <p>Address: <i>GITC</i></p>
</div>
</body>
</html>

HTML;

        return $text;
    }
}