<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  
  if (isset($_SESSION['username'])) {
    // Redirect to home page if user is already logged in
    die(header('Location: ../pages/list.php'));
  }

  $db = getDatabaseConnection();

  drawHeader(['login_register_switch']);
?>
  <header>
    <h1>
        <a href="../pages/index.php">
            UP Tickets
        </a>
    </h1>
  </header>
  <main>
    <form action="../actions/action_login.php" id="sign_in_form" method="post">
      <h2>Login</h2>
      <input type="email_or_username" name="userid" placeholder="email or username">
      <input type="password" name="password" placeholder="password">
      <div class="buttons">
        <button type="submit">Login</button>
        <button type="button" id="hide_sign_in">Switch to Sign Up</button>
      </div>
    </form>
    <form action="../actions/action_sign_up.php" id="sign_up_form" class="hide" method="post">
      <h2>Sign Up</h2>
      <input type="email" name="email" placeholder="email">
      <input type="name" name="name" placeholder="name">
      <input type="username" name="username" placeholder="username">
      <input type="password" name="password" placeholder="password">
      <input type="password" name="hide_sign_up" placeholder="repeat password">
      <div class="buttons">
        <button type="submit">Sign Up</button>
        <button type="button" id="hide_sign_up">Switch to Login</button>
      </div>
    </form>
  </main>
<?php
  drawFooter();
?>