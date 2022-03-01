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
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="Common/style.css">
    <?php require_once "Common/Connection.php"?>
    <?php require_once "Common/Sanitize.php"?>

</head>
<body>
<div class="main px-5">
    <h1 class="title">Admin Panel</h1>
    <div class="row mt-5">
        <div class="col-12 mt-4 text-muted">
            <h3 class="mb-5">General Data</h3>
            <div class="row mt-5 mb-5 ">
                <div class="d-flex d-flex col">
                    <p>Total User :</p>
                    <p class="text-success ms-3">
                        <?php
                        global $tbl_log , $tbl_users , $connect;
                        $sql = "SELECT `id` FROM $tbl_users ";
                        $result = $connect->query($sql);
                        $result->execute();
                        if ($result->rowCount()) {
                            $row = $result->fetchAll(PDO::FETCH_ASSOC);
                            echo(count($row));
                        }else echo "0";
                        ?>

                    </p>
                </div>
                <div class="d-flex col">
                    <p>Total View :</p>
                    <p class="ms-3 text-success">
                        <?php
                        global $tbl_log , $tbl_users , $connect;
                        $sql = "SELECT `id` FROM $tbl_log ";
                        $result = $connect->query($sql);
                        $result->execute();
                        if ($result->rowCount()) {
                            $row = $result->fetchAll(PDO::FETCH_ASSOC);
                            echo(count($row));
                        }else echo "0";
                        ?>
                    </p>
                </div>
                <div class="d-flex col">
                    <p>Total Admins :</p>
                    <p class="ms-3 text-success">
                        <?php
                        global $tbl_log , $tbl_users , $connect;
                        $sql = "SELECT `id` FROM $tbl_users WHERE `role` = 2";
                        $result = $connect->query($sql);
                        $result->execute();
                        if ($result->rowCount()) {
                            $row = $result->fetchAll(PDO::FETCH_ASSOC);
                            echo(count($row));
                        }else echo "0";
                        ?>
                    </p>
                </div>
            </div>
            <div class="row  mb-5 ">
                <div class="d-flex col">
                    <p>Active users : </p>
                    <p class="ms-3 text-success">
                        <?php
                        global $tbl_log , $tbl_users , $connect;
                        $sql = "SELECT `id` FROM $tbl_users WHERE `status` = 1";
                        $result = $connect->query($sql);
                        $result->execute();
                        if ($result->rowCount()) {
                            $row = $result->fetchAll(PDO::FETCH_ASSOC);
                            echo(count($row));
                        }else echo "0";
                        ?>
                    </p>
                </div>
                <div class="d-flex col">
                    <p>Disable users : </p>
                    <p class="ms-3 text-warning">
                        <?php
                        global $tbl_log , $tbl_users , $connect;
                        $sql = "SELECT `id` FROM $tbl_users WHERE `status` = 2";
                        $result = $connect->query($sql);
                        $result->execute();
                        if ($result->rowCount()) {
                            $row = $result->fetchAll(PDO::FETCH_ASSOC);
                            echo(count($row));
                        }else echo "0";
                        ?>
                    </p>
                </div>
                <div class="d-flex col">
                    <p>Banned users : </p>
                    <p class="ms-3 text-danger">
                        <?php
                        global $tbl_log , $tbl_users , $connect;
                        $sql = "SELECT `id` FROM $tbl_users WHERE `status` = 3";
                        $result = $connect->query($sql);
                        $result->execute();
                        if ($result->rowCount()) {
                            $row = $result->fetchAll(PDO::FETCH_ASSOC);
                            echo(count($row));
                        }else echo "0";
                        ?>
                    </p>
                </div>
            </div>

            <h3 class="mb-5">Current Data</h3>
            <div class="row mt-5 mb-2 ">
                <div class="d-flex col">
                    <p>Today View :</p>
                    <p class="ms-3 text-success">
                        <?php
                        $counter = 0 ;
                        global $tbl_log , $tbl_users , $connect;
                        $sql = "SELECT `time` FROM $tbl_log";
                        $result = $connect->query($sql);
                        $result->execute();
                        if ($result->rowCount()) {

                            $row = $result->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($row as $res) {
                                $time = strval(explode(" " , $res['time'])[0]);
                                $year = (explode("-" , $time))[0];
                                $month = strval((explode("-" , $time))[1]);
                                $day = strval((explode("-" , $time))[2]);
                                if(($month==date("m")) && $year == date("Y") && $day == date("d")){
                                    $counter ++ ;
                                }
                            }
                            echo $counter ;
                        }else echo "0";
                        ?>
                    </p>
                </div>
                <div class="d-flex col">
                    <p>Today Login :</p>
                    <p class="ms-3 text-success">
                        <?php
                        $counter = 0 ;
                        global $tbl_log , $tbl_users , $connect;
                        $sql = "SELECT `time` FROM $tbl_log WHERE `status`=2";
                        $result = $connect->query($sql);
                        $result->execute();
                        if ($result->rowCount()) {

                            $row = $result->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($row as $res) {
                                $time = strval(explode(" " , $res['time'])[0]);
                                $year = (explode("-" , $time))[0];
                                $month = strval((explode("-" , $time))[1]);
                                $day = strval((explode("-" , $time))[2]);
                                if(($month==date("m")) && $year == date("Y") && $day == date("d")){
                                    $counter ++ ;
                                }
                            }
                            echo $counter ;
                        }else echo "0";
                        ?>
                    </p>
                </div>
                <div class="d-flex col">
                    <p>Online Now  :</p>
                    <p class="ms-3 text-success">
                        <?php
                        $counter_login = 0 ;
                        $counter_logout = 0 ;
                        global $tbl_log , $tbl_users , $connect;
                        $sql = "SELECT `time` FROM $tbl_log WHERE `status`=2";
                        $result = $connect->query($sql);
                        $result->execute();
                        if ($result->rowCount()) {

                            $row = $result->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($row as $res) {
                                $time = strval(explode(" ", $res['time'])[0]);
                                $year = (explode("-", $time))[0];
                                $month = strval((explode("-", $time))[1]);
                                $day = strval((explode("-", $time))[2]);
                                if (($month == date("m")) && $year == date("Y") && $day == date("d")) {
                                    $counter_login++;
                                }
                            }
                        }else echo "0";
                        $sql_logout = "SELECT `time` FROM $tbl_log WHERE `status`=3";
                        $result_logout = $connect->query($sql_logout);
                        $result_logout->execute();
                        if ($result_logout->rowCount()) {

                            $row = $result_logout->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($row as $res) {
                                $time = strval(explode(" ", $res['time'])[0]);
                                $year = (explode("-", $time))[0];
                                $month = strval((explode("-", $time))[1]);
                                $day = strval((explode("-", $time))[2]);
                                if (($month == date("m")) && $year == date("Y") && $day == date("d")) {
                                    $counter_logout++;
                                }
                            }
                        }else echo "0";
                        echo ($counter_login - $counter_logout) ;
                        ?>
                    </p>
                </div>

            </div>


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
