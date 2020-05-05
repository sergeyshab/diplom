<?php
require_once "init.php";

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {

        $validate = new Validate();

        $validate->check($_POST, [
            'email' => ['required'=>true,'email'=>true],
            'password' => ['required'=>true]
        ]);

        if($validate->passed()) {
            $user = new User;
            $remember = (Input::get('remember')) === 'on' ? true : false;

            $login = $user->login(Input::get('email'), Input::get('password'), $remember);

            if($login) {
                Redirect::to('index.php');
            } else {
                $login_failed = 'login failed';
              }
        } else {
            $val_errors = $validate->errors();
        }
    }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body class="text-center">

    <form class="form-signin" method="post">

    	  <a href="index.php"><img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72"></a>
    	  <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>

        <div class="alert alert-danger">
          <ul>

          <?php if($val_errors) { ?>
                 <?php foreach ($val_errors as $val_error) :?>
                      <li><?php echo $val_error ;?></li>
                 <?php endforeach; ?>
         <?php } ?>

         <?php if($login_failed) { ?>
                      <li><?php echo $login_failed ;?></li>
         <?php } ?>

          </ul>
        </div>

        <div class="alert alert-info">
          Заполните пожалуйста форму
        </div>

    	  <div class="form-group">
          <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo Input::get('email') ?>">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" id="password" placeholder="Пароль" name="password">
        </div>

    	  <div class="checkbox mb-3">
    	    <label>
    	      <input type="checkbox" name="remember"> Запомнить меня
    	    </label>
    	  </div>

        <input type="hidden" name="token" value="<?php echo Token::generate();?>">

    	  <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    	  <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
    </form>
</body>
</html>
