<?php

require_once 'vendor/autoload.php';

use Roma\Task6\User;

$user = new User();

while(true)
{
  print("\n1: Вывести все данные \n2: Добавить пользователя\n3: Удалить пользователя (по id) \n4: Поиск пользователя \n5: Обновление пользователя \n");
  $actionNum = readline("Выберите действие: ");

  switch ($actionNum) {
    case 1:
      $user->showAllData();
      break;

    case 2:
      $userName = readline("username: ");
      $userEmail = readline("Email: ");
      $user->addUser($userName, $userEmail);
      break;
    
    case 3:
      $user->showAllData();
      $id = readline("Введите id пользователя: ");
      $user->deleteUser($id);
      break;

    case 4:
      $str = readline("Введите userName или email: ");
      $user->searchUsers($str);
      break;

    case 5:
      $user->showAllData();
      $id = readline("Введите id пользователя: ");
      $name = readline("Введите имя: ");
      $email = readline("Введите email: ");
      $user->updateUser($id, $name, $email);
    default:
      print("Выбранно неправильное действие!\n");
      break;
  }
}
