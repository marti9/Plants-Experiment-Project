<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <form action="./formularz.php" method="POST">                                                     
        wybierz Laboranta<br>
        <select name='Lab'>
        <?php
        require("./L2/tajne.php");

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql="SET NAMES 'utf8' COLLATE 'utf8_polish_ci'";
        $result = $conn->query($sql);

        $sql = "SELECT * from p_laborant";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_array()) {
        echo '<option value="'.$row[1].'">'.$row[1].'</option>' ;
        }
        } else {
        echo "0 results";
        }
        $conn->close();
        
        ?>
        </select><br>
        <input type="submit">
        </form>
    </body>
</html>