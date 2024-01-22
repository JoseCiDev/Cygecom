<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>GECOM - PHP Info</title>
</head>

<body>
    <?php if ($_GET['unauthorized']) : ?>
        <p>Não autorizado. Hash inválida!</p>
    <?php endif ?>

    <form method="POST">
        <input type="password" name='hash' placeholder="hash" required autofocus>
        <button type="submit">Enviar</button>
    </form>
</body>

</html>
