<?php
    $titulo = "Inicio";
    include_once "cabecalho.ui.php";
    include_once "manipulacao.php";
?>
<section id="lista_escolas_individuais" class="controlePadding bg-blue-alpha">
    <div class="container">
        <h1 class="text-center margin-botttom-10">
            Lista de Escolas Georeferenciadas
        </h1>
        <div id="map" class="margin-botttom-10"></div>
    <div class="row align-items-center">
        <?php
        $resultA = consultarAll("Escola");
        if($resultA != null) {
            while ($atual1 = mysqli_fetch_assoc($resultA)) {
                echo '
                    <div class="col-sm-12 col-md-4 margin-top-alinhamento">
                        <div class="card atuacao-coluna margin-top-alinhamento">
                            <div class="card-header font-weight-bold">
                                '.$atual1['nome'].'
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Latitude: '.$atual1['latitude'].'</li>
                                <li class="list-group-item">Longitude: '.$atual1['longitude'].'</li>
                            </ul>
                        </div>
                    </div>
                ';
            }
        }
        ?>
    </div>
    </div>
</section>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script type="text/javascript" src="markerclusterer/src/markerclusterer.js"></script>
<script type="text/javascript">
    function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: {lat: -27.357680716325305, lng: -53.39662313461304},
            mapTypeId: google.maps.MapTypeId.SATELLITE
        });

        // Create an array of alphabetical characters used to label the markers.
        var posicoes = {};
        var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.
        var markers = locations.map(function(location, i) {
            return new google.maps.Marker({
                position: location,
                label: labels[i % labels.length]
            });
        });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'markerclusterer/images/m'});
    }
    var locations = [
        <?php
        $result = consultarAll("Escola");
        if($result != null) {
            while ($atual = mysqli_fetch_assoc($result)) {
                echo '{lat: '."$atual[latitude]".', lng: '."$atual[longitude]".'},';
            }
        }
        ?>
    ];
    window.onload = function(){
        initMap();
    }
</script>

<?php
include_once "rodape.ui.php";
?>
