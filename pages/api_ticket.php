    <?php
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../utils/session.php');
    session_start();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/comment.class.php');
    require_once(__DIR__ . '/../database/department.class.php');
    require_once(__DIR__ . '/../utils/util_funcs.php');

    $ret = array();
    
    if (!Session::isLoggedIn()) $ret['error'] = 'User not logged in!';

    if (!isset($_GET['func'])) $ret['error'] = 'No function provided!';

    if (!isset($ret['error'])) {
        switch($_GET['func']) {
            case 'my_tickets':
            case 'display_tickets':
                $tickets = array();
                $ret['statusFilter'] = isset($_GET['status']) ? $_GET['status'] : '';
                $ret['tagsFilter'] = (isset($_GET['tags']) && $_GET['tags'] != '') ? explode(',', $_GET['tags']) : array();
                $ret['departmentsFilter'] = (isset($_GET['departments']) && $_GET['departments'] != '') ? explode(',', $_GET['departments']) : array();
                $ret['dateLowerBound'] = isset($_GET['dateLowerBound']) ? $_GET['dateLowerBound'] : '';
                $ret['dateUpperBound'] = isset($_GET['dateUpperBound']) ? $_GET['dateUpperBound'] : '';
                $ret['userId'] = $_GET['func'] == 'my_tickets' ? $_SESSION['IDUSER'] : null;
                $ret['sort'] = empty($_GET['sort']) ? null : $_GET['sort'];
                $ids = Ticket::getTickets($db, 
                    $ret['statusFilter'], 
                    $ret['tagsFilter'], 
                    $ret['departmentsFilter'], 
                    $ret['dateLowerBound'], 
                    $ret['dateUpperBound'],
                    $ret['userId'],
                    $ret['sort']
                );
                foreach ($ids as $id) {
                    $ticketData = Ticket::getTicketData($db, $id);
                    // error_log('the id is: ' . $id . '   ', 3, "./my-errors.log");
                    $tickets[] = array(
                        'id' => $ticketData->id,
                        'title' => $ticketData->title,
                        'description' => $ticketData->description,
                        'status' => $ticketData->status,
                        'clientId' => $ticketData->clientId,
                        'agentId' => $ticketData->agentId,
                        'departmentId' => $ticketData->departmentId,
                        'departmentName' => $ticketData->departmentId ? Department::getDepartment($db, $ticketData->departmentId)->name : '',
                        'date' => $ticketData->date,
                        'documents' => array_column(Ticket::getDocuments($db, $id), 'Path'),
                        'tags' => array_column(Ticket::getTicketTags($db, $id), 'Name'),
                        // 'error1' => $ticketData->clientId != null,
                        // 'error' => $ticketData->agentId != null,
                        'author' => $ticketData->clientId != null ?  User::getUser($db, $ticketData->clientId)->username : '',
                        'assignee' => $ticketData->agentId != null ? User::getUser($db, $ticketData->agentId)->username : '',
                    );
                }
                $ret['tickets'] = $tickets;
                break;    
            case 'get_ticket':
                if (!isset($_GET['id'])) {
                    $ret['error'] = 'No id provided!';
                    break;
                }
                $ticketData = Ticket::getTicketData($db, $_GET['id']);
                $ret['id'] = $ticketData->id;
                $ret['title'] = $ticketData->title;
                $ret['description'] = $ticketData->description;
                $ret['status'] = $ticketData->status;
                $ret['clientId'] = $ticketData->clientId;
                $ret['agentId'] = $ticketData->agentId;
                $ret['agentName'] = $ticketData->agentId ? User::getUser($db, $ticketData->agentId)->username : '';
                $ret['departmentId'] = $ticketData->departmentId;
                $ret['departmentName'] = $ticketData->departmentId ? Department::getDepartment($db, $ticketData->departmentId)->name : '';
                $ret['date'] = $ticketData->date;
                $ret['documents'] = array_column(Ticket::getDocuments($db, $_GET['id']), 'Path');
                $ret['tags'] = array_column(Ticket::getTicketTags($db, $_GET['id']), 'Name');
                $ret['author'] = User::getUser($db, $ticketData->clientId)->username;
                $ret['assignee'] = $ticketData->agentId ? User::getUser($db, $ticketData->agentId)->username : '';
                $ret['comments'] = Ticket::getComments($db, $_GET['id']);
                for ($i = 0; $i < count($ret['comments']); $i++)
                    $ret['comments'][$i]['documents'] = array_column(Comment::getDocuments($db, $ret['comments'][$i]['CommentID']), 'Path');
                $ret['updates'] = Ticket::getUpdates($db, $_GET['id']);
                break;
            default:
                $ret['error'] = 'Couldn\'t find function '.$_GET['functionname'].'!';
                break;
        }
    }

    echo json_encode($ret);
?>