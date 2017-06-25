<?php

namespace app\controllers;

use stdClass;
use Yii;
use yii\web\Controller;
use YiiNodeSocket\NodeSocket;

/**
 * NsEventExampleController controller.
 * 
 * @author Iskryzhytskyi Oleksandr <oleksandr.iskryzhytskyi@gmail.com>
 */
class NsEventExampleController extends Controller
{

    /**
     * Instruction page.
     * 
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Sending global event.
     * 
     * @return string
     */
    public function actionSendEvent()
    {
        /* @var $nodeSocket NodeSocket */
        $nodeSocket = Yii::$app->nodeSocket;
        $event = $nodeSocket->getFrameFactory()->createEventFrame();
        $event->setEventName('event.example');
        $event['data'] = [
            1,
            ['red', 'black', 'white'],
            new stdClass(),
            'simple string'
        ];
        $event->send();
        return $this->render('sendEvent');
    }

    /**
     * Sending event to room.
     * 
     * @return string
     */
    public function actionSendRoomEvent()
    {
        /* @var $nodeSocket NodeSocket */
        $nodeSocket = Yii::$app->nodeSocket;
        $event = $nodeSocket->getFrameFactory()->createEventFrame();
        $event->setRoom('example');
        $event->setEventName('example.room.event');
        $event['type_string'] = 'hello world';
        $event['type_array'] = [1, 2, 3];
        $event['type_object'] = ['one' => 1, 'two' => 2];
        $event['type_bool'] = true;
        $event['type_integer'] = 11;
        $event->send();
        return $this->render('sendRoomEvent');
    }

    /**
     * Catching events page.
     * 
     * @return string
     */
    public function actionEventListener()
    {
        Yii::$app->nodeSocket->registerClientScripts();
        return $this->render('eventListener');
    }

}
