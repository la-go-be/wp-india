<?php if ( ! defined( 'FW' ) )
	die( 'Forbidden' );
$shortcodes_extension = fw_get_template_customizations_directory_uri().'/extensions/shortcodes/shortcodes';
$map_placeholder = $atts['map_placeholder'];
$map_scroll = $atts['map_scroll'] == 1 ? 'true' : 'false';
$geo = ( isset($atts['geo']) && $atts['geo'] == 1 )? true : false;
?>
<script>
    jQuery(document).ready(function($) {
        var directionDisplay;
        var directionsService = new google.maps.DirectionsService();
        var map;
        function initialize() {
          var latlng = new google.maps.LatLng(<?php echo esc_js($atts['destination_coor']); ?>);
          // set direction render options
          var rendererOptions = {
            draggable: true,
            polylineOptions: {
              strokeColor:'#f30c74'
            }
          };
          directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
          var myOptions = {
            zoom: <?php echo esc_js($atts['map_zoom']); ?>,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: false,
            scrollwheel: <?php echo esc_js($map_scroll); ?>,
            styles: <?php echo html_entity_decode($atts['map_style']); ?>
          };
          // add the map to the map placeholder
          map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
          directionsDisplay.setMap(map);
          directionsDisplay.setPanel(document.getElementById("directionsPanel"));
          // Add a marker to the map for the end-point of the directions.
          var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title:"<?php echo esc_js($atts['destination_marker']); ?>",
            icon: '<?php echo esc_url($shortcodes_extension."/map-direction/static/img/map_start.png"); ?>'
          });
        }

        /*hdv*/
        function makeMarker( position, icon, title ) {
            new google.maps.Marker({
            position: position,
            map: map,
            icon: icon,
            title: title
            });
        };
        var movingIcon = new google.maps.MarkerImage('<?php echo esc_url($shortcodes_extension."/map-direction/static/img/map_center.png"); ?>');
        var startIcon = new google.maps.MarkerImage('');
        /*end hdv*/
        function calcRoute() {
          // get the travelmode, startpoint and via point from the form
          var travelMode = $('input[name="travelMode"]:checked').val();
          var start = $("#routeStart").val();
          var via = $("#routeVia").val();

          if (travelMode == 'TRANSIT') {
            via = ''; // if the travel mode is transit, don't use the via waypoint because that will not work
          }
          var end = "<?php echo esc_js($atts['destination_coor']); ?>"; // endpoint is a geolocation
          var waypoints = []; // init an empty waypoints array
          if (via != '') {
            // if waypoints (via) are set, add them to the waypoints array
            waypoints.push({
              location: via,
              stopover: true
            });
          }
          var request = {
            origin: start,
            destination: end,
            waypoints: waypoints,
            unitSystem: google.maps.UnitSystem.METRIC,
            travelMode: google.maps.DirectionsTravelMode[travelMode]
          };
          directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
              $('#directionsPanel').empty(); // clear the directions panel before adding new directions
              directionsDisplay.setDirections(response);

              /*hdv*/
              var leg = response.routes[0].legs[0];
              makeMarker(leg.start_location, movingIcon, "Start" );
              makeMarker(leg.end_location, startIcon, "End" );

            } else {
              // alert an error message when the route could nog be calculated.
              if (status == 'ZERO_RESULTS') {
                notie.alert(3, 'No route could be found between the origin and destination.', 6);
              } else if (status == 'UNKNOWN_ERROR') {
                notie.alert(3, 'A directions request could not be processed due to a server error. The request may succeed if you try again.', 6);
              } else if (status == 'REQUEST_DENIED') {
                notie.alert(3, 'This webpage is not allowed to use the directions service.', 6);
              } else if (status == 'OVER_QUERY_LIMIT') {
                notie.alert(3, 'The webpage has gone over the requests limit in too short a period of time.', 6);
              } else if (status == 'NOT_FOUND') {
                notie.alert(3, 'At least one of the origin, destination, or waypoints could not be geocoded.', 6);
              } else if (status == 'INVALID_REQUEST') {
                notie.alert(3, 'The DirectionsRequest provided was invalid.', 6);
              } else {
                notie.alert(3, 'There was an unknown error in your request. Requeststatus: nn'+status, 6);
              }
            }
          });
        }
        initialize();
        $('#routeForm').on('submit', function(){
            calcRoute();
            $('.apimap_form').css('overflow-y', 'scroll');
            $('#directionsPanel').css('border-color', '#dadada');
            return false;
        });

        $('.c-radio label span.check-checkbox').click(function(event) {
            $('.c-radio label span.check-checkbox').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>
<div class="map-direction-wrapper">
    <div id="map_canvas" class="wow fadeInUp"></div>
    <div class="apimap_form wow fadeInDown">
        <p class="map-form-title"><?php echo html_entity_decode($atts['form_label']); ?></p>
        <form id="routeForm">
            <div class="c-enter">
                <label>
                  <?php _e('Direction From*', 'plan-up') ?> <br />
                  <input type="text" id="routeStart" value="<?php echo esc_attr($map_placeholder); ?>">
                </label>
                <label>
                  <?php _e('Via', 'plan-up'); ?><br />
                  <input type="text" id="routeVia" value="">
                </label>
            </div>
            <div class="c-radio">
                <label><input style="visibility: hidden;" type="radio" name="travelMode" checked value="DRIVING" /> <span class="active check-checkbox"> <?php _e('Driving', 'plan-up'); ?></span></label>
                <label><input style="visibility: hidden;" type="radio" class="ss" name="travelMode" value="TRANSIT" /><span class="check-checkbox"> <?php _e('Public transport', 'plan-up'); ?></span></label>
                <label><input style="visibility: hidden;" type="radio" name="travelMode" value="BICYCLING" /><span class="check-checkbox"> <?php _e('Bicycling', 'plan-up'); ?></span></label>
            </div>
            <input type="submit" value="<?php _e('GET ME TO THE VENUE', 'plan-up'); ?>">
        </form>
        <p class="direction-label"><?php _e('Direction', 'plan-up'); ?></p>
        <div id="directionsPanel"></div>
    </div>
</div>

<script>
  function plan_up_map_initialize() {
    var input = document.getElementById('routeStart');
    var input_via = document.getElementById('routeVia');
    var autocomplete = new google.maps.places.Autocomplete(input);
    var autocomplete_via = new google.maps.places.Autocomplete(input_via);
  }
  var tempmap = google.maps.event.addDomListener(window, 'load', plan_up_map_initialize);

  /*Get user current possition*/
  jQuery(document).ready(function($) {
        function plan_up_getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(plan_up_savePosition, plan_up_positionError, {timeout:10000});
            } else {
                //Geolocation is not supported by this browser
            }
        }
        // handle the error here
        function plan_up_positionError(error) {
            var errorCode = error.code;
            var message = error.message;
            notie.alert(3, message, 6);
        }
        function plan_up_savePosition(position) {
            $.get('https://maps.googleapis.com/maps/api/geocode/json?latlng='+position.coords.latitude+","+position.coords.longitude, function(data) {
                if( typeof data['results'][0]['formatted_address'] !== 'undefined' )
                    $('#routeStart').val(data['results'][0]['formatted_address']);
                if( typeof data['results'][1]['formatted_address'] !== 'undefined' )
                    $('#routeStart').val(data['results'][1]['formatted_address']);
            });
        }
        <?php if($geo): ?>
          plan_up_getLocation();
        <?php endif; ?>
  });
</script>