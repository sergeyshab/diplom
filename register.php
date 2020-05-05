<?php

require_once 'init.php';

if(Input::exists()) {
      if (Token::check(Input::get('token'))) {
                $validate = new Validate();

                $validation = $validate->check($_POST, [

                   'username' => [
                       'required' => true,
                       'min' => 2,
                       'max' => 15,
                   ],
                   'email' => [
                       'required' => true,
                       'email' => true,
                       'unique' => 'users'
                   ],
                   'password' => [
                       'required' => true,
                       'min' => 3
                   ],
                    'password_again' => [
                       'required' => true,
                       'matches' => 'password'
                   ],
                   'accept' => [
                        'required' => true
                       ]
                ]);

                if ($validation->passed()) {

                $user = new User;

                $user->create([
                    'username' => Input::get('username'),
                    'password' => password_hash(Input::get('password'), PASSWORD_DEFAULT),
                    'email' => Input::get('email')
                ]);

                redirect::to('login.php');
                Session::flash('success', 'вы успешно зарегистрировались');

                } else {
                      $val_errors = $validation->errors();
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

    <form class="form-signin" action="" method="post">
        <?php //print_r($_POST);?>
        <a href="index.php"><img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72"></a>
    	  <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>

        <div class="alert alert-danger">
          <ul>
             <?php if($val_errors) {?>
                 <?php foreach ($val_errors as $val_error) : ?>
                       <li>
                           <?php echo $val_error . "</br>"?>
                       </li>
                 <?php endforeach; ?>
              <?php } ?>
          </ul>
        </div>

        <div class="alert alert-success">
            <?php echo Session::flash('success');?>
        </div>

        <div class="alert alert-info">
          Заполните пожалуйста форму<br>
          Все поля обязательны для заполнения!
        </div>


    	  <div class="form-group" >
          <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo Input::get('email') ?>">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="email" placeholder="Ваше имя"  name="username" value="<?php echo Input::get('username') ?>">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" id="password" placeholder="Пароль" name="password">
        </div>
        
        <div class="form-group">
          <input type="password" class="form-control" id="password" placeholder="Повторите пароль" name="password_again">
        </div>

        <input type="hidden" name="token" value="<?php echo Token::generate();?>">

    	  <div class="checkbox mb-3">
    	    <label>
    	      <input type="checkbox" name="accept"> Согласен со всеми правилами
    	    </label>
    	  </div>
    	  <button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
    	  <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
    </form>

</body>
</html>
