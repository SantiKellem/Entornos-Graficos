<?php
    ob_start();
    session_start();

    include("../../database.php");
    include("../../admin/successMensajes.php");
    include("../../successMail.php");

    if (!isset($_SESSION["codUsuario"]) || $_SESSION["tipoUsuario"] != "Dueño de local") {
        header("Location: ../../inicio_de_sesion/inicio_sesion.php");
    }

    $parametro = NULL;
    $busqueda = NULL;
    if (isset($_GET["buscar"])) {
        $busqueda = $_GET["buscar_name"];
        $parametro = $_GET["parametro"];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../Imagenes-Videos/bolsas-de-compra.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="owner_promociones.css">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
    <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
    <title>Promociones | Rosario Shopping Center</title>
</head>
<body>
    <?php
        include("../../Barra_Navegacion/Nav-bar.php");
    ?>
    <section>
        <!-- FORMULARIO DE BUSQUEDA -->
        <?php
            if (!isset($_GET["buscar_name"])) {
                $_GET["buscar_name"] = NULL;
            }
        ?>
        <h1 class="page_title">Promociones</h1>
        <div class="back_img">
            <div class="search_box">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="get" class="form_search">
                    <label class="search_label" for="select_parametro">Búsqueda de Promoción:
                        <select name="parametro" id="select_parametro" class="form-search__select">
                            <option value="textoPromo" <?php if ($parametro == 'textoPromo') echo 'selected'; ?> aria-label="Busqueda por texto">Por Texto</option>
                            <option value="categoriaCliente" <?php if ($parametro == 'categoriaCliente') echo 'selected'; ?> aria-label="Busqueda por categoria">Por Categoría</option>
                            <option value="codPromo" <?php if ($parametro == 'codPromo') echo 'selected'; ?> aria-label="Busqueda por Promo">Por Codigo de Promo</option>
                        </select>
                    </label>
                    <a href="Promociones.php" class="refresh_button" title="Quitar Selección" aria-label="Quitar Selección"><svg class="refresh_logo" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/><path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/></svg></a>
                    <input type="text" placeholder="¿Qué buscas?" class="form-search__input" id="search" name="buscar_name" value="<?php echo $_GET["buscar_name"] ?>" aria-label="Busqueda de la promocion">
                    <input type="submit" value="Buscar" class="form-search__button" name="buscar"><br>
                    <input type="submit" value="Crear Promoción" class="form-search__create-button" name="crear">
                </form>
            </div>
        </div>
        <?php
            if (isset($_GET["crear"])) {
                header("Location: CrearPromociones.php");
            }
            successMensaje();
        ?>

        <!-- SELECT FILAS POR PAG Y TABLA -->
        <?php
            $bandera = true;
            $flag = false;
            $k = 0;
            $i = 0;
            $j = 0;
            $cant_registros = 5;
            $pag = isset($_GET["page"]) ? $_GET["page"] : 1;
            $inicio = ($pag - 1) * $cant_registros;

            $search_locales = "SELECT * FROM locales WHERE codUsuario = {$_SESSION['codUsuario']}";
            $search_locales_total = "SELECT COUNT(*) FROM locales  WHERE codUsuario = {$_SESSION['codUsuario']}";
            $result_locales = mysqli_query($conn, $search_locales);
            $result_locales_total = mysqli_query($conn, $search_locales_total);

            if(mysqli_num_rows($result_locales) > 0){
                ?>    
                <div class="mostrar_locales">
                        <div class="nav_locales">
                            <?php
                                while($row_locales = mysqli_fetch_assoc($result_locales)){
                                    $_SESSION["buscar_local"] = isset($_SESSION["buscar_local"]) ? $_SESSION["buscar_local"] : $row_locales["codLocal"];
                                    $_SESSION["buscar_nombre_local"] = isset($_SESSION["buscar_nombre_local"]) ? $_SESSION["buscar_nombre_local"]: $row_locales["nombreLocal"];
                                    if($j < 1){
                                        $sql_total = "SELECT COUNT(*) FROM promociones WHERE codLocal = {$_SESSION['buscar_local']}";
                                        $result_total = mysqli_query($conn, $sql_total);
                                        $row_total = mysqli_fetch_row($result_total);
                                        $total_results = $row_total[0];
                                        $total_pags = ceil($total_results / $cant_registros);
                                        $j++;
                                    }
                                    ?>
                                    <div class='header_locales'>
                                        <form method='get' action="Promociones.php">
                                            <?php
                                                if($_SESSION["buscar_local"] == $row_locales["codLocal"]){
                                            ?>
                                                <input name="<?php echo $row_locales["codLocal"];?>" type="submit" value="<?php echo $row_locales["nombreLocal"]; ?>" class="local <?php echo 'submitted';?>">
                                            <?php
                                                }
                                                else{
                                                    ?>
                                                    <input name="<?php echo $row_locales["codLocal"];?>" type="submit" value="<?php echo $row_locales["nombreLocal"]; ?>" class="local <?php echo !empty($_GET[$row_locales["codLocal"]]) ? 'submitted':'';?>">
                                                    <?php
                                                }
                                            ?>
                                        </form>       
                                    </div><?php
                                    if(!empty($_GET[$row_locales["codLocal"]])){
                                        $_SESSION["buscar_local"] = $row_locales["codLocal"];                                        
                                        $_SESSION["buscar_nombre_local"] = $row_locales["nombreLocal"];
                                        if($busqueda != "" && isset($parametro)){
                                            $search_promos = "SELECT * FROM promociones WHERE (codLocal, $parametro) LIKE ('{$row_locales["codLocal"]}', '$busqueda') LIMIT $inicio, $cant_registros";
                                            $result_promos = mysqli_query($conn, $search_promos);
                                        }      
                                        else{                                  
                                            $search_promos = "SELECT * FROM promociones WHERE codLocal = {$row_locales['codLocal']} LIMIT $inicio, $cant_registros";
                                            $result_promos = mysqli_query($conn, $search_promos);
                                        }
                                        $sql_total = "SELECT COUNT(*) FROM promociones WHERE codLocal = {$_SESSION['buscar_local']}";

                                        if(mysqli_num_rows($result_promos) > 0){
                                            $flag = true;                                       
                                        }
                                        else{
                                            $bandera = false;
                                        }
                                        header("LOCATION: Promociones.php");
                                    }
                                }
                            ?>
                        </div>
                        <?php  
                            if($flag){
                        ?><div class="contenedor_tabla">
                            <table class="tabla_promocion">
                                    <tr>
                                        <th>Texto Promoción</th>
                                        <th>Categoría</th>
                                        <th>Fecha de Finalización</th>
                                        <th>Dias validos</th>
                                        <th>Acciones</th>
                                    </tr>
                                </div>
                                <?php
                                    if(mysqli_num_rows($result_promos) > 0){
                                        $dias_semana = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                                        while($row_promos = mysqli_fetch_assoc($result_promos)){
                                            $class = false;
                                            $pend = false;
                                            $dias_validos = "";
                                            for ($i = 0; $i <= 6; $i++) {
                                                if ($row_promos["diasSemana"][$i] == 1) {
                                                    $dias_validos = $dias_validos . $dias_semana[$i] . "-";
                                                }
                                            }
                                            $len = strlen($dias_validos);
                                            $dias_validos[$len - 1] = ' ';
                                            if($row_promos["estadoPromo"] == "denegada"){
                                                $class = true;
                                            }
                                            elseif($row_promos["estadoPromo"] == "pendiente"){
                                                $pend = true;
                                            }
                                            ?>          
                                            <tr>
                                                <td class="<?php echo $class ? 'denegada':'';?> <?php echo $pend ? 'pendiente':'';?>"><?php echo $row_promos["textoPromo"]?></td>
                                                <td class="<?php echo $class ? 'denegada':'';?>" <?php echo $pend ? 'pendiente':'';?>><?php echo $row_promos["categoriaCliente"]?></td>
                                                <td class="<?php echo $class ? 'denegada':'';?>" <?php echo $pend ? 'pendiente':'';?>><?php echo $row_promos["fechaHastaPromo"]?></td>
                                                <td class="<?php echo $class ? 'denegada':'';?>" <?php echo $pend ? 'pendiente':'';?>><?php echo $dias_validos?></td>
                                                <?php
                                                    if($row_promos["estadoPromo"] == "aprobada"){
                                                ?>
                                                    <td>
                                                        <?php echo"
                                                            <button class='delete_button' onclick=\"document.getElementById('modal-{$row_promos["codPromo"]}').checked = true\" aria-label='Eliminar Local' title='Eliminar Local'>
                                                                <svg class='delete_symbol' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-square-fill' viewBox='0 0 16 16'>
                                                                    <path d='M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708'/>
                                                                </svg>
                                                            </button>
                                                            <input type='checkbox' id='modal-{$row_promos["codPromo"]}' name='modal-trigger'>
                                                            <div class='modal'>
                                                                <div class='modal-dialog'>
                                                                    <div class='modal-content'>
                                                                        <div class='modal-header'>
                                                                            <h5 class='modal-title'>Dar de baja: <strong style='color: #c90a0a'>{$row_promos["codPromo"]}- {$_SESSION["buscar_nombre_local"]}</strong></h5>
                                                                            <button type='button' class='btn btn-close' onclick=\"document.getElementById('modal-{$row_promos["codPromo"]}').checked = false\" aria-label='Cerrar'></button>
                                                                        </div>
                                                                        <div class='modal-body'>
                                                                            <p>¿Está seguro de que desea eliminar esta Promoción?</p>
                                                                        </div>
                                                                        <div class='modal-footer'>
                                                                            <form method='POST' action='Promociones.php'>
                                                                                <input type='hidden' name='codPromo' value='{$row_promos["codPromo"]}'>
                                                                                <button type='button' class='btn btn-secondary' onclick=\"document.getElementById('modal-{$row_promos["codPromo"]}').checked = false\">Cancelar</button>
                                                                                <button type='submit' class='btn btn-danger'>Eliminar</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        ";
                                                            if(!empty($_POST["codPromo"])){
                                                                $sql_update = "UPDATE promociones SET estadoPromo = 'denegada' WHERE codPromo = {$_POST["codPromo"]}";
                                                                mysqli_query($conn, $sql_update);
                                                                $_POST = array();
                                                                header("LOCATION: Promociones.php");
                                                            }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    }
                                                    elseif($row_promos["estadoPromo"] == "denegada"){
                                                        ?>
                                                        <td>
                                                            <?php
                                                             echo "
                                                             <button class='accept_button' onclick=\"document.getElementById('modal-{$row_promos["codPromo"]}').checked = true\" aria-label='Restablecer Local' title='Restablecer Local'>
                                                                 <svg class='accept_symbol' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-check-circle-fill' viewBox='0 0 16 16'>
                                                                     <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
                                                                 </svg>
                                                             </button>
                                                             <input type='checkbox' id='modal-{$row_promos["codPromo"]}' name='modal-trigger'>
                                                             <div class='modal'>
                                                                 <div class='modal-dialog'>
                                                                     <div class='modal-content'>
                                                                         <div class='modal-header'>
                                                                             <h5 class='modal-title'>Restablecer: <strong style='color: #14c974'>{$row_promos["codPromo"]}- {$_SESSION["buscar_nombre_local"]}</strong></h5>
                                                                             <button type='button' class='btn btn-close' onclick=\"document.getElementById('modal-{$row_promos["codPromo"]}').checked = false\" aria-label='Cerrar'></button>
                                                                         </div>
                                                                         <div class='modal-body'>
                                                                             <p>¿Está seguro de que desea restablecer el local?</p>
                                                                         </div>
                                                                         <div class='modal-footer'>
                                                                             <form method='POST' action='Promociones.php'>
                                                                                 <input type='hidden' name='codPromo_rest' value='{$row_promos["codPromo"]}'>
                                                                                 <button type='button' class='btn btn-secondary' onclick=\"document.getElementById('modal-{$row_promos["codPromo"]}').checked = false\">Cancelar</button>
                                                                                 <button type='submit' class='btn btn-success' name='codPromo_rest'>Restablecer</button>
                                                                             </form>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                            ";
                                                         if(!empty($_POST["codPromo_rest"])){
                                                            $sql_update = "UPDATE promociones SET estadoPromo = 'aprobada' WHERE codPromo = {$_POST["codPromo_rest"]}";
                                                            mysqli_query($conn, $sql_update);
                                                            $_POST = array();
                                                            header("LOCATION: Promociones.php");
                                                         }
                                                            ?>
                                                        </td>
                                                        <?php
                                                    }
                                                    ?>
                                            </tr>
                                <?php 
                                        }
                                    }
                                    else{
                                        ?>
                                        <div class="no_promo">No hay promociones en este local</div>
                                    <?php
                                    }
                                ?>
                            </table>
                           </div>
                    </div>
                    <?php
                        }
                        $j = 0;
                        if(empty($_SESSION["buscar_local"])){
                            ?>
                            <div class="no_promo cion">Seleccione el local que deseea revisar</div>
                        <?php
                        }
                        elseif(isset($_SESSION["buscar_local"]) && !$flag){
                            ?>
                    <div class="contenedor_tabla">
                        <table class="tabla_promocion">
                            <?php
                            $dias_semana = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                            if($busqueda != "" && isset($parametro)){
                                $search_promos = "SELECT * FROM promociones WHERE codLocal = '{$_SESSION['buscar_local']}' AND $parametro LIKE '$busqueda%' LIMIT $inicio, $cant_registros";
                                $result_promos = mysqli_query($conn, $search_promos);
                            }
                            else{
                                $search_promos = "SELECT * FROM promociones WHERE codLocal = {$_SESSION['buscar_local']} LIMIT $inicio, $cant_registros";
                                $result_promos = mysqli_query($conn, $search_promos);
                            }
                            if(mysqli_num_rows($result_promos) > 0){
                                while($row_promos = mysqli_fetch_assoc($result_promos)){
                                    $class = false;
                                    $pend = false;
                                    $dias_validos = "";
                                    for ($i = 0; $i <= 6; $i++) {
                                        if ($row_promos["diasSemana"][$i] == 1) {
                                            $dias_validos = $dias_validos . $dias_semana[$i] . "-";
                                        }
                                    }
                                    $len = strlen($dias_validos);
                                    $dias_validos[$len - 1] = ' ';
                                    if($row_promos["estadoPromo"] == "denegada"){
                                        $class = true;
                                    }
                                    if($row_promos["estadoPromo"] == "pendiente"){
                                        $pend = true;
                                    }
                                    if(!$flag){
                                    ?>
                                            <?php
                                                while($j < 1){
                                            ?>
                                                <tr>
                                                    <th>Texto Promoción</th>
                                                    <th>Categoría</th>
                                                    <th>Fecha de Finalización</th>
                                                    <th>Dias validos</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            <?php
                                                    $j++;
                                                }
                                            ?>
                                                <tr>
                                                    <td class="<?php echo $class ? 'denegada':'';?> <?php echo $pend ? 'pendiente':'';?>"><?php echo $row_promos["textoPromo"]?></td>
                                                    <td class="<?php echo $class ? 'denegada':'';?> <?php echo $pend ? 'pendiente':'';?>"><?php echo $row_promos["categoriaCliente"]?></td>
                                                    <td class="<?php echo $class ? 'denegada':'';?> <?php echo $pend ? 'pendiente':'';?>"><?php echo $row_promos["fechaHastaPromo"]?></td>
                                                    <td class="<?php echo $class ? 'denegada':'';?> <?php echo $pend ? 'pendiente':'';?>"><?php echo $dias_validos?></td>
                                                    <?php
                                                        if($row_promos["estadoPromo"] != "denegada"){
                                                    ?>
                                                        <td>
                                                            <?php echo"
                                                                <button class='delete_button' onclick=\"document.getElementById('modal-{$row_promos["codPromo"]}').checked = true\" aria-label='Eliminar Local' title='Eliminar Local'>
                                                                    <svg class='delete_symbol' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-square-fill' viewBox='0 0 16 16'>
                                                                        <path d='M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708'/>
                                                                    </svg>
                                                                </button>
                                                                <input type='checkbox' id='modal-{$row_promos["codPromo"]}' name='modal-trigger'>
                                                                <div class='modal'>
                                                                    <div class='modal-dialog'>
                                                                        <div class='modal-content'>
                                                                            <div class='modal-header'>
                                                                                <h5 class='modal-title'>Dar de baja: <strong style='color: #c90a0a'>{$row_promos["codPromo"]}- {$_SESSION["buscar_nombre_local"]}</strong></h5>
                                                                                <button type='button' class='btn btn-close' onclick=\"document.getElementById('modal-{$row_promos["codPromo"]}').checked = false\" aria-label='Cerrar'></button>
                                                                            </div>
                                                                            <div class='modal-body'>
                                                                                <p>¿Está seguro de que desea eliminar esta Promoción?</p>
                                                                            </div>
                                                                            <div class='modal-footer'>
                                                                                <form method='POST' action='Promociones.php'>
                                                                                    <input type='hidden' name='codPromo' value='{$row_promos["codPromo"]}'>
                                                                                    <button type='button' class='btn btn-secondary' onclick=\"document.getElementById('modal-{$row_promos["codPromo"]}').checked = false\">Cancelar</button>
                                                                                    <button type='submit' class='btn btn-danger'>Eliminar</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            ";
                                                                if(!empty($_POST["codPromo"])){
                                                                    $sql_update = "UPDATE promociones SET estadoPromo = 'denegada' WHERE codPromo = {$_POST["codPromo"]}";
                                                                    mysqli_query($conn, $sql_update);
                                                                    $_POST = array();
                                                                    header("LOCATION: Promociones.php");
                                                                }
                                                            ?>
                                                        </td>
                                                        <?php
                                                        }
                                                        elseif($row_promos["estadoPromo"] == "denegada"){
                                                            ?>
                                                            <td>
                                                                <?php
                                                                 echo "
                                                                 <button class='accept_button' onclick=\"document.getElementById('modal-{$row_promos["codPromo"]}').checked = true\" aria-label='Restablecer Local' title='Restablecer Local'>
                                                                     <svg class='accept_symbol' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-check-circle-fill' viewBox='0 0 16 16'>
                                                                         <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
                                                                     </svg>
                                                                 </button>
                                                                 <input type='checkbox' id='modal-{$row_promos["codPromo"]}' name='modal-trigger'>
                                                                 <div class='modal'>
                                                                     <div class='modal-dialog'>
                                                                         <div class='modal-content'>
                                                                             <div class='modal-header'>
                                                                                 <h5 class='modal-title'>Restablecer: <strong style='color: #14c974'>{$row_promos["codPromo"]}- {$_SESSION["buscar_nombre_local"]}</strong></h5>
                                                                                 <button type='button' class='btn btn-close' onclick=\"document.getElementById('modal-{$row_promos["codPromo"]}').checked = false\" aria-label='Cerrar'></button>
                                                                             </div>
                                                                             <div class='modal-body'>
                                                                                 <p>¿Está seguro de que desea restablecer el local?</p>
                                                                             </div>
                                                                             <div class='modal-footer'>
                                                                                 <form method='POST' action='Promociones.php'>
                                                                                     <input type='hidden' name='codPromo_rest' value='{$row_promos["codPromo"]}'>
                                                                                     <input type='hidden' name='accion' value='R'>
                                                                                     <button type='button' class='btn btn-secondary' onclick=\"document.getElementById('modal-{$row_promos["codPromo"]}').checked = false\">Cancelar</button>
                                                                                     <button type='submit' class='btn btn-success' name='codPromo_rest'>Restablecer</button>
                                                                                 </form>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                                ";
                                                             if(isset($_POST["codPromo_rest"])){
                                                                $sql_update = "UPDATE promociones SET estadoPromo = 'aprobada' WHERE codPromo = '{$row_promos["codPromo"]}'";
                                                                mysqli_query($conn, $sql_update);
                                                                $_POST = array();
                                                                header("LOCATION: Promociones.php");
                                                             }
                                                                ?>
                                                            </td>
                                                            <?php
                                                        }
                                                        ?>
                                                </tr>
                                    <?php
                                    }
                                }
                            }
                            else{
                                ?>
                                <div class="no_promo cion">El local no presenta promociones</div>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                            <?php
                        }
                        if(!$bandera){
                            ?>
                            <div class="no_promo cion">El local no presenta promociones</div>
                            <?php
                        }
                    ?>
                <!-- PAGINACION -->
            </section>
            <div class="pagination_info">
                <?php
                    $pag = !isset($_GET["page"]) ? 1 : $_GET["page"];
                ?>
                <span>Página <?php echo $pag ?> de <?php echo $total_pags ?></span>
                <?php
                echo '
                    <span>
                        <ul class="pagination">
                ';
                if (isset($_GET["page"]) && $pag > 1) {
                    ?>
                    <li class="page-item"><a href="?parametro=<?php echo $parametro ?>&buscar_name=<?php echo $busqueda ?>&buscar=Buscar&page=<?php echo $_GET["page"] - 1 ?>" class="page-link">««</a></li>
                    <?php
                }
                else {
                    ?>
                    <li class="page-item"><a class="page-link inactive">««</a></li>
                    <?php
                }
                for ($i = 1; $i <= $total_pags; $i++) {
                    ?>
                    <li class="page-item"><a href="?parametro=<?php echo $parametro ?>&buscar_name=<?php echo $busqueda ?>&buscar=Buscar&page=<?php echo $i ?>" class="page-link"><?php echo $i ?></a></li>
                    <?php
                }
                if (!isset($_GET["page"])) {
                    $_GET["page"] = 1;
                }
                if ($_GET["page"] >= $total_pags) {
                    ?>
                    <li class="page-item"><a class="page-link inactive">»»</a></li>
                    <?php
                }
                else {
                    ?>
                    <li class="page-item"><a href="?parametro=<?php echo $parametro ?>&buscar_name=<?php echo $busqueda ?>&buscar=Buscar&page=<?php echo $_GET["page"] + 1 ?>" class="page-link">»»</a></li>
                    <?php
                }
                echo '
                        </ul>
                    </span>
                ';
                ?>
            </div>
        <?php
            }
            else {
                ?>
                    <div class="no_promo">El dueño no presenta Locales</div>
                <?php
            }
        ?>
    <?php
        successMail();
        $_SESSION["mailEnviado"] = 0;
    ?>
    <?php
        successMail();
        $_SESSION["mailEnviado"] = 0;
    ?>
    <?php
        include("../../Pie_De_Pagina/footer.php");
    ?>
</body>
</html>
<?php
    ob_end_flush();
?>