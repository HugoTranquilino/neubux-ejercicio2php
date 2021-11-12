<?php
    header("Content-disposition: attachment; filename=ganador.txt");
    header("Content-type: MIME");
    readfile("ganador.txt");
?>