<script src="paho-mqtt.js"></script>
<script>
    client = new Paho.MQTT.Client("tailor.cloudmqtt.com", Number(34090), "clientId");
    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;
    ///////////////////////////
    client.connect({
        useSSL: true,
        userName: "zpfdcyrx",
        password: "OypjtCmtYhqp",
        onSuccess: onConnect
    });
    function onConnect() {
        console.log("onConnect");
        client.subscribe("TEST/MQTT_DHT11");
        message = new Paho.MQTT.Message("0");
        message.destinationName = "TEST/MQTT_DHT11";
        client.send(message);
    }
    ///////////////////////////////////////////
    function onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }
    function onMessageArrived(message) {
        console.log("onMessageArrived:" + message.payloadString);
        console.log(message.payloadString)
        document.getElementById('Value_dht11').innerHTML = message.payloadString;
    }
</script>