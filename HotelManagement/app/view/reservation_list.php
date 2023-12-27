<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation List</title>
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
                    <h2 class="display-6 text-center">Reservation List</h2>
                </div>
                <div class="row">
                    <div class="col m-3">
                        <div class="text-center">
                            <button type="button" class="btn btn-primary btn-create" id="createModal" data-bs-toggle="modal"
                                    data-bs-target="#createReservationModal">
                                Create Reservation
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="createReservationModal" tabindex="-1" aria-labelledby="createReservationModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createReservationModalLabel">Create New Reservation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="createReservationForm" method="post">
                                    <div class="mb-3">
                                        <label for="customerInf" class="form-label">Customer Information:</label>
                                        <input type="text" class="form-control" id="customerInf" name="customerInf" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="checkIn" class="form-label">Check In:</label>
                                        <input type="text" class="form-control" id="checkIn" name="checkIn" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="checkOut" class="form-label">Check Out:</label>
                                        <input type="number" class="form-control" id="checkOut" name="checkOut" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="roomType" class="form-label">Room Type:</label>
                                        <input type="text" class="form-control" id="roomType" name="roomType">
                                    </div>
                                    <button type="button" class="btn btn-primary" id="createReservationButton"
                                            data-bs-target="#createReservationModal">
                                        Create Reservation
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editReservationModal" tabindex="-1" aria-labelledby="editReservationModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editReservationModalLabel">Edit Reservation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editReservationForm" method="post">
                                    <input type="hidden" id="editReservationId" name="editReservationId" value="">
                                    <div class="mb-3">
                                        <label for="customerInf" class="form-label">Customer Information:</label>
                                        <input type="text" class="form-control" id="editCustomerInf" name="customerInf" value="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="checkIn" class="form-label">Check In:</label>
                                        <input type="text" class="form-control" id="editCheckIn" name="checkIn" value="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="checkOut" class="form-label">Check Out:</label>
                                        <input type="text" class="form-control" id="editCheckOut" name="checkOut" value="" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="roomType" class="form-label">Room Type:</label>
                                        <input type="text" class="form-control" id="editRoomType" name="roomType" value="" required>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="editReservationButton"
                                            data-bs-target="#editReservationModal">
                                        Edit Reservation
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    require __DIR__ . '/../controller/reservationController.php';

                    $reservationController = new ReservationController();

                    $reservations = $reservationController->getAllReservations();

                    if ($reservations) {
                        ?>
                         <div class="table-responsive">
                             <table class="table">
                                 <thead>
                                 <tr>
                                     <th>Customer Info</th>
                                     <th>Check In</th>
                                     <th>Check Out</th>
                                     <th>Room Type</th>
                                     <th class="edit-column" style="display: none;">Edit</th>
                                     <th class="delete-column" style="display: none;">Delete</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 <?php foreach ($reservations as $reservation) { ?>
                                     <tr>
                                         <td><?php echo $reservation->getCustomerInf(); ?></td>
                                         <td><?php echo $reservation->getCheckIn(); ?></td>
                                         <td><?php echo $reservation->getCheckOut(); ?></td>
                                         <td><?php echo $reservation->getRoomType(); ?></td>
                                         <td>
                                             <button type="button" id="editReservationButtonTable" style="display: none;" class="btn btn-primary btn-edit" data-bs-toggle="modal"
                                                     data-bs-target="#editReservationModal" data-reservation-id="<?php echo $reservation->getIdReservation(); ?>">Edit
                                             </button>
                                         </td>
                                         <td>
                                             <button type="button" id="deleteReservationButton" style="display: none" class="btn btn-danger delete-reservation"
                                                     data-reservation-id="<?php echo $reservation->getIdReservation(); ?>">Delete
                                             </button>
                                         </td>
                                     </tr>
                                 <?php } ?>
                                 </tbody>
                             </table>
                         </div>
                        <?php
                    } else {
                        echo '<p>No Reservations available.</p>';
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
            $('.delete-reservation').show();
            $('.edit-column').show();
            $('.delete-column').show();
        } else {
            $('.btn-edit').hide();
            $('.btn-create').hide();
            $('.delete-reservation').hide();
            $('.edit-column').hide();
            $('.delete-column').hide();
        }
        $('.delete-reservation').click(function () {
            var reservationId = $(this).data('reservation-id');
            deleteReservation(reservationId);
        });
        // Manejar el click del botón
        $('#createReservationButton').click(function () {
            addReservation();
        });
    });
</script>
<script>
    $(document).on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var reservationId = $(this).data('reservation-id');
        console.log('Reservation ID:', reservationId);
        getReservationDetails(reservationId);
    });
    $(document).on('click', '#editReservationButton', function (e) {
        updateReservation();
        $('#editReservationModal').modal('hide');
    });
</script>
<script>
    $('#createReservationForm').submit(function (event) {
        console.log("click en el button");
        event.preventDefault();
        addReservation();
    });
</script>
</body>
</html>