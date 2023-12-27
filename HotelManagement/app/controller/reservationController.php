<?php
require __DIR__ . '/../model/Reservation.php';


class ReservationController
{
    private function getDBInstance()
    {
        require_once __DIR__ . '/../model/database.php';
        return new Database();
    }

    public function createReservation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'createReservation') {
            $customerInf = $_POST['customerInf'];
            $checkIn = $_POST['checkIn'];
            $checkOut = $_POST['checkOut'];
            $roomType = $_POST['roomType'];

            $Reservation = new Reservation($customerInf, $checkIn, $checkOut, $roomType);
            $result = $Reservation->createReservation($this->getDBInstance());

            if ($result) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Reservation creado exitosamente.']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Error al crear el Reservation.']);
            }
        }
    }

    public function getReservationDetails()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getReservationDetails') {
            $reservationId = $_GET['id_reservation'];
            try {
                $reservationModel = new Reservation();
                $reservation = $reservationModel->getReservationDetails($this->getDBInstance(), $reservationId);

                if ($reservation) {
                    $response = ['success' => true, 'reservation' => $reservation];
                } else {
                    $response = ['success' => false, 'message' => 'Error al obtener los detalles del reservation.'];
                }
            } catch (Exception $e) {
                $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    public function updateReservation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateReservation') {
            if (isset($_POST['id_reservation'], $_POST['customerInf'], $_POST['checkIn'], $_POST['checkOut'], $_POST['roomType'])) {
                $reservationId = $_POST['id_reservation'];
                $customerInf = $_POST['customerInf'];
                $checkIn = $_POST['checkIn'];
                $checkOut = $_POST['checkOut'];
                $roomType = $_POST['roomType'];
            } else {

            }
            try {
                $reservationModel = new Reservation();
                $result = $reservationModel->updateReservation($this->getDBInstance(), $reservationId, $customerInf, $checkIn, $checkOut,$roomType);

                if ($result) {
                    $response = ['success' => true, 'message' => 'Reservation actualizado exitosamente.'];
                } else {
                    $response = ['success' => false, 'message' => 'Error al actualizar el reservation.'];
                }
            } catch (Exception $e) {
                $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    public function deleteReservation()
    {
        $reservationId = $_GET['reservationId'];
        try {
            $reservationModel = new Reservation();
            $result = $reservationModel->deleteReservation($this->getDBInstance(), $reservationId);

            if ($result) {
                $response = ['success' => true, 'message' => 'Reservation eliminado exitosamente.'];
            } else {
                $response = ['success' => false, 'message' => 'Error al eliminar el Reservation.'];
            }
        } catch (Exception $e) {
            error_log('error', $e);
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }


    public function getAllReservations()
    {
        $reservationModel = new Reservation();
        $reservations = $reservationModel->getAllReservations($this->getDBInstance());
        return $reservations;
    }
}

$controller = new ReservationController();
$requestMethod = $_SERVER['REQUEST_METHOD'];
switch ($requestMethod) {
    case 'GET':
        $controller->getReservationDetails();
        break;
    case 'POST':
        $controller->createReservation();
        $controller->updateReservation();
        break;
    case 'DELETE':
        $controller->deleteReservation();
        break;
    default:
        break;
}
?>