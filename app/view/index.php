<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Задачник</title>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <h1 class="mb-5 mt-5">Задачник</h1>
            <div class="page_button">
                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Добавить задачу
                </a>

                <?php if (!\App\isAdmin()) { ?>
                <a class="btn btn-success" data-toggle="collapse" href="#collapseAdmin" role="button" aria-expanded="false" aria-controls="collapseAdmin">
                    Вход
                </a>
                <?php } else { ?>
                    <a href="/admin/?logout" class="btn btn-success">Выйти</a>
                <?php } ?>
            </div>
            <div class="collapse mt-4" id="collapseAdmin" >
            <form action="/admin" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputName">Имя</label>
                        <input type="text" name="user_name" class="form-control" id="inputName" placeholder="введите имя" autofocus required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword">Пароль</label>
                        <input type="text" name="user_password" class="form-control" id="inputPassword" placeholder="введите пароль мой лорд :)" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Вход в чертоги</button>
            </form>
            </div>
            <div class="collapse mt-4" id="collapseExample" >
                <form action="/" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputName">Имя</label>
                            <input type="text" name="user_name" class="form-control" id="inputName" placeholder="введите имя" autofocus required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail">Email</label>
                            <input type="email" name="user_email" class="form-control" id="inputEmail" placeholder="введите email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputTask">Задача</label>
                        <textarea type="text" name="text" class="form-control" id="inputTask" placeholder="Напишите задачку :)" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
            <table class="table mt-5 table-hover table-dark">
                <tr>
                    <?php $direction = (@$_REQUEST['direction'] == 'asc') ? 'desc' : 'asc'; ?>
                    <th>id</th>
                    <th><a href="/?sort=user_name&direction=<?php echo $direction; ?>">имя</a></th>
                    <th><a href="/?sort=user_email&direction=<?php echo $direction; ?>">email</a></th>
                    <th>задача</th>
                    <th><a href="/?sort=status&direction=<?php echo $direction; ?>">статус</a></th>
                </tr>
                <?php
                foreach ($tickets as $ticket) { ?>
                    <tr>
                        <td><?=$ticket['id'];?></td>
                        <td><?=$ticket['user_name'];?></td>
                        <td><?=$ticket['user_email'];?></td>
                        <td><?=$ticket['text'];?></td>
                        <td><?=$ticket['status'];?></td>
                    </tr>
                <?php } ?>
            </table>
            <?php echo $pagination; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>