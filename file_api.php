<?php
    $ftp_user_name = "u826160606.spellflisol";
    $ftp_user_pass = "Flisol!234";
    $ftp_server = "156.67.73.11";

    $file = $_FILE["fileToUpload"]["name"];
    $remote_file = "uploads/$file";

    // establecer una conexión básica
    $conn_id = ftp_connect($ftp_server);

    // iniciar sesión con nombre de usuario y contraseña
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

    // cargar un archivo
    if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
        echo "se ha cargado $file con éxito\n";
    } else {
        echo "Hubo un problema durante la transferencia de $file\n";
    }

    // cerrar la conexión ftp
    ftp_close($conn_id);
?>
