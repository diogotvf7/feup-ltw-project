
<?php function drawMyAccountPage() { ?>
    <main id="my-account-page">
        <form method="post" action="../actions/edit_account.php">
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
                    <input type="password" name="password" placeholder="Password" readonly hidden required>
                </div>
                <div id="change-password-div">
                    <label for="change-password" hidden>Change password:</label>
                    <input type="checkbox" name="change-password" hidden>
                </div>
                <div>
                    <label for="new-password" hidden>New password: </label>
                    <input type="password" name="new-password" placeholder="New password" readonly hidden>
                </div>
                <div>
                    <label for="confirm-new-password" hidden>Confirm new password: </label>
                    <input type="password" name="confirm-new-password" placeholder="Confirm new password" readonly hidden>
                </div>
            </fieldset>
            <button type="button">Edit</button>
            <button type="submit" hidden>Save</button>
        </form>
    </main>
<?php } ?>