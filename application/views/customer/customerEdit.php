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
#map { position: relative; width: 100%; height: 50rem;}
.mapboxgl-ctrl-geocoder {
    min-width: 100%;
}
.commute-label {
    background-color: #4d90fe; 
    color: #fff;
}
.commute-label2 {
    background-color: #808080; 
    color: #fff;
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

<div class="container" style="max-width: 90%;">
    <div style="margin-top: 10px; height: 100px; padding-top: 10px;">
        <h1 style="color: darkgray; text-align: center;">Customer Edit</h1>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div id="map"></div>                    
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 10px;">
                        <label for="email">User Email:</label>
                        <input type="email" id="email" name="email" class="form-control required" value="<?php echo $customerInfo->user_email;?>"/>
                    </div>
                    <div class="form-group commute-label" style="padding: 5px;">
                        <label style="font-size: 16pt;"><u><i><b>Commute Requirements</b></i></u></label>
                    </div>
                    <!-- <div class="form-group">
                        <label for="payment_status">Payment Status:</label>
                        <select id="payment_status" class="form-control required">
                            <option value="0">Not Paid</option>
                            <option value="1">Paid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="qr_code_ref">QR Code Reference:</label>
                        <input type="text" id="qr_code_ref" name="qr_code_ref" class="form-control required"  value="<?php echo $customerInfo->qr_code_ref;?>"/>
                    </div> -->
                    <div class="form-group">
                        <label for="start_addr">Starting Point:</label>
                        <div id="start_addr" style="width: 100%;"></div>
                    </div>
                    <div class="form-group">
                        <label for="dest_addr">End Point:</label>
                        <div id="dest_addr" style="width: 100%;"></div>
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
                    <div class="form-group commute-label2" style="padding: 5px;">
                        <label style="font-size: 12pt;">All Commutes are currently only for Monday - Friday.</label>
                    </div>
                    <hr />
                    <div class="form-group">
                        <button id="btn_update" class="btn btn-primary float-right"><i class="fa fa-paper-plane"></i> Update</button>
                    </div>
                    <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customerInfo->id;?>"/>
                </div>
            </div>
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

    $(document).ready(function(){
        // TO MAKE THE MAP APPEAR YOU MUST
        // ADD YOUR ACCESS TOKEN FROM
        // https://account.mapbox.com
        const token = 'pk.eyJ1IjoiYW5kcmVqczE5NzkiLCJhIjoiY2s4ZXg3M3hxMDBtaDNkbjZwMGl1ZGNkMCJ9.lfRQSV9ls7UYOQgG4zJSSg';
        mapboxgl.accessToken = token;
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [-79.4512, 43.6568],
            zoom: 13
        });

        const locStart = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl,
            marker: true
        });

        const locDest = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl,
            marker: true
        });
        
        map.addControl(new mapboxgl.FullscreenControl());
        // Add zoom and rotation controls to the map.
        map.addControl(new mapboxgl.NavigationControl());

        $("#start_addr").append(locStart.onAdd(map));
        $("#dest_addr").append(locDest.onAdd(map));

        // var payment_old = eval("<?php // echo $customerInfo->payment_status; ?>");
        // var qr_code_ref_old = "<?php // echo $customerInfo->qr_code_ref; ?>";
        var street_addr1 = "<?php echo $customerInfo->street_addr1; ?>";
        var city1 = "<?php echo $customerInfo->city1; ?>";
        var state1 = "<?php echo $customerInfo->state1; ?>";
        var zip_code1 = "<?php echo $customerInfo->zip_code1; ?>";
        var country1 = "<?php echo $customerInfo->country1; ?>";
        var street_addr2 = "<?php echo $customerInfo->street_addr2; ?>";
        var city2 = "<?php echo $customerInfo->city2; ?>";
        var state2 = "<?php echo $customerInfo->state2; ?>";
        var zip_code2 = "<?php echo $customerInfo->zip_code2; ?>";
        var country2 = "<?php echo $customerInfo->country2; ?>";
        var at_work_by_old = "<?php echo $customerInfo->at_work_by; ?>";
        var off_work_at_old = "<?php echo $customerInfo->off_work_at; ?>";

        $("#start_addr .mapboxgl-ctrl-geocoder--input").val(street_addr1 + ", " + city1 + ", " + state1 + " " + zip_code1 + ", " + country1);
        $("#dest_addr .mapboxgl-ctrl-geocoder--input").val(street_addr2 + ", " + city2 + ", " + state2 + " " + zip_code2 + ", " + country2);

        // $("#payment_status").val(payment_old);
        // $("#qr_code_ref").val(qr_code_ref_old);
        $("#at_work_by option:contains(" + at_work_by_old + ")").attr('selected', 'selected');
        $("#off_work_at option:contains(" + off_work_at_old + ")").attr('selected', 'selected');

        $("#btn_update").click(function(){
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
            var sp = $("#start_addr .mapboxgl-ctrl-geocoder--input").val();
            var dp = $("#dest_addr .mapboxgl-ctrl-geocoder--input").val();
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

            var post_url = "<?php echo base_url(); ?>editCustomer";
            $.post(
                post_url,
                {
                    customer_id: $("#customer_id").val(),
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
                        location.href = "<?php echo base_url(); ?>viewAllCustomers";
                    } else {
                        alert("You failed in updating customer information. Please contact the developer.");
                    }
                    if (res == "same") {
                        alert("You have entered the same information. Please try another.");
                    }
                }
            );
        });

        $("#btn_customers").click(function(){
            location.href = "<?php echo base_url(); ?>viewAllCustomers";
        });
    });

</script>

</body>
</html>