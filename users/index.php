<?php
require_once 'C:/OSPanel/domains/diplom/init.php';

$user = new User;

if(!$user->isLoggedIn()) {
    redirect::to('login.php');
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Users</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
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
            <a style="color: cornflowerblue" class="nav-link" href="http://diplom/index.php">Главная</a>
          </li>
          <li class="nav-item">
            <a style="color: cornflowerblue" class="nav-link" href="">Управление пользователями</a>
          </li>
        </ul>

        <ul class="navbar-nav">
          <li class="nav-item">
            <li class="nav-item">
                <a class="nav-link" ><?php echo $user->data()->username ?></a>
            </li>
            <li class="nav-item">
              <a style="color: cornflowerblue" href="http://diplom/profile.php" class="nav-link">Профиль</a>
            </li>
            <a style="color: cornflowerblue" href="http://diplom/logout.php" class="nav-link">Выйти</a>
          </li>
        </ul>
      </div>
  </nav>

    <div class="container">
      <div class="col-md-12">
        <h1>Пользователи</h1>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Имя</th>
              <th>Email</th>
              <th>Действия</th>
            </tr>
          </thead>

<?php
$users = Database::getInstance()->getAll('users');
//echo '<pre>';
//print_r($users->results());
?>
       <?php foreach ($users->results() as $user) : ?>
            <tbody>
            <tr>
              <td><?php echo $user->id ?></td>
              <td><?php echo $user->username ?></td>
              <td><?php echo $user->email ?></td>
              <td>
                  <?php if($user->group_id == 1) {?>
              	<a href="upgrade.php?id=<?php echo $user->id ?>" class="btn btn-success">Назначить администратором</a>
                <a href="http://diplom/user_profile.php?id=<?php echo $user->id ?>" class="btn btn-info">Посмотреть</a>
                <a href="edit.php?id=<?php echo $user->id ?>" class="btn btn-warning">Редактировать</a>
                <a href="delete.php?id=<?php echo $user->id ?>" class="btn btn-danger" onclick="return confirm('Вы уверены?');">Удалить</a>
                  <?php } else {?>
                  <a href="downgrade.php?id=<?php echo $user->id ?>" class="btn btn-warning">Разжаловать</a>
                  <a href="http://diplom/user_profile.php?id=<?php echo $user->id ?>" class="btn btn-info">Посмотреть</a>
                  <a href="edit.php?id=<?php echo $user->id ?>" class="btn btn-warning">Редактировать</a>
                  <a href="delete.php?id=<?php echo $user->id ?>" class="btn btn-danger" onclick="return confirm('Вы уверены?');">Удалить</a>
                  <?php } ?>
              </td>
            </tr>
       <?php endforeach; ?>

          </tbody>
        </table>
      </div>
    </div>  
  </body>
</html>
