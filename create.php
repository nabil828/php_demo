

<?php
if (isset($_POST['submit'])) {
  require "./config.php";
  require "./install.php";
  require "./common.php";

  try {
    $new_user = array(
    "firstname" => $_POST['firstname'],
    "lastname"  => $_POST['lastname'],
    "email"     => $_POST['email']
    );


    // $sql = "INSERT INTO MyGuests (firstname, lastname, email)
    // VALUES ($new_user['firstname'], $new_user['lastname'], $new_user['email'], $new_user['date'])";
    //
    //
    // // use exec() because no results are returned
    // $conn->exec($sql);
    $sql = sprintf(
    "INSERT INTO %s (%s) values (%s)",
    "MyGuests",
    implode(", ", array_keys($new_user)),
    ":" . implode(", :", array_keys($new_user))
        );
        echo $sql;

        $statement = $conn->prepare($sql);
        $statement->execute($new_user);
      } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
      }
}
?>



<?php include "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
  > <?php echo $_POST['firstname']; ?> successfully added.
<?php } ?>

    <h2>Add a user</h2>

    <form method="post">
    	<label for="firstname">First Name</label>
    	<input type="text" name="firstname" id="firstname">

    	<label for="lastname">Last Name</label>
    	<input type="text" name="lastname" id="lastname">

    	<label for="email">Email Address</label>
    	<input type="text" name="email" id="email">

    	<input type="submit" name="submit" value="Submit">
    </form>

    <a href="index.php">Back to home</a>

    <?php include "templates/footer.php"; ?>
