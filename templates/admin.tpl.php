<?php function drawAdminPage() { ?>
    <main id="admin-page">
        <div id="left">
            <div id="dropdown">
                <button class="dropdown-button" id="create-button"> <i class="fa-sharp fa-solid fa-plus"></i>Create</button>
                <div id="drop-content" hidden>
                    <button class="dropdown-button" id="create-department" type="button">Create Department</button>
                    <button class="dropdown-button" id="create-status" type="button">Create Status</button>
                    <button class="dropdown-button" id="create-faq" type="button">Create FAQ</button>
                </div>
            </div>
            <div class="table">
                <table class="department-table">
                    <thead>
                        <tr>
                            <th>Name of Department</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="right">
            <h1> Website KPIs </h1>
            <div id="statistics-box">
                <h2>Tickets</h2>
                <div id="statistics">
                    <p id="tickets-open-today">Open today:</p>
                    <p id="tickets-closed-today">Closed today:</p>
                </div>
            </div>
            <div id="popular-tags-box">
                <h2>Most used tags</h2>
                <ul id="popular-tags">
                </ul>
            </div>
        </div>
    </main>

<?php } ?>