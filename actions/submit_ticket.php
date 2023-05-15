<?php
  include_once('../utils/session.php');
  include_once('../database/connection.db.php');
  include_once('../database/ticket.class.php');
  include_once('../database/department.class.php');
  include_once('../database/tag.class.php');

  session_start();
  $db = getDatabaseConnection();

  if ($_SERVER["REQUEST_METHOD"] != "POST")
    exit("POST request expected");

  $ticket_title = $_POST['ticket_title'];
  $ticket_description = $_POST['ticket_description'];   
    
    if (!empty($_POST['ticket_department'])){
        $ticket_department = $_POST['ticket_department'];
        $departmentID = Department::getDepartmentbyName($db, $ticket_department);
    }
    else {
        $departmentID = null;
    }

    
    $now = new DateTime('now',new DateTimeZone('Europe/Lisbon'));
    $now = $now->format('Y-m-d H:i:s');
    $status = "Open";
    $ticketID = Ticket::addTicket($db, $ticket_title, $ticket_description, $status, $_SESSION['IDUSER'], $departmentID, $now);
    settype($ticketID, "integer");

    /* handling tags */

    if (!empty($_POST['tags'])){
        $tags = $_POST['tags'];
        foreach ($tags as $tag){
            $tagID = Tag::getTagbyName($db, $tag);
            if ($tagID == null) {
                $tagID = Tag::createTag($db, $tag);
            }
            Ticket::addTicketTag($db, $ticketID, $tagID);
        }
    }
    
    if ($_FILES['files']['error'][0] != 4){
        
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    
    // $file_type = $finfo->file($_FILES['files']['tmp_name']);
        
    foreach ( $_FILES['files']['type'] as $type){
        if (!in_array($type, array('application/pdf','image/png', 'image/jpeg', 'image/gif', 'text/plain'))) exit("Invalid file type");
    }

    $error_array = $_FILES['files']['error'];
    
    $size_array = array_sum($_FILES['files']['size']);
        
    if (count($error_array) > 10){
        exit("Maximum number of uploaded files exceeded");
    }

    if ($size_array > 104857600) { // 1MB
        exit("Files uploaded exceed maximum upload size");
    }

    if (array_count_values($error_array)[0] != count($error_array)){
        switch($_FILES['files']['error']){
            case UPLOAD_ERR_PARTIAL:
                exit("File upload was not completed.");
                break;
            case UPLOAD_ERR_EXTENSION:
                exit("File upload stopped by a PHP extension");
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                exit("No temporary directory was found for file upload");
                break;
            case UPLOAD_ERR_CANT_WRITE:
                exit("Failed file upload");
                break;
            default:
                exit("Unknown error");
                break;
        }
    }

    for ($i = 0; $i < count($_FILES['files']['name']); $i++){
        if (!file_exists(__DIR__ . "/../docs/tickets-docs/" . $ticketID)) mkdir(__DIR__ . "/../docs/tickets-docs/" . $ticketID,  0777, true);
        $path = "docs/tickets-docs/" . $ticketID . "/" . $_FILES['files']['name'][$i];
        $destination = __DIR__ . "/../"  . $path;
        if (!move_uploaded_file($_FILES['files']['tmp_name'][$i], $destination)) exit("Error moving file");
        Ticket::addDocument($db, $ticketID, $path);
    }

    }
    header("Location: /../pages/my_tickets.php");
    
    

?>

