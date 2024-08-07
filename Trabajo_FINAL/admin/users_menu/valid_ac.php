<?php
    ob_start();
    session_start();
    include("../../database.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["accept_account"])) {
            $estado = "A";
            $cuerpo = "Su cuenta de Dueño de Local fue validada. Ya puede ingresar y comenzar a gestionar sus locales. ¡Gracias por sumarse a nosotros!";
            $_SESSION["ownerAceptado"] = 1;
        }
        else {
            $estado = "R";
            $cuerpo = "Su solicitud de cuenta de Dueño de Local fue rechazada. Comuníquese con el administrador a través del formulario de contacto si así lo requiere.";
            $_SESSION["ownerRechazado"] = 1;
        }
        
        $destinatario = $_POST["nombreUsuario"];
        $asunto = "Validación/Rechazo de Cuenta";
        $headers = 'From: rosarioshoppingcenter@gmail.com' . "\r\n" .
                    'Reply-To: no_reply@gmail.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        mail($destinatario, $asunto, $cuerpo, $headers);

        $sql = "UPDATE usuarios 
                SET estado = '$estado'
                WHERE codUsuario = '{$_POST["codUsuario"]}'";

        try {
            mysqli_query($conn, $sql);
            header("Location: admin_owner.php");
        }
        catch (mysqli_sql_exception) {
            echo "Error al intentar realizar la operación, inténtelo más tarde.";
        }
    }

    ob_end_flush();
?>