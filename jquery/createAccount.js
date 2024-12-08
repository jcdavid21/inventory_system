$(document).ready(() => {
    $("#submit").on("click", function(event){
        event.preventDefault();
        const gender = $('#gender').val();
        const fname = $('#fname').val();
        const mname = $('#mname').val();
        const lname = $('#lname').val();
        const contactNo = $('#contact').val();
        const address = $('#address').val();
        const username = $('#uname').val();
        const password = $('#password').val();
        const confirmPassword = $('#confirmPassword').val();
        const birthdate = $('#birthdate').val();

        console.log(
            gender + " " +
            fname + " " +
            mname + " " +
            lname + " " +
            contactNo + " " +
            address + " " +
            username + " " +
            password + " " +
            confirmPassword + " " +
            birthdate
            
        )

        function validatePassword(password) {
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            return passwordPattern.test(password);
        }

        function validateBirthdate(birthdate) {
            const today = new Date(); // Get today's date
            const birthdateObj = new Date(birthdate); // Convert input to Date object
        
            // Check if birthdate is greater than today
            if (birthdateObj > today) {
                return "Birthdate cannot be in the future.";
            }
        
            // Calculate age
            const age = today.getFullYear() - birthdateObj.getFullYear();
            const hasHadBirthdayThisYear =
                today.getMonth() > birthdateObj.getMonth() ||
                (today.getMonth() === birthdateObj.getMonth() && today.getDate() >= birthdateObj.getDate());
        
            const finalAge = hasHadBirthdayThisYear ? age : age - 1;
        
            // Check if age is at least 16
            if (finalAge < 16) {
                return "You must be at least 16 years old.";
            }
        
            return "Valid birthdate.";
        }
        
        

        function validateConfirmPassword(password, confirmPassword) {
            return password === confirmPassword;
        }

        function validateContactNo(contactNo) {
            const contactPattern = /^09\d{9}$/;
            return contactPattern.test(contactNo);
        }

        if (gender && fname && lname && contactNo && address && username && password) {
            if (!validatePassword(password)) {
                Swal.fire({
                    title: "Invalid Password!",
                    text: "Password must be at least 8 characters long and contain at least one uppercase and one lowercase letter.",
                    
                });
                return;
            }

            if (!validateContactNo(contactNo)) {
                Swal.fire({
                    title: "Invalid Contact Number!",
                    text: "Contact number must start with '09' followed by 9 digits.",
                    
                });
                return;
            }

            if (!validateConfirmPassword(password, confirmPassword)) {
                Swal.fire({
                    title: "Invalid Password!",
                    text: "Passwords do not match.",
                    
                });
                return;
            }

            if(validateBirthdate(birthdate) !== "Valid birthdate.") {
                Swal.fire({
                    title: "Invalid Birthdate!",
                    text: validateBirthdate(birthdate),
                    
                });
                return;
            }

            const data = {
                gender,
                fname,
                mname,
                lname,
                contactNo,
                address,
                username,
                password,
                birthdate
            };

            $.ajax({
                url: "../backend/admin/createAcc.php",
                method: "post",
                data: data,
                success: (response) => {
                    if (response !== "existed") {
                        Swal.fire({
                            title: "Registered Successfully",
                            text: "Account has been created",
                            
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Account Existed!",
                            text: "Your username is already exist.",
                            
                        });
                    }
                },
                error: () => {
                    alert("Failed to connect!");
                }
            });
        } else {
            Swal.fire({
                title: "Empty Field!",
                text: "Make sure all fields are filled.",
                
            });
        }
    });
});
