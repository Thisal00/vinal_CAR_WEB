<?php require_once __DIR__ . '/db.php'; ?>
<!DOCTYPE html>

<html lang="en">
<head>
  
  <meta charset="UTF-8">
  <title>Compare Vehicles</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <style>
    body {
      background-color: #0b1e3f;
      color: white;
      font-family: "Segoe UI", sans-serif;
    }
    h2 {
      text-align: center;
      color: #00d4ff;
      margin: 20px 0;
      font-weight: bold;
    }
    .card {
      background: #1f3b6e;
      border: none;
      border-radius: 15px;
      color: white;
      box-shadow: 0 6px 14px rgba(0,0,0,0.5);
      transform: scale(0.95);
      opacity: 0;
    }
    .table {
      background-color: #1f3b6e;
      border-radius: 12px;
      overflow: hidden;
    }
    th, td {
      padding: 12px;
      border: 1px solid #007bff;
      text-align: center;
    }
    th {
      background-color: #007bff;
      color: white;
    }
    .chart-container {
      background-color: #1f3b6e;
      padding: 20px;
      border-radius: 15px;
      margin-top: 30px;
      box-shadow: 0 6px 14px rgba(0,0,0,0.5);
      opacity: 0;
      transform: translateY(20px);
    }
    .summary-box {
      background: #162b52;
      padding: 25px;
      border-radius: 15px;
      margin-top: 30px;
      font-size: 16px;
      line-height: 1.7;
      box-shadow: 0 6px 14px rgba(0,0,0,0.5);
      opacity: 0;
      transform: translateY(20px);
    }
    .highlight {
      color: #00d4ff;
      font-weight: bold;
    }
  </style>
</head>
<body>

<!-- Navbar -->
  <?php include 'a_nav.php'; ?>
  <br>
  <br>
  <br>
  <br>


  <body>
