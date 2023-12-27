var __BASE_URL__ = 'http://localhost/HotelManagement/';
function addHotel() {
    // Obtener los datos del formulario
    var name = $('#name').val();
    var location = $('#location').val();
    var rating = $('#rating').val();
    $.ajax({
        type: 'POST',
        url: __BASE_URL__ + 'app/controller/hotelController.php',
        data: {
            action: 'createHotel',
            name: name,
            location: location,
            rating: rating
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log(response.message);
                window.location.reload();
            } else {
                console.error(response.message);
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}

function getHotelDetails(hotelId) { //Metodo para obtener los datos al darle click edit en el campo seleccionado
    $.ajax({
        type: 'GET',
        url: __BASE_URL__ + 'app/controller/hotelController.php',
        data: {
            action: 'getHotelDetails',
            id_hotel: hotelId
        },
        dataType: 'json',

        success: function (response) {
            debugger;
            console.log(response);
            //mostrar los datos en los campos del formulario de edit
            if (response.success) {
                $('#editHotelId').val(response.hotel.id_hotel);
                $('#editName').val(response.hotel.name);
                $('#editLocation').val(response.hotel.location);
                $('#editRating').val(response.hotel.rating);
                // Abre el modal de edición
                $('#editHotelModal').modal('show');
            } else {
                console.error(response.message);
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}

function updateHotel() { //Metodo para actualizar un hotel
    // Obtener los datos del formulario
    var hotelId = $('#editHotelId').val();
    var name = $('#editName').val();
    var location = $('#editLocation').val();
    var rating = $('#editRating').val();

    $.ajax({
        type: 'POST',
        url: __BASE_URL__ + 'app/controller/hotelController.php',
        data: {
            action: 'updateHotel',
            id_hotel: hotelId,
            name: name,
            location: location,
            rating: rating
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log(response.message);
                window.location.reload();
            } else {
                console.error(response.message);
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}

function deleteHotel(hotelId) { //Metodo para eliminar un hotel
    var confirmDelete = confirm("¿Are you sure you want to delete this hotel?");
    if (!confirmDelete) {
        return;
    }
    $.ajax({
        type: 'DELETE',
        url: __BASE_URL__ + 'app/controller/hotelController.php?action=deleteHotel&hotelId=' + hotelId,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log(response.message);
                location.reload();
            } else {
                console.error(response.message);
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}

function loadHotelList() { //Metodo para pintar la tabla
    // Realizar la llamada AJAX para obtener la lista de hoteles actualizada
    $.ajax({
        type: 'GET',
        url: __BASE_URL__ + 'app/controller/hotelController.php',
        data: {action: 'getAllHotels'},
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Construir la tabla con los datos de hoteles
                var html = '<table class="table"><thead><tr><th>Name</th><th>Location</th><th>Rating</th><th>Edit</th><th>Delete</th></tr></thead><tbody>';
                $.each(response.hotels, function (index, hotel) {
                    html += '<tr><td>' + hotel.name + '</td><td>' + hotel.location + '</td><td>' + hotel.rating + '</td><td><a href="#" class="btn btn-primary">Edit</a></td><td><a href="#" class="btn btn-danger" data-hotel-id="' + hotel.id_hotel + '">Delete</a></td></tr>';
                });
                html += '</tbody></table>';

                // Actualizar la lista de hoteles en el contenedor
                $('#hotelList').html(html);

                assignDeleteEvent();
            } else {
                console.error(response.message);
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}

function addReservation() { //Metodo para agregar una reserva
    // Obtener los datos del formulario
    var customerInf = $('#customerInf').val();
    var checkIn = $('#checkIn').val();
    var checkOut = $('#checkOut').val();
    var roomType = $('#roomType').val();
    $.ajax({
        type: 'POST',
        url: __BASE_URL__ + 'app/controller/reservationController.php',
        data: {
            action: 'createReservation',
            customerInf: customerInf,
            checkIn: checkIn,
            checkOut: checkOut,
            roomType: roomType
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log(response.message);
                window.location.reload();
            } else {
                console.error(response.message);
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}

function getReservationDetails(reservationId) { //Metodo para obtener los datos al darle click edit en el campo seleccionado
    console.log('Llama a getReservationDetails');
    $.ajax({
        type: 'GET',
        url: __BASE_URL__ + 'app/controller/reservationController.php',
        data: {
            action: 'getReservationDetails',
            id_reservation: reservationId
        },
        dataType: 'json',

        success: function (response) {
            debugger;
            console.log(response);
            //mostrar los datos en los campos del formulario de edit
            if (response.success) {
                $('#editReservationId').val(response.reservation.id_reservation);
                $('#editCustomerInf').val(response.reservation.customerInf);
                $('#editCheckIn').val(response.reservation.checkIn);
                $('#editCheckOut').val(response.reservation.checkOut);
                $('#editRoomType').val(response.reservation.roomType);
                // Abre el modal de edición
                $('#editReservationModal').modal('show');
            } else {
                console.error(response.message);
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}

function updateReservation() { //Metodo para actualizar la reserva
    // Obtener los datos del formulario
    var reservationId = $('#editReservationId').val();
    var customerInf = $('#editCustomerInf').val();
    var checkIn = $('#editCheckIn').val();
    var checkOut= $('#editCheckOut').val();
    var roomType= $('#editRoomType').val();

    $.ajax({
        type: 'POST',
        url: __BASE_URL__ + 'app/controller/reservationController.php',
        data: {
            action: 'updateReservation',
            id_reservation: reservationId,
            customerInf: customerInf,
            checkIn: checkIn,
            checkOut: checkOut,
            roomType: roomType
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log(response.message);
                window.location.reload();
            } else {
                console.error(response.message);
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}

function deleteReservation(reservationId) { //Metodo para eliminar la reserva
    var confirmDelete = confirm("¿Are you sure you want to delete this reservation?");
    if (!confirmDelete) {
        return;
    }
    $.ajax({
        type: 'DELETE',
        url: __BASE_URL__ + 'app/controller/reservationController.php?action=deleteReservation&reservationId=' + reservationId,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log(response.message);
                location.reload();
            } else {
                console.error(response.message);
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}

function addRoomType() { //Metodo para crear RoomType
    // Obtener los datos del formulario
    var name = $('#name').val();
    var capacity = $('#capacity').val();
    var amenities = $('#amenities').val();
    var prices = $('#prices').val();
    var inventory = $('#inventory').val();
    $.ajax({
        type: 'POST',
        url: __BASE_URL__ + 'app/controller/roomTypeController.php',
        data: {
            action: 'createRoomType',
            name: name,
            capacity: capacity,
            amenities: amenities,
            prices: prices,
            inventory: inventory
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log(response.message);
                window.location.reload();
            } else {
                console.error(response.message);
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}

function getRoomTypeDetails(roomTypeId) { //Metodo para obtener los datos al darle click edit en el campo seleccionado
    console.log('Llama a getRoomTypeDetails');
    $.ajax({
        type: 'GET',
        url: __BASE_URL__ + 'app/controller/roomTypeController.php',
        data: {
            action: 'getRoomTypeDetails',
            id_roomType: roomTypeId
        },
        dataType: 'json',

        success: function (response) {
            debugger;
            console.log(response);
            if (response.success) {
                //mostrar los datos en los campos del formulario de edit
                $('#editRoomTypeId').val(response.roomType.id_roomType);
                $('#editName').val(response.roomType.name);
                $('#editCapacity').val(response.roomType.capacity);
                $('#editAmenities').val(response.roomType.amenities);
                $('#editPrices').val(response.roomType.prices);
                $('#editInventory').val(response.roomType.inventory);
                // Abre el modal de edición
                $('#editRoomTypeModal').modal('show');
            } else {
                console.error(response.message);
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}

function updateRoomType() { //Metodo para hacer update al RoomType seleccionado
    // Obtener los datos del formulario
    var roomTypeId = $('#editRoomTypeId').val();
    var name = $('#editName').val();
    var capacity = $('#editCapacity').val();
    var amenities = $('#editAmenities').val();
    var prices = $('#editPrices').val();
    var inventory = $('#editInventory').val();
    console.log(roomTypeId);
    $.ajax({
        type: 'POST',
        url: __BASE_URL__ + 'app/controller/roomTypeController.php',
        data: {
            action: 'updateRoomType',
            id_roomType: roomTypeId,
            name: name,
            capacity: capacity,
            amenities: amenities,
            prices: prices,
            inventory: inventory
        },
        dataType: 'json',
        success: function (response) {
            console.log(response)
            if (response.success) {
                console.log(response.message);
                window.location.reload();
            } else {
                console.error(response.message);
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}

function loadRoomTypeList() { //Metodo para pintar la tabla
    // Realizar la llamada AJAX para obtener la lista actualizada de tipos de habitación
    $.ajax({
        type: 'GET',
        url: __BASE_URL__ + 'app/controller/roomTypeController.php',
        data: { action: 'getAllRoomTypes' },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Construir la tabla con los datos de tipos de habitación
                var html = '<table class="table"><thead><tr><th>Name</th><th>Capacity</th><th>Amenities</th><th>Prices</th><th>Inventory</th><th>Edit</th><th>Delete</th></tr></thead><tbody>';
                $.each(response.roomTypes, function(index, roomType) {
                    html += '<tr><td>' + roomType.name + '</td><td>' + roomType.capacity + '</td><td>' + roomType.amenities + '</td><td>' + roomType.prices + '</td><td>' + roomType.inventory + '</td><td><button class="btn btn-primary" onclick="editRoomType(' + roomType.id_roomType + ')">Edit</button></td><td><button class="btn btn-danger" onclick="deleteRoomType(' + roomType.id_roomType + ')">Delete</button></td></tr>';
                });
                html += '</tbody></table>';

                $('#roomTypeList').html(html); // Actualizar la lista de tipos de habitación en el contenedor
                assignDeleteEvent();
            } else {
                console.error('Error al cargar los tipos de habitación:', response.message);
            }
        },
        error: function(error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}

function deleteRoomType(roomTypeId) { //Metodo para eliminar roomType
    var confirmDelete = confirm("¿Are you sure you want to delete this Room Type?");
    if (!confirmDelete) {
        return;
    }
    $.ajax({
        type: 'DELETE',
        url: __BASE_URL__ + 'app/controller/roomTypeController.php?action=deleteRoomType&roomTypeId=' + roomTypeId,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log(response.message);
                location.reload();
            } else {
                console.error(response.message);
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}

function authenticateUser(username, password) { //Metodo de autenticacion del usuario
    $.ajax({
        type: 'POST',
        url: __BASE_URL__ + 'app/controller/loginController.php',
        data: { username: username, password: password },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#result').html('Login successful');
                localStorage.setItem('usuarioLogueado', 'true'); // Almacenar en localStorage que el usuario está logueado
                window.location.href = '/HotelManagement/app/view/hotel_list.php'; // Redirecciona al usuario
            } else {
                $('#result').html('Login failed');
                localStorage.removeItem('usuarioLogueado');
            }
        },
        error: function() {
            $('#result').html('Error during AJAX request');
            localStorage.removeItem('usuarioLogueado');
        }
    });
}
function logout() {
    localStorage.removeItem('usuarioLogueado'); // Eliminar el estado de autenticación del localStorage
    window.location.href = '/HotelManagement/app/view/login_view.php'; // Redirigir al usuario a la página de inicio de sesión
}