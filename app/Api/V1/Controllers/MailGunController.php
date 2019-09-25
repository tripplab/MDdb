<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MailingLog;
use Illuminate\Http\Request;

//use Vinkla\Pusher\Facades\Pusher;

class MailGunController extends Controller
{
    public function index()
    {
    }

    public function info(Request $request)
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if (isset($request['event-data'])) {
            $arr = $request['event-data'];
        } else {
            $arr = $request;
        }

        $variables = $arr['user-variables'];

        if (! empty($variables) && isset($variables['mailing_id'])) {
            $mailing_log = new MailingLog();
            $mailing_log->mailing_id = $variables['mailing_id'];
            $mailing_log->monthly_cut_id = $variables['monthly_cut_id'];
            $mailing_log->investor_id = ('' != $variables['investor_id'] ? $variables['investor_id'] : null);
        }

        switch ($arr['event']) {
            case 'delivered':
                app('log')->log('info', date('Y-m-d H:i:s', $arr['timestamp']).': Correo entregado a: '.$arr['recipient']);
                //Pusher::trigger('info', 'correo', ['message' => date('Y-m-d H:i:s', $arr['timestamp']) . ': Correo entregado a: ' . $arr['recipient'] ]);
                if (! empty($variables) && isset($variables['mailing_id'])) {
                    $mailing_log->event = $arr['event'];
                    $mailing_log->email = $arr['recipient'];
                    $mailing_log->message = 'Correo entregado satisfactoriamente';
                    $mailing_log->timestamp = date('Y-m-d H:i:s', $arr['timestamp']);
                }
                break;
            case 'failed':
                app('log')->log('error', date('Y-m-d H:i:s', $arr['timestamp']).': Error al enviar correo a '.$arr['recipient'].'; motivo: '.$arr['delivery-status']['description']);
                //Pusher::trigger('info', 'correo', ['message' => date('Y-m-d H:i:s', $arr['timestamp']) . ': Error al enviar correo a ' . $arr['recipient'] . '; motivo: ' . $arr['delivery-status']['description']]);

                if (! empty($variables) && isset($variables['mailing_id'])) {
                    $mailing_log->event = $arr['event'];
                    $mailing_log->email = $arr['recipient'];
                    $mailing_log->message = $this->getMessageLog($arr['reason'], $arr['delivery-status']['message']);
                    $mailing_log->timestamp = date('Y-m-d H:i:s', $arr['timestamp']);
                }
                break;
            case 'bounced':
                app('log')->log('error', date('Y-m-d H:i:s', $arr['timestamp']).': Error al enviar correo a '.$arr['recipient'].'; motivo: '.$arr['error']);
                //Pusher::trigger('info', 'correo', ['message' => date('Y-m-d H:i:s', $arr['timestamp']) . ': Error al enviar correo a ' . $arr['recipient'] . '; motivo: ' . $arr['error']]);
                if (! empty($variables) && isset($variables['mailing_id'])) {
                    $mailing_log->event = $arr['event'];
                    $mailing_log->email = $arr['recipient'];
                    $mailing_log->message = $arr['error'];
                    $mailing_log->timestamp = date('Y-m-d H:i:s', $arr['timestamp']);
                }
                break;
            case 'opened':
                app('log')->log('info', date('Y-m-d H:i:s', $arr['timestamp']).': '.$arr['recipient'].' ha leído su correo');
                if (! empty($variables) && isset($variables['mailing_id'])) {
                    $mailing_log->event = $arr['event'];
                    $mailing_log->email = $arr['recipient'];
                    $mailing_log->message = 'El correo ha sido leído';
                    $mailing_log->timestamp = date('Y-m-d H:i:s', $arr['timestamp']);
                }
                break;
        }

        if (! empty($variables) && isset($variables['mailing_id'])) {
            $mailing_log->save();
        }

        return response('OK', 200)->header('X-PHP-Response-Code: 200', true, 200);
    }

    public function getMessageLog($reason, $description)
    {
        switch ($reason) {
            case 'old':
                return 'Hay un problema con el dominio o no existe.';
                break;

            case 'bounce':
                return 'La dirección de email no existe.';
                break;

            case 'suppress-bounce':
                return 'El correo fue rechazado por el proveedor.';
                break;

            case 'suppress-complaint':
                return 'El usuario ha marcado estos correos como SPAM.';
                break;

            case 'generic':
                return $description;
                break;
        }
    }
}
