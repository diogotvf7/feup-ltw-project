<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  
  if (isset($_SESSION['IDUSER'])) {
    // Redirect to home page if user is already logged in
    die(header('Location: ../pages/display_tickets.php'));
  }

  $db = getDatabaseConnection();

  drawHeader(['login_register_switch'], ['login-register']);
?>
  <main>
    <h1 class="up">Welcome to</h1>
    <form action="../actions/action_login.php" class="form-box" method="post">
      <h2>Login</h2>
      <input type="email" name="email" placeholder="Email" hidden>
      <input type="name" name="name" placeholder="Name" hidden>
      <input type="username" name="username" placeholder="Username">
      <input type="password" name="password" placeholder="Password">
      <input type="password" name="confirm-password" placeholder="Confirm password" hidden>
      <button type="submit">Login</button>
      <span>
        <p>Don't have an account yet?</p>
        <button type="button" id="switch-state">Sign Up</button>
      </span>
    </form>
    <h1 class="down">UP Tickets</h1>
  </main>
<?php
  drawFooter();
?>