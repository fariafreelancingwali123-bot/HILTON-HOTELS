<?php
$conn = new mysqli("localhost", "u1fkgwiwpmjub", "mp8cjl5322br", "dbnorj5zgiry1n");

// Search setup
$location = $_GET['location'] ?? '';
$hotels = [];
$noMatch = false;

if (!empty($location)) {
    $stmt = $conn->prepare("SELECT * FROM hotels WHERE location LIKE ?");
    $searchTerm = "%$location%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $hotels = $result;
    } else {
        $noMatch = true;
        $hotels = $conn->query("SELECT * FROM hotels");
    }
} else {
    $hotels = $conn->query("SELECT * FROM hotels");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Hilton Hotel Booking</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background: #f5f5f5;
    }

    header {
      background-color: #003580;
      color: white;
      padding: 20px;
      text-align: center;
    }

    form {
      display: flex;
      justify-content: center;
      gap: 10px;
      padding: 20px;
      background: white;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    input[type="text"], input[type="date"] {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      padding: 10px 15px;
      background-color: #003580;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #00254d;
    }

    h2 {
      text-align: center;
      padding: 10px;
      color: #003580;
    }

    .hotel-list {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding: 20px;
      gap: 20px;
    }

    .hotel-card {
      background: white;
      width: 300px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: 0.3s;
    }

    .hotel-card:hover {
      transform: translateY(-5px);
    }

    .hotel-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .hotel-card h3 {
      margin: 10px;
    }

    .hotel-card p {
      margin: 10px;
      color: #555;
    }

    .hotel-card a {
      display: block;
      text-align: center;
      background-color: #003580;
      color: white;
      padding: 10px;
      text-decoration: none;
      border-top: 1px solid #eee;
    }

    .hotel-card a:hover {
      background-color: #00254d;
    }

    @media (max-width: 768px) {
      .hotel-card {
        width: 90%;
      }

      form {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>Hilton-Style Hotel Booking</h1>
  </header>

  <form method="get">
    <input type="text" name="location" placeholder="Enter City" value="<?= htmlspecialchars($location) ?>">
    <input type="date" name="checkin">
    <input type="date" name="checkout">
    <button type="submit">Search</button>
  </form>

  <h2>
    <?php
      if (!empty($location) && !$noMatch) {
        echo "Showing results for '" . htmlspecialchars($location) . "'";
      } elseif ($noMatch) {
        echo "No hotels found for '" . htmlspecialchars($location) . "'. Showing all hotels.";
      } else {
        echo "Featured Hotels in Pakistan";
      }
    ?>
  </h2>

  <div class="hotel-list">
    <?php while ($row = $hotels->fetch_assoc()): ?>
      <div class="hotel-card">
        <img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
        <h3><?= $row['name'] ?></h3>
        <p>📍 <?= $row['location'] ?></p>
        <p>💲 <?= $row['price'] ?> / night</p>
        <a href="book.php?id=<?= $row['id'] ?>">Book Now</a>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
