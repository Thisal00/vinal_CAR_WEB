<?php
session_start();
require_once __DIR__.'/../db.php';
require_login();

if ($_SESSION['role'] !== 'admin') {
    exit('Access denied');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to_email = $_POST['to_email'] ?? '';
    $reply = $_POST['reply'] ?? '';

    if ($to_email && $reply) {
        ?>
        <!-- ✅ Hidden FormSubmit form -->
        <form id="formsubmit" action="https://formsubmit.co/thisalchathnuka@gmail.com" method="POST">
            <input type="hidden" name="_subject" value="Reply from Vinal Auto">
            <input type="hidden" name="_replyto" value="<?php echo htmlspecialchars($to_email); ?>">
            <input type="hidden" name="message" value="<?php echo htmlspecialchars($reply); ?>">
            <input type="hidden" name="_next" value="http://localhost/vinal_auto/admin/messages.php?success=1">
        </form>

        <script>
            // auto-submit the hidden form
            document.getElementById("formsubmit").submit();
        </script>
        <?php
        exit;
    } else {
        echo "<script>alert('Invalid email or empty message'); window.history.back();</script>";
    }
}
?>
