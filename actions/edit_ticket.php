<?php
    include_once('../utils/session.php');
    include_once('../database/connection.db.php');
    include_once('../database/ticket.class.php');
    include_once('../database/tag.class.php');
    include_once('../database/ticket_update.class.php');
    include_once('../database/user.class.php');
    include_once('../database/department.class.php');

    session_start();

    if (!Session::isLoggedIn())
        die(header('Location: /pages/login.php'));

    $db = getDatabaseConnection();
    
    var_dump($_POST);

    $ticket = Ticket::getTicketData($db, $_POST['id']);
    $tags = Ticket::getTicketTags($db, $_POST['id']);
        
    if (isset($_POST['status']) && $_POST['status'] != $ticket->status) {
        Ticket::updateTicketStatus($db, $_POST['id'], $_POST['status']);
        TicketUpdate::createTicketUpdate(
            $db, 
            $_POST['id'], 
            'Status', 
            'Ticket status updated to: ' . $_POST['status'] . '.'
        );
    }

    if (isset($_POST['tags'])) {
        $new_tags = empty($_POST['tags']) ? array() : $_POST['tags'];
        $old_tags = empty($tags) ? array() : array_column($tags, 'Name');
        $tags_to_add = array_diff($new_tags, $old_tags);
        $tags_to_remove = array_diff($old_tags, $new_tags);
        $updateString = '';
        $updateString .= !empty($tags_to_add) ? 'Tags added: ' . implode(', ', $tags_to_add) . '.' : '';
        $updateString .= !empty($tags_to_add) && !empty($tags_to_remove) ? ' | ' : '';
        $updateString .= !empty($tags_to_remove) ? 'Tags removed: ' . implode(', ', $tags_to_remove) . '.' : '';
        if (!empty($tags_to_add) || !empty($tags_to_remove))
            TicketUpdate::createTicketUpdate(
                $db, 
                $_POST['id'], 
                'Tags', 
                $updateString
            );

        foreach ($tags_to_add as $tag) {
            if (!Tag::tagExists($db, $tag))
                Tag::createTag($db, $tag);
            Tag::addTag($db, $_POST['id'], $tag);
        }

        foreach ($tags_to_remove as $tag)
            Tag::removeTag($db, $_POST['id'], $tag);
    }

    if (isset($_POST['agent']) && $_POST['agent'] != $ticket->agentId) {
        Ticket::updateTicketAgent($db, $_POST['id'], !empty($_POST['agent']) ? $_POST['agent'] : null);
        $messageString = $_POST['agent'] == '' ? 'Ticket unassigned.' : 'Ticket assigned to ' . User::getUser($db, $_POST['agent'])->name . '.';
        TicketUpdate::createTicketUpdate(
            $db, 
            $_POST['id'], 
            'Assignee', 
            $messageString
        );
    }

    if (isset($_POST['department']) && $_POST['department'] != $ticket->departmentId) {
        Ticket::updateTicketDepartment($db, $_POST['id'], !empty($_POST['department']) ? $_POST['department'] : null);
        $messageString = $_POST['department'] == '' ? 'Ticket department unassigned.' : 'Ticket moved to ' . Department::getDepartment($db, $_POST['department'])->name . ' department.';
        TicketUpdate::createTicketUpdate(
            $db, 
            $_POST['id'], 
            'Department', 
            $messageString
        );
    }

    if (isset($_POST['title']) && $ticket->title != $_POST['title']) {
        Ticket::updateTicketTitle($db, $_POST['id'], $_POST['title']);
        TicketUpdate::createTicketUpdate(
            $db, 
            $_POST['id'], 
            'Title', 
            'Title changed to ' . $_POST['title'] . '.'
        );
    }

    if (isset($_POST['description']) && $ticket->description != $_POST['description']) {
        Ticket::updateTicketDescription($db, $_POST['id'], $_POST['description']);
        TicketUpdate::createTicketUpdate(
            $db, 
            $_POST['id'], 
            'Description', 
            'Description changed.'
        );
    }

    header('Location: ../pages/ticket_page.php?id=' . $_POST['id']);
?>
