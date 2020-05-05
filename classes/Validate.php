<?php


class Validate {

    private $passed = false, $erorrs = [], $db = null;
	
// передаёт соединение с  базой свойству $db
    public function __construct() {
        $this->db = Database::getInstance();
    }

// проверяет валидационные данные

    public function check($source, $items = [], $user_id = null) {

        //print_r($source);
        //print_r($items);

        foreach ($items as $item => $rules) { // В $items у нас весь массив c правилами
                                              // в $item - ключ ('username', 'email', 'password', 'password_again'), а в $rules все правила
            foreach ($rules as $rule => $rule_value) { // теперь в $rules массив с правилами, $rule - это ('required', 'min', 'max' и т.д.),
                                                       // а $rule_value - это соответственно значенич ('true', '2', '15' и т.д.)

              $value = $source[$item]; // В $value храниться значение нашего инпута; $source - это наш глобальный массив $_POST, $item - ('username', 'email', 'password', 'password_again')

              if($rule == 'required' && empty($value)) {

                  $this->addError(" введите {$item}");
              } else if(!empty($value)) {
                  switch ($rule) {

                      case 'min':
                          if(strlen($value) < $rule_value) {
                              $this->addError("{$item} должен быть минимум {$rule_value} символа");
                      }
                      break;

                      case 'max':
                          if (strlen($value) > $rule_value) {
                             $this->addError("{$item} должен быть максимум {$rule_value} символа");
                      }
                      break;

                      case 'matches':
                          if($value != $source[$rule_value]) {
                              $this->addError("{$rule_value} должен совпадать с {$item}");
                          }
                          break;

                      case 'unique':          // табл 'users', 'password', 'значение инпута'
                          $check = $this->db->get($rule_value, [$item, '=', $value]);
                          //var_dump($check);
                          if($check->count()) {
                              $this->addError("{$item} уже существует");
                          }
                          break;

                      case 'email':
                          if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                              $this->addError("не правильный формат {$item}");
                          }
                          break;

//                      case 'equal':
//                          $check = $this->db->getAll($rule_value);
//                          $users = $check->results();
//
//                          break;

                      case 'equal':
                          $User = new User;
                          $User->data()->password;
                          var_dump($User->data()->password);

                          if(!password_verify($value, $User->data()->password)) {
                              $this->addError("не правильный текущий {$item}");
                          }
                          break;

                  }
              }

            }
        }

        if(empty($this->erorrs)) {
            $this->passed = true;
        }

        return $this;

    }

// добавляет сообщение об ошибке и потом закидываем в массив

    public function addError($error) {
        //echo $error;
        $this->erorrs[] = $error;
    }

// возвращает массив наших ошибок

    public function errors() {
        return $this->erorrs;
    }

// метод выводит true либо false в нашем свойстве $passed

    public function passed() {
        return $this->passed;
    }
}