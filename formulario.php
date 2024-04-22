<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serpientes y Escaleras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .container {
            margin-top: 50px;
            margin-left: 500px;
        }

        h1 {
            text-align: center;
        }

        body {
            background-image: url(/fondos.webp);
        }
    </style>
</head>

<body>

    <h1>JUEGO DE SERPIENTES Y ESCALERAS</h1>

    <div class="container">
        <form action="SyE.php" method="post">
            <?php
            $num_jugadores = 3;

            for ($i = 1; $i <= $num_jugadores; $i++) {
                ?>
                <div class="col-3 mb-3">
                    <label for="nombre<?= $i ?>" class="form-label">Jugador <?= $i ?></label>
                    <input type="text" class="form-control" id="nombre<?= $i ?>" name="nombres[]" aria-describedby="jugador<?= $i ?>">
                </div>
            <?php } ?>

            <button type="submit" class="btn btn-primary">Start</button>
        </form>
    </div>

</body>

</html>



