<?php
require __DIR__ . '/../model/RoomType.php';
class RoomTypeController
{
    private function getDBInstance()
    {
        require_once __DIR__ . '/../model/database.php';
        return new Database();
    }

    public function createRoomType()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'createRoomType') {
            $name = $_POST['name'];
            $capacity = $_POST['capacity'];
            $amenities = $_POST['amenities'];
            $prices = $_POST['prices'];
            $inventory = $_POST['inventory'];

            $roomType = new RoomType($name, $capacity, $amenities, $prices, $inventory);
            $result = $roomType->createRoomType($this->getDBInstance());

            if ($result) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Room type creado exitosamente.']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Error al crear el room type.']);
            }
        }
    }

    public function getRoomTypeDetails()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getRoomTypeDetails') {
            $roomTypeId = $_GET['id_roomType'];
            try {
                $roomTypeModel = new RoomType();
                $roomType = $roomTypeModel->getRoomTypeDetails($this->getDBInstance(), $roomTypeId);

                if ($roomType) {
                    $response = ['success' => true, 'roomType' => $roomType];
                } else {
                    $response = ['success' => false, 'message' => 'Error al obtener los detalles del roomType.'];
                }
            } catch (Exception $e) {
                $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    public function updateRoomType()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateRoomType') {
            if (isset($_POST['id_roomType'], $_POST['name'], $_POST['capacity'], $_POST['amenities'], $_POST['prices'], $_POST['inventory'])) {
                $roomTypeId = $_POST['id_roomType'];
                $name = $_POST['name'];
                $capacity = $_POST['capacity'];
                $amenities = $_POST['amenities'];
                $prices = $_POST['prices'];
                $inventory = $_POST['inventory'];
            } else {

            }
            try {
                $roomTypeModel = new RoomType();
                $result = $roomTypeModel->updateRoomType($this->getDBInstance(), $roomTypeId, $name, $capacity, $amenities, $prices, $inventory);

                if ($result) {
                    $response = ['success' => true, 'message' => 'Room Type actualizado exitosamente.'];
                } else {
                    $response = ['success' => false, 'message' => 'Error al actualizar el Room Type.'];
                }
            } catch (Exception $e) {
                $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    public function deleteRoomType()
    {
        $roomTypeId = $_GET['roomTypeId'];
        try {

            $roomTypeModel = new RoomType();
            $result = $roomTypeModel->deleteRoomType($this->getDBInstance(), $roomTypeId);

            if ($result) {
                $response = ['success' => true, 'message' => 'Room Type eliminado exitosamente.'];
            } else {
                $response = ['success' => false, 'message' => 'Error al eliminar el Room Type.'];
            }
        } catch (Exception $e) {
            error_log('error', $e);
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function getAllRoomTypes()
    {
        $roomTypeModel = new RoomType();
        $roomTypes = $roomTypeModel->getAllRoomTypes($this->getDBInstance());
        return $roomTypes;
    }
}

$controller = new RoomTypeController();
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        $controller->getRoomTypeDetails();
        break;
    case 'POST':
        $controller->createRoomType();
        $controller->updateRoomType();
        break;
    case 'DELETE':
        $controller->deleteRoomType();
        break;
    default:
        break;
}
?>
