<!DOCTYPE html>
<html>
<head>
  <title>Salary-Based Vehicle Suggestion</title>
  <style>
    body {
      background-color: #0b1e3f;
      color: white;
      font-family: sans-serif;
      padding: 20px;
    }
    input, button {
      padding: 10px;
      margin: 10px 0;
      border-radius: 6px;
      border: none;
    }
    button {
      background-color: #007bff;
      color: white;
      cursor: pointer;
    }
  </style>
</head>
<body>

<h2>🚗 Vehicle Suggestion by Salary</h2>

<form method="POST">
  <label>Enter your monthly salary (Rs):</label><br>
  <input type="number" name="salary" required>
  <button type="submit">Suggest</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $salary = intval($_POST['salary']);

  echo "<h3>Suggested Vehicles:</h3>";

  if ($salary < 200000) {
    echo "🔹 Suzuki Alto<br>🔹 Perodua Axia";
  } elseif ($salary < 500000) {
    echo "🔹 Toyota Vitz<br>🔹 Nissan March";
  } elseif ($salary < 1000000) {
    echo "🔹 Toyota Aqua<br>🔹 Honda Fit";
  } else {
    echo "🔹 Honda Vezel<br>🔹 Toyota CH-R";
  }
}
?>

</body>
</html>