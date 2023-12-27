<?php
require __DIR__ . '/database.php';

class Reservation
{
    private $id_reservation;
    private $customerInf;
    private $checkIn;
    private $checkOut;
    private $roomType;
    private $db;

    /**
     * @param $customerInf
     * @param $checkIn
     * @param $checkOut
     * @param $roomType
     */
    public function __construct($customerInf = null, $checkIn = null, $checkOut = null, $roomType = null)
    {
        $this->customerInf = $customerInf;
        $this->checkIn = $checkIn;
        $this->checkOut = $checkOut;
        $this->roomType = $roomType;
        $this->db = new Database();
    }

    /**
     * @return mixed
     */
    public function getIdReservation()
    {
        return $this->id_reservation;
    }

    /**
     * @param mixed $id_reservation
     */
    public function setIdReservation($id_reservation)
    {
        $this->id_reservation = $id_reservation;
    }

    /**
     * @return mixed
     */
    public function getCustomerInf()
    {
        return $this->customerInf;
    }

    /**
     * @param mixed $customerInf
     */
    public function setCustomerInf($customerInf)
    {
        $this->customerInf = $customerInf;
    }

    /**
     * @return mixed
     */
    public function getCheckIn()
    {
        return $this->checkIn;
    }

    /**
     * @param mixed $checkIn
     */
    public function setCheckIn($checkIn)
    {
        $this->checkIn = $checkIn;
    }

    /**
     * @return mixed
     */
    public function getCheckOut()
    {
        return $this->checkOut;
    }

    /**
     * @param mixed $checkOut
     */
    public function setCheckOut($checkOut)
    {
        $this->checkOut = $checkOut;
    }

    /**
     * @return mixed
     */
    public function getRoomType()
    {
        return $this->roomType;
    }

    /**
     * @param mixed $roomType
     */
    public function setRoomType($roomType): void
    {
        $this->roomType = $roomType;
    }

    public function createReservation($db) //insertar datos escritos a la base de datos para crear uno
    {
        try {
            $conn = $db->getConnection();
            $query = "INSERT INTO reservation (customerInf, checkIn, checkOut, roomType) VALUES (:customerInf, :checkIn, :checkOut, :roomType)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':customerInf', $this->customerInf);
            $stmt->bindParam(':checkIn', $this->checkIn);
            $stmt->bindParam(':checkOut', $this->checkOut);
            $stmt->bindParam(':roomType', $this->roomType);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getReservationDetails($db, $reservationId) //obtener los detalles de las reservas
    {
        try {
            $conn = $db->getConnection();
            $query = "SELECT * FROM reservation WHERE id_reservation = :id_reservation";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_reservation', $reservationId);
            $stmt->execute();
            $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

            return $reservation;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $conn = null;
        }
    }

    public function updateReservation($db, $reservationId, $customerInf, $checkIn, $checkOut,$roomType) //actualizar la reserva
    {
        try {
            $conn = $db->getConnection();
            $query = "UPDATE reservation SET customerInf = :customerInf, checkIn = :checkIn, checkOut = :checkOut, roomType = :roomType WHERE id_reservation = :reservationId";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':customerInf', $customerInf);
            $stmt->bindParam(':checkIn', $checkIn);
            $stmt->bindParam(':checkOut', $checkOut);
            $stmt->bindParam(':roomType', $roomType);
            $stmt->bindParam(':reservationId', $reservationId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $conn = null;
        }
    }

    public function deleteReservation($db, $reservationId) //eliminar la reserva
    {
        try {
            $conn = $db->getConnection();
            $query = "DELETE FROM reservation WHERE id_reservation = :id_reservation";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_reservation', $reservationId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function getAllReservations($db) //obtener todas las reservas
    {
        try {
            $conn = $db->getConnection();
            $query = "SELECT * FROM reservation";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $reservations = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $reservation = new Reservation($row['customerInf'], $row['checkIn'], $row['checkOut'], $row['roomType']);
                $reservation->setIdReservation($row['id_reservation']);
                $reservations[] = $reservation;
            }

            return $reservations;
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return null;
        } finally {
            $conn = null;
        }
    }

}
?>