<div class="container">
  <h2>Vehicle Comparison Tool</h2>

  <!-- Selection Form -->
  <form method="POST" class="p-4 rounded mb-4" style="background:#162b52; box-shadow: 0 4px 12px rgba(0,0,0,0.4);">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Select First Vehicle:</label>
        <select class="form-select" name="vehicle1" required>
          <option value="">-- Select Vehicle --</option>
          <?php
          $vehicles = $conn->query("SELECT id, model_name FROM vehicle_list");
          while ($v = $vehicles->fetch_assoc()) {
            $sel = (isset($_POST['vehicle1']) && $_POST['vehicle1'] == $v['id']) ? "selected" : "";
            echo "<option value='{$v['id']}' $sel>" . htmlspecialchars($v['model_name']) . "</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Select Second Vehicle:</label>
        <select class="form-select" name="vehicle2" required>
          <option value="">-- Select Vehicle --</option>
          <?php
          $vehicles->data_seek(0);
          while ($v = $vehicles->fetch_assoc()) {
            $sel = (isset($_POST['vehicle2']) && $_POST['vehicle2'] == $v['id']) ? "selected" : "";
            echo "<option value='{$v['id']}' $sel>" . htmlspecialchars($v['model_name']) . "</option>";
          }
          ?>
        </select>
      </div>
    </div>
    <button type="submit" class="btn btn-primary w-100 mt-3 fw-bold">🔍 Compare</button>
  </form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id1 = intval($_POST['vehicle1']);
  $id2 = intval($_POST['vehicle2']);

  $query = $conn->query("SELECT * FROM vehicle_list WHERE id IN ($id1, $id2)");
  $data = [];

  while ($row = $query->fetch_assoc()) {
    $data[] = [
      'model_name'     => htmlspecialchars($row['model_name']),
      'fuel_efficiency'=> floatval($row['fuel_efficiency']),
      'price'          => floatval($row['price']),
      'resale_value'   => floatval($row['resale_value'])
    ];
  }

  if (count($data) === 2) {
    echo '<div class="card p-3 mt-4 comparison-card">';
    echo '<h4 class="text-center text-info"> Comparison Table</h4>';
    echo '<table class="table table-bordered text-white">';
    echo '<tr><th>Feature</th><th>' . $data[0]['model_name'] . '</th><th>' . $data[1]['model_name'] . '</th></tr>';
    echo '<tr><td> Fuel Efficiency (km/l)</td><td>' . $data[0]['fuel_efficiency'] . '</td><td>' . $data[1]['fuel_efficiency'] . '</td></tr>';
    echo '<tr><td> Price (New)</td><td>Rs. ' . number_format($data[0]['price']) . '</td><td>Rs. ' . number_format($data[1]['price']) . '</td></tr>';
    echo '<tr><td>Resale Value</td><td>Rs. ' . number_format($data[0]['resale_value']) . '</td><td>Rs. ' . number_format($data[1]['resale_value']) . '</td></tr>';
    echo '</table>';
    echo '</div>';

    // Chart
    $vehicleNames = [$data[0]['model_name'], $data[1]['model_name']];
    $fuelData     = [$data[0]['fuel_efficiency'], $data[1]['fuel_efficiency']];
    $priceData    = [$data[0]['price'], $data[1]['price']];
    $resaleData   = [$data[0]['resale_value'], $data[1]['resale_value']];
    ?>

    <div class="chart-container">
      <h4 class="text-center text-info">Feature Comparison Chart</h4>
      <canvas id="compareChart" height="120"></canvas>
    </div>

    <script>
    const ctx = document.getElementById('compareChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ["Fuel Efficiency", "Price", "Resale Value"],
        datasets: [
          {
            label: "<?php echo $vehicleNames[0]; ?>",
            data: [<?php echo $fuelData[0]; ?>, <?php echo $priceData[0]; ?>, <?php echo $resaleData[0]; ?>],
            backgroundColor: "rgba(0, 212, 255, 0.7)"
          },
          {
            label: "<?php echo $vehicleNames[1]; ?>",
            data: [<?php echo $fuelData[1]; ?>, <?php echo $priceData[1]; ?>, <?php echo $resaleData[1]; ?>],
            backgroundColor: "rgba(0, 123, 255, 0.7)"
          }
        ]
      },
      options: {
        responsive: true,
        animation: {
          duration: 1500,
          easing: "easeOutBounce"
        },
        plugins: {
          legend: { labels: { color: "white", font: { size: 14, weight: 'bold' } } }
        },
        scales: {
          x: { ticks: { color: "white", font: { size: 13 } } },
          y: { ticks: { color: "white", font: { size: 13 } } }
        }
      }
    });
    </script>

    <?php
    // ✅ Smart Summary
    $summary = "<div class='summary-box smart-summary'>";
    $summary .= "<h5 class='text-info fw-bold'> Smart Assistant Insights</h5>";

    // Fuel comparison
    if ($data[0]['fuel_efficiency'] > $data[1]['fuel_efficiency']) {
      $summary .= "<p> <span class='highlight'>{$data[0]['model_name']}</span> offers better fuel efficiency, making it cheaper to run daily.</p>";
    } elseif ($data[1]['fuel_efficiency'] > $data[0]['fuel_efficiency']) {
      $summary .= "<p> <span class='highlight'>{$data[1]['model_name']}</span> offers better fuel efficiency, saving more on fuel expenses.</p>";
    } else {
      $summary .= "<p> Both vehicles perform equally in terms of fuel efficiency.</p>";
    }

    // Price comparison
    if ($data[0]['price'] < $data[1]['price']) {
      $summary .= "<p> <span class='highlight'>{$data[0]['model_name']}</span> is more affordable, making it a budget-friendly choice.</p>";
    } elseif ($data[1]['price'] < $data[0]['price']) {
      $summary .= "<p> <span class='highlight'>{$data[1]['model_name']}</span> comes at a lower price, giving better upfront savings.</p>";
    } else {
      $summary .= "<p> Both vehicles are priced the same.</p>";
    }

    // Resale value comparison
    if ($data[0]['resale_value'] > $data[1]['resale_value']) {
      $summary .= "<p> <span class='highlight'>{$data[0]['model_name']}</span> holds its value better, making it a stronger long-term investment.</p>";
    } elseif ($data[1]['resale_value'] > $data[0]['resale_value']) {
      $summary .= "<p> <span class='highlight'>{$data[1]['model_name']}</span> has a stronger resale market, giving you more when you sell.</p>";
    } else {
      $summary .= "<p> Both vehicles have the same resale value.</p>";
    }

    $summary .= "<p> <b>Overall:</b> If you prioritize <span class='highlight'>running cost savings</span>, choose the fuel-efficient one.  
                 If you want <span class='highlight'>lower purchase cost</span>, go for the cheaper model.  
                 And if you care about <span class='highlight'>long-term value</span>, the higher resale option is your winner.</p>";
    $summary .= "</div>";

    echo $summary;
  } else {
    echo "<p class='text-warning text-center mt-4'> Please select two valid vehicles.</p>";
  }
}
?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // GSAP animations
  window.onload = () => {
    gsap.to(".comparison-card", {scale:1, opacity:1, duration:0.8, ease:"back.out(1.7)"});
    gsap.to(".chart-container", {opacity:1, y:0, duration:1, delay:0.5});
    gsap.to(".smart-summary", {opacity:1, y:0, duration:1, delay:1});
  };
</script>
</body>
</html>
