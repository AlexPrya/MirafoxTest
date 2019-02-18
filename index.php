<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Mirafox. Эмулятор теста</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div class="container" id="tests">
    <div class="row">
        <div class="col-12">
            <h2>Настройки теста</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form class="" id="test" action="processing.php">
                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="complexity_from">Сложность от</label>
                        <input id="complexity_from" class="form-control" type="number" name="complexity[]"  min="0" max="100">
                    </div>
                    <div class="form-group col-6">
                        <label for="complexity_to">до</label>
                        <input id="complexity_to" class="form-control" type="number" name="complexity[]"  min="0" max="100">
                    </div>
                </div>
                <div class="form-group">
                    <label for="intellect">Интеллект</label>
                    <input class="form-control" type="number" id="intellect" min="0" max="100" name="intellect">
                </div>
                <input type="hidden" name="type" value="process">
                <input type="submit" class="btn btn-lg btn-primary" value="Эмулировать тест">
                <a href="" id="go_to_history" class="btn btn-primary btn-lg">История</a>
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <h2>Результаты теста</h2>
    </div>
    <div class="row">
        <div class="col-12">
            <h3><span id="countResults">0</span> из 40 вопросов</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table id="results">
                <thead>
                    <tr>
                        <th scope="col">Номер вопроса</th>
                        <th scope="col">ID вопроса</th>
                        <th scope="col">Количество использований</th>
                        <th scope="col">Сложность вопроса</th>
                        <th scope="col">Ответ на вопрос</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div class="container" id="history" style="display: none;">
    <div class="row">
        <div class="col-12">
            <a href="" id="go_to_tests" class="btn btn-primary btn-lg">Назад</a>
        </div>
        <div class="col-12">
            <h2>История</h2>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <table id="history_table">
                <thead>
                <tr>
                    <th scope="col">№</th>
                    <th scope="col">Интеллект</th>
                    <th scope="col">Сложность</th>
                    <th scope="col">Результат</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('form#test').submit(
      function (e) {
        e.preventDefault();
        var url = $(this).attr("action"),
          form = $(this).serialize();

        $.ajax({
          type: "GET",
          url: url,
          dataType: "json",
          data: $('form#test').serialize(),
          success: function (result) {
            var html = '<tr>';

            result.forEach(
              function (item, i) {
                html += '<td>' + (+i + 1) + '</td>' +
                  '<td>' + item.question_id + '</td>' +
                  '<td>' + item.question_num_of_uses + '</td>' +
                  '<td>' + item.question_complexity + '</td>' +
                  '<td>' + (+item.result) + '</td>';
                html += '</tr><tr>';
              }
            );
            html += '</tr>';
            $('table#results').find('tbody').html(html);
          }
        });
      }
    );

    $("#go_to_history").click(
      function (e) {
        e.preventDefault();

        $("#tests").hide();
        $("#history").show();

        $.ajax({
          type: "GET",
          url: "/processing.php?type=history",
          dataType: "json",
          success: function (result) {
            var html = '<tr>';

            result.forEach(
              function (item, i) {
                html += '<td>' + (+i + 1) + '</td>' +
                  '<td>' + item.intellect + '</td>' +
                  '<td>' + item.complexity_from + '/' + item.complexity_to + '</td>' +
                  '<td>' + item.result + '</td>';
                html += '</tr><tr>';
              }
            );
            html += '</tr>';
            $('table#history_table').find('tbody').html(html);
          }
        });
      }
    );

    $("#go_to_tests").click(
      function (e) {
        e.preventDefault();

        $("#history").hide();
        $("#tests").show();
        $('table#history_table').find('tbody').html("");
      }
    );
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
