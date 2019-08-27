<?php
    $titulo = "Inicio";
    include_once "cabecalho.ui.php";
    include_once "manipulacao.php";
?>
<section id="lista_escolas_individuais" class="pt-5 pb-5 bg-blue-alpha">
    <div class="container">
        <h1 class="text-center pb-5">
            Lista de Escolas Georeferenciadas
        </h1>
        <div id="map" class="mb-5"></div>
    <div class="row align-items-center">
        <?php
        $resultA = consultarAll("escola");
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
            zoom: 10,
            center: {lat: -27.357680716325305, lng: -53.39662313461304},
            mapTypeId: google.maps.MapTypeId.SATELLITE
        });

        var locations = [
            <?php
            $result = consultarAll("escola");
            $nomes = "";
            if($result != null) {
                while ($atual = mysqli_fetch_assoc($result)) {
                    echo '{lat: '."$atual[latitude]".', lng: '."$atual[longitude]".'},';
                    $nomes.= '\''.$atual['nome'].'\',';
                }
            }
            $nomes = substr($nomes, 0, -1);
            ?>
        ];

        <?php
            echo 'var secretMessages = ['.$nomes.'];';
        ?>

        for (var i = 0; i < secretMessages.length; ++i) {
            var marker = new google.maps.Marker({
                position: locations[i],
                map: map
            });
            attachSecretMessage(marker, secretMessages[i]);
        }
        function attachSecretMessage(marker, secretMessage) {
            var infowindow = new google.maps.InfoWindow({
                content: secretMessage
            });

            marker.addListener('click', function () {
                infowindow.open(marker.get('map'), marker);
            });
        }
    }
    window.onload = function(){
        initMap();
    }
</script>

<?php
    include_once "rodape.ui.php";
?>
