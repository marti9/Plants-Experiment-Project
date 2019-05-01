<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <form action="./wstaw_wyniki.php" method="POST">
        <?php
        require("./L2/tajne.php");
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        echo "Laborant: <br>";
        echo $_POST["Lab"];
        $lab = $_POST["Lab"];
        echo "<br>";

        $sql = "SELECT id_pp, rozmiar from p_podpow join p_powierzchnia on p_podpow.id_p = p_powierzchnia.id_p join p_laborant on p_powierzchnia.id_l = p_laborant.id_l where imie = '$lab' ";
        $result = $conn->query($sql);

        echo "Wybierz podpowierzchnię: <br>";
        echo "<select name=\"Podpow\">";
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_array()) {
        echo '<option value="'.$row[0].'">'.$row[0].' Rozmiar: '.$row[1].'</option>' ;
        }
        } 
        else {
        echo "0 results";
        }
        echo "</select>";
        echo "<input type='hidden' name='Lab' value=".$lab.">";

        $conn->close();
        ?>
        <input type="submit">
        </form>

    </body>
</html>