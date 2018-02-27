<?php
$upload_errors = array(
    UPLOAD_ERR_OK       => "No errors.",
    UPLOAD_ERR_INI_SIZE => "Larger than upload_mas_filesize. ",
    UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE .",
    UPLOAD_ERR_PARTIAL => "Partial uploads. ",
    UPLOAD_ERR_NO_FILE => "NO file. ",
    UPLOAD_ERR_NO_TMP_DIR => "No temporary directory .",
    UPLOAD_ERR_CANT_WRITE => "Can't write to disk. ",
    UPLOAD_ERR_EXTENSION => "File uploads stopped by extention."
);

if(isset($_POST['submit'])){
    //process the form data
    $temp_file = $_FILES['file_upload']['tmp_name'];
    $target_file = $_FILES['file_upload']['name'];
    $upload_dir = "upload";

    //you will probably want to first use file_exists() to make sure there isn't a file by the same name
    //move_upload file will return false if $temp_file is not a valid uploads file
    //or if it can not be moved for any other reason
    if(move_uploaded_file($temp_file,$upload_dir. "/".$target_file)){
        $message = "File uploaded successfully";
    }else {
        $error = $_FILES['file_upload']['error'];
        $message = $upload_errors[$error];
    }

}


?>
<?php
//The maximu file size (in bytes) must be declared before the file input field and cant be larger than the setting
// for upload_max_filesize in php.ini
?>

<html>
    <head>
        <title>Upload</title>
    </head>
    <body>
        <?php if(!empty($message)) {echo "<p>{$message}</p>";} ?>
        <form action="file_upload.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
            <input type="file" name="file_upload" />

            <input type="submit" name="submit" value="Upload" />
        </form>
    </body>
</html>
