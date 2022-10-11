<?php
    include '_dbconnect.php';
    session_start();
    $userId = $_SESSION['userId'];
    
    
    if(isset($_POST["updateProfilePic"])){
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $newfilename = "person-".$userId.".jpg";

            $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/OnlineProductDelivery/img/';
            $uploadfile = $uploaddir . $newfilename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
                echo "<script>alert('success');
                        window.location=document.referrer;
                    </script>";
            } else {
                echo "<script>alert('не удалось загрузить изображения, пожалуйста, попробуйте еще раз.');
                        window.location=document.referrer;
                    </script>";
            }
        }
        else{
            echo '<script>alert("Пожалуйста, выберите файл изображения для загрузки.");
                window.history.back(1);
            </script>';
        }
    }

    if(isset($_POST["updateProfileDetail"])){
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $password =$_POST["password"];

        $passSql = "SELECT * FROM users WHERE id='$userId'"; 
        $passResult = mysqli_query($conn, $passSql);
        $passRow=mysqli_fetch_assoc($passResult);
        if (password_verify($password, $passRow['password'])){ 
            $sql = "UPDATE `users` SET `firstName` = '$firstName', `lastName` = '$lastName', `email` = '$email', `phone` = '$phone' WHERE `id` ='$userId'";   
            $result = mysqli_query($conn, $sql);
            if($result){
                echo '<script>alert("Обновление успешно!.");
                        window.history.back(1);
                    </script>';
            }else{
                echo '<script>alert("Обновление не удалось, пожалуйста, попробуйте еще раз.");
                        window.history.back(1);
                    </script>';
            } 
        }
        else {
            echo '<script>alert("Неверный пароль.");
                        window.history.back(1);
                    </script>';
        }
    }
    
    if(isset($_POST["removeProfilePic"])){
        $filename = $_SERVER['DOCUMENT_ROOT']."/OnlineProductDelivery/img/person-".$userId.".jpg";
        if (file_exists($filename)) {
            unlink($filename);
            echo "<script>alert('Удалено');
                window.location=document.referrer;
            </script>";
        }
        else {
            echo "<script>alert('Фото недоступно.');
                window.location=document.referrer;
            </script>";
        }
    }
    
?>