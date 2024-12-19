<?php
require_once '../../dbCfg.php';
require_once '../../Controller/Users/registeredUserBotController.php';


$botConfig = null;
$error = null; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['industry'])) {
    $result = handleIndustrySelection($_POST['industry']);
    if (isset($result['error'])) {
        $error = $result['error'];
    } else {
        $botConfig = $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bot Prototype</title>
  <link rel="stylesheet" href="registeredUserBot.css">
  <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
</head>
<body>
  <h1>Choose Your Industry</h1>
  <form method="POST">
    <div class="button-container">
      <input type="submit" name="industry" value="F&B" class="button" />

      <button type="button" class="button" onclick="alert('More industries will be added along the way...')">
        Coming Soon...
      </button>
    </div>
  </form>

  <div id="chatbotContainer">
    <?php if ($botConfig): ?>
      <!-- Dynamically add the df-messenger component -->
      <df-messenger
        intent="<?= htmlspecialchars($botConfig['intent']) ?>"
        chat-title="<?= htmlspecialchars($botConfig['chat_title']) ?>"
        agent-id="<?= htmlspecialchars($botConfig['agent_id']) ?>"
        language-code="<?= htmlspecialchars($botConfig['language_code']) ?>">
      </df-messenger>
    <?php elseif ($error): ?>
      <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
  </div>
  <!-- <script src="registeredUserBotController.php"></script> -->


</body>
</html>
