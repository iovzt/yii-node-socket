<?php

use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
?>

<h3>Event successfully sent</h3>
<a href="<?php echo Url::to(['send-room-event']); ?>">Resend event</a>