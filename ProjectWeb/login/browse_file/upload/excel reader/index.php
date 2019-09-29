<?php
$conn = mysqli_connect("localhost", "root", "", "map_data");
require_once('excel_reader2.php');
require_once('SpreadsheetReader.php');
    $sql = "DROP TABLE IF EXISTS `tbl_info`";
    mysqli_query($conn, $sql);
    $sql = "CREATE TABLE `tbl_info` (
        `Time` int(10) PRIMARY KEY,
        `1` float(10),
        `2` float(10),
        `3` float(10)
        )ENGINE=INNODB CHARACTER SET ascii COLLATE ascii_general_ci";
    if (mysqli_query($conn, $sql)) {
    } else {
    echo mysqli_error($conn);
    }  

if (isset($_POST["import"])) {


    $allowedFileType = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {

        $targetPath =  $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $Reader = new SpreadsheetReader_XLSX($targetPath);

        $sheetCount = count($Reader->sheets());
        for ($i = 0; $i < $sheetCount; $i++) {

            $Reader->ChangeSheet($i);
            $c = 0;
            foreach ($Reader as $Row) {
                $time = "";
                if (isset($Row[0])) {
                    $time = mysqli_real_escape_string($conn, $Row[0]);
                }

                $center = "";
                if (isset($Row[1])) {
                    $center = mysqli_real_escape_string($conn, $Row[1]);
                }

                $house = "";
                if (isset($Row[2])) {
                    $house = mysqli_real_escape_string($conn, $Row[2]);
                }

                $fixed = "";
                if (isset($Row[3])) {
                    $fixed = mysqli_real_escape_string($conn, $Row[3]);
                }

                if (($c >= 2) and (!empty($time) || !empty($center) || !empty($house) || !empty($fixed))) {
                    $query = "INSERT INTO tbl_info(`Time`,`1`,`2`,`3`) values('" . $time . "','" . $center . "','" . $house . "','" . $fixed . "')";
                    $result = mysqli_query($conn, $query);

                    if (!empty($result)) {
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data" . mysqli_error($conn);
                    }
                }
                $c += 1;
            }
        }
    } else {
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial;
            width: 550px;
        }

        .outer-container {
            background: #F0F0F0;
            border: #e0dfdf 1px solid;
            padding: 40px 20px;
            border-radius: 2px;
        }

        .btn-submit {
            background: #333;
            border: #1d1d1d 1px solid;
            border-radius: 2px;
            color: #f0f0f0;
            cursor: pointer;
            padding: 5px 20px;
            font-size: 0.9em;
        }

        .tutorial-table {
            margin-top: 40px;
            font-size: 0.8em;
            border-collapse: collapse;
            width: 100%;
        }

        .tutorial-table th {
            background: #f0f0f0;
            border-bottom: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        .tutorial-table td {
            background: #FFF;
            border-bottom: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        #response {
            padding: 10px;
            margin-top: 10px;
            border-radius: 2px;
            display: none;
        }

        .success {
            background: #c7efd9;
            border: #bbe2cd 1px solid;
        }

        .error {
            background: #fbcfcf;
            border: #f3c6c7 1px solid;
        }

        div#response.display-block {
            display: block;
        }
    </style>
</head>

<body>
    <h2>Import Excel File into MySQL Database using PHP</h2>

    <div class="outer-container">
        <form action="" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Choose Excel
                    File</label> <input type="file" name="file" id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import" class="btn-submit">Import</button>

            </div>

        </form>

    </div>
    <div id="response" class="<?php if (!empty($type)) {
                                    echo $type . " display-block";
                                } ?>"><?php if (!empty($message)) {
                                                                                                    echo "empika";
                                                                                                    header('Location: http://localhost/Rousoi/ProjectWeb/login/browse_file/upload/index.html');
                                                                                                }  ?></div>


    <?php
    $sqlSelect = "SELECT * FROM tbl_info";
    $result = mysqli_query($conn, $sqlSelect);
    if (mysqli_num_rows($result) > 0) {
        ?>

        <table class='tutorial-table'>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>

                </tr>
            </thead>
            <?php
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                <tbody>
                    <tr>
                        <td><?php echo $row['Time']; ?></td>
                        <td><?php echo $row['1']; ?></td>
                        <td><?php echo $row['2']; ?></td>
                        <td><?php echo $row['3']; ?></td>
                    </tr>
                <?php
                    }
                    ?>
                </tbody>
        </table>
    <?php
    }
    ?>

</body>

</html>