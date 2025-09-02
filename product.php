<button onclick="document.getElementById('orderForm').style.display='block'">Buy Now</button>

<div id="orderForm" style="display:none;">
  <form method="POST" action="submit_order.php">
    <input type="hidden" name="part_id" value="<?= $part_id ?>">
    <input type="text" name="name" placeholder="ඔබගේ නම" required>
    <input type="text" name="phone" placeholder="දුරකථන අංකය" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Confirm Order</button>
  </form>
</div>