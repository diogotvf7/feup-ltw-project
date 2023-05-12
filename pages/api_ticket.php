    <?php
    header('Content-Type: application/json');

    require_once(__DIR__ . '/../utils/session.php');
    session_start();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../utils/util_funcs.php');

    $ret = array();
    if (!Session::isLoggedIn()) $ret['error'] = 'User not logged in!';

    if (!isset($_GET['func'])) $ret['error'] = 'No function provided!';

    if (!isset($ret['error'])) {
        if ($_GET['func'] == 'my_tickets' || $_GET['func'] == 'display_tickets') {
            $tickets = array();
            $ret['statusFilter'] = isset($_GET['status']) ? $_GET['status'] : '';
            $ret['tagsFilter'] = isset($_GET['tags']) ? explode(',', $_GET['tags']) : array();
            $ret['departmentsFilter'] = isset($_GET['departments']) ? explode(',', $_GET['departments']) : array();
            $ret['dateLowerBound'] = isset($_GET['dateLowerBound']) ? $_GET['dateLowerBound'] : '';
            $ret['dateUpperBound'] = isset($_GET['dateUpperBound']) ? $_GET['dateUpperBound'] : '';
            $ret['userId'] = $_SESSION['IDUSER'];
            $ret['sort'] = $_GET['sort'];
            $ids = Ticket::getTickets($db, 
                $ret['statusFilter'], 
                $ret['tagsFilter'], 
                $ret['departmentsFilter'], 
                $ret['dateLowerBound'], 
                $ret['dateUpperBound'],
                $_GET['func'] == 'my_tickets' ? $ret['userId'] : null,
                isset($_GET['sort']) ? $_GET['sort'] : null
            );
            foreach ($ids as $id) {
                $ticketData = Ticket::getTicketData($db, $id);
                $tickets[] = array(
                    'id' => $ticketData->id,
                    'title' => $ticketData->title,
                    'description' => $ticketData->description,
                    'status' => $ticketData->status,
                    'clientId' => $ticketData->clientId,
                    'agentId' => $ticketData->agentId,
                    'departmentId' => $ticketData->departmentId,
                    'date' => $ticketData->date,
                    'documents' => array_column(Ticket::getDocuments($db, $id), 'Path'),
                    'tags' => array_column(Ticket::getTicketTags($db, $id), 'Name'),
                    'author' => User::getUser($db, $ticketData->clientId)->username,
                    'assignee' => $ticketData->agentId ? User::getUser($db, $ticketData->agentId)->username : '',
                );
            }
            $ret['tickets'] = $tickets;
        } else $ret['error'] = 'Couldn\'t find function '.$_GET['functionname'].'!';
    }

    echo json_encode($ret);
?>