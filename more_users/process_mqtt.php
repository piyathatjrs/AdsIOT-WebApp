
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="paho-mqtt.js"></script>
<script>
   
    client = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId");
    client2 = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId2");
    client3 = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId3");
    client4 = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId4");
    client5 = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId5");



    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

    client2.onConnectionLost = onConnectionLost2;
    client2.onMessageArrived = onMessageArrived2;

    client3.onConnectionLost = onConnectionLost3;
    client3.onMessageArrived = onMessageArrived3;

    client4.onConnectionLost = onConnectionLost4;
    client4.onMessageArrived = onMessageArrived4;

    client5.onConnectionLost = onConnectionLost5;
    client5.onMessageArrived = onMessageArrived5;

    ///////////////////////////
    client.connect({
        useSSL: true,
        userName: "zpfdcyrx",
        password: "OypjtCmtYhqp",
        onSuccess: onConnect
    });

    client2.connect({
        useSSL: true,
        userName: "zpfdcyrx",
        password: "OypjtCmtYhqp",
        onSuccess: onConnect2
    });

    client3.connect({
        useSSL: true,
        userName: "zpfdcyrx",
        password: "OypjtCmtYhqp",
        onSuccess: onConnect3
    });

    client4.connect({
        useSSL: true,
        userName: "zpfdcyrx",
        password: "OypjtCmtYhqp",
        onSuccess: onConnect4
    });

    client5.connect({
        useSSL: true,
        userName: "zpfdcyrx",
        password: "OypjtCmtYhqp",
        onSuccess: onConnect5
    });

    function onConnect() {
        console.log("onConnect");
        client.subscribe("TEST/MQTT_DHT11");
        message = new Paho.MQTT.Message("กำลังประมวลผล");
        message.destinationName = "TEST/MQTT_DHT11";
        client.send(message);
    }

    function onConnect2() {
        console.log("onConnect2");
        client2.subscribe("TEST/MQTT_SOIL");
        message = new Paho.MQTT.Message("กำลังประมวลผล");
        message.destinationName = "TEST/MQTT_SOIL";
        client2.send(message);
    }

    function onConnect3() {
        console.log("onConnect3");
        client3.subscribe("TEST/MQTT_WATER");
        message = new Paho.MQTT.Message("กำลังประมวลผล");
        message.destinationName = "TEST/MQTT_WATER";
        client3.send(message);
    }

    function onConnect4() {
        console.log("onConnect4");
        client4.subscribe("TEST/MQTT_RAIN");
        message = new Paho.MQTT.Message("กำลังประมวลผล");
        message.destinationName = "TEST/MQTT_RAIN";
        client4.send(message);
    }


    function onConnect5() {
        console.log("onConnect5");
        client5.subscribe("TEST/MQTT_GYRO");
        message = new Paho.MQTT.Message("กำลังประมวลผล");
        message.destinationName = "TEST/MQTT_GYRO";
        client5.send(message);
    }

    ///////////////////////////////////////////
    function onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }
   
    function onMessageArrived(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString);
        document.getElementById('TEST/MQTT_DHT11').innerHTML = "<h4>" + message.payloadString + "°C</h4>";
  
       
    }
    function onConnectionLost2(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }
    function onMessageArrived2(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString);
        document.getElementById('TEST/MQTT_SOIL').innerHTML = "<h4>" + message.payloadString + "%</h4>";

        
    }
    function onConnectionLost3(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }
    function onMessageArrived3(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString);
        document.getElementById('TEST/MQTT_WATER').innerHTML = "<h4>" + message.payloadString + "%</h4>";
        
    }

    function onConnectionLost4(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    function onMessageArrived4(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString);
        document.getElementById('TEST/MQTT_RAIN').innerHTML = "<h4>" + message.payloadString + "%</h4>";

       
    }

    function onConnectionLost5(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    function onMessageArrived5(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString);
        document.getElementById('TEST/MQTT_GYRO').innerHTML = message.payloadString;
    }
</script>