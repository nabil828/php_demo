
<?php
if (isset($_POST['submit'])) {
  require "./config.php";
  require "./install.php";
  require "./common.php";

  try {
    $sql = "SELECT *
    FROM MyGuests
    WHERE lastname = :lastname";

    $lastname = $_POST['lastname'];

    $statement = $conn->prepare($sql);
    $statement->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
    // if ($result && $statement->rowCount() > 0) {
    //   // open table
    //   foreach ($result as $row) {
    //     // table contents
    //   }
    //   // close table
    // } else 	{
    //   // no results
    // }
  }catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>



<?php include "templates/header.php"; ?>

    <h2>Find user based on location</h2>

    <form method="post">
    	<label for="lastname">Last Name</label>
    	<input type="text" id="lastname" name="lastname">

    	<input type="submit" name="submit" value="View Results">
    </form>

    <?php if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
          <thead>
    <tr>
      <th>#</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email Address</th>
      <th>Date</th>
    </tr>
          </thead>
      <tbody>
        <?php foreach ($result as $row) { ?>
        <tr>
  <td><?php echo escape($row["id"]); ?></td>
  <td><?php echo escape($row["firstname"]); ?></td>
  <td><?php echo escape($row["lastname"]); ?></td>
  <td><?php echo escape($row["email"]); ?></td>
  <td><?php echo escape($row["reg_date"]); ?> </td>
        </tr>
      <?php } ?>
        </tbody>
    </table>

  <?php } else { ?>
  > No results found for <?php echo escape($_POST['lastname']); ?>.
<?php }
} ?>

    <a href="index.php">Back to home</a>

<?php include "templates/footer.php";?>
