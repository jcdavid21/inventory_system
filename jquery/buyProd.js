$(document).ready(function() {
    // When the "Proceed" button is clicked
    $(document).on('click', '.buyProd', function() {
        var equipmentId = $(this).attr('id').replace('buyProd', ''); // Get the equipment ID from the button's ID

        // Get the quantity value from the modal
        var quantity = $('#quantity' + equipmentId).val();
        var warranty = $('#warranty' + equipmentId).val();
        var buyers_name = $('#buyerName' + equipmentId).val();
        var buyers_contact = $('#buyerContact' + equipmentId).val();
        
        var currentDate = new Date();
        var warrantyDate = new Date(warranty);

        // Validate quantity (must be >= 1)
        if (quantity < 1 || isNaN(quantity)) {
            Swal.fire("Invalid Quantity", "Quantity must be at least 1.", "warning");
            return false; // Stop form submission
        }

        // Validate warranty (must be at least 30 days from today)
        if (warrantyDate <= currentDate || (warrantyDate - currentDate) < 30 * 24 * 60 * 60 * 1000) {  // 30 days in milliseconds
            Swal.fire("Invalid Warranty Date", "Warranty date must be at least 30 days from today.", "error");
            return false; // Stop form submission
        }

        if(buyers_name === '' || buyers_name === null)
        {
            Swal.fire("Empty Field!", "Buyer's Name is required!", "warning");
            return;
        }

        if(buyers_contact === '' || buyers_contact === null)
        {
            Swal.fire("Empty Field!", "Buyer's Contact is required!", "warning");
            return;
        }

        if(buyers_contact.length !== 11)
        {
            Swal.fire("Invalid Contact Number!", "Contact number must be 11 digits!", "warning");
            return;
        }

        // Proceed with the purchase
        Swal.fire({
            title: 'Proceed with Purchase?',
            text: 'Are you sure you want to proceed with the purchase?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with the purchase
                $.ajax({
                    type: 'POST',
                    url: '../backend/admin/buy_equipment.php',
                    data: {
                        equipmentId: equipmentId,
                        quantity: quantity,
                        warranty: warranty,
                        buyers_name: buyers_name,
                        buyers_contact: buyers_contact
                    },
                    success: function(response) {
                        if (response === 'success') {
                            Swal.fire("Purchase Successful", "The equipment has been purchased successfully.", "success").then((result) => {
                                if (result) {
                                    window.location.reload();
                                }
                            });
                        } else {
                            Swal.fire("Purchase failed", response, "warning");
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("An error occurred: " + error);
                    }
                });
            }
        });
    });
});
