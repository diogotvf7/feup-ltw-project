<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  include_once('../utils/util_funcs.php');
  $db = getDatabaseConnection();
  
  if (isset($_SESSION['IDUSER'])) {
    // Redirect to home page if user is already logged in
    if ($_SESSION['PERMISSIONS'] == 'Admin' || $_SESSION['PERMISSIONS'] == 'Agent'){
      header('Location: /pages/display_tickets.php');
    }
    else{
      header('Location: /pages/my_tickets.php');
    }
  }


  drawHeader(['login_register_switch'], ['login-register']);
?>
  <main>
    <h1 class="up">Welcome to</h1>
    <form action="../actions/action_login.php" class="form-box" method="post">
      <h2>Login</h2>
      <input type="email" name="email" placeholder="Email" hidden>
      <input type="name" name="name" placeholder="Name" hidden>
      <input type="username" name="username" placeholder="Username">
      <input type="password" id="password" name="password" oninput="" placeholder="Password">
      
      <div class="requirements-todo-list" hidden>
        <span class="requirements-title">
            Your password has to:
        </span>
            <div class="requirement-todo-item ">
        <div class="requirement-todo-icon pull-left">
            <i name="password_lowercase_icon" class="fa fa-info-circle" aria-hidden="true"></i>
            <div class="icon-checkmark-small"></div>
        </div>
        <div class="requirement-todo-text pull-left">
            Have at least one lowercase.
        </div>
    </div>

            <div class="requirement-todo-item ">
        <div class="requirement-todo-icon pull-left">
            <i name="password_uppercase_icon" class="fa fa-info-circle" aria-hidden="true"></i>
            <div class="icon-checkmark-small"></div>
        </div>
        <div class="requirement-todo-text pull-left">
            Have at least one uppercase.
        </div>
    </div>

            <div class="requirement-todo-item">
        <div class="requirement-todo-icon pull-left">
            <i name="password_number_icon" class="fa fa-info-circle" aria-hidden="true"></i>
            <div class="icon-checkmark-small"></div>
        </div>
        <div class="requirement-todo-text pull-left">
            Have at least one number.
        </div>
    </div>

            <div class="requirement-todo-item ">
        <div class="requirement-todo-icon pull-left">
            <i name="password_special_icon" class="fa fa-info-circle" aria-hidden="true"></i>
            <div class="icon-checkmark-small"></div>
        </div>
        <div class="requirement-todo-text pull-left">
            Have at least one special character.
        </div>
    </div>

            <div class="requirement-todo-item ">
        <div class="requirement-todo-icon pull-left">
            <i name="password_min_length_icon" class="fa fa-info-circle" aria-hidden="true"></i>
            <div class="icon-checkmark-small"></div>
        </div>
        <div class="requirement-todo-text pull-left">
            Be at least 8 characters.
        </div>
    </div>

    </div>
      <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm password" hidden>
      <div class="match-passwords" hidden>
        <span class="requirements-title">
            Both passwords should match!
        </span>
      </div>
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