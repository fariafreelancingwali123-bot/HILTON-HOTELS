<!-- book.php -->
<?php
$conn = new mysqli("localhost", "u1fkgwiwpmjub", "mp8cjl5322br", "dbnorj5zgiry1n");
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM hotels WHERE id = $id");
$hotel = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $checkin = $_POST['checkin'];
  $checkout = $_POST['checkout'];

  $conn->query("INSERT INTO bookings (hotel_id, name, email, checkin, checkout) VALUES ('$id', '$name', '$email', '$checkin', '$checkout')");
  echo "Booking confirmed for $name!";
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Book <?= $hotel['name'] ?></title>
</head>
<body>
  <h1><?= $hotel['name'] ?></h1>
  <form method="post">
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="email" name="email" placeholder="Your Email" required>
    <input type="date" name="checkin" required>
    <input type="date" name="checkout" required>
    <button type="submit">Confirm Booking</button>
  </form>
</body>
</html>
