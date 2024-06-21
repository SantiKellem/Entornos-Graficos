<?php
    ob_start();
    session_start();
    if (!isset($_SESSION["codUsuario"]) || $_SESSION["codUsuario"] != 1) {
        session_destroy();
        header("Location: ../../inicio_de_sesion/inicio_sesion.php");
    }
    include("../../database.php");
    include("verif_nov.php");
    include("../successMensajes.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../Imagenes-Videos/bolsas-de-compra.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="admin_nov_style.css">
    <link rel="stylesheet" href="../../Barra_Navegacion/Bar-style.css">
    <link rel="stylesheet" href="../../Pie_De_Pagina/footer.css">
    <title>Rosario Shopping Center - Novedades</title>
</head>
<body>
    
    <?php
        include("../../Barra_Navegacion/Nav-bar.php");
    ?>

    <section>
        <?php
            if (!isset($_GET["buscar_name"])) {
                $_GET["buscar_name"] = NULL;
            }
        ?>
        <h1 class="page_title">Novedades</h1>
        <div class="search_box">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="get" class="form_search">
                <label class="search_label" for="select_parametro">Búsqueda de novedad:
                    <select name="parametro" id="select_parametro" class="form-search__select">
                        <option value="tituloNovedad">Por título</option>
                        <option value="codNovedad">Por código</option>
                        <option value="tipoUsuario">Por categoría</option>
                        <option value="estadoNovedad">Por estado</option>
                    </select>
                </label>
                <input type="text" placeholder="¿Qué buscas?" class="form-search__input" id="search" name="buscar_name" value="<?php echo $_GET["buscar_name"] ?>">
                <input type="submit" value="Buscar" class="form-search__button" name="buscar">
                <input type="submit" value="Crear Novedad" class="form-search__create-button" name="crear">
            </form>
        </div>

        <?php
            $parametro = NULL;
            $busqueda = NULL;
            if (isset($_GET["buscar"])) {
                $busqueda = $_GET["buscar_name"];
                $parametro = $_GET["parametro"];
            }
            
            if (isset($_GET["crear"])) {
                header("Location: crear_nov.php");
            }

            successMensaje();
            $_SESSION["novCreada"] = 0;
            $_SESSION["novModificada"] = 0;
            $_SESSION["novRestablecida"] = 0;
            $_SESSION["novEliminada"] = 0;
            
            $cant_registros = 10;
            $pag = isset($_GET["page"]) ? $_GET["page"] : 1;
            $inicio = ($pag - 1) * $cant_registros;

            if (empty($busqueda)) {
                $sql = "SELECT * FROM novedades LIMIT $inicio, $cant_registros";
                $sql_total = "SELECT COUNT(*) FROM novedades";
            }
            else {
                $sql = "SELECT * FROM novedades WHERE $parametro = '$busqueda' LIMIT $inicio, $cant_registros";
                $sql_total = "SELECT COUNT(*) FROM novedades WHERE $parametro = '$busqueda'";
            }
            
            $result_total = mysqli_query($conn, $sql_total);
            $row_total = mysqli_fetch_row($result_total);
            $total_results = $row_total[0];
            $total_pags = ceil($total_results / $cant_registros);
                
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "
                        <div class='table_box'>
                        <table class='table_list'>
                            <caption>Lista de Novedades</caption>
                            <tr>
                                <th>Código</th>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Inicio</th>
                                <th>Finalización</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>    
                    ";
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row["estadoNovedad"] == "B") $class_b = "estado_baja";
                    elseif ($row["estadoNovedad"] == "NV") $class_b = "estado_no_vigente";
                    else $class_b = "";
                    echo "
                                <tr>
                                    <td class='$class_b cod_cell'>{$row["codNovedad"]}</td>
                                    <td class='$class_b'>{$row["tituloNovedad"]}</td>
                                    <td class='$class_b'>{$row["textoNovedad"]}</td>
                                    <td class='$class_b'>{$row["fechaDesdeNov"]}</td>
                                    <td class='$class_b'>{$row["fechaHastaNov"]}</td>
                                    <td class='$class_b'>{$row["tipoUsuario"]}</td>
                                    <td class='$class_b'>{$row["estadoNovedad"]}</td>
                                    <td class='button_cell'>
                                        <form action='modificar_nov.php' method='POST'>
                                            <button type='submit' class='modify_button' aria-label='Modificar Novedad' title='Modificar Novedad'>
                                                <input type='hidden' name='codNovedad' value='{$row["codNovedad"]}'>
                                                <svg class='modify_symbol' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                                                    <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                                                    <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z'/>
                                                </svg>
                                            </button>
                                        </form>
                                        <button class='delete_button' onclick=\"document.getElementById('modal-{$row["codNovedad"]}').checked = true\" aria-label='Eliminar Novedad' title='Eliminar Novedad'>
                                            <svg class='delete_symbol' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-square-fill' viewBox='0 0 16 16'>
                                                <path d='M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708'/>
                                            </svg>
                                        </button>
                                        <input type='checkbox' id='modal-{$row["codNovedad"]}' name='modal-trigger'>
                                        <div class='modal'>
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title'>Dar de baja: <strong style='color: #c90a0a'>{$row["codNovedad"]}- {$row["tituloNovedad"]}</strong></h5>
                                                        <button type='button' class='btn btn-close' onclick=\"document.getElementById('modal-{$row["codNovedad"]}').checked = false\" aria-label='Cerrar'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <p>¿Está seguro de que desea eliminar la novedad?</p>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <form method='POST' action='eliminar_nov.php'>
                                                            <input type='hidden' name='codNovedad' value='{$row["codNovedad"]}'>
                                                            <button type='button' class='btn btn-secondary' onclick=\"document.getElementById('modal-{$row["codNovedad"]}').checked = false\">Cancelar</button>
                                                            <button type='submit' class='btn btn-danger'>Eliminar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                    ";
                }
                echo "
                            </table>
                        </div>
                ";
                ?>

                <!-- PAGINACION -->
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

                    if (isset($_GET["page"]) && $_GET["page"] > 1) {
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
                echo "
                    <div class='warning-box'>
                            <p class='warning-box__msj'>No hay novedades cargadas</p>
                    </div>";
            }
        ?>

    </section>

    <?php
        include("../../Pie_De_Pagina/footer.php");
    ?>

</body>
</html>
<?php
    ob_end_flush();
?>