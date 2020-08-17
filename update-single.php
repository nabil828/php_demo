<?php

/**
  * Use an HTML form to edit an entry in the
  * users table.
  *
  */

require "./config.php";
require "./install.php";
require "./common.php";

if (isset($_GET['id'])) {
  try {
    $id = $_GET['id'];

    $sql = "SELECT * FROM MyGuests WHERE id = :id";
    $statement = $conn->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
  echo "Something went wrong!";
  exit;
}
?>



<?php require "templates/header.php"; ?>

<h2>Edit a user</h2>

<form method="post">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
      <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<?php
if (isset($_POST['submit'])) {
  try {
    $user =[
      "id"        => $_POST['id'],
      "firstname" => $_POST['firstname'],
      "lastname"  => $_POST['lastname'],
      "email"     => $_POST['email'],
      "reg_date"      => $_POST['reg_date']
    ];

    $sql = "UPDATE MyGuests
            SET id = :id,
              firstname = :firstname,
              lastname = :lastname,
              email = :email,
              reg_date = :reg_date
            WHERE id = :id";

  $statement = $conn->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
