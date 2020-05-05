<?php
require_once 'C:/OSPanel/domains/diplom/init.php';

$user_id = $_GET['id'];

$user = new User;

if(!$user->isLoggedIn()) {
    redirect::to('login.php');
}


$anatherUser = new User($user_id);
$anatherUser_username = $anatherUser->data()->username;
$anatherUser_status = $anatherUser->data()->status;


if(Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST, [

            'username' => [
                'required' => true,
                'min' => 2,
                'max' => 15,
            ],
            'status' => [
                'required' => true,
                'min' => 3,
                'max' => 150
            ]
        ]);

        if ($validation->passed()) {

            //$user = new User;

            $user->update([
                'username' => Input::get('username'),
                'status' => Input::get('status')],
                $user_id);

            //redirect::to('profile.php');
            $success_update = Session::flash('success', 'Профиль успешно обновлен!');

        } else {

            $val_errors = $validation->errors();
        }
    }
}
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
              <a style="color: cornflowerblue" class="nav-link" href="http://diplom/index.php">Главная</a>
            </li>
            <li class="nav-item">
              <a style="color: cornflowerblue" class="nav-link" href="index.php">Управление пользователями</a>
            </li>
          </ul>

          <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link" ><?php echo $user->data()->username ?></a>
              </li>
              <li class="nav-item">
                <a style="color: cornflowerblue" href="profile.php" class="nav-link">Профиль</a>
              </li>
              <a style="color: cornflowerblue" href="http://diplom/logout" class="nav-link">Выйти</a>
            </li>
          </ul>
        </div>
    </nav>

   <div class="container">
     <div class="row">
       <div class="col-md-8">
         <h1>Профиль пользователя - <?php echo $anatherUser_username ?></h1>
         <div class="alert alert-success"><?php echo $success_update ?></div>
         
         <div class="alert alert-danger">
           <ul>
               <?php if($val_errors) {?>
                   <?php foreach ($val_errors as $val_error) : ?>
                       <li><?php echo $val_error . '<br>'?></li>
                   <?php endforeach; ?>
               <?php } ?>
           </ul>
         </div>
         <form action="" class="form" method="post">
           <div class="form-group">
             <label for="username">Имя</label>
             <input type="text" id="username" class="form-control" name="username" value="<?php echo $anatherUser_username ?>">
           </div>
           <div class="form-group">
             <label for="status">Статус</label>
             <input type="text" id="status" class="form-control" name="status" value="<?php echo $anatherUser_status ?>">
           </div>

             <input type="hidden" name="token" value="<?php echo Token::generate();?>">

           <div class="form-group">
             <button class="btn btn-warning">Обновить</button>
           </div>
         </form>


       </div>
     </div>
   </div>
</body>
</html>