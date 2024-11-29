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
	.or .list-group-item {
		font-size:16px;
	}
	.or .card {
		max-width:18rem;
		border-radius: 0;
		margin-bottom : 10px;
		    margin-left: auto;
    margin-right: auto;
	}
	.or .card .card-title {
		color : #00c49a;
	}
	.or .card .card-img-top {
		border-top-left-radius: 0px;
		border-top-right-radius: 0px;
		width: 100%;
    height: 380px;
    object-fit: cover;
    object-position: top center;
	}
	.or .card>.list-group:last-child {
		border-bottom-right-radius: 0px;
		border-bottom-left-radius: 0px;
	}
	@keyframes glow-grow {
	  0% {
		box-shadow: 0px 0px 0px 0px rgba(255,255,255,0.5);
	  }
	  70%, 100% {
		box-shadow: 0px 0px 0px 40px rgba(255,255,255,0);
	  }
	}
	.verify-input .field {
		border-radius: 999px;
		animation-name: glow-grow;
		animation-duration: 1.5s;
		animation-iteration-count: infinite;
		animation-timing-function: ease-out;
		    display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		-webkit-box-pack: start;
		-ms-flex-pack: start;
		justify-content: flex-start;
		padding: 0;
	}
	.verify-input .field.has-addons .control:not(:last-child) {
		margin-right: -1px;
	}
	.verify-input .form-control {
		padding: 0 15px;
		height: 53px;
		    font-size: 1.5rem;
		line-height : 18px;
		    border-radius: 999px 0 0 999px;
			    border: 0;
	}
	.verify-input .btn {
		    border-radius: 0 999px 999px 0;
		    background: #00d070;
			padding: 10px 30px;
			height: auto;
			width: auto;
			border: none;
			color: #fff;
			font-size: 1.375rem;
			white-space: nowrap;
	}
	.verify-input .btn-primary:active:focus {
		box-shadow: none;
	}
	.invalid-box {
		padding: 42px;
		border-radius: 15px;
	}
	.invalid-box img {
		margin-bottom : 24px;
	}
	.invalid-box h2 {
		font-size: 2.5rem;
		    color: #4a4a4a;
			padding-bottom:30px;
	}
	.invalid-box p {
		font-size: 1.4rem;
    line-height: 1.6;
	}
	.container.my-alert {
		padding : 0;
	}
	
	
	.or .card.row {
		flex-direction : row;
		max-width : 600px;
	}
	.or .card.row > div{
		padding : 0;
	}
	@media (max-width: 767px) {
		.invalid-box {padding: 22px;}
		.invalid-box h2 {
			font-size: 1.8rem;
			padding-bottom:10px;
		}
		.invalid-box p {
			font-size: 1rem;
			line-height: 1.2;
		}
	}
	@media (max-width: 576px) {
		.or .card.row {
			max-width : 288px;
		}
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
    

    <header class="py-5">
        <div class="container pt-md-1 pb-md-4">
            <div class="row">
                <div id="show-product-details">
                </div>
                <div class="col-xl-11 mx-auto">
                    <h1 class="bd-title mt-0">Verify Product</h1>
                    <p class="bd-lead"></p>
                    <div class="verify-input">
                        <form action="">
							<div class="field has-addons">
								<div class="control is-fullwidth w-100">
									<input type="text" class="form-control float-left w-100" name="code" id="code" value="{{ $code ?? '' }}">
									<input type="hidden" id="address" value="">
                                    <input type="hidden" id="state" value="">
									<input type="hidden" id="lng" value="">
									<input type="hidden" id="lat" value="">
									<span class="error codeerr"></span>
									<div id="suc">
									</div>
								</div>
								<div class="control">
									<button class="btn btn-primary" type="button" id="verify">Verify <i class="icon ion-checkmark-round"></i></button>
								</div>
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
                    state:jQuery('#state').val(),
                },
                beforeSend: function() {
                    jQuery('.codeerr').text('');
                    $('#show-product-details').empty('');
                    $('.or').remove()
                },
                complete: function() {},
                success: function(json) {
                    if (json.success) {
                        $('#show-product-details').append('<p>' + json.msg + '</p>');
                        //if (json.is_verified == 0) {
                        $('#show-product-details').append('<div class="or"><div class="card row"><div class="col-md-6 col-sm-12"><img class="card-img-top" src="https://masterverify.net/product/1519286376PAPAYA-TANGiE%202.0.jpg"></div><div class="col-md-6 col-sm-6"><div class="card-body"><h5 class="card-title m-0">' + json.data.name + '</h5></div><ul class="list-group list-group-flush"><li class="list-group-item">Manufacturing Date : ' + json.data.manufacturing + '</li><li class="list-group-item">Expiry Date : ' + json.data.expiry + '</li><li class="list-group-item">Product type : ' + json.data.type + '</li><li class="list-group-item">Weight : ' + json.data.weight + '</li><li class="list-group-item">Brand : ' + json.data.brand + '</li></ul></div></div></div>');
                        //}
                    } else {
                        $('#show-product-details').append('<p classs="text-danger">' + json.msg + '</p>');
                        $('#show-product-details').append(`<div class="container my-alert">
                                                                <div class="invalid-box bg-white text-dark text-center">
                                                                    <img src="/assets/images/red-alert.svg" class="my-alert-icon" >
                                                                    <div class="my-2">
                                                                        <h2 >Invalid Serial &nbsp;<i class="icon ion-close-round text-danger"></i></h2>
                                                                    </div>
                                                                    <p class="m-0"><b>This product could not be verified. Please double check that you entered the correct serial number.</b></p>
                                                                </div>
                                                            </div>`);
                    }
                }
            });
        });

    </script>
    <script>
        jQuery(document).ready(function() {
            askForLocationPermission();
            <?php if(isset($code) && $code && !empty($code)) { ?> 
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
                        state:jQuery('#state').val(),
                    },
                    beforeSend: function() {
                        jQuery('.codeerr').text('');
                        $('#show-product-details').empty('');
                        $('.or').remove()
                    },
                    complete: function() {},
                    success: function(json) {
                        if (json.success) {
                            $('#show-product-details').append('<p>' + json.msg + '</p>');
                            //if (json.is_verified == 0) {
                                $('#show-product-details').append('<div class="or"><div class="card row"><div class="col-md-6 col-sm-12"><img class="card-img-top" src="https://masterverify.net/product/1519286376PAPAYA-TANGiE%202.0.jpg"></div><div class="col-md-6 col-sm-6"><div class="card-body"><h5 class="card-title m-0">' + json.data.name + '</h5></div><ul class="list-group list-group-flush"><li class="list-group-item">Manufacturing Date : ' + json.data.manufacturing + '</li><li class="list-group-item">Expiry Date : ' + json.data.expiry + '</li><li class="list-group-item">Product type : ' + json.data.type + '</li><li class="list-group-item">Weight : ' + json.data.weight + '</li><li class="list-group-item">Brand : ' + json.data.brand + '</li></ul></div></div></div>');
                            //}
                        } else {
                            $('#show-product-details').append('<p classs="text-danger">' + json.msg + '</p>');
                            $('#show-product-details').append(`<div class="container my-alert">
                                                                <div class="invalid-box bg-white text-dark text-center">
                                                                    <img src="/assets/images/red-alert.svg" class="my-alert-icon" >
                                                                    <div class="my-2">
                                                                        <h2 >Invalid Serial &nbsp;<i class="icon ion-close-round text-danger"></i></h2>
                                                                    </div>
                                                                    <p class="m-0"><b>This product could not be verified. Please double check that you entered the correct serial number.</b></p>
                                                                </div>
                                                            </div>`);
                        }
                    }
                });
            <?php } ?>

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
                                    get_thirdparty_locatio();
                            }
                        };
                        navigator.geolocation.getCurrentPosition(
                            () => {}, // Success callback (needed to trigger permission prompt)
                            error => {
                                get_thirdparty_locatio()
                                console.error('Error getting location:', error);
                                document.getElementById('location-info').innerHTML =
                                    'Error getting location.';
                            }
                        );
                    }
                });
            } else {
                get_thirdparty_locatio();
                document.getElementById('location-info').innerHTML =
                    'Geolocation permissions API is not supported by this browser.';
            }
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                get_thirdparty_locatio();
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
                get_thirdparty_locatio();
                document.getElementById('location-info').innerHTML =
                    "Geolocation is not supported by this browser.";
            }
        }

        function getGeolocationDetails(position) {
             if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function (position) {
                            const lat = position.coords.latitude;
                            const lon = position.coords.longitude;
                             fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}` )
                            .then(response => response.json())
                            .then(data => {
                                const formattedAddress = data.display_name;
                                $('#address').val(data.display_name);
                                $('#lat').val(data.lat);
                                $('#lng').val(data.lon);
                                $('#state').val(data.address.state)
                                document.getElementById('location-info').innerHTML = formattedAddress;
                            })
                            .catch(error => {
                               get_thirdparty_locatio();
                            });
                        },
                        function (error) {
                            get_thirdparty_locatio();
                            $('#address').text('Geolocation error: ' + error.message);
                        }
                    );
            } else {
                get_thirdparty_locatio();
                $('#address').text('Geolocation is not supported by this browser.');
            }
           
        }
    function get_thirdparty_locatio(){
        $.get('https://ipapi.co/json',function(result){
                response=result;
                const addressParts = [];
                if (response.city) addressParts.push(response.city);
                if (response.region) addressParts.push(response.region);
                if (response.postal) addressParts.push(response.postal);
                if (response.country_name) addressParts.push(response.country_name);
                const formattedAddress = addressParts.join(', ');
                if(result){
                    $('#lat').val(response.latitude);
                    $('#lng').val(response.longitude);
                    $('#address').val(formattedAddress);
                    $('#state').val(response.region)
                   document.getElementById('location-info').innerHTML = formattedAddress;
                }
        })
    }
    </script>
</body>

</html>