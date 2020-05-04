<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
</head>
<body>

    <?php
        echo $this->getContent();
    ?>

    <h2>Sign up using this form</h2>

    <?php echo $this->tag->form("signup/register"); ?>

        <p>
            <label for="nama">Nama</label>
            <?php echo $this->tag->textField("nama"); ?>
        </p>

        <p>
            <label for="no_ktp">no_ktp</label>
            <?php echo $this->tag->textField("no_ktp"); ?>
        </p>

        <p>
            <label for="password">password</label>
            <?php echo $this->tag->textField("password"); ?>
        </p>


        <p>
            <?php echo $this->tag->submitButton("Register"); ?>
        </p>

    </form>

</body>
</html>

