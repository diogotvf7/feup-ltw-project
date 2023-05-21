
<?php function drawMyAccountPage() { ?>
    <main id="my-account-page">
        <form method="post" action="../actions/edit_account.php">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <h1>My Account</h1>
            <fieldset>
                <div>    
                    <label for="name">Name: </label>
                    <input id="name" name="name" placeholder="Name" readonly required>
                </div>
                <div>
                    <label for="username">Username: </label>
                    <input id="username" name="username" placeholder="Username" readonly required>
                </div>
                <div>
                    <label for="email">Email: </label>
                    <input id="email" name="email" placeholder="Email" readonly required>
                </div>
                <div>
                    <label for="password" hidden>Password: </label>
                    <input id="password" type="password" name="password" placeholder="Password" readonly hidden required>
                </div>
                <div id="change-password-div">
                    <label for="checkbox" hidden>Change password:</label>
                    <input id="checkbox" type="checkbox" name="change-password" hidden>
                </div>
                <div>
                    <label for="new-password" hidden>New password: </label>
                    <input id="new-password" type="password" name="new-password" placeholder="New password" readonly hidden>
                </div>
                <div>
                    <label for="confirm-new-password" hidden>Confirm new password: </label>
                    <input id="confirm-new-password" type="password" name="confirm-new-password" placeholder="Confirm new password" readonly hidden>
                </div>
            </fieldset>
            <button type="button">Edit</button>
            <button type="submit" hidden>Save</button>
        </form>
        <button type="button" class="delete-button">
            <i class="fa-solid fa-trash"></i> Delete account
        </button>
    </main>
<?php } ?>