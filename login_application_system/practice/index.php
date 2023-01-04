<?php
use Composer\DependencyResolver\Transaction;
use Twilio\Rest\Serverless\V1\Service\FunctionInstance;

try {
  $db = new PDO(
    'mysql:host=localhost;dbname=auth',
    'root',
    '',
    // Persistent Connection
    [
        PDO::ATTR_PERSISTENT => true,
        // Turn off the simulation statement in sql server
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
  );
  $db->exec('SET names utf8');
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage());
}
// Work With Transaction [Practice]
try {
  $stmt = $db->prepare("SELECT * FROM users WHERE user_name=:user_name AND password=:password");
  $stmt->execute([
    'user_name' => 'hamza',
    'password' => '1234'
  ]);
  if ($stmt->rowCount()) {
    $user_data = $stmt->fetchAll()[0];
    print_r($user_data);
    $user_salary = $user_data['user_salary'];
    $permission = $user_data['permission'];
    $salary_transact = 1000.00;

    if ($user_salary >= $salary_transact && $permission == 1) {
      $stmt = $db->prepare("SELECT * FROM users WHERE user_name=:username");
      $stmt->bindValue(':username', 'mohamed');
      $stmt->execute();
      if ($stmt->rowCount()) {
        $salary = $stmt->fetchAll()[0]['user_salary'];
        $total_salary = $salary + $salary_transact;
        $stmt = $db->prepare(
          "UPDATE users SET user_salary = :user_salary WHERE user_name = :user_name"
        );
        $stmt->execute([
          'user_salary' => $total_salary,
          'user_name' => 'mohamed'
        ]);
        if ($stmt->rowCount()) {
          $current_salary = $user_salary - $salary_transact;
          $stmt = $db->prepare(
            "UPDATE users SET user_salary=:user_salary WHERE user_name=:user_name"
          );
          $stmt->execute(['user_salary' => $current_salary, 'user_name' => 'hamza']);
          if ($stmt->rowCount()) {
            echo 'Transaction Happened Successfully';
          }
        }
      }
    }
  }

} catch (\PDOException $e) {
  die(print_r($e->getMessage()));
}




// Work with FetchObject;
// class user
// {
//   private $car;
//   private $user_name;
//   public function __construct($car, $user_name)
//   {
//     $this->car = $car;
//     $this->user_name = $user_name;
//   }
// }

// $stmt = $db->query('SELECT * FROM users');
// echo ('<pre>');
// print_r($stmt->fetchObject('user', ['tesla', 'Jallal']));
// echo ('</pre>');


// Best practice fot the fetch
// $stmt = $db->query('SELECT user_name,password FROM users');
// echo '<pre>';
// print_r($stmt->fetchAll(PDO::FETCH_KEY_PAIR));
// echo '</pre>';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Master PDO</title>
</head>

<body>
  <form action="" method="post"></form>
</body>

</html>