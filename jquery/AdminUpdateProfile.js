$(document).ready(()=>{
   $(".updateAccount").on("click", function(e){
        const account_id = $(this).attr("id");
        const container = $(this).closest(".modal-content");
        const fName = container.find(".updateFname").val();
        const mName = container.find(".updateMname").val();
        const lName = container.find(".updateLname").val();
        const contact = container.find(".updateContact").val();
        const address = container.find(".updateAddress").val();
        const password = container.find(".updatePassword").val();
        const confirmPass = container.find(".updateConfirmpassword").val();


        if(fName === '' || fName === null)
        {
            Swal.fire("Empty Field!", "First Name is required!", "warning");
            return;
        }
        if(lName === '' || lName === null)
        {
            Swal.fire("Empty Field!", "Last Name is required!", "warning");
            return;
        }
        if(contact === '' || contact === null)
        {
            Swal.fire("Empty Field!", "Contact is required!", "warning");
            return;
        }
        if(address === '' || address === null)
        {
            Swal.fire("Empty Field!", "Address is required!", "warning");
            return;
        }
        if(password !== null && password !== ''){
            if(password.length < 8)
            {
                Swal.fire("Invalid Password!", "Password must be at least 8 characters long!", "warning");
                return;
            }
            if(password !== confirmPass)
            {
                Swal.fire("Password Mismatch!", "Password does not match!", "warning");
                return;
            }
        }


        if(contact.length !== 11)
        {
            Swal.fire("Invalid Contact Number!", "Contact number must be 11 digits!", "warning");
            return;
        }


        $.ajax({
            url:"../backend/admin/updateProfile.php",
            method: "POST",
            data:{
                account_id,
                fName,
                mName,
                lName,
                contact,
                address,
                password,
            },
            success: (response) => {
                if(response === "success")
                {
                    Swal.fire("Success!", "Account has been updated!").then((result)=>{
                        if(result.isConfirmed)
                        {
                            location.reload();
                        }
                    });
                }
                else
                {
                    Swal.fire("Failed!", "Failed to update account!", "error");
                }
            },
            error: () => {
                Swal.fire("Failed!", "Failed to update account!", "error");
            }
        });
   });
})