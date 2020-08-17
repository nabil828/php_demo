
<?php

/**
  * List all users with a link to edit
  */

try {
  require "./config.php";
  require "./install.php";
  require "./common.php";



  $sql = "SELECT * FROM MyGuests";

  $statement = $conn->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();

} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>

<?php
if (isset($_GET["id"])) {
  try {

    $id = $_GET["id"];

    $sql = "DELETE FROM MyGuests WHERE id = :id";

    $statement = $conn->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $success = "User successfully deleted";
    echo $success;

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>

<?php require "templates/header.php"; ?>
<h2>Update users</h2>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email Address</th>
      <th>Date</th>
      <th>Edit</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["id"]); ?></td>
      <td><?php echo escape($row["firstname"]); ?></td>
      <td><?php echo escape($row["lastname"]); ?></td>
      <td><?php echo escape($row["email"]); ?></td>
      <td><?php echo escape($row["reg_date"]); ?> </td>
      <td><a href="delete.php?id=<?php echo escape($row["id"]); ?>">Delete </a></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="index.php">Back to home</a>
