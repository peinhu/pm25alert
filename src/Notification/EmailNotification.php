<?php

namespace Core\Notification;

use Core\Log;
use PHPMailer;

class EmailNotification implements Notification
{

    public function send($subscriber)
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
        $mail->addAddress($subscriber->email, $subscriber->name);
        $mail->isHTML(true);
        $mail->Subject = '[PM2.5告警] ' . date('m月d日', time());
        $mail->Body = $this->generateContent($subscriber);

        if ( ! $mail->send() ) {
            Log::failToNotify($subscriber->name, $subscriber->email, $mail->ErrorInfo);

            return false;
        }

        return true;

    }

    protected function generateContent($subscriber)
    {
        $apiResponse = $subscriber->response;

        $contactConfig = config('contact');

        $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' .
            '<html>' .
            '<head>' .
            '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' .
            '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>' .
            '<meta name="format-detection" content="telephone=no" />' .
            '</head>' .
            '<body style="margin: 0; padding: 0;">' .
            '<div style="display:none;">' . tipsOnPollutionLevel($apiResponse->pollutionLevel) . '</div>' .
            '<table vertical-align="top" border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;color:#ffffff;text-indent:3px;" bgcolor="#2AAF87" bordercolor="white">' .
            '<tr>' .
            '<th width="100" align="left">条目</th>' .
            '<th align="left">详情</th>' .
            '</tr>' .
            '<tr>' .
            '<td>地点</td>' .
            '<td>' . $apiResponse->positionName . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td>污染等级(共六级)</td>' .
            '<td><span style="border-radius:3px;padding-left:3px;padding-right:3px;background:' . getColorByPollutionLevel($apiResponse->pollutionLevel) . '">' . displayByPollutionLevel($apiResponse->pollutionLevel) . '</span>  ' . tipsOnPollutionLevel($apiResponse->pollutionLevel) . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td>首要污染物</td>' .
            '<td>' . $apiResponse->primaryPollutant . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td>空气质量指数</td>' .
            '<td>' . $apiResponse->aqi . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td>PM2.5浓度</td>' .
            '<td>' . $apiResponse->pm25 . ' μg/m3</td>' .
            '</tr>' .
            '<tr>' .
            '<td>监测时间</td>' .
            '<td>' . $apiResponse->timePoint . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td>告警等级</td>' .
            '<td><span style="border-radius:3px;padding-left:3px;padding-right:3px;background:' . getColorByPollutionLevel($subscriber->alertLevel) . '">' . displayByPollutionLevel($subscriber->alertLevel) . '</span></td>' .
            '</tr>' .
            '<tr>' .
            '<td>告警时间</td>' .
            '<td>' . $subscriber->alertTime . '</td>' .
            '</tr>' .
            '<tr>' .
            '<td>分级标准</td>' .
            '<td>' . call_user_func([config('app')->standard, 'name']) . '</td>' .
            '</tr>' .
            '</table>';

        $html .= '<div style="margin-top:20px;">收到此邮件是因为您订阅了PM2.5告警服务，如有任何问题请联系服务提供方。';
        $html .= empty($contactConfig->qq) ? '' : '<p>QQ:' . $contactConfig->qq . '</p>';
        $html .= empty($contactConfig->email) ? '' : '<p>邮箱:' . $contactConfig->email . '</p>';
        $html .= empty($contactConfig->telephone) ? '' : '<p>电话:' . $contactConfig->telephone . '</p>';
        $html .= '</div>' . '</body>' . '</html>';

        return $html;

    }
}