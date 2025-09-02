<?php 
require_once __DIR__.'/../db.php'; 
require_login(); 

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;
$vehicle = [
  'make'=>'','model'=>'','year'=>'','price'=>'','mileage'=>'',
  'transmission'=>'','fuel'=>'','description'=>'','image'=>''
];

if ($editing) {
  $stmt = $mysqli->prepare("SELECT * FROM vehicles WHERE id=?");
  $stmt->bind_param('i',$id);
  $stmt->execute();
  $vehicle = $stmt->get_result()->fetch_assoc() ?? $vehicle;
  $stmt->close();
}

$msg = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $make = trim($_POST['make'] ?? '');
  $model = trim($_POST['model'] ?? '');
  $year = (int)($_POST['year'] ?? 0);
  $price = (float)($_POST['price'] ?? 0);
  $mileage = (float)($_POST['mileage'] ?? 0);
  $transmission = $_POST['transmission'] ?? '';
  $fuel = $_POST['fuel'] ?? '';
  $description = trim($_POST['description'] ?? '');

  $imageName = $vehicle['image'] ?? '';
  if (!empty($_FILES['image']['name'])) {
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
      $imageName = uniqid('car_', true).'.'.$ext;
      move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/../assets/images/uploads/'.$imageName);
    } else {
      $msg = 'Invalid image type.';
    }
  }

  if (!$msg && $make && $model && $year) {
    if ($editing) {
      // UPDATE
      $stmt = $mysqli->prepare("
        UPDATE vehicles 
        SET make=?, model=?, year=?, price=?, mileage=?, transmission=?, fuel=?, description=?, image=? 
        WHERE id=?");
      $stmt->bind_param('ssiddssssi', 
        $make,$model,$year,$price,$mileage,
        $transmission,$fuel,$description,$imageName,$id
      );
      $stmt->execute(); 
      $stmt->close();
      header('Location: vehicles.php'); 
      exit;
    } else {
      // INSERT
      $stmt = $mysqli->prepare("
        INSERT INTO vehicles (make,model,year,price,mileage,transmission,fuel,description,image) 
        VALUES (?,?,?,?,?,?,?,?,?)");
      $stmt->bind_param('ssiddssss', 
        $make,$model,$year,$price,$mileage,
        $transmission,$fuel,$description,$imageName
      );
      $stmt->execute(); 
      $stmt->close();
      header('Location: vehicles.php'); 
      exit;
    }
  } else if(!$msg) {
    $msg = 'Required: make, model, year.';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $editing?'Edit':'Add'; ?> Vehicle - Vinal Auto</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <header style="display:flex;justify-content:space-between;align-items:center">
      <h2><?php echo $editing?'Edit':'Add'; ?> Vehicle</h2>
      <div><a class="btn" href="vehicles.php">Back</a></div>
    </header>
    <?php if ($msg) echo '<div class="alert">'.e($msg).'</div>'; ?>
    <form method="post" enctype="multipart/form-data" class="card form">
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:10px">
        <input name="make" placeholder="Make" value="<?php echo e($vehicle['make']); ?>" required>
        <input name="model" placeholder="Model" value="<?php echo e($vehicle['model']); ?>" required>
        <input type="number" name="year" placeholder="Year" value="<?php echo e($vehicle['year']); ?>" required>
        <input type="number" step="0.01" name="price" placeholder="Price (LKR)" value="<?php echo e($vehicle['price']); ?>">
        <input type="number" step="0.1" name="mileage" placeholder="Mileage (km)" value="<?php echo e($vehicle['mileage']); ?>">
        <select name="transmission">
          <?php
            $opts=['','Manual','Automatic'];
            foreach($opts as $o){ 
              $sel = ($vehicle['transmission']===$o)?'selected':''; 
              echo "<option $sel>".e($o)."</option>"; 
            }
          ?>
        </select>
        <select name="fuel">
          <?php
            $opts=['','Petrol','Diesel','Hybrid','Electric'];
            foreach($opts as $o){ 
              $sel = ($vehicle['fuel']===$o)?'selected':''; 
              echo "<option $sel>".e($o)."</option>"; 
            }
          ?>
        </select>
      </div>
      <textarea name="description" placeholder="Description"><?php echo e($vehicle['description']); ?></textarea>
      <div>
        <?php if (!empty($vehicle['image'])) echo '<img style="max-width:180px" src="../assets/images/uploads/'.e($vehicle['image']).'">'; ?>
      </div>
      <input type="file" name="image" accept="image/*">
      <button class="btn"><?php echo $editing?'Save Changes':'Create Vehicle'; ?></button>
    </form>
  </div>
</body>
</html>
