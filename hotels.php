<!-- hotels.php -->
<?php
$conn = new mysqli("localhost", "u1fkgwiwpmjub", "mp8cjl5322br", "dbnorj5zgiry1n");
$location = $_GET['location'];
$query = "SELECT * FROM hotels WHERE location LIKE '%$location%'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Hotel Listings</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Hotels in <?= htmlspecialchars($location) ?></h1>
  <div class="hotel-list">
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="hotel-card">
        <img src="<?= $row['image'] ?>" alt="Hotel image">
        <h3><?= $row['name'] ?></h3>
        <p>Price: $<?= $row['price'] ?>/night</p>
        <a href="book.php?id=<?= $row['id'] ?>">Book Now</a>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
