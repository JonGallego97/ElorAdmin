<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Module;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\User;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\MessageData;

class FirebaseController extends Controller
{
    //enviar la notificacion dispositivo
    public function fcmTesting(){
        //dispositivo al que se enviara la notificacion
        $deviceToken="cjJYg4YSTl6ZPwyOEYIbpw:APA91bGBesFO8L8LNT3MxZoMGV7u-_2eg2OlFO6A3HoSYZnJeuPNbMNkvuNwfzey1xtkr_KrGOXEC_k3DLbLUzL4Z7FpOZZGLhBIweYv9_oRHjW_4AVGFte8uhDnAq1LJv-JcpJR3jtN";

        $user = User::where('id', 1)->value('name');
        $customData = [
            'customKey' => 'Custom_value',
            'anotherkey' => 'cutom_value_2'
        ];
        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withHighestPossiblePriority()
            ->withNotification(Notification::create($user,'Cuerpo del mensaje2'))
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
