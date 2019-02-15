<?php

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Mirafox. Онлайн тест</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    </head>
    <body>
        <h2>Настройки теста</h2>
        <form action="processing.php">
            <div>
                <span>Сложность от</span>
                <input type="number" name="complexity[]"  min="0" max="100">
                <span>до</span>
                <input type="number" name="complexity[]"  min="0" max="100">
            </div>
            <div>
                <span>Интеллект</span>
                <input type="number"  min="0" max="100" name="intellect">
            </div>

            <input type="submit" value="test">

        </form>

        <h2>Результаты теста</h2>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    </body>
</html>
