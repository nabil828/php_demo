<?php
$servername = "localhost";
$username = "nabil828";
$password = "6407710";
$dbname = "dbauto";


// Create + Check connection

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbauto", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";


// PHP MySQL Insert Data
// try {
//   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//   // set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   $sql = "INSERT INTO MyGuests (firstname, lastname, email)
//   VALUES ('John', 'Doe', 'john@example.com')";
//   // use exec() because no results are returned
//   $conn->exec($sql);
//   echo "New record created successfully";
// } catch(PDOException $e) {
//   echo $sql . "<br>" . $e->getMessage();
// }
//


// try {
//   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//   // set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//   // begin the transaction
//   $conn->beginTransaction();
//   // our SQL statements
//   $conn->exec("INSERT INTO MyGuests (firstname, lastname, email)
//   VALUES ('John', 'Doe', 'john@example.com')");
//   $conn->exec("INSERT INTO MyGuests (firstname, lastname, email)
//   VALUES ('Mary', 'Moe', 'mary@example.com')");
//   $conn->exec("INSERT INTO MyGuests (firstname, lastname, email)
//   VALUES ('Julie', 'Dooley', 'julie@example.com')");
//
//   // commit the transaction
//   $conn->commit();
//   echo "New records created successfully";
// } catch(PDOException $e) {
//   // roll back the transaction if something failed
//   $conn->rollback();
//   echo "Error: " . $e->getMessage();
// }



// prepare and bind
// try {
//   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//   // set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//   // prepare sql and bind parameters
//   $stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email)
//   VALUES (:firstname, :lastname, :email)");
//   $stmt->bindParam(':firstname', $firstname);
//   $stmt->bindParam(':lastname', $lastname);
//   $stmt->bindParam(':email', $email);
//
//   // insert a row
//   $firstname = "John";
//   $lastname = "Doe";
//   $email = "john@example.com";
//   $stmt->execute();
//
//   // insert another row
//   $firstname = "Mary";
//   $lastname = "Moe";
//   $email = "mary@example.com";
//   $stmt->execute();
//
//   // insert another row
//   $firstname = "Julie";
//   $lastname = "Dooley";
//   $email = "julie@example.com";
//   $stmt->execute();
//
//   echo "New records created successfully";
// } catch(PDOException $e) {
//   echo "Error: " . $e->getMessage();
// }



echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th></tr>";

class TableRows extends RecursiveIteratorIterator {
  function __construct($it) {
    parent::__construct($it, self::LEAVES_ONLY);
  }

  function current() {
    return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
  }

  function beginChildren() {
    echo "<tr>";
  }

  function endChildren() {
    echo "</tr>" . "\n";
  }
}


try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT id, firstname, lastname FROM MyGuests");
  $stmt->execute();

  // set the resulting array to associative
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
    echo $v;
  }
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";

$conn = null;

?>
