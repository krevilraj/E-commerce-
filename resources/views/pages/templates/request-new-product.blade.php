@extends('layouts.app')

@section('content')
    <section class="page-header mb-none">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li class="active">Contact Us</li>
            </ul>
        </div>
    </section>
    <!-- Google Maps - Go to the bottom of the page to change settings and map location. -->
    <div id="googlemaps" class="google-map"></div>

    <div class="section-contact-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">


                    <div class="alert alert-success hidden mt-lg" id="contactSuccess">
                        <strong>Success!</strong> Your message has been sent to us.
                    </div>

                    <div class="alert alert-danger hidden mt-lg" id="contactError">
                        <strong>Error!</strong> There was an error sending your message.
                        <span class="font-size-xs mt-sm display-block" id="mailErrorMessage"></span>
                    </div>

                    <h2 class="heading-text-color">Leave a <strong>Message</strong></h2>
                    <form id="contactForm" action="{{ route('contact.post') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Name </label>
                                    <input type="text" value="" data-msg-required="Please enter your name."
                                           maxlength="100" class="form-control" name="name" id="name" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" value="" data-msg-required="Please enter your email address."
                                           data-msg-email="Please enter a valid email address." maxlength="100"
                                           class="form-control" name="email" id="email" required>
                                </div>

                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" value="Testimional" data-msg-required="Please enter the subject."
                                           maxlength="100" class="form-control" name="subject" id="subject" required disabled>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group mb-lg">
                                    <label for="message">Message *</label>
                                    <textarea maxlength="5000" data-msg-required="Please enter your message." rows="5"
                                              class="form-control" name="message" id="message"  required></textarea>
                                </div>

                                <input type="checkbox"   onchange="document.getElementById('send').disabled = !this.checked" /> Check If You Are A Human
                                <br>

                                <input type="submit" value="Send Message" class="btn btn-primary mb-xlg"
                                       data-loading-text="Loading..." id="send"  disabled>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <h2 class="heading-text-color">Contact <strong>Details</strong></h2>
                    <ul class="list-unstyled list-contact">
                        <li>
                            <i class="fa fa-phone"></i>
                            @if(getConfiguration('site_primary_phone'))
                                <div>{{ getConfiguration('site_primary_phone') }}</div>
                            @endif
                            @if(getConfiguration('site_secondary_phone'))
                                <div>{{ getConfiguration('site_secondary_phone') }}</div>
                            @endif
                        </li>
                        <li>
                            <i class="fa fa-envelope"></i>
                            <div>{{ getConfiguration('site_primary_email') }}</div>
                            <div>{{ getConfiguration('site_secondary_email') }}</div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/views/view.contact.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMxJ92oBkSnVNHFX3R8XhtYQPEgk1_IiI"></script>
  <script>

        /*
        Map Settings

            Find the Latitude and Longitude of your address:
                - http://universimmedia.pagesperso-orange.fr/geo/loc.htm
                - http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude/
        */

        // Map Markers
        var mapMarkers = [{
            address: "{{getConfiguration('address')}}",
            html: "<strong>{{getConfiguration('company_name')}}</strong><br>{{getConfiguration('address')}}",
            icon: {
                image: "{{ asset('img/pin.png') }}",
                iconsize: [26, 46],
                iconanchor: [12, 46]
            },
            popup: true
        }];

        // Map Initial Location
        var initLatitude = 27.7055822;
        var initLongitude =85.330885;;

        // Map Extended Settings
        var mapSettings = {
            controls: {
                draggable: ((!$.browser.mobile)),
                panControl: true,
                zoomControl: true,
                mapTypeControl: true,
                scaleControl: true,
                streetViewControl: true,
                overviewMapControl: true
            },
            scrollwheel: false,
            markers: mapMarkers,
            center: {lat: initLatitude, lng: initLongitude},
            zoom: 16
        };

        var map = $('#googlemaps').gMap(mapSettings),
            mapRef = $('#googlemaps').data('gMap.reference');

        // Map Center At
        var mapCenterAt = function (options, e) {
            e.preventDefault();
            $('#googlemaps').gMap("centerAt", options);
        };

        // Styles from https://snazzymaps.com/
        var styles = [{
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{"color": "#e9e9e9"}, {"lightness": 17}]
        }, {
            "featureType": "landscape",
            "elementType": "geometry",
            "stylers": [{"color": "#f5f5f5"}, {"lightness": 20}]
        }, {
            "featureType": "road.highway",
            "elementType": "geometry.fill",
            "stylers": [{"color": "#ffffff"}, {"lightness": 17}]
        }, {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [{"color": "#ffffff"}, {"lightness": 29}, {"weight": 0.2}]
        }, {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [{"color": "#ffffff"}, {"lightness": 18}]
        }, {
            "featureType": "road.local",
            "elementType": "geometry",
            "stylers": [{"color": "#ffffff"}, {"lightness": 16}]
        }, {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [{"color": "#f5f5f5"}, {"lightness": 21}]
        }, {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [{"color": "#dedede"}, {"lightness": 21}]
        }, {
            "elementType": "labels.text.stroke",
            "stylers": [{"visibility": "on"}, {"color": "#ffffff"}, {"lightness": 16}]
        }, {
            "elementType": "labels.text.fill",
            "stylers": [{"saturation": 36}, {"color": "#333333"}, {"lightness": 40}]
        }, {"elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {
            "featureType": "transit",
            "elementType": "geometry",
            "stylers": [{"color": "#f2f2f2"}, {"lightness": 19}]
        }, {
            "featureType": "administrative",
            "elementType": "geometry.fill",
            "stylers": [{"color": "#fefefe"}, {"lightness": 20}]
        }, {
            "featureType": "administrative",
            "elementType": "geometry.stroke",
            "stylers": [{"color": "#fefefe"}, {"lightness": 17}, {"weight": 1.2}]
        }];

        var styledMap = new google.maps.StyledMapType(styles, {
            name: 'Styled Map'
        });

        mapRef.mapTypes.set('map_style', styledMap);
        mapRef.setMapTypeId('map_style');

    </script>
@endpush