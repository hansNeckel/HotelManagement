<?php

require __DIR__ . '/database.php';

class roomType
{
    private $id_roomType;
    private $name;
    private $capacity;
    private $amenities;
    private $prices;
    private $inventory;
    private $db;

    /**
     * @param $name
     * @param $capacity
     * @param $amenities
     * @param $prices
     * @param $inventory
     */
    public function __construct($name = null, $capacity = null, $amenities = null, $prices = null, $inventory = null)
    {
        $this->name = $name;
        $this->capacity = $capacity;
        $this->amenities = $amenities;
        $this->prices = $prices;
        $this->inventory = $inventory;
        $this->db = new Database();
    }

    /**
     * @return mixed
     */
    public function getIdRoomType()
    {
        return $this->id_roomType;
    }

    /**
     * @param mixed $id_roomType
     */
    public function setIdRoomType($id_roomType): void
    {
        $this->id_roomType = $id_roomType;
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
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param mixed $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @return mixed
     */
    public function getAmenities()
    {
        return $this->amenities;
    }

    /**
     * @param mixed $amenities
     */
    public function setAmenities($amenities)
    {
        $this->amenities = $amenities;
    }

    /**
     * @return mixed
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param mixed $prices
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
    }

    /**
     * @return mixed
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * @param mixed $inventory
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;
    }

    public function createRoomType($db) //insertar a la bd los datos escritos en el formulario para crear
    {
        try {
            $conn = $db->getConnection();
            $query = "INSERT INTO roomtype (name, capacity, amenities, prices, inventory) VALUES (:name, :capacity, :amenities, :prices, :inventory)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':capacity', $this->capacity);
            $stmt->bindParam(':amenities', $this->amenities);
            $stmt->bindParam(':prices', $this->prices);
            $stmt->bindParam(':inventory', $this->inventory);
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

    public function getRoomTypeDetails($db, $roomTypeId) //obtener detalles del roomType
    {
        try {
            $conn = $db->getConnection();
            $query = "SELECT * FROM roomtype WHERE id_roomType = :id_roomType";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_roomType', $roomTypeId);
            $stmt->execute();
            $roomType = $stmt->fetch(PDO::FETCH_ASSOC);

            return $roomType;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $conn = null;
        }
    }

    public function updateRoomType($db, $roomTypeId, $name, $capacity, $amenities, $prices, $inventory) //actualizar roomType
    {
        try {
            $conn = $db->getConnection();
            $query = "UPDATE roomtype SET name = :name, capacity = :capacity, amenities = :amenities, prices = :prices, inventory = :inventory WHERE id_roomType = :roomTypeId";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':capacity', $capacity);
            $stmt->bindParam(':amenities', $amenities);
            $stmt->bindParam(':prices', $prices);
            $stmt->bindParam(':inventory', $inventory);
            $stmt->bindParam(':roomTypeId', $roomTypeId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            $conn = null;
        }
    }

    public function deleteRoomType($db, $roomTypeId) //eliminar un roomType
    {
        try {
            error_log($roomTypeId);
            $conn = $db->getConnection();
            $query = "DELETE FROM roomtype WHERE id_roomType = :id_roomType";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_roomType', $roomTypeId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log($e);
            echo "Error: " . $e->getMessage();
            return false;
        } catch (\mysql_xdevapi\Exception $ex) {
            error_log($ex);
            echo "Error: " . $ex->getMessage();
            return false;
        }
    }

    public static function getAllRoomTypes($db) //obtener todos los roomTypes
    {
        try {
            $conn = $db->getConnection();
            $query = "SELECT * FROM roomtype";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $roomTypes = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $roomType = new Roomtype($row['name'], $row['capacity'], $row['amenities'] , $row['prices'], $row['inventory']);
                $roomType->setIdRoomType($row['id_roomType']);
                $roomTypes[] = $roomType;
            }

            return $roomTypes;
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return null;
        } finally {
            $conn = null;
        }
    }


}

?>
