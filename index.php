<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>

    <script>

        function cambiar(pos) {
            var x = pos.coords.latitude;
            var y = pos.coords.longitude;
            window.location = "index.php?latitud=" + x + "&longitud=" + y;
        }
        function ubicacion() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(cambiar);
            } else {
                alert('It seems like Geolocation, which is required for this page, is not enabled in your browser. Please use a browser which supports it.');
            }
        }

    </script>

    <?php

    class BaseDeDatos {

        public $conexion;

        public function llamada($string) {
            return mysqli_query($this->conexion, $string);
        }

        public function hacerConexion() {
            $this->conexion = mysqli_connect("localhost", "root", "", "direcciones");
            mysqli_set_charset($this->conexion, "utf8");
        }

        public function DesplegarLista() {
            $string = "select * from latitudlongitud";
            $resultado = $this->llamada($string);
            ?>

            <select name="Vista Localizaciones">
                <?php
                while ($row = mysqli_fetch_assoc($resultado)) {
                    ?>
                    <option> <?php echo "longitud: " . $row["longitud"] . " latitud: " . $row["latitud"] ?></option>
                    <?php
                }
                ?>
            </select>
            <?php
        }

        public function insertarUbicacion($latitud, $longitud) {
            $latitud=(int)$latitud;
            $longitud=(int)$longitud;
            $string2 = "SELECT count(IdCampo) as cuenta FROM latitudlongitud;";
            $resultado2 = $this->llamada($string2);
            $contador = mysqli_fetch_assoc($resultado2);
            $indice = (int) ($contador["cuenta"]) + 1;
            $string = "INSERT INTO latitudlongitud VALUES(" . $indice . "," .$latitud . "," .$longitud . ")";            
            $llamada=mysqli_query($this->conexion, $string);
            
        }

    }
    ?>

    <body>  
        <form name="formulario" method="post" action="javascript:ubicacion()">
            <input type='submit' name='localizacion' value='LOCATION NOW' style='width:170px; height:125px'> 
        </form>

        <?php
        $objeto = new BaseDeDatos();
        $objeto->hacerConexion();
        $objeto->DesplegarLista();
        if (isset($_REQUEST["latitud"]) & isset($_REQUEST["longitud"])) {
            $latitud = $_REQUEST["latitud"];
            $longitud = $_REQUEST["longitud"];
            $objeto->insertarUbicacion($latitud, $longitud);
        } else {
            echo "no hay variables para almacenar";
        }
        ?>


        <!-- 
        Aqui se hara el form que guarde las direcciones utilizadas
        
        
        !-->

        <!-- 
        la direccion
        
        
        -->

    </body>
</html>
