<?php

require_once 'connec.php';
$pdo = new \PDO(DSN, USER, PASS);

$firstname = $lastname = "";

if (!empty($_POST) && isset($_POST['btnContact'])) {

    $errors = [];

    $firstname = trim($_POST['user_firstname']);
    $lastname = trim($_POST['user_lastname']);


    if (empty($firstname))
        $errors['firstname'] = 'Required';
    if(strlen($firstname) > 45)
        $errors['firstname'] = 'Lastname too long';
    if (empty($lastname))
        $errors['lastname'] = 'Required';
    if(strlen($lastname) > 45)
        $errors['lastname'] = 'Firstname too long';


    var_dump($errors);
    if (empty($errors)) {

        echo $firstname;

        echo $lastname;
        $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

        $statement->execute();

        header("Location: index.php");

    }
}




$query2 = "SELECT * FROM friend";
$statement = $pdo->query($query2);
$friends = $statement->fetchAll(PDO::FETCH_ASSOC);


var_dump($friends);



?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>title</title>
  </head>
  <body>
    <ul>
        <?php foreach ($friends as $friend)
          echo "<li>" . $friend['firstname'] . " " . $friend['lastname'] ."</li>"; ?>
    </ul>
    <form action="index.php" method="post">
        <div class="form-group">
            <label for="firstname">Enter your firstname : </label>
            <input type="text"  name="user_firstname" class="form-control" id="firstname" placeholder="Jhon" required>
            <?php if (isset($errors['firstname'])): ?>
            <span style="color:red;"><?= $errors['firstname'] ?></span>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="lastname">Enter your lastname : </label>
            <input type="text" name="user_lastname" class="form-control" id="formGroupExampleInput2" placeholder="FERRIER" required>
            <?php if (isset($errors['lastname'])): ?>
            <span style="color:red;"><?= $errors['lastname'] ?></span>
            <?php endif; ?>
        </div>
        <button type="submit" value="send" name="btnContact">send</button>
    </form>
  </body>
</html>


