<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Aduan</title>
</head>
<body>
<?= $this->getContent() ?>


<?php echo $this->tag->linkTo(["aduan/create", "Buat aduan", 'class' => 'btn btn-primary']); ?>
<br>
<?php echo $this->tag->linkTo(["home", "Home", 'class' => 'btn btn-primary']); ?>

<br>


<?php foreach ($aduans as $aduan) { ?>
    <?= $aduan->a->judul ?>
    <?= $aduan->a->isi ?>
    <?= $aduan->a->created_on ?>
    <?= 'PENULIS :' ?>
    <?= $aduan->u->nama ?>
    <?php
        if($auth['role'] == 'admin' || $auth['id'] == $aduan->a->user_id){
            echo $this->tag->linkTo(["aduan/edit/".$aduan->a->id, "Edit aduan", 'class' => 'btn btn-primary']);
            echo $this->tag->linkTo(["aduan/delete/".$aduan->a->id, "Hapus aduan", 'class' => 'btn btn-primary']);
        }
    ?>
<br>
<?php } ?>
    
</body>
</html>



