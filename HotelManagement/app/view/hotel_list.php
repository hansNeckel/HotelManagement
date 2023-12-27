<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel List</title>
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
                    <h2 class="display-6 text-center">Hotel List</h2>
                </div>
                <div class="row">
                    <div class="col m-3">
                        <div class="text-center">
                            <button type="button" class="btn btn-primary btn-create" data-bs-toggle="modal"
                                    data-bs-target="#createHotelModal">
                                Create Hotel
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="createHotelModal" tabindex="-1" aria-labelledby="createHotelModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createHotelModalLabel">Create New Hotel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="createHotelForm" method="post">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Location:</label>
                                        <input type="text" class="form-control" id="location" name="location" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Rating:</label>
                                        <input type="number" class="form-control" id="rating" name="rating" required>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="createHotelButton"
                                            data-bs-target="#createHotelModal">
                                        Create Hotel
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editHotelModal" tabindex="-1" aria-labelledby="editHotelModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editHotelModalLabel">Edit Hotel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editHotelForm" method="post">
                                    <input type="hidden" id="editHotelId" name="editHotelId" value="">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name:</label>
                                        <input type="text" class="form-control" id="editName" name="name" value="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Location:</label>
                                        <input type="text" class="form-control" id="editLocation" name="location" value="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Rating:</label>
                                        <input type="number" class="form-control" id="editRating" name="rating" value="" required>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="editHotelButton"
                                            data-bs-target="#editHotelModal">
                                        Edit Hotel
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    require __DIR__ . '/../controller/hotelController.php';

                    $hotelController = new HotelController();

                    $hotels = $hotelController->getAllHotels();

                    if ($hotels) {
                        ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Rating</th>
                                    <th class="edit-column" style="display: none;">Edit</th>
                                    <th class="delete-column" style="display: none;">Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($hotels as $hotel) { ?>
                                    <tr>
                                        <td><?php echo $hotel->getName(); ?></td>
                                        <td><?php echo $hotel->getLocation(); ?></td>
                                        <td><?php echo $hotel->getRating(); ?></td>
                                        <td>
                                            <button type="button" id="editHotelButtonTable" style="display: none;" class="btn btn-primary btn-edit" data-bs-toggle="modal"
                                                    data-bs-target="#editHotelModal" data-hotel-id="<?php echo $hotel->getIdHotel(); ?>">Edit
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" id="deleteHotelButton" style="display: none" class="btn btn-danger delete-hotel"
                                                    data-hotel-id="<?php echo $hotel->getIdHotel(); ?>">Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    } else {
                        echo '<p>No hotels available.</p>';
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
            $('.delete-hotel').show();
            $('.edit-column').show();
            $('.delete-column').show();
        } else {
            $('.btn-edit').hide();
            $('.btn-create').hide();
            $('.delete-hotel').hide();
            $('.edit-column').hide();
            $('.delete-column').hide();
        }
        $('.delete-hotel').click(function () {
            var hotelId = $(this).data('hotel-id');
            deleteHotel(hotelId);
        });
        $('#createHotelButton').click(function () {
            addHotel();
        });
    });
</script>
<script>
    $(document).on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var hotelId = $(this).data('hotel-id');
        console.log('Hotel ID:', hotelId);
        getHotelDetails(hotelId);
    });
    $(document).on('click', '#editHotelButton', function (e) {
        updateHotel();
        loadHotelList();
        $('#editHotelModal').modal('hide');
    });
</script>
<script>
    $('#createHotelForm').submit(function (event) {
        event.preventDefault();
        addHotel();
        loadHotelList();
    });
</script>
</body>
</html>