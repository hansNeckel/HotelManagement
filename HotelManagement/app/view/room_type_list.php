<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Type List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<?php include 'menu.php'; ?>
<div class="container">
    <div class="row mt-5">
        <div class="col">
            <div class="card mt-5">
                <div class="card-header">
                    <h2 class="display-6 text-center">Room Type List</h2>
                </div>
                <div class="row">
                    <div class="col m-3">
                        <div class="text-center">
                            <button type="button" class="btn btn-primary btn-create" data-bs-toggle="modal"
                                    data-bs-target="#createRoomTypeModal">
                                Create Room Type
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="createRoomTypeModal" tabindex="-1" aria-labelledby="createRoomTypeModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createRoomTypeModalLabel">Create New Room Type</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="createRoomTypeForm" method="post">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="capacity" class="form-label">Capacity:</label>
                                        <input type="number" class="form-control" id="capacity" name="capacity" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="amenities" class="form-label">Amenities:</label>
                                        <input type="number" class="form-control" id="amenities" name="amenities" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="prices" class="form-label">Prices:</label>
                                        <input type="number" class="form-control" id="prices" name="prices" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inventory" class="form-label">Inventory:</label>
                                        <input type="number" class="form-control" id="inventory" name="inventory" required>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="createRoomTypeButton"
                                            data-bs-target="#createRoomTypeModal">
                                        Create Room Type
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editRoomTypeModal" tabindex="-1" aria-labelledby="editRoomTypeModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editRoomTypeModalLabel">Edit Room Type</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editRoomTypeForm" method="post">
                                    <input type="hidden" id="editRoomTypeId" name="editRoomTypeId" value="">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name:</label>
                                        <input type="text" class="form-control" id="editName" name="name" value="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="capacity" class="form-label">Capacity:</label>
                                        <input type="number" class="form-control" id="editCapacity" name="capacity" value="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="amenities" class="form-label">Amenities:</label>
                                        <input type="number" class="form-control" id="editAmenities" name="amenities" value="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="prices" class="form-label">Price:</label>
                                        <input type="number" class="form-control" id="editPrices" name="prices" value="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inventory" class="form-label">Inventory:</label>
                                        <input type="number" class="form-control" id="editInventory" name="inventory" value="" required>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="editRoomTypeButton"
                                            data-bs-target="#editRoomTypeModal">
                                        Edit Room Type
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    require __DIR__ . '/../controller/roomTypeController.php';

                    $roomTypeController = new RoomTypeController();

                    $roomtypees = $roomTypeController->getAllRoomTypes();

                    if ($roomtypees) {
                        ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Capacity</th>
                                    <th>Amenities</th>
                                    <th>Prices</th>
                                    <th>Inventory</th>
                                    <th class="edit-column" style="display: none;">Edit</th>
                                    <th class="delete-column" style="display: none;">Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($roomtypees as $roomType) { ?>
                                    <tr>
                                        <td><?php echo $roomType->getName(); ?></td>
                                        <td><?php echo $roomType->getCapacity(); ?></td>
                                        <td><?php echo $roomType->getAmenities(); ?></td>
                                        <td><?php echo $roomType->getPrices(); ?></td>
                                        <td><?php echo $roomType->getInventory(); ?></td>
                                        <td>
                                            <button type="button" id="editRoomTypeButtonTable" style="display: none;" class="btn btn-primary btn-edit" data-bs-toggle="modal"
                                                    data-bs-target="#editRoomTypeModal" data-roomtype-id="<?php echo $roomType->getIdRoomType(); ?>">Edit
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" id="deleteRoomTypeButton" style="display: none" class="btn btn-danger delete-roomType"
                                                    data-roomtype-id="<?php echo $roomType->getIdRoomType(); ?>">Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    } else {
                        echo '<p>No Room Types available.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<script src="assets/js/script.js"></script>
<script>
    $(document).ready(function() {
        if (localStorage.getItem('usuarioLogueado') === 'true') {
            $('.btn-edit').show();
            $('.btn-create').show();
            $('.delete-roomType').show();
            $('.edit-column').show();
            $('.delete-column').show();
        } else {
            $('.btn-edit').hide();
            $('.btn-create').hide();
            $('.delete-roomType').hide();
            $('.edit-column').hide();
            $('.delete-column').hide();
        }
        $('.delete-roomType').click(function () {
            var roomTypeId = $(this).data('roomtype-id');
            deleteRoomType(roomTypeId);
        });
        $('#createRoomTypeButton').click(function () {
            addRoomType();
        });
    });
</script>
<script>
    $(document).on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var roomTypeId = $(this).data('roomtype-id');
        console.log('Room Type ID:', roomTypeId);
        getRoomTypeDetails(roomTypeId);
    });
    $(document).on('click', '#editRoomTypeButton', function (e) {
        updateRoomType();
        loadRoomTypeList();
        $('#editRoomTypeModal').modal('hide');
    });
</script>
</body>
</html>