<html>
    <head>
        <title>Upload Avatar</title>
    </head>
    <body>
        <h1>Upload your avatar</h1>
        <form id="upload-form" action="<?php echo URL::site('avatar/upload') ?>" method="post" enctype="multipart/form-data">
            <p>Choose file:</p>
            <p><input type="file" name="avatar" id="avatar" /></p>
            <p><input type="submit" name="submit" id="submit" value="Upload" /></p>
        </form>
    
    
    <?php if ($uploaded_file): ?>
        <h1>Upload success</h1>
        <p>
            Here is your uploaded avatar:
            <img src="<?php echo URL::site("/uploads/$uploaded_file") ?>" alt="Uploaded avatar" />
        </p>
        <?php else: ?>
        <h1>Something went wrong with the upload</h1>
        <p><?php echo $error_message ?></p>
        <?php endif ?>
    
    
    </body>
</html>