<?php
$titulo = "Cadastro";
include_once "cabecalho.ui.php";
include_once "manipulacao.php";
?>
<section id="contato" class="controlePadding bg-blue-alpha">
    <div class="container">
        <h1 class="text-center mb-4 p-4">
            Cadastro de Escolas
        </h1>
        <?php
        if (isset($_POST['enviar'])){
            $nome = $_POST['nome'];
            $latitude = $_POST['latitude'];
            $logitude = $_POST['longitude'];
            $valores = array($nome,$latitude,$logitude);
            $result = inserirSemId("escola",vetorToString($valores));
            if($result){
                echo "<div class='alert alert-success' role='alert'>
                        Sucesso: A escola ".$nome." foi cadastrada com sucesso!</div>";
            }else{
                echo "<div class='alert alert-danger' role='alert'>
                        Erro: A escola não foi cadastrada!</div>";
            }
        }
        ?>
        <div class="row align-items-baseline">
            <div class="col-sm-12 col-md-6">
                <div class="list-group mb-3">
                    <a class="list-group-item list-group-item-action active text-white font-weight-bold">
                        Dados da Escola:
                    </a>
                    <form class="list-group-item" method="post" action="">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" required>
                        </div>
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude" required>
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude" required>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="initialize();">Localizar Cordenadas no Mapa</button>
                        <button type="submit" class="btn btn-success" name="enviar" value="true">Cadastrar</button>
                    </form>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-5">
                <div class="list-group">
                    <a class="list-group-item list-group-item-action active text-white font-weight-bold">
                        Mapa
                    </a>
                    <div class="form-group">
                        <div class="alert alert-primary mb-auto" role="alert">
                            Clique com o Botão direito sobre o mapa para adicinar um marcador no Mapa.
                        </div>
                        <div class="list-group-item" id="mapa" style="width:100%; min-height:350px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Mapa -->
<script src="https://maps.googleapis.com/maps/api/js" async defer></script>

<script type="text/javascript">
    var latInicial = -27.358580237063798;
    var lngInicial = -53.396408557891846;
    
    function update_coordinates() {
        if(document.getElementById('latitude').value !== "" && document.getElementById('longitude').value !== ""){
            latInicial = document.getElementById('latitude').value;
            lngInicial = document.getElementById('longitude').value;
        }
    }

    // inicio da funcoes que incializam o mapa
    function initialize() {
        update_coordinates();
        //  var latlng = new google.maps.LatLng(document.getElementById('longitude').value,document.getElementById('latitude').value);
        // pegar lat long do municipio  ou do cep
        var latlng = new google.maps.LatLng(latInicial, lngInicial);

        var myOptions = {
            zoom: 14,
            scrollwheel: false,
            center: latlng,
            mapTypeControl: true,
            mapTypeId: google.maps.MapTypeId.SATELLITE
        };
        var map = new google.maps.Map(document.getElementById("mapa"), myOptions);
        var marker;

        google.maps.event.addListener(map, 'rightclick', function(event) {
            var latLng = event.latLng;
            if(marker){
                marker.setPosition(latLng);
            }else{
                marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    draggable: true
                });
            }
            update_position(latLng);
            google.maps.event.addListener(marker, 'drag', function(event) {
                update_position(marker.getPosition());
            });
        });
    }

    function update_position(latLng){
        document.getElementById('longitude').value = latLng.lng();
        document.getElementById('latitude').value = latLng.lat();
    }
    
    window.onload = function(){
        initialize();
    }

    function reload_map() {
        initialize();
    }
</script>
<?php
    include_once "rodape.ui.php";
?>
