<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/../db.php';

use Mpdf\Mpdf;

// ==================== GET VEHICLE ====================
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die("❌ Invalid vehicle ID");
}

$stmt = $mysqli->prepare("SELECT * FROM vehicles WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$vehicle = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$vehicle) {
    die("❌ Vehicle not found");
}

// ==================== mPDF INIT ====================
$mpdf = new Mpdf([
    'default_font' => 'dejavusans',
    'margin_top'   => 28,
    'margin_bottom'=> 20,
]);

// ==================== HEADER ====================
$mpdf->SetHTMLHeader('
<div style="text-align:center; font-size:16px; font-weight:bold; color:#2c3e50;">
    Vinal Auto Traders
</div>
<div style="text-align:center; font-size:12px; color:#555;">
    Premium Vehicle Sales & Imports
</div>
<hr style="border:1px solid #999;">
');

// ==================== FOOTER ====================
$mpdf->SetFooter('
<hr style="border:1px solid #999;">
<table width="100%">
  <tr>
    <td width="33%">Generated on {DATE d-m-Y}</td>
    <td width="33%" align="center">Vinal Auto © {DATE Y}</td>
    <td width="33%" align="right">Page {PAGENO}</td>
  </tr>
</table>
');

// ==================== HTML TEMPLATE ====================
$html = "
<style>
  body { font-family: dejavusans; font-size: 12pt; color: #2c3e50; }
  h2 { text-align: center; color: #1a5276; margin-bottom: 15px; }
  table { border-collapse: collapse; width: 100%; margin-top: 10px; }
  td, th { border: 1px solid #666; padding: 8px; font-size: 11pt; }
  th { background: #f8f9f9; text-align: left; width: 35%; }
  .price { color: #e74c3c; font-weight: bold; font-size: 13pt; }
  .highlight { background: #f4f6f9; }
</style>

<h2>🚗 Vehicle Details Report</h2>
<table>
  <tr><th>Make</th><td>{$vehicle['make']}</td></tr>
  <tr class='highlight'><th>Model</th><td>{$vehicle['model']}</td></tr>
  <tr><th>Year</th><td>{$vehicle['year']}</td></tr>
  <tr class='highlight'><th>Price</th><td class='price'>LKR ".number_format($vehicle['price'])."</td></tr>
  <tr><th>Mileage</th><td>".number_format($vehicle['mileage'])." km</td></tr>
  <tr class='highlight'><th>Transmission</th><td>{$vehicle['transmission']}</td></tr>
  <tr><th>Fuel</th><td>{$vehicle['fuel']}</td></tr>
  <tr class='highlight'><th>Description</th><td>{$vehicle['description']}</td></tr>
</table>
";

// ==================== VEHICLE IMAGE ====================
if (!empty($vehicle['image'])) {
    $imgPath = __DIR__ . '/../assets/images/uploads/' . $vehicle['image'];
    if (file_exists($imgPath)) {
        $html .= "
        <br><div style='text-align:center; margin-top:20px;'>
            <img src='{$imgPath}' style='width:350px; border:3px solid #ddd; border-radius:10px; padding:5px;'>
            <p style='font-size:10pt; color:#888;'>Vehicle Image</p>
        </div>";
    }
}

// ==================== OUTPUT ====================
$mpdf->WriteHTML($html);
$mpdf->Output("vehicle_{$vehicle['id']}.pdf", "I"); // I = inline preview
