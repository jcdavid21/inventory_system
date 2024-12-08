$(document).ready(function() {
    // Trigger the update when the update button is clicked
    $(".updateAccount").on("click", function() {
        var equipmentId = $(this).attr("id").replace('updateBtn', ''); // Get equipment_id from the button id
        var formData = $('#updateEquipmentForm' + equipmentId).serialize(); // Serialize the form data


        $.ajax({
            type: "POST",
            url: "../backend/admin/update_equipment.php", // PHP file to handle the update
            data: formData, // Sending the form data
            success: function(response) {
                if(response === 'success') {
                    Swal.fire({
                        title: "Equipment Updated",
                        text: "The equipment has been updated successfully.",
                    }).then((result) => {
                       if(result) {
                        window.location.reload(); // Refresh the page to show the updated data
                       }
                    });
                   
                } else {
                    // Show an error message if the update failed
                    Swal.fire({
                        title: "Error",
                        text: response,
                        icon: "warning"
                    });
                }
            },
            error: function(xhr, status, error) {
                alert("An error occurred: " + error);
            }
        });
    });
});
