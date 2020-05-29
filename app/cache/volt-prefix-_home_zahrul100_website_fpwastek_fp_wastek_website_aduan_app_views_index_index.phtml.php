<?php
echo $this->getContent();

echo "<h1>Welcome to Adukan.local!</h1>";
echo "<h2>Adukan masalahmu di sini!</h2>";

echo $this->tag->linkTo(["signup", "Daftar di sini!", 'class' => 'btn btn-primary']);
echo $this->tag->linkTo(["login", "Login di sini!", 'class' => 'btn btn-primary']);

?>
