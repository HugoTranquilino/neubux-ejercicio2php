<?php 

$juego_rd = array();
$jugadores = array();
$jug_1 = 0;
$jug_2 = 0;
$winner = "";
$error = "";


$file_name = (!empty($_FILES['file']['tmp_name'])) ? $_FILES['file']['tmp_name'] : '';

if (!empty($file_name)) {
    if ($fl = fopen($file_name,'r')) {
        $i = 1;

        while (!feof($fl)) {
            $ronda = fgets($fl);

            if (!empty($ronda)) {
                if ($i != 1) {
                    array_push($juego_rd,$ronda);
                }
            }
            $i++;
        }

        for ($i=0; $i < sizeof($juego_rd); $i++) { 
            $resul = explode(' ',$juego_rd[$i]);
            $jug_1 = (int)$resul[0];
            $jug_2 = (int)$resul[1];

            if ($jug_1 > $jug_2) {
                $jugadores['jugador1'][] = abs($jug_1 - $jug_2);
            } else {
                $jugadores['jugador2'][] = abs($jug_1 - $jug_2);
            }
        }        
        
        $max_ventaja_jugador1 = max($jugadores['jugador1']);
        $max_ventaja_jugador2 = max($jugadores['jugador2']);

        $winner = ($max_ventaja_jugador1 > $max_ventaja_jugador2) ? '1' : '2' ;
        $ventaja = ($max_ventaja_jugador1 > $max_ventaja_jugador2) ? $max_ventaja_jugador1 : $max_ventaja_jugador2 ;
        
        if(file_exists("ganador.txt")) {
            unlink("ganador.txt");
            $file = fopen("ganador.txt","a+");
        }else{
            $file = fopen("ganador.txt","a+");
        }

        $data = $winner.' '.$ventaja;
        fputs($file,$data);
        fclose($file);
    }else{
        $error = 'No se encontro el archivo';
    }
} else {
    $error = 'Por favor elige un archivo';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neubux ejercicio 2</title>

    <!-- style css -->
    <link rel="stylesheet" href="main.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    
    <main>

        <section class="contenent">
            <h1>Ejercicio 2</h1>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                <label for="file">
                    Seleccione un archivo:
                    <input type="file" name="file" id="file" accept="text/plain">
                </label>
                <button type="submit" class="btn">Analizar</button>
            </form>

            <span>
                <?php echo $err = (!empty($error)) ? $error : '' ; ?>
            </span>
            
            <div class="resulltados">
                <?php
                    if (!empty($winner)) {
                        echo '<a class="btn" href="descarga.php" target="_blank" rel="noopener noreferrer">Ver Ganador</a>';
                    }
                ?>
            </div>
        </section>

    </main>

</body>
</html>