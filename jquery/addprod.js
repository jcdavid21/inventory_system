$(document).ready(() => {
    $('#submit').on('click', (event) => {
        event.preventDefault(); // Prevent default form submission

        let isValid = true; // Flag to check form validity
        const expirationDate = $('#expiration_date').val();
        const quantityInStock = parseInt($('#quantity_in_stock').val());
        const today = new Date();
        const minExpirationDate = new Date(today);
        minExpirationDate.setDate(today.getDate() + 7); // Set minimum date to 7 days from today

        // Validate required inputs
        $('#addProd input[required], #addProd select[required], #addProd textarea[required]').each(function () {
            if ($(this).val().trim() === '') {
                isValid = false;
                Swal.fire({
                    title: "Missing Input",
                    text: `Please fill out the ${$(this).prev('label').text()} field.`,
                    icon: "warning"
                });
                $(this).focus(); // Focus the first invalid field
                return false; // Break out of the loop
            }
        });

        // If expiration date is provided, validate it
        if (expirationDate) {
            const selectedDate = new Date(expirationDate);
            if (selectedDate < minExpirationDate) {
                isValid = false;
                Swal.fire({
                    title: "Invalid Expiration Date",
                    text: "Expiration date must be at least 7 days from today.",
                    icon: "error"
                });
            }
        }

        // Validate quantity in stock
        if (quantityInStock <= 0 || isNaN(quantityInStock)) {
            isValid = false;
            Swal.fire({
                title: "Invalid Quantity",
                text: "Quantity in stock must be greater than 1.",
                icon: "error"
            });
        }

        // If all validations pass, log the form values and submit via AJAX
        if (isValid) {
            const formData = new FormData($('#addProd')[0]);

            // Log all form data values
            console.log("Form Data Values:");
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            // Submit via AJAX
            $.ajax({
                url: "../backend/admin/add_product.php", // Backend script for form submission
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response === "success") {
                        Swal.fire({
                            title: "Product Added",
                            text: "The product has been added successfully.",
                            icon: "success"
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response,
                            icon: "error"
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        title: "Error",
                        text: "An error occurred. Please try again later.",
                        icon: "error"
                    });
                }
            });
        }
    });
});
