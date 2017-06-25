<?php

use yii\web\View;

/* @var $this View */
?>

<div id="state"></div>

<?php
$this->registerJs('
    
    var $state = $("#state");
    var updateState = function (message, data) {
        $state.append("<div>" + message + ", data type: [" + typeof data + "]</div>");
    };

    var socket = new YiiNodeSocket();
    socket.on("event.example", function (data) {
        updateState("Fired \"event.example\" event", data);
    });
    var inited = false;
    socket.onConnect(function () {  
        var room = socket.room("example");
        room._isJoined = false;
        room.join(function (success, membersCount) {            
            if (success) {
                updateState("Joined into room example: members count [" + membersCount + "]");              
                if(!inited) {
                    inited = true;
                    this.on("example.room.event", function (data) {
                        updateState("Receive event in example room, event: example.room.event", data);
                    });
                    this.on("join", function (membersCount) {
                        updateState("New member joined, new members count is: " + membersCount);
                    });
                }
            } else {
                updateState("Join error: " + membersCount);
            }
        });
    });         
');
