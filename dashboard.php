<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="Dashboard.css">
    <link rel="stylesheet" href="Common/style.css">
    <?php
    function findUser($id)
    {
        global $tbl_users, $connect , $tbl_log;
        $sql = ("SELECT `id`,`name`,`family`,`phone` ,`user_name` ,`email` ,`password`,`img` ,`role` , `status`  FROM $tbl_users WHERE `id`= $id ");
        $result = $connect->query($sql);
        $result->execute();
        if ($result->rowCount()) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

    require_once "Common/Connection.php";
    if ($_SESSION['key'] == "true") {
        $user = findUser($_SESSION['id']);
        if (md5($user['user_name']) == $_GET['verify']) {
            $id = $user['id'];
            $img = $user['img'];
            $name = $user['name'];
            $family = $user['family'];
            $phone = $user['phone'];
            $user_name = $user['user_name'];
            $email = $user['email'];
            $role = $user['role'];
            $status = $user['status'];
        } else {
            header("location: ./MainPage.php");
        }
    } else {
        header("location: ./MainPage.php");
    }
    if (isset($_POST['logout'])) {
        global $tbl_users, $connect , $tbl_log;


        $login_sql = "INSERT INTO `$tbl_log` SET  `userId`=?, `status`=? ";
        $send_log = $connect->prepare($login_sql);
        $send_log->bindValue(1 , $_SESSION['id']);
        $send_log->bindValue(2 , 3);
        $send_log->execute();

        $_SESSION['key'] = null;
        $_SESSION['id'] = null;
        $_SESSION['user_name'] = null;
        $_SESSION['email'] = null;

        header("Location: ./MainPage.php");
    }


    ?>

    <!--  Edit Items  -->
    <?php
    global $tbl_users, $connect, $id;
    if (isset($_POST['sub_name'])) {
        $sql = "UPDATE $tbl_users SET `name`=? WHERE id=?";
        $result = $connect->prepare($sql);
        $name = ($_POST['edit-name']);

        $result->bindValue(1, $name);
        $result->bindValue(2, $id);
        $result->execute();
        header("Location: #");
    }

    if (isset($_POST['sub_family'])) {
        $sql = "UPDATE $tbl_users SET `family`=? WHERE id=?";
        $result = $connect->prepare($sql);
        $family = ($_POST['edit-family']);

        $result->bindValue(1, $family);
        $result->bindValue(2, $id);
        $result->execute();
        header("Location: #");
    }


    if (isset($_POST['sub_phone'])) {
        $sql = "UPDATE $tbl_users SET `phone`=? WHERE id=?";
        $result = $connect->prepare($sql);
        $phone = ($_POST['edit-phone']);

        $result->bindValue(1, $phone);
        $result->bindValue(2, $id);
        $result->execute();
        header("Location: #");
    }


    ?>
    <?php
    function deleteFile($input)
    {
        $direction = "./Profiles/" . $input;
        if (file_exists($direction)) {
            if ($direction != "./Profiles/user.png") {
                unlink($direction);
            }

        }
    }

    ?>
    <?php
    if (isset($_POST['up-pic'])) {
        $tempName = $_FILES["pic"]["tmp_name"];
        $path = $_FILES['pic']['name'];
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $finalName = time() . ".$extension";

        $folder = "Profiles/" . $finalName;
        if (move_uploaded_file($tempName, $folder)) {
            global $tbl_users, $connect, $id;

//            Delete last file
            $query_delete = "SELECT `img` FROM $tbl_users WHERE `id`=$id";
            $query_result = $connect->prepare($query_delete);
            $query_result->execute();
            if ($query_result->rowCount()) {
                $selected = $query_result->fetch(PDO::FETCH_ASSOC);
                foreach ($selected as $res) {
                    deleteFile($res);
                }
            }


//        Send Name
            $send_name_DB = $finalName;

            $sql = "UPDATE `$tbl_users` SET `img`=? WHERE `id` =?";
            $result = $connect->prepare($sql);
            $result->bindValue(1, $send_name_DB);
            $result->bindValue(2, $id);
            $result->execute();


            header("location:#");
        }
    }
    ?>

</head>
<body>
<div class="main px-5">
    <h1 class="title">Dashboard</h1>
    <div class="row mt-5">
        <div class="col-6 mt-4">
            <form action="" method="post">
                <div class="row fs-5">
                    <p class="text-muted fs-5 col-3 ">Name : </p><?php global $name;
                    if ($name == null) {
                        echo '<p class="text-danger bg-opacity-75 col mt-2 col-5" id="name_set"
                                                      style="font-size: 14px"> Not Set Yet </p>';
                    } else {
                        echo "<p class='text-muted col-5 '>$name</p>";
                    }
                    ?>
                    <input required name="edit-name" type="text" placeholder="e.x. : John " class="col-5 text-muted"
                           id="name_input"
                           style="display: none;font-size: 14px;margin-top: -10px;background-color: transparent;border: none ; outline: none;">
                    <?php
                    if ($name == null) {
                        echo '<a class="col-1" style="cursor: pointer" id="name"><i class="far fa-edit text-muted "
                                                                          style="font-size: 14px"></i></a>';
                    }
                    ?>
                    <button class="col-1" type="submit" name="sub_name"
                            style="background: none;border: none;margin-top:-10px;font-size: 16px;display: none"
                            id="sub_name"><i class="fas fa-check-square text-success"></i></button>
                </div>
            </form>


            <form action="" method="post">
                <div class="row fs-5">
                    <p class="text-muted fs-5 col-3 ">Family : </p><?php global $family;
                    if ($family == null) {
                        echo '<p class=" text-danger bg-opacity-75 col mt-2 col-5" id="family_set"
                                                      style="font-size: 14px"> Not Set Yet </p>';
                    } else {
                        echo "<p class='text-muted col-5'>$family</p>";
                    }
                    ?>
                    <input required name="edit-family" type="text" placeholder="e.x. : Davis " class="col-5 text-muted"
                           id="family_input"
                           style="display: none;font-size: 14px;margin-top: -10px;background-color: transparent;border: none ; outline: none;">
                    <?php
                    if ($family == null) {
                        echo '<a class="col-1" style="cursor: pointer" id="family"><i class="far fa-edit text-muted "
                                                                            style="font-size: 14px"></i></a>';
                    }
                    ?>
                    <button class="col-1" type="submit"
                            style="background: none;border: none;margin-top:-10px;font-size: 16px;display: none"
                            id="sub_family" name="sub_family"><i class="fas fa-check-square text-success"></i></button>
                </div>
            </form>


            <form action="" method="post">
                <div class="row fs-5">
                    <p class="text-muted fs-5 col-3 ">Phone :</p> <?php global $phone;
                    if ($phone == null) {
                        echo '<p class="  text-danger bg-opacity-75 mt-2 col-5" id="phone_set"
                                                      style="font-size: 14px"> Not Set Yet </p> ';
                    } else {
                        echo "<p class='text-muted col-5'>$phone</p>";
                    }
                    ?>
                    <input required name="edit-phone" type="tel" placeholder="e.x. : 09144832451"
                           class="col-5 text-muted" id="phone_input"
                           style="display: none;font-size: 14px;margin-top: -10px;background-color: transparent;border: none ; outline: none;">
                    <?php
                    if ($phone == null) {
                        echo '<a class="col-1" style="cursor: pointer" id="phone"><i class="far fa-edit text-muted "
                                                                           style="font-size: 14px"></i></a>';
                    }
                    ?>
                    <button class="col-1" type="submit"
                            style="background: none;border: none;margin-top:-10px;font-size: 16px;display: none"
                            id="sub_phone" name="sub_phone"><i class="fas fa-check-square text-success"></i></button>
                </div>
            </form>


            <!--            --------------------------                -->
            <div class="row fs-5">
                <p class="text-muted fs-5 col-3">Email :</p>
                <p class="col text-muted" style="font-size: 16px;margin-top: 5px"><?php global $email;
                    echo $email ?></p>
            </div>

            <div class="row fs-5">
                <p class="text-muted fs-5 col-4">Username : </p>
                <p class="col text-muted"><?php global $user_name;
                    echo $user_name ?></p>
            </div>


            <p class="text-muted border-bottom border-dark fs-4 fw-bold mt-4 pb-2">Data : </p>

            <div class="row fs-5">
                <p class="text-muted fs-5 col-3">Role : </p> <?php global $role;
                if ($role == 1) {
                    echo "<p class='badge bg-info text-dark opacity-50 col-3  mt-1' style='font-size: 15px;height: 25px' >Member</p>";
                } else if ($role == 2) {
                    echo "<p class='badge bg-primary text-dark opacity-50 col-3 mt-1' style='font-size: 15px;height: 25px' >Admin</p>";
                } else if ($role == 3) {
                    echo "<p class='badge bg-dark text-white opacity-50 col-3 mt-1' style='font-size: 15px;height: 25px' >Owner</p>";
                }
                ?>
            </div>

            <div class="row fs-5">
                <p class="text-muted fs-5 col-3">Status : </p>
                <?php global $status;
                if ($status == 1) {
                    echo "<p class='badge bg-success text-dark opacity-50 col-3 mt-1' style='font-size: 15px;height: 25px' >Active</p>";
                } else if ($status == 2) {
                    echo "<p class='badge bg-warning text-dark opacity-50 col-3 mt-1' style='font-size: 15px;height: 25px' >Disable</p>";
                } else if ($status == 3) {
                    echo "<p class='badge bg-danger text-white opacity-50 col-3 mt-1' style='font-size: 15px;height: 25px' >Banned</p>";
                } else if ($status == 4) {
                    echo "<p class='badge bg-dark text-white opacity-50 col-3 mt-1' style='font-size: 15px;height: 25px' >Suspend</p>";
                }
                ?>

            </div>
        </div>
        <div class="col-6 border-start border-dark text-center mt-4">
            <form action="" method="post" enctype="multipart/form-data">
                <?php global $img;
                echo "<img src='./Profiles/$img' alt='profile' class='logo mb-2 center'>"
                ?>
                <br>
                <a class="text-decoration-none text-muted  " style="font-size: 12px;">Change Picture</a>

                <input type="file" accept="image/*" id="pic" name="pic"
                       style="background: none;position: absolute;margin-left: -100px;opacity: 0;width: 100px;cursor: unset;">
                <button type="submit" id="up-pic" name="up-pic"
                        style="background: none;border: none;margin-right: -40px ; margin-left: 20px;"
                        class="text-muted"><i class="fas fa-check"></i></button>
            </form>
            <p class="text-muted mt-4 fs-5">Welcome To Your Profile</p>
            <form action="" method="post">
                <div class="row p-5">
                    <a href="#" class="text-muted col text-decoration-none">Setting <i
                                class="fas fa-cog text-muted mx-1 pt-1"></i></a>
                    <button type="submit" name="logout" class="logout col text-decoration-none text-danger mx-1">Logout
                        <i
                                class="fa fa-sign-out text-danger mx-1" aria-hidden="true"></i></button>
                </div>
            </form>
            <?php
            global $role;
            if ($role > 1) {
                echo "<a href='admin.php' class='btn btn-dark col-7'>Admin Panel</a>";
            }
            ?>
        </div>
    </div>

    <script src="EditItems.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/03a20c7f25.js" crossorigin="anonymous"></script>

</div>
</body>
</html>