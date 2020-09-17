<?php
include "./db.php";
$uploaded_files = $pdo->prepare("SELECT * FROM uploaded_files");
$uploaded_files->execute();
?>
<ul>
    <?php foreach ($uploaded_files->fetchAll(PDO::FETCH_ASSOC) as $file): ?>
    <li>
        <a href="<?php echo $file['url'] ?>" target="_blank">
            <?php echo $file['url'] ?>
        </a>
    </li>
    <?php endforeach;?>
</ul>

<form action="./api/upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file"><br>
    <input type="submit" value="Submit">
</form>