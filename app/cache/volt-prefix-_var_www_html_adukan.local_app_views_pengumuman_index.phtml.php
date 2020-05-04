<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman</title>
</head>
<body>
<?= $this->getContent() ?>

<?php echo $this->tag->linkTo(["home", "Home", 'class' => 'btn btn-primary']); ?>
<br>
<?php echo $this->tag->linkTo(["pengumuman/create", "Buat pengumuman", 'class' => 'btn btn-primary']); ?>
<br>


<?php foreach ($pengumumans as $pengumuman) { ?>
<?= $pengumuman->judul ?>
<?= $pengumuman->isi ?>
<?= $pengumuman->created_on ?>
<?php
    if($auth['role'] == 'admin'){
        echo $this->tag->linkTo(["pengumuman/edit/".$pengumuman->id, "Edit pengumuman", 'class' => 'btn btn-primary']);
        echo $this->tag->linkTo(["pengumuman/delete/".$pengumuman->id, "Hapus pengumuman", 'class' => 'btn btn-primary']);
    }
?>
<br>
<?php } ?>
    
</body>
</html>



