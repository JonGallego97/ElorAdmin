<?php

namespace App\Http\Controllers\API;

use App\Models\Module;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\MessageData;

class FirebaseController extends Controller
{
    //enviar la notificacion dispositivo
    public function fcmTesting(){
        //dispositivo al que se enviara la notificacion
        $deviceToken="j";

        $customData = [
            'CustomKey' => 'Custom_value',
            'anotherkey' => 'cutom_value_2'
        ];
        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withHighestPossiblePriority()
            ->withNotification(Notification::create('Titulo','Cuerpo del mensaje'))
            ->withData(MessageData::fromArray($customData));

        $firebase = app('firebase.messaging');
        try {
            $firebase->send($message);
            return response()->json(['message' => 'Notificación enviada con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
