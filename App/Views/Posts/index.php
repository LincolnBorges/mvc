
<html>
<head>
    <meta charset="UTF-8">
    <title>Teste</title>
</head>
<body>
    <h1>Título</h1>
    <?php foreach ($posts as $item) { ?>
        <p><?=$item['title']?></p>
        <p><?=$item['content']?></p>
        <hr>
    <?php } ?>
</body>
</html>
