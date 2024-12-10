$(document).ready(()=>{
    $("#submit").on("click", function(e){
        e.preventDefault()
        const username = $("#uname").val()
        const password = $("#password").val()

        if(username && password){
            $.ajax({
                url: "./backend/admin/login.php",
                method: "post",
                data:{
                    username,
                    password
                },
                success: function(response){
                    if(response === "Invalid Password"){
                        Swal.fire({
                            title: "Invalid Password",
                            
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }else if(response === "deactivated"){
                        Swal.fire({
                            title: "Account Deactivated!",
                            
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }else{
                        console.log(response)
                        Swal.fire({
                            title: "Success!",
                            text: "Successfully Log in",
                            showConfirmButton: true,
                            timer: 3000,
                          }).then((result) => {
                            if(result){
                                localStorage.setItem("adminDetails", response);
                                window.location.href = "./components/dashboard.php";
                            }
                        });
                    }
                },
                error: function(){
                    alert("Connection Error")
                }
            })
        }
    })
})