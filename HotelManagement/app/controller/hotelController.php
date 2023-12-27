<?php
require __DIR__ . '/../model/Hotel.php';

class HotelController
{

    public function index() {
        $hotels = $this->getAllHotels();
        include __DIR__ . '/../view/hotel_list.php';
    }
    private function getDBInstance()
    {
        require_once __DIR__ . '/../model/database.php';
        return new Database();
    }

    public function createHotel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'createHotel') {
            $name = $_POST['name'];
            $location = $_POST['location'];
            $rating = $_POST['rating'];

            $hotel = new Hotel($name, $location, $rating);
            $result = $hotel->createHotel($this->getDBInstance());

            if ($result) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Hotel creado exitosamente.']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Error al crear el hotel.']);
            }
        }
    }

    public function getHotelDetails()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getHotelDetails') {
            $hotelId = $_GET['id_hotel'];
            try {
                $hotelModel = new Hotel();
                $hotel = $hotelModel->getHotelDetails($this->getDBInstance(), $hotelId);

                if ($hotel) {
                    $response = ['success' => true, 'hotel' => $hotel];
                } else {
                    $response = ['success' => false, 'message' => 'Error al obtener los detalles del hotel.'];
                }
            } catch (Exception $e) {
                $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    public function updateHotel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateHotel') {
            if (isset($_POST['id_hotel'], $_POST['name'], $_POST['location'], $_POST['rating'])) {
                $hotelId = $_POST['id_hotel'];
                $name = $_POST['name'];
                $location = $_POST['location'];
                $rating = $_POST['rating'];
            } else {
            }
            try {
                $hotelModel = new Hotel();
                $result = $hotelModel->updateHotel($this->getDBInstance(), $hotelId, $name, $location, $rating);

                if ($result) {
                    $response = ['success' => true, 'message' => 'Hotel actualizado exitosamente.'];
                } else {
                    $response = ['success' => false, 'message' => 'Error al actualizar el hotel.'];
                }
            } catch (Exception $e) {
                $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    public function deleteHotel()
    {
        $hotelId = $_GET['hotelId'];
        try {
            $hotelModel = new Hotel();
            $result = $hotelModel->deleteHotel($this->getDBInstance(), $hotelId);

            if ($result) {
                $response = ['success' => true, 'message' => 'Hotel eliminado exitosamente.'];
            } else {
                $response = ['success' => false, 'message' => 'Error al eliminar el hotel.'];
            }
        } catch (Exception $e) {
            error_log('error', $e);
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getAllHotels()
    {
        $hotelModel = new Hotel();
        $hotels = $hotelModel->getAllHotels($this->getDBInstance());

        return $hotels;
    }
}

$controller = new HotelController();
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        $controller->getHotelDetails();
        break;
    case 'POST':
        $controller->createHotel();
        $controller->updateHotel();
        break;
    case 'DELETE':
        $controller->deleteHotel();
        break;
    default:
        break;
}


?>
