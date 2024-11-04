<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap 5 Starter Template</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- <link rel="stylesheet" href="custom.css"> -->
</head>
<style>
    body {
        background-image: url('/assets/images/mesh-bg.png');
        background-color: #168351;
        background-repeat: repeat;
        background-size: cover;
        color: #fff;
        font-size: 1.2rem;
        min-height: 100%;
        height: auto;
    }

    .header-logo {
        max-width: 140px;
    }

    .my-alert {
        max-width: 60rem;
    }
    .my-alert-icon{
        max-width: 15rem;
    }
</style>

<body>
    <nav class="navbar bg-body-tertiary bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/assets/images/logo.png" alt="Logo" class="d-inline-block align-text-top header-logo">
            </a>
        </div>
    </nav>
    <div class="container my-alert mt-5">
        <div class="bg-white text-dark px-5 py-3 rounded text-center">
            <img src="/assets/images/red-alert-icon.svg" class="my-alert-icon" >
            <div class="my-2">
                <h2 >Invalid Serial &nbsp;<i class="icon ion-close-round text-danger"></i></h2>
            </div>
            <p ><b>This product could not be verified. Please double check that you entered the correct serial number.</b></p>
        </div>
    </div>

    <header class="py-5 border-bottom">
        <div class="container pt-md-1 pb-md-4">
            <div class="row">
                <div class="col-xl-8">
                    <h1 class="bd-title mt-0">Verify Product</h1>
                    <p class="bd-lead"></p>
                    <div class="d-flex flex-column flex-sm-row">
                        <form action="" class="row" style="width: 100%;">
                            <div class="col-md-6">
                                <input type="text" class="form-control float-left col-md-12" name="code" id="code">
                                <input type="hidden" id="address" value="">
                                <input type="hidden" id="lng" value="">
                                <input type="hidden" id="lat" value="">
                                <span class="error codeerr"></span>
                                <div id="suc">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary float-left col-dmd-3" type="button"
                                    id="verify">Verify</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container" style="display: none">
        <!-- Your content goes here -->
        <h1>Your Location</h1>
        <p id="location-info">Waiting for location...</p>
        <button onclick="getLocation()">Get My Location</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script>
        jQuery('#verify').click(function() {
            var code = jQuery('#code').val();
            if (code == '') {
                jQuery('.codeerr').text('Please Enter Code');
                return;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{route('verify')}}",
                type: 'post',
                dataType: 'json',
                data: {
                    code: jQuery('#code').val(),
                    address: jQuery('#address').val(),
                    lat: jQuery('#lat').val(),
                    lng: jQuery('#lng').val(),
                },
                beforeSend: function() {
                    jQuery('.codeerr').text('');
                    $('#suc').html('');
                    $('.or').remove()
                },
                complete: function() {},
                success: function(json) {
                    if (json.success) {
                        $('#suc').html('<p>' + json.msg + '</p>');
                        //if (json.is_verified == 0) {
                        $('#suc').after('<div class="or"><img src="' + json.data.image + '"><span>' + json.data.name + '</span><span>Manufacturing Date : ' + json.data.manufacturing + '</span><span>Expiry Date : ' + json.data.expiry + '</span><span>Product type : ' + json.data.type + '</span><span>Weight : ' + json.data.weight + '</span><span>Brand : ' + json.data.brand + '</span></div>');
                        //}
                    } else {
                        $('#suc').html('<p>' + json.msg + '</p>');
                    }
                }
            });
        });
    </script>
    <script>
        jQuery(document).ready(function() {
            askForLocationPermission()
        });

        function askForLocationPermission() {
            if (navigator.permissions) {
                navigator.permissions.query({
                    name: 'geolocation'
                }).then(permissionStatus => {
                    if (permissionStatus.state === 'granted') {
                        // If permission is already granted, get and display the location
                        getLocation();
                    } else {
                        // Otherwise, request permission
                        permissionStatus.onchange = () => {
                            if (permissionStatus.state === 'granted') {
                                getLocation();
                            } else {
                                document.getElementById('location-info').innerHTML =
                                    'Location permission denied.';
                            }
                        };
                        navigator.geolocation.getCurrentPosition(
                            () => {}, // Success callback (needed to trigger permission prompt)
                            error => {
                                console.error('Error getting location:', error);
                                document.getElementById('location-info').innerHTML =
                                    'Error getting location.';
                            }
                        );
                    }
                });
            } else {
                document.getElementById('location-info').innerHTML =
                    'Geolocation permissions API is not supported by this browser.';
            }
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                document.getElementById('location-info').innerHTML =
                    'Geolocation is not supported by this browser.';
            }
        }

        function showPosition(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            document.getElementById('location-info').innerHTML =
                `Your location: Latitude ${latitude}, Longitude ${longitude}`;
        }
    </script>
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getGeolocationDetails);
            } else {
                document.getElementById('location-info').innerHTML =
                    "Geolocation is not supported by this browser.";
            }
        }

        function getGeolocationDetails(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            // Use OpenCage API to get detailed location information
            fetch(
                    `https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=973058f6de3141178726442d18369f14`
                )
                .then(response => response.json())
                .then(data => {
                    const locationDetails = data.results[0];
                    console.log(locationDetails);
                    const formattedAddress = locationDetails.formatted;
                    $('#address').val(locationDetails.formatted);
                    $('#lat').val(latitude);
                    $('#lng').val(longitude);
                    document.getElementById('location-info').innerHTML = formattedAddress;
                })
                .catch(error => {
                    console.error('Error fetching location details:', error);
                    document.getElementById('location-info').innerHTML = "Error fetching location details.";
                });
        }
    </script>
</body>

</html>