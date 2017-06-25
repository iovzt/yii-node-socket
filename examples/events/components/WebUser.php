<?php

namespace app\components;

use Exception;
use Yii;
use yii\web\IdentityInterface;
use yii\web\User;
use YiiNodeSocket\NodeSocket;

/**
 * WebUser class.
 *
 * @author Iskryzhytskyi Oleksandr <oleksandr.iskryzhytskyi@gmail.com>
 */
class WebUser extends User
{

    /**
     * @param IdentityInterface $identity
     * @param bool $cookieBased
     * @param int $duration
     */
    protected function afterLogin($identity, $cookieBased, $duration)
    {
        parent::afterLogin($identity, $cookieBased, $duration);
        /* @var $nodeSocket NodeSocket */
        $nodeSocket = Yii::$app->nodeSocket;
        $frame = $nodeSocket->getFrameFactory()->createAuthenticationFrame();
        $frame->setUserId($this->getId());
        try {

            $frame->send();
        } catch (Exception $ex) {

            Yii::error($ex->getMessage() . "\n" . $ex->getTraceAsString(), 'ext.nodesocket');
        }
    }

    /**
     * @param IdentityInterface $identity
     */
    protected function afterLogout($identity)
    {
        parent::afterLogout($identity);
        /* @var $nodeSocket NodeSocket */
        $nodeSocket = Yii::$app->nodeSocket;
        $frame = $nodeSocket->getFrameFactory()->createLogoutFrame();
        $frame->setUserId($this->getId());
        try {

            $frame->send();
        } catch (Exception $ex) {

            Yii::error($ex->getMessage() . "\n" . $ex->getTraceAsString(), 'ext.nodesocket');
        }
    }

}
