<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serpientes y Escaleras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url(/fondos.webp);
        }

        .titulo {
            margin-left: 80px;
            font-size: 10px;
            color: black;
        }

        .boton {
            font-size: 40px;
        }

        table {
            border-collapse: collapse;
        }

        table td {
            border: 3px solid black;
        }

        .ficha {
            position: relative;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .ficha img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    $jugadores = array(
        array('acumulado' => 1, 'dado' => 0, 'mensaje' => ''),
        array('acumulado' => 1, 'dado' => 0, 'mensaje' => ''),
        array('acumulado' => 1, 'dado' => 0, 'mensaje' => '')
    );

    if (isset($_POST['reiniciar'])) {
        unset($_COOKIE['posiciones_fichas']);
        setcookie('posiciones_fichas', null, -1, '/');
        header("Refresh:0");
        exit;
    }

    $posiciones_anteriores = isset($_COOKIE['posiciones_fichas']) ? json_decode($_COOKIE['posiciones_fichas'], true) : array();

    if (isset($_POST['valor']) && isset($_POST['jugador'])) {
        $jugador = $_POST['jugador'];
        $dado = $vrandom = rand(1, 12);
        $valorantiguo = $_POST['valor'];
        $jugadores[$jugador]['acumulado'] = $valorantiguo + $dado;

        $posiciones_anteriores[$jugador] = $jugadores[$jugador]['acumulado'];

        switch ($jugadores[$jugador]['acumulado']) {
            case 19:
                $jugadores[$jugador]['acumulado'] = 59;
                $jugadores[$jugador]['mensaje'] = "USTED CAYÓ EN LA CASILLA 19 POR LO QUE SUBIÓ POR LA ESCALERA A LA CASILLA 59";
                break;
            case 28:
                $jugadores[$jugador]['acumulado'] = 75;
                $jugadores[$jugador]['mensaje'] = "USTED CAYÓ EN LA CASILLA 28 POR LO QUE SUBIÓ POR LA ESCALERA A LA CASILLA 75";
                break;
            case 43:
                $jugadores[$jugador]['acumulado'] = 5;
                $jugadores[$jugador]['mensaje'] = "USTED CAYÓ EN LA CASILLA 43 POR LO QUE BAJÓ POR LA SERPIENTE A LA CASILLA 5";
                break;
            case 70:
                $jugadores[$jugador]['acumulado'] = 30;
                $jugadores[$jugador]['mensaje'] = "USTED CAYÓ EN LA CASILLA 70 POR LO QUE BAJÓ POR LA SERPIENTE A LA CASILLA 30";
                break;
            case 72:
                $jugadores[$jugador]['acumulado'] = 91;
                $jugadores[$jugador]['mensaje'] = "USTED CAYÓ EN LA CASILLA 72 POR LO QUE SUBIÓ POR LA ESCALERA A LA CASILLA 91";
                break;
            case 87:
                $jugadores[$jugador]['acumulado'] = 74;
                $jugadores[$jugador]['mensaje'] = "USTED CAYÓ EN LA CASILLA 87 POR LO QUE BAJÓ POR LA SERPIENTE A LA CASILLA 74";
                break;
            case 82:
                $jugadores[$jugador]['acumulado'] = 99;
                $jugadores[$jugador]['mensaje'] = "USTED CAYÓ EN LA CASILLA 82 POR LO QUE SUBIÓ POR LA ESCALERA A LA CASILLA 99";
                break;
            case 96:
                $jugadores[$jugador]['acumulado'] = 38;
                $jugadores[$jugador]['mensaje'] = "USTED CAYÓ EN LA CASILLA 96 POR LO QUE BAJÓ POR LA SERPIENTE A LA CASILLA 38";
                break;
            default:
                if ($dado > 1) {
                    $jugadores[$jugador]['mensaje'] = "USTED AVANZO $dado CASILLAS";
                } else {
                    $jugadores[$jugador]['mensaje'] = "USTED AVANZO $dado CASILLAS";
                }
                break;
        }
        $jugadores[$jugador]['dado'] = $dado;

        setcookie('posiciones_fichas', json_encode($posiciones_anteriores), time() + (86400 * 30), "/"); // 86400 = 1 día
    }
    ?>

    <div class="row p-1">
        <?php for ($i = 0; $i < 3; $i++) : ?>
            <div class="col-4">
                <h1>JUGADOR <?= $i + 1 ?></h1>
                <form action="/SyE.php" method="post">
                    <input type="hidden" name="jugador" value="<?= $i ?>">
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label" for="valor<?= $i ?>">ACUMULADO</label>
                            <input class="form-control" type="text" id="valor<?= $i ?>" name="valor" min="1" max="10" value="<?= isset($posiciones_anteriores[$i]) ? $posiciones_anteriores[$i] : 1 ?>" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label" for="dado<?= $i ?>">DADO</label>
                            <input class="form-control" type="text" id="dado<?= $i ?>" name="dado" min="1" max="10" value="<?= $jugadores[$i]['dado'] ?>" required>
                            <input type="hidden" name="Nojugada">
                        </div>
                        <div class="col-4">
                            <input type="submit" class="btn btn-warning mt-4" value="TIRAR">
                        </div>
                    </div>
                </form>
                <?php if ($jugadores[$i]['dado'] > 0) : ?>
                    <div style="border:solid; margin-top: 20px; padding: 10px;">
                        <?php if ($jugadores[$i]['acumulado'] < 100) : ?>
                            <h3>TIRO</h3>
                            <h4><?= $jugadores[$i]['dado'] ?></h4>
                            <h4><?= $jugadores[$i]['mensaje'] ?></h4>
                        <?php else : ?>
                            <h1>FELICIDADES JUGADOR <?= $i + 1 ?>, ¡GANASTE!</h1>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endfor; ?>
    </div>

    <!-- Botón de reinicio -->
    <form action="/SyE.php" method="post">
        <input type="hidden" name="reiniciar" value="true">
        <input type="submit" class="btn btn-danger" value="REINICIAR">
    </form>

    <!-- Imágenes -->
    <img src="/escalera1.png" alt="" style="z-index:2; margin-top:10px; margin-left:560px; position: absolute;
                    width: 50px; height:200px; transform: rotate(20deg)">
            <img src="/escalera_corta.png" alt="" style="z-index:2; margin-top:25px; margin-left:75px; position: absolute;
                    width: 50px; height:100px; transform: rotate(0deg)">
            <img src="/escalera_corta2.png" alt="" style="z-index:2; margin-top:270px; margin-left:75px; position: absolute;
                    width: 50px; height:280px; transform: rotate(0deg)">
            <img src="/escalera1.png" alt="" style="z-index:2; margin-top:130px; margin-left:400px; position: absolute;
                    width: 50px; height:410px; transform: rotate(-20deg)">
            <img src="/serpiente_larga_rosa.png" alt="" style="z-index:2; margin-top:190px; margin-left:600px; position: absolute;
                    width: 50px; height:300px;">
            <img src="/serpiente_pequeña.png" alt="" style="z-index:2; margin-top:90px; margin-left:415px; position: absolute;
                    width: 50px; height:100px;">
            <img src="/serpiente_pequeña_verde.png" alt="" style="z-index:2; margin-top:320px; margin-left:200px; position: absolute;
                    width: 50px; height:300px; transform: rotate(-20deg)">
            <img src="/serpiente_larga_rosa.png" alt="" style="z-index:2; margin-top:-30px; margin-left:220px; position: absolute;
                    width: 50px; height:470px; transform: rotate(15deg)">

    <!-- Fichas de jugadores -->
    <?php for ($i = 0; $i < 3; $i++) : ?>
        <?php
        $posX = isset($posiciones_anteriores[$i]) ? ($posiciones_anteriores[$i] % 10) * 60 + 10 : 10;
        $posY = isset($posiciones_anteriores[$i]) ? floor($posiciones_anteriores[$i] / 10) * 60 + 10 : 10;
        ?>
        <img src="/fichanegra.png" alt="" style="z-index:2; margin-top:<?= $posY ?>px; margin-left:<?= $posX ?>px; position: absolute; width: 60px; height:60px;">
    <?php endfor; ?>

    <!-- Tablero -->
    <table class="tablero" style="z-index: 1;">
        <?php
        $colores = ['yellow', 'white', 'red', 'blue', 'green'];
        $NoCasilla = 101;
        $coloranterior = '';
        for ($fila = 0; $fila < 10; $fila++) {
            echo "<tr>";
            for ($columna = 0; $columna < 10; $columna++) {
                echo "<td>";
                $colorquetoca = rand(0, 4);
                while ($colorquetoca == $coloranterior) {
                    $colorquetoca = rand(0, 4);
                }
                $coloranterior = $colorquetoca;

                if ($fila > 0) {
                    if ($columna == 0) {
                        $NoCasilla -= 10;
                    } else {
                        if ($fila % 2 == 0) {
                            $NoCasilla--;
                        } else {
                            $NoCasilla++;
                        }
                    }
                } else {
                    $NoCasilla--;
                }

                echo "<div class='ficha' style='background-color: $colores[$colorquetoca]'><p>$NoCasilla</p></div>";
                echo "</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>

</body>

</html>









        