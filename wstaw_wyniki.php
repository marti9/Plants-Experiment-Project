<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    </head>
    <body>

        <?php
        require("./L2/tajne.php");
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        echo "Laborant: ".$_POST["Lab"];
        echo "<br>";
        echo "Wybrane id popowierzchni: ".$_POST["Podpow"];

        $lab = $_POST["Lab"];
        $imie = $_POST["Lab"];
        $podpow = $_POST["Podpow"];
        
        $sql="SET NAMES 'utf8' COLLATE 'utf8_polish_ci'";
        $result = $conn->query($sql);

        $lab = "select id_l from p_laborant where imie = '$lab'";
        $result = $conn->query($lab);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_array()) {
                $lab1 = $row[0];
            }
            } 
            else {
            echo "0 results";
            }

        echo "<br>Numer id Laboranta: ";
        echo $lab1;
        echo "<br>";

        $wsp_ros = "select wsp_nat from p_rosliny join p_podpow on p_rosliny.id_r = p_podpow.id_r where id_pp = '$podpow'";
        $result = $conn->query($wsp_ros);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_array()) {
                $wsp_ros1 = $row[0];
            }
            } 
            else {
            echo "0 results";
            }

        echo "<br>Współczynnik naturalnego wzrostu rośliny: ";
        echo $wsp_ros1;
        echo "<br>";

        $wsp_naw = "select wsp_wzr from p_nawozy join p_nawozenie on p_nawozy.id_n = p_nawozenie.id_n join p_powierzchnia on p_nawozenie.id_p = p_powierzchnia.id_p join p_laborant on p_powierzchnia.id_l = p_laborant.id_l where imie = '$imie'";
        $result = $conn->query($wsp_naw);

        $wsp_naw1 = 1;

        if ($result->num_rows > 0) {
            while($row = $result->fetch_array()) {
                $wsp_naw1 = $wsp_naw1 * $row[0];
            }
            } 
            else {
            echo "<br>Brak nawozu<br>";
            $wsp_naw1 = 1;
            }

        echo "<br>Współczynnik wzrostu użytych nawozów: ";
        echo $wsp_naw1;
        echo "<br>";

        $wsp_gruntu = "select wsp_gru from p_powierzchnia join p_laborant on p_powierzchnia.id_l = p_laborant.id_l where imie = '$imie'";
        $result = $conn->query($wsp_gruntu);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_array()) {
                $wsp_gru1 = $row[0];
            }
            } 
            else {
            echo "0 results";
            }

        echo "<br>Współczynnik gruntu: ";
        echo $wsp_gru1;
        echo "<br>";

        if($wsp_ros1 * $wsp_naw1 >= $wsp_gru1){
            echo "<br>Roślina urosła!!<br>";
            $res = 1;
        }
        else{
            echo "<br>Niestety, roślina nie wyrosła :(<br>";
            $res = 0;
        }

        $sql = "insert into p_wyniki(id_l,id_pp,wynik) 
        values ('$lab1','$podpow','$res')";
        $result = $conn->query($sql);

        echo "<br>Wyniki zapisane w bazie!";

        $conn->close();

        echo "<br><br>";
        echo "<a href='Formularz_bazy.php'>Przeprowadz kolejne badanie</a>";

        ?>

    </body>
</html>