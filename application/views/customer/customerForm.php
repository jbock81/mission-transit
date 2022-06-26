<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Mission Transit, LLC</title>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>

<!-- Load the `mapbox-gl-geocoder` plugin. -->
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">

<style>
body { margin: 0; padding: 0; }
#map { position: absolute; top: 0; bottom: 0; width: 100%; }
.place_name {
    display: table;
    position: relative;
    height: 10vh;
    margin: 10px auto;
    word-wrap: anywhere;
    white-space: pre-wrap;
    padding: 10px;
    font-size: 16pt;
    font-weight: bold;
    text-align: center;
    color: #4d90fe;
    background: white;
}
#div_form {
    position:absolute;
    width: 80%;
    height: 36vh;
    bottom: 30px;
    margin-left: 10%;
}
.mapboxgl-ctrl-geocoder {
    min-width: 100%;
}
#start_addr .mapboxgl-ctrl-geocoder:first-child {
  z-index: 1001;
}
#dest_addr .mapboxgl-ctrl-geocoder:first-child {
  z-index: 1000;
}
</style>
</head>
<body>
    <div id="map"></div>
    <div id="div_form">
        <div class="row" id="frm1" style="height:100%;">
            <div class="col-md-4">
            </div>
            <div class="col-md-4" style="background: #ffffff; border-radius:20px;">
                <div class="form-group" style="vertical-align: middle;">
                    <label id="lbl_start_addr" class="place_name">Please type your home address</label>
                </div>
                <div class="form-group">
                    <div id="start_addr" style="width: 100%;"></div>
                </div>
                <div class="form-group">
                    <label for="at_work_by">I must arrive at work by:</label>
                    <select id="at_work_by" class="form-control required">
                        <option value="07:00:00">7.00 a.m.</option>
                        <option value="07:30:00">7.30 a.m.</option>
                        <option value="08:00:00">08.00 a.m.</option>
                        <option value="08:30:00">08.30 a.m.</option>
                        <option value="09:00:00">09.00 a.m.</option>
                        <option value="09:30:00">09.30 a.m.</option>
                        <option value="10:00:00">10.00 a.m.</option>
                    </select>
                </div>
                <div class="form-group" style="text-align: center;">
                    <button id="btn_to_step2" class="btn btn-lg btn-info" style="width: 80%;"><i class="fa fa-paper-plane"></i> Continue</button>
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        <div class="row" id="frm2" style="height:100%;">
            <div class="col-md-4">
            </div>
            <div class="col-md-4" style="background: #ffffff; border-radius:20px;">
                <div class="form-group" style="vertical-align: middle;">
                    <label id="lbl_dest_addr" class="place_name">Please type your work address</label>
                </div>
                <div class="form-group">
                    <div id="dest_addr" style="width: 100%;"></div>
                </div>
                <div class="form-group">
                    <label for="off_work_at">I finish work at:</label>
                    <select id="off_work_at" class="form-control required">
                        <option value="15:00:00">3.00 p.m.</option>
                        <option value="15:30:00">3.30 p.m.</option>
                        <option value="16:00:00">4.00 p.m.</option>
                        <option value="16:30:00">4.30 p.m.</option>
                        <option value="17:00:00">5.00 p.m.</option>
                        <option value="17:30:00">5.30 p.m.</option>
                        <option value="18:00:00">6.00 p.m.</option>
                        <option value="18:30:00">6.30 p.m.</option>
                        <option value="19:00:00">7.00 p.m.</option>
                    </select>
                </div>
                <div class="form-group" style="text-align: center;">
                    <button id="btn_to_step3" class="btn btn-lg btn-info" style="width: 80%;"><i class="fa fa-paper-plane"></i> Continue</button>
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        <div class="row" id="frm3" style="height:80%;">
            <div class="col-md-4">
            </div>
            <div class="col-md-4" style="background: #ffffff; border-radius:20px;">
                <div class="form-group" style="vertical-align: middle;">
                    <label class="place_name">Please enter your email</label>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" class="form-control required" placeholder="Your email"/>
                </div>
                <div class="form-group" style="text-align: center;">
                    <button id="btn_submit" class="btn btn-lg btn-info" style="width: 80%;"><i class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
<script>
    function validateEmail(vEmail){
        var mailformat = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/;
        if(vEmail.match(mailformat)){
            return true;
        }else{
            return false;
        }
    }

    function step1() {
        $("#frm1").show();
        $("#frm2").hide();
        $("#frm3").hide();
    }

    function step2() {
        $("#frm1").hide();
        $("#frm2").show();
        $("#frm3").hide();
    }

    function step3() {
        $("#frm1").hide();
        $("#frm2").hide();
        $("#frm3").show();
    }

    function moveHandler1() {
        
    }

    function moveHandler2() {
        
    }

