<?php 
include("header.php");

$contacts  =  select( 'textos_lang', '*', array('related_id' => 8,'lang' => $lang) );
$contacts  =  $contacts->fetch_assoc();
?>
		<!-- contact-US -->
		<section id="contact">
			<h2 class="dn">contactos</h2>
			<div id="map" class="map"></div>
			<div class="container">
				<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 pdt20">
					<?=$contacts['descricao']?><!-- <p></p> -->
				</div>
					<div class="col-lg-6 col-md-6 col-sm-6">
						<div id="form">
<?php
    $sbm=false;
	
	if (isset($_GET['contact']) && $_SERVER['REQUEST_METHOD']==="POST") {
		$sbm=true;
		if (!empty($_POST['nome']) && verifyEmail($_POST['email']) && !empty($_POST['message'])) {
			$nome = limpaString($_POST['nome']);
			$email = limpaString($_POST['email']);
			$message = limpaString($_POST['message']);
			$text = "Nome: $nome<br>Email: $email<br>Mensagem:<br> $message";
			if (sendMailGeral2("Contacto site GAP", $text, "geral@gaplda.pt")) {
				echo '<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
						<p>A sua mensagem foi enviada com sucesso. Entraremos em contacto o mais brevemente possível.</p>
					</div>';
			}
			else {
				echo '<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
						<p>Parece que algo está errado. Por favor, tente novamente.</p>
					</div>';
			}
		}
		else {
			echo '<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
						<p>Atenção! É melhor verificar tudo novamente. Este formulário está longe de estar válido.</p>
					</div>';
		}
	}
?>
							<form data-parsley-validate role="form" method="POST" action="?contact">
								<div id="fg-name" class="form-group">
									<label for="name">nome</label>
									<input type="text" class="form-control" id="name" name="nome" value="" required>
								</div>
								<div id="fg-email" class="form-group">
									<label for="email">email</label>
									<input type="email" class="form-control" id="email" name="email" value=" " required>
								</div>
								<div class="form-group">
									<label for="message">mensagem</label>
									<textarea class="form-control" id="message" name="message" data-parsley-trigger="keyup" data-parsley-minlength="0" data-parsley-maxlength="1000" data-parsley-validation-threshold="10" data-parsley-minlength-message = "Please write a message with at least 20 characters.."> </textarea>
								</div>
								<div class="captcha_wrapper">
									<div class="g-recaptcha" data-sitekey="6LcsaFwUAAAAANMMgHfDohjXhuCNmowHCidmK-Lj"></div>
								</div>
								<button id="form-submit" type="submit" class="btn btn-default">enviar</button>
							</form>	
						</div>
					</div>		
				</div>
			</div>
		</section>
		<!--/contact-US -->
<!-- MAPS -->
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCv2gKVxa_DDENWgTyZqnGf1HqK9YzQDzs&sensor=true"></script>
    <script type="text/javascript">
        /* MAPS */
        // var GAP = new google.maps.LatLng(41.1222848, -8.1116781),
        // marker,
        // map;
        // var mapOptions = {
        //     zoom: 15,
        //     center: GAP,
        //     mapTypeControl: true,
        //     mapTypeControlOptions: {
        //         style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        //     },
        //     zoomControl: true,
        //     zoomControlOptions: {
        //         style: google.maps.ZoomControlStyle.SMALL
        //     },
        //     styles: [{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]},{featureType:"poi",stylers:[{saturation:-100},{lightness:51},{visibility:"simplified"}]},{featureType:"road.highway",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"road.arterial",stylers:[{saturation:-100},{lightness:30},{visibility:"on"}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]/**/},{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}]/**/},{featureType:"water",elementType:"labels",stylers:[{visibility:"on"},{lightness:-25},{saturation:-100}]},{featureType:"water",elementType:"geometry",stylers:[{hue:"#ffff00"},{lightness:-25},{saturation:-97}]}]
        // };

        // var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        // var marker = new google.maps.Marker({
        //     position: GAP,
        //     map: map,
        //     animation: google.maps.Animation.DROP,
        //     title:"GAP"
        // });

        // marker.setAnimation(google.maps.Animation.BOUNCE);
        var gapporto = new google.maps.LatLng(41.2040204, -8.528738),
            marker,
            map;

        var gaplx = new google.maps.LatLng(38.750714, -9.21631),
            marker,
            map;

            var mapOptions = {
                zoom: 7,
                mapTypeControl: true,
                mapTypeControlOptions: {
                  style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                },
                zoomControl: true,
                zoomControlOptions: {
                  style: google.maps.ZoomControlStyle.SMALL
                }
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            addMarker();

            /*============================ centrar mapa entre os 2 pontos ================================*/ 
            //  Make an array of the LatLng's of the markers you want to show
            var LatLngList = new Array (gapporto, gaplx);
            //  Create a new viewpoint bound
            var bounds = new google.maps.LatLngBounds ();
            //  Go through each...
            for (var i = 0, LtLgLen = LatLngList.length; i < LtLgLen; i++) {
              //  And increase the bounds to take this point
              bounds.extend (LatLngList[i]);
            }
            map.fitBounds(bounds);
            /*============================ /centrar mapa entre os 2 pontos ================================*/


        function addMarker() {
            marker = new google.maps.Marker({
                map:map,
                animation: google.maps.Animation.DROP,
                position: gapporto
            });

            markerlx = new google.maps.Marker({
                map:map,
                animation: google.maps.Animation.DROP,
                position: gaplx
            });
            setTimeout(function(){
                marker.setAnimation(google.maps.Animation.BOUNCE);
            },2000);
            
            setTimeout(function(){
                markerlx.setAnimation(google.maps.Animation.BOUNCE)
            },3000);
            
            // google.maps.event.addListener(marker, 'click', toggleBounce);
            // google.maps.event.addListener(markerlx, 'click', toggleBounce);
        }

        // function hideMarker() { marker.setVisible(false);directionsDisplay.setMap(map); }
        // function showMarker() { marker.setVisible(true);directionsDisplay.setMap(); }
        /*-----------------------------------*/
    </script>
<?php include("footer.php"); ?>