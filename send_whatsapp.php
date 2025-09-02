include 'send_whatsapp.php';

$my_number = '0768291088';
$message = 'ඔබගේ order එක සාර්ථකව ලැබී ඇත. ස්තුතියි!';

$link = sendWhatsApp($my_number, $message);

echo '<a href="'.$link.'" target="_blank" style="color:#25D366;">📲 Click to open WhatsApp</a>';