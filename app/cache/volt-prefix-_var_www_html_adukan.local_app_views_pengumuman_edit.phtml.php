<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Form</title>
</head>
<body>

    <?php
        echo $this->getContent();
    ?>

    <h2>Edit Pengumuman</h2>

    <?php echo $this->tag->form("pengumuman/update"); ?>

        <p>
            <label for="judul">judul</label>
            <?php echo $this->tag->textField(["judul","value" => $pengumuman->judul]); ?>
        </p>

        <p>
            <label for="isi">isi</label>
            <?php echo $this->tag->textField(["isi", "value" => $pengumuman->isi]); ?>
        </p>

        <p>
            <?php echo $this->tag->hiddenField(["id", "value" => $pengumuman->id]); ?>
        </p>

        <p>
            <?php echo $this->tag->submitButton("Edit"); ?>
        </p>

    </form>

</body>
</html>

