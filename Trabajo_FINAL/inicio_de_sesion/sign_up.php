<?php
    include("../database.php");
    session_start();
    function valid_input($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);

        return $input;
      }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../Imagenes-Videos/bolsas-de-compra.png">
    <link rel="stylesheet" href="log_in.css">
    <title>Registrarse | Rosario Shopping Center</title>
</head>
<body>
    <header>

    </header>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="form">
            <div class="logo-cont" title="Inicio de la pagina principal">
                <a href="../Home-UNR/index.php"><img src="../Imagenes-Videos/logo.jpg" alt="Inicio de la pagina principal" class="logo"></a>
                <h1 style="display: none">Rosario Shopping Center</h1>
            </div>
            <div class="username_form">
                <img src="../Imagenes-Videos/avatar.png" alt="Imagen de avatar de usuario" class="avatar-de-email" title="Avatar de usuario">
                <input type="text" required class="form-control" id="floatingInput"  name="username" autocomplete="off" aria-labelledby="email_label">
                <label for="floatingInput" id="email_label">Email del Usuario</label>
            </div>
            <div class="password_form">
                <img src="../Imagenes-Videos/candado.png" alt="Ver Contraseña" class="avatar-de-email" id="togglePassword" title="Ver/Ocultar Contraseña">
                <input type="password" required class="form-control" id="password" name="password" aria-labelledby="pass_label">
                <label for="password" id="pass_label">Contraseña</label>
            </div>
            <script>
                document.getElementById('togglePassword').addEventListener('click', function () {
                    const passwordField = document.getElementById('password');
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);
                    if (type === 'text') {
                        this.src = '../Imagenes-Videos/desbloquear.png'; 
                    } else {
                        this.src = '../Imagenes-Videos/candado.png'; 
                    }   
                });
            </script>
            <fieldset>
                <legend>Tipo de usuario</legend>
                <div class="user_type_box">
                    <div class="owner_box">
                        <input id="owner" type="radio" name="type" class="user_type" value="Dueño de local" aria-labelledby="dueño_option">
                        <span></span>
                        <label for="owner" id="dueño_option">Dueño de Local</label>
                    </div>
                    <div class="client_box">
                        <input id="client" type="radio" name="type" class="user_type" value="Cliente" aria-labelledby="cliente_option">
                        <span></span>
                        <label for="client" id="cliente_option">Cliente</label>
                    </div>
                </div>
            </fieldset>
            <div class="footer_form">
                <input type="submit" value="Registrarse" class="submit" name="submit" aria-label="Confirmar Datos y Registrar Usuario">
                <p class="regis">¿Desea iniciar sesión?<a href="inicio_sesion.php"> Iniciar sesion</a></p>
            <div class="cont_error">
                <?php
                    if(!empty($_POST["submit"]) && isset($_POST["type"])){
                        $_SESSION["nombreUsuario"] = $_POST["username"];
                        $name = valid_input($_POST["username"]);
                        $_SESSION["claveUsuario"] = $_POST["password"];
                        $_SESSION["tipoUsuario"] = $_POST["type"];
                        $URL = "https://rosarioshoppingcenter.shop/inicio_de_sesion/Validacion.php" . "?email={$_SESSION["nombreUsuario"]}&" . "claveUsuario={$_SESSION["claveUsuario"]}&" . "type={$_SESSION["tipoUsuario"]}";
                        $_POST = array();
                        $valid = "SELECT * FROM usuarios WHERE nombreUsuario = '{$_SESSION["nombreUsuario"]}'";
                        $valid_query = mysqli_query($conn, $valid);
                        if(!empty($_SESSION["nombreUsuario"]) && !empty($_SESSION["claveUsuario"])){
                            if(mysqli_num_rows($valid_query) > 0){
                                echo"<p class= 'error'>*El Usuario ya se encuentra registrado</p>";
                            }
                            if(!filter_var($name, FILTER_VALIDATE_EMAIL)){
                                echo"<p class= 'error'>*Dirección de Correo Electrónico inválida</p>";
                            }
                            else{
                                if($_SESSION["tipoUsuario"] == "Cliente"){
                                    $destinatario = $_SESSION["nombreUsuario"];
                                    $asunto = "Verificacion de correo electrónico";
                                    $cuerpo = "
                                    <html>
                                        <head>
                                            <title>Verificacion de correo electrónico</title>
                                            <style>
                                            .email-container {
                                                display: grid;
                                                grid-template-columns: 100%;
                                                grid-template-rows: 20% 2% 50% auto;
                                                background-color: #e5e5e5;
                                                
                                            }
                                            .email-logo{
                                                grid-rows: 1/2;
                                                width: 100px;
                                                height: 100px;
                                                margin: 30px auto;
                                            }
                                            .separacion {
                                                grid-rows: 2/3;
                                                height: 2px;
                                                background-color: black;
                                                width: 80%;
                                                margin:auto;
                                            }
                                            .email-title{
                                                grid-rows: 3/4;
                                                font-size: 18px;
                                                margin: 30px auto;
                                            }
                                            .email-enlace{
                                                grid-rows: 4/5;
                                                padding: 7px;
                                                margin: 30px auto;
                                                background-color: rgb(0,160,240);
                                                text-decoration: none;
                                                color: black !important;
                                                border-radius: 10px;
                                                font-weight:900;
                                                font-size: 14px;
                                            }
                                            </style>
                                        </head>
                                        <body>
                                            <div class='email-container'>
                                                <img class='email-logo' src='https://rosarioshoppingcenter.shop/Imagenes-Videos/bolsas-de-compra.png' alt='logo.png'>
                                                <div class='separacion'></div>
                                                <h2 class='email-title'>Validar cuenta de cliente {$_SESSION["nombreUsuario"]}</h2>
                                                <a class='email-enlace ' href='{$URL}'>Validar Cuenta</a>
                                            </div>
                                        </body>
                                    </html>
                                    ";
                                    $headers = "MIME-Version: 1.0" . "\r\n";
                                    $headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
                                    $headers .= 'From: rosarioshoppingcenter@gmail.com' ."\r\n";
                                    $headers .= "Return-path: $destinatario" . "\r\n";
                                    @mail($destinatario, $asunto, $cuerpo, $headers);
                                    echo"<p class= 'enviado'>*Verificación de correo electrónico enviada</p>";
                                }
                                else{
                                    $sql = "INSERT INTO usuarios (nombreUsuario, claveUsuario, tipoUsuario, categoriaCliente, estado, cantidadPromo) VALUES ('{$_SESSION["nombreUsuario"]}', '{$_SESSION["claveUsuario"]}', '{$_SESSION["tipoUsuario"]}', '', 'P', '0')";
                                    $query = mysqli_query($conn, $sql);
                                    echo "<p class= 'enviado'>*Verificación de correo electrónico enviada</p>";
                                }
                            }
                        }
                        else{
                            echo "<p class= 'error'>*Complete todos los campos para registrarse</p>";
                        }
                    }
                        
                ?>
            </div>
            </div>
        </form>
    </main>
</body>
</html>

