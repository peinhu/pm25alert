<?php

namespace Core;

use PHPMailer;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class EmailNotification implements NotificationInterface
{

    public function sendMessage($user)
    {

        $email_config = config('notification')->email;

        $mail = new PHPMailer;
        $mail->Mailer = $email_config->driver;
        $mail->Host = $email_config->host;
        $mail->SMTPAuth = true;
        $mail->Username = $email_config->username;
        $mail->Password = $email_config->password;
        $mail->SMTPSecure = $email_config->encryption;
        $mail->Port = $email_config->port;
        $mail->setFrom($email_config->username, 'do-not-reply');
        $mail->addAddress($user->email, $user->name);
        $mail->isHTML(true);
        $mail->Subject = '[PM2.5告警] '.date('m月d日',time());
        $mail->Body    = $this->generateMessageContent($user);

        $log = new Logger('Email');
        $log->pushHandler(new StreamHandler(__DIR__.'/../log/email_error.log', Logger::ERROR));

        if(!$mail->send()) {
            $log->addError($mail->ErrorInfo,['name'=>$user->name,'email'=>$user->email,'api_url'=>$user->api_url]);
        }
    }

    protected function generateMessageContent($user)
    {
        $userResponse = $user->response;

        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'.
        '<html>'.
        '<head>'.
        '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'.
        '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>'.
        '<meta name="format-detection" content="telephone=no" />'.
        '</head>'.
        '<body style="margin: 0; padding: 0;">'.
        '<div style="display:none;">'.tipsOnPollutionLevel($userResponse->pollutionLevel).'</div>'.
            '<table vertical-align="top" border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;color:#ffffff;text-indent:3px;" bgcolor="#2AAF87" bordercolor="white">'.
            ' <tr>'.
                ' <th width="100" align="left">条目</th>'.
                ' <th align="left">详情</th>'.
            '</tr>'.
            ' <tr>'.
                ' <td>地点</td>'.
                ' <td>'.$userResponse->positionName.'</td>'.
            '</tr>'.
            ' <tr>'.
                ' <td>污染等级(共六级)</td>'.
                ' <td><span style="border-radius:3px;padding-left:3px;padding-right:3px;background:'.getColorByPollutionLevel($userResponse->pollutionLevel).'">'.displayByPollutionLevel($userResponse->pollutionLevel).'</span>  '.tipsOnPollutionLevel($userResponse->pollutionLevel).'</td>'.
            '</tr>'.
            ' <tr>'.
                ' <td>首要污染物</td>'.
                ' <td>'.$userResponse->primaryPollutant.'</td>'.
            '</tr>'.
            ' <tr>'.
                ' <td>空气质量指数</td>'.
                ' <td>'.$userResponse->aqi.'</td>'.
            '</tr>'.
            ' <tr>'.
                ' <td>PM2.5浓度</td>'.
                ' <td>'.$userResponse->pm25.' μg/m3</td>'.
            '</tr>'.
            '<tr>'.
                ' <td>监测时间</td>'.
                ' <td>'.$userResponse->timePoint.'</td>'.
            '</tr>'.
            '<tr>'.
                ' <td>告警等级</td>'.
                ' <td><span style="border-radius:3px;padding-left:3px;padding-right:3px;background:'.getColorByPollutionLevel($user->alert_level).'">'.displayByPollutionLevel($user->alert_level).'</span></td>'.
            '</tr>'.
            '<tr>'.
                ' <td>告警时间</td>'.
                ' <td>'.$user->alert_time.'</td>'.
            '</tr>'.
            '</table>'.
        '<div style="margin-top:20px;">收到此邮件是因为您订阅了PM2.5告警服务，如有任何问题请通过以下方式联系。'.
        '<p>QQ:'.config('contact')->qq.'</p>'.
        '<p>邮箱:'.config('contact')->email.'</p>'.
        '<p>电话:'.config('contact')->telephone.'</p>'.
        '</div>'.
        '</body>'.
        '</html>';

    }
}