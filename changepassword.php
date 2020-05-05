<?php
require_once 'init.php';

$user = new User;
//echo $user->data()->password;
$user_id = $user->data()->id;
//echo $user_id;

if(!$user->isLoggedIn()) {
    redirect::to('login.php');
}

if(Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST, [

            'password' => [
                'required' => true,
                'equal' => 'users',
                'min' => 3
            ],

            'new_password' => [
                'required' => true,
                'min' => 3
            ],

            'new_password_again' => [
                'required' => true,
                'matches' => 'new_password',
                'min' => 3
            ]

        ], $user_id);

        if ($validation->passed()) {

            $user = new User;

            $user->update([
                'password' => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)],
                $user_id);

            //redirect::to('login.php');
            $new_password_succsess = Session::flash('success', 'Пароль успешно обновлён!');

        } else {
            $val_errors = $validation->errors();
        }
    }
}
var_dump($_POST);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
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
          <li class="nav-item">
              <?php if($user->hasPermissions('moderator')) :?>
                  <a class="nav-link" style="color: cornflowerblue" href="users/index.php">Управление пользователями</a>
              <?php endif; ?>
          </li>
        </ul>

        <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" ><?php echo $user->data()->username ?></a>
            <li class="nav-item">
              <a style="color: cornflowerblue" href="profile.php" class="nav-link">Профиль</a>
            </li>
            <a style="color: cornflowerblue" href="logout.php" class="nav-link">Выйти</a>
          </li>
        </ul>
      </div>
    </nav>

   <div class="container">
     <div class="row">
       <div class="col-md-8">
         <h1>Изменить пароль</h1>
         <div class="alert alert-success"><?php echo $new_password_succsess ?></div>
         
         <div class="alert alert-danger">
           <ul>
               <?php if($val_errors) {?>
                   <?php foreach ($val_errors as $val_error) : ?>
                       <li><?php echo $val_error . '<br>'?></li>
                   <?php endforeach; ?>
               <?php } ?>
           </ul>
         </div>
         <ul>
           <li><a href="profile.php">Изменить профиль</a></li>
         </ul>
         <form action="" method="post" class="form">
           <div class="form-group">
             <label for="password">Текущий пароль</label>
             <input type="password" id="password" class="form-control" name="password" value="">
           </div>

           <div class="form-group">
             <label for="new_password">Новый пароль</label>
             <input type="password" id="new_password" class="form-control" name="new_password">
           </div>

           <div class="form-group">
             <label for="new_password_again">Повторите новый пароль</label>
             <input type="password" id="new_password_again" class="form-control" name="new_password_again">
           </div>

             <input type="hidden" id="text" class="form-control" name="token" value="<?php echo Token::generate();?>">

           <div class="form-group">
             <button class="btn btn-warning">Изменить</button>
           </div>
         </form>


       </div>
     </div>
   </div>
</body>
</html>