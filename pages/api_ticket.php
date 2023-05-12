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
        switch ($_GET['func']) {
            case 'my_tickets':
                $tickets = array();
                $ret['statusFilter'] = isset($_GET['status']) ? $_GET['status'] : '';
                $ret['tagsFilter'] = isset($_GET['tags']) ? explode(',', $_GET['tags']) : array();
                $ret['departmentsFilter'] = isset($_GET['departments']) ? explode(',', $_GET['departments']) : array();
                $ret['dateLowerBound'] = isset($_GET['dateLowerBound']) ? $_GET['dateLowerBound'] : '';
                $ret['dateUpperBound'] = isset($_GET['dateUpperBound']) ? $_GET['dateUpperBound'] : '';
                $ret['userId'] = $_SESSION['IDUSER'];
                $ids = Ticket::getTickets($db, 
                    $ret['statusFilter'], 
                    $ret['tagsFilter'], 
                    $ret['departmentsFilter'], 
                    $ret['dateLowerBound'], 
                    $ret['dateUpperBound'],
                    $ret['userId']
                );
                foreach ($ids as $id) {
                    $ticketData = Ticket::getTicketData($db, $id);
                    $tickets[] = array(
                        'id' => $ticketData['TicketID'],
                        'title' => $ticketData['Title'],
                        'description' => $ticketData['Description'],
                        'status' => $ticketData['Status'],
                        'clientId' => $ticketData['ClientID'],
                        'agentId' => $ticketData['AgentID'],
                        'departmentId' => $ticketData['DepartmentID'],
                        'date' => $ticketData['Date'],
                        'documents' => array_column(Ticket::getDocuments($db, $id), 'Path'),
                        'tags' => array_column(Ticket::getTicketTags($db, $id), 'Name'),
                        'author' => User::getUser($db, $ticketData['ClientID'])->username,
                        'assignee' => $ticketData['AgentID'] ? User::getUser($db, $ticketData['AgentID'])->username : '',
                    );
                }
                $ret['tickets'] = $tickets;
                break;
            case 'display_tickets':
                if ($_SESSION['PERMISSIONS'] != 'Admin' && $_SESSION['PERMISSIONS'] != 'Agent') $ret['error'] = 'You don\'t have permission to access this data!';
                $tickets = array();
                $ret['statusFilter'] = isset($_GET['status']) ? $_GET['status'] : '';
                $ret['tagsFilter'] = isset($_GET['tags']) ? explode(',', $_GET['tags']) : array();
                $ret['departmentsFilter'] = isset($_GET['departments']) ? explode(',', $_GET['departments']) : array();
                $ret['dateLowerBound'] = isset($_GET['dateLowerBound']) ? $_GET['dateLowerBound'] : '';
                $ret['dateUpperBound'] = isset($_GET['dateUpperBound']) ? $_GET['dateUpperBound'] : '';
                $ids = Ticket::getTickets($db, 
                    $ret['statusFilter'], 
                    $ret['tagsFilter'], 
                    $ret['departmentsFilter'], 
                    $ret['dateLowerBound'], 
                    $ret['dateUpperBound']
                );
                foreach ($ids as $id) {
                    $ticketData = Ticket::getTicketData($db, $id);
                    $tickets[] = array(
                        'id' => $ticketData['TicketID'],
                        'title' => $ticketData['Title'],
                        'description' => $ticketData['Description'],
                        'status' => $ticketData['Status'],
                        'clientId' => $ticketData['ClientID'],
                        'agentId' => $ticketData['AgentID'],
                        'departmentId' => $ticketData['DepartmentID'],
                        'date' => $ticketData['Date'],
                        'documents' => array_column(Ticket::getDocuments($db, $id), 'Path'),
                        'tags' => array_column(Ticket::getTicketTags($db, $id), 'Name'),
                        'author' => User::getUser($db, $ticketData['ClientID'])->username,
                        'assignee' => $ticketData['AgentID'] ? User::getUser($db, $ticketData['AgentID'])->username : '',
                    );
                }
                $ret['tickets'] = $tickets;
                break;
            default:
                $ret['error'] = 'Couldn\'t find function '.$_GET['functionname'].'!';
                break;
        }
    }

    echo json_encode($ret);
?>