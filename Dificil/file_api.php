<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $texto = $_POST["texto"];
    $archivo = $_FILES["archivo"];

    if ($archivo["error"] === UPLOAD_ERR_OK) {
        $nombreTemporal = $archivo["tmp_name"];
        $nombreLocal = "uploads/" . basename($archivo["name"]);

        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }

        if (move_uploaded_file($nombreTemporal, $nombreLocal)) {
            echo "Archivo subido localmente con éxito.<br>";
            echo "Texto recibido: " . htmlspecialchars($texto) . "<br>";

            // Ahora conectamos por FTP
            $ftp_user_name = "u826160606.spellflisol";
            $ftp_user_pass = "Flisol!234";
            $ftp_server = "156.67.73.11";
            $remote_file = "uploads/" . basename($archivo["name"]);

            $conn_id = ftp_connect($ftp_server);

            if ($conn_id) {
                $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

                if ($login_result) {
                    if (ftp_put($conn_id, $remote_file, $nombreLocal, FTP_BINARY)) {
                        echo "Se ha cargado el archivo al servidor FTP con éxito.";
                    } else {
                        echo "Hubo un problema durante la transferencia al servidor FTP.";
                    }
                } else {
                    echo "No se pudo iniciar sesión en el servidor FTP.";
                }

                ftp_close($conn_id);
            } else {
                echo "No se pudo conectar al servidor FTP.";
            }

        } else {
            echo "Error al mover el archivo localmente.";
        }
    } else {
        echo "Error al subir el archivo.";
    }
} else {
    echo "Método no permitido.";
}
?>

