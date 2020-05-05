<?php
require_once 'init.php';

function dd ($data) {
    echo '<pre>';
    var_dump($data);
    echo '<pre>';
    die;
}


$user = new User;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Дипломный проект по PHP</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">User Management</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a style="color: cornflowerblue" class="nav-link" href="index.php">Главная</a>
          </li>
        </ul>

          <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                  <?php
                      if($user->isLoggedIn()) {
                           echo "<h3>Hi,{$user->data()->username}</h3>";
                      }
                   ?>
              </li>
              <li class="nav-item">
                  <?php
                      if($user->hasPermissions('admin')) {
                           echo "<h3>-You are admin!</h3>";
                      }
                  ?>
              </li>
          </ul>

        <?php if($user->isLoggedIn()) : ?>
        <ul class="navbar-nav">

            <a class="nav-link" ><?php echo $user->data()->username ?></a>

          <li class="nav-item">
                <a style="color: cornflowerblue" href="logout.php" class="nav-link" >Выйти</a>
          </li>
          <li class="nav-item">
                <a style="color: cornflowerblue" href="profile.php" class="nav-link">Профиль</a>
          </li>
          <?php endif; ?>
          <?php if(!$user->isLoggedIn()) : ?>

                <a style="color: cornflowerblue" href="login.php" class="nav-link" >Войти</a>

                <a style="color: cornflowerblue" href="register.php" class="nav-link">Регистрация</a>

          <?php endif; ?>


        </ul>
      </div>
    </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="jumbotron">
          <h1 class="display-4">Привет, мир!</h1>
          <p class="lead">Это дипломный проект по разработке на PHP. На этой странице список наших пользователей.</p>
          <hr class="my-4">
            <?php if(!$user->isLoggedIn()) {?>
                   <p>Чтобы стать частью нашего проекта вы можете пройти регистрацию.</p>
                   <a class="btn btn-primary btn-lg" href="register.php" role="button">Зарегистрироваться</a>
            <?php }?>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h1>Пользователи</h1>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Имя</th>
              <th>Email</th>
              <th>Дата</th>
            </tr>
          </thead>

          <tbody>

<?php
$users = Database::getInstance()->getAll('users');

?>
          <?php foreach ($users->results() as $user) : ?>

            <tr>
              <td><?php echo $user->id;?></td>
              <td><a href="user_profile.php?id=<?php echo $user->id;?>"><?php echo $user->username;?></a></td>
              <td><?php echo $user->email;?></td>
              <td><?php echo $user->date;?></td>
            </tr>

          <?php endforeach; ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
