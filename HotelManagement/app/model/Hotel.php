<?php

require __DIR__ . '/database.php';

class Hotel
{
    private $id_hotel;
    private $name;
    private $location;
    private $rating;
    private $db;


    /**
     * @param $name
     * @param $location
     * @param $rating
     */
    public function __construct($name = null, $location = null, $rating = null)
    {
        $this->name = $name;
        $this->location = $location;
        $this->rating = $rating;
        $this->db = new Database();
    }

    /**
     * @return mixed
     */
    public function getIdHotel()
    {
        return $this->id_hotel;
    }

    /**
     * @param mixed $id_hotel
     */
    public function setIdHotel($id_hotel)
    {
        $this->id_hotel = $id_hotel;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function createHotel($db) //Insertar a la bd los campos escritos
    {
        try {
            $conn = $db->getConnection();
            $query = "INSERT INTO hotel (name, location, rating) VALUES (:name, :location, :rating)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':location', $this->location);
            $stmt->bindParam(':rating', $this->rating);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $conn = null;
        }
    }

    public function getHotelDetails($db, $hotelId) //obtener los detalles del hotel
    {
        try {
            $conn = $db->getConnection();
            $query = "SELECT * FROM hotel WHERE id_hotel = :id_hotel";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_hotel', $hotelId);
            $stmt->execute();
            $hotel = $stmt->fetch(PDO::FETCH_ASSOC);

            return $hotel;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $conn = null;
        }
    }

    public function updateHotel($db, $hotelId, $name, $location, $rating) //actualizar el hotel
    {
        try {
            $conn = $db->getConnection();
            $query = "UPDATE hotel SET name = :name, location = :location, rating = :rating WHERE id_hotel = :hotelId";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':hotelId', $hotelId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $conn = null;
        }
    }

    public function deleteHotel($db, $hotelId) //eliminar un hotel
    {
        try {
            $conn = $db->getConnection();
            $query = "DELETE FROM hotel WHERE id_hotel = :id_hotel";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_hotel', $hotelId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function getAllHotels($db) //obtener todos los hoteles
    {
        try {
            $conn = $db->getConnection();
            $query = "SELECT * FROM hotel";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $hotels = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $hotel = new Hotel($row['name'], $row['location'], $row['rating']);
                $hotel->setIdHotel($row['id_hotel']);
                $hotels[] = $hotel;
            }

            return $hotels;
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return null;
        } finally {
            $conn = null;
        }
    }
}

?>