$(document).ready(function(){
    var step = 1;
    var start_lng = 0;
    var start_lat = 0;
    var dest_lng = 0;
    var dest_lat = 0;
    step1();
	// TO MAKE THE MAP APPEAR YOU MUST
	// ADD YOUR ACCESS TOKEN FROM
	// https://account.mapbox.com
    const token = "pk.eyJ1IjoiYW5kcmVqczE5NzkiLCJhIjoiY2s4ZXg3M3hxMDBtaDNkbjZwMGl1ZGNkMCJ9.lfRQSV9ls7UYOQgG4zJSSg";
	mapboxgl.accessToken = token;
    const map = new mapboxgl.Map({
        container: 'map', // container ID
        style: 'mapbox://styles/mapbox/streets-v11', // style URL
        center: [-73.989, 40.733], // starting position [lng, lat]
        zoom: 13 // starting zoom
    });

    // disable map rotation using right click + drag
    map.dragRotate.disable();
 
    // disable map rotation using touch rotation gesture
    map.touchZoomRotate.disableRotation();

    const locStart = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl,
        marker: false
    });
    locStart.on('result', function(ev) {
        $("#lbl_start_addr").text(ev.result.place_name);
        marker1.setLngLat(ev.result.center);
        marker1.addTo(map);
        // map.once('moveend', moveHandler1);
    });
    $("#start_addr").append(locStart.onAdd(map));

    const locDest = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl,
        marker: false
    });
    locDest.on('result', function(ev) {
        $("#lbl_dest_addr").text(ev.result.place_name);
        marker2.setLngLat(ev.result.center);
        marker2.addTo(map);
        // map.once('moveend', moveHandler2);
    });
    $("#dest_addr").append(locDest.onAdd(map));

    var r_gc_prefix = "https://api.mapbox.com/geocoding/v5/mapbox.places/";
    var r_gc_suffix = ".json?types=address&access_token=" + token;
    var r_gc_api = "";
    // Add a new Marker.
    const marker1 = new mapboxgl.Marker({
        color: '#F84C4C' // color it red
    });

    const marker2 = new mapboxgl.Marker({
        color: '#4C4CF8' //
    });

    map.on('click', (e) => {
        if (step == 1 || step == 2){
            // console.log(e.lngLat.wrap());
            r_gc_api = r_gc_prefix + e.lngLat.lng + "," + e.lngLat.lat + r_gc_suffix;
            // Create a default Marker and add it to the map.
            if (step == 1) {
                marker1.setLngLat([e.lngLat.lng, e.lngLat.lat]);
                marker1.addTo(map);
                $.get(r_gc_api, function(res){
                    $("#lbl_start_addr").text(res.features[0].place_name);
                    $("#start_addr .mapboxgl-ctrl-geocoder--input").val(res.features[0].place_name);
                });
            }
            if (step == 2) {
                marker2.setLngLat([e.lngLat.lng, e.lngLat.lat]);
                marker2.addTo(map);
                $.get(r_gc_api, function(res){
                    $("#lbl_dest_addr").text(res.features[0].place_name);
                    $("#dest_addr .mapboxgl-ctrl-geocoder--input").val(res.features[0].place_name);
                });
            }
        }
    });

    $("#btn_to_step2").click(function(){
        step = 2;
        step2();
    });

    $("#btn_to_step3").click(function(){
        step = 3;
        step3();
    });

    $("#btn_submit").click(function(){
        var email = $("#email").val();
        if (!validateEmail(email)){
            alert("You have entered an invalid email address!");
            $("#email").focus();
            return;
        }
        // var payment_status = $("#payment_status option:selected").val();
        // var qr_code_ref = $("#qr_code_ref").val();
        // if (qr_code_ref.length == 0) {
        //     alert("You have not entered a QR code reference!");
        //     return;
        // }
        var sp = $("#lbl_start_addr").text();
        var dp = $("#lbl_dest_addr").text();
        if (sp.length == 0) {
            alert("You have not entered the starting point!");
            return;
        }
        if (dp.length == 0) {
            alert("You have not entered the end point!");
            return;
        }

        var arr_sp = sp.split(", ");
        var arr_dp = dp.split(", ");
        if (arr_sp.length < 4) {
            alert("You have entered an invalid address for starting point!");
            return;
        }
        if (arr_dp.length < 4) {
            alert("You have entered an invalid address for end point!");
            return;
        }

        var post_url = "<?php echo base_url(); ?>addCustomer";
        $.post(
            post_url,
            {
                // payment_status: payment_status,
                // qr_code_ref: qr_code_ref,
                email: email,
                start_point: sp,
                end_point: dp,
                at_work_by: $("#at_work_by option:selected").text(),
                off_work_at: $("#off_work_at option:selected").text()
            },
            function(res){
                if (res == "success") {
                    alert("Thank you. We will contact you about your trip shortly.");
                    location.href = "<?php echo base_url(); ?>customer";
                }
            }
        );
    });
});

    
</script> 
</body>
</html>