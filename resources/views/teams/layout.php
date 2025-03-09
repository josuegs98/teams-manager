        <?php
            include '../header.php';
            require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\src\Controllers\TeamController.php');
            $controller = new TeamController();
            $controller->index();
        ?>

        <h3>Listado de equipos</h3>
        <?php
            if(isset($_SESSION['teamOperationResult']) && $_SESSION['teamOperationResult'] != "")
            {
                if($_SESSION['operationStatus'] == 'success')
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$_SESSION['teamOperationResult'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                else
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_SESSION['teamOperationResult'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }               
        ?>
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Tipo de Deporte</th>
                    <th scope="col">Ciudad</th>
                    <th scope="col">Fecha de fundación</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(!is_null($controller->teams))
                    {
                        foreach($controller->teams as $team)
                        {
                            $row = 
                            "<tr>
                                <td scope='row'>".$team->name."</td>
                                <td>".$controller->model::TYPES[$team->sport_type]."</td>
                                <td>".$team->city."</td>
                                <td>".date('d-m-Y', strtotime($team->foundation_date))."</td>
                                <td>
                                    <form action='../../../src/router/TeamRouter.php' method='POST' autocomplete='off' enctype='multipart/form-data'>
                                        <input type='hidden' name='teams_action' value='view'>
                                        <input type='hidden' name='id' value='".$team->id."'>
			                            <button type='submit' class='btn btn-info'>Ver Detalles</button>
                                    </form>
                                </td>
                            </tr>";
                            echo $row;
                        }
                    }
                ?>
                <tr>
                    <th scope="row" colspan="5">Crear un equipo nuevo</th>
                </tr>
            </tbody>
            <tfoot>
                <form action="../../../src/router/TeamRouter.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <tr>
                        <td scope="row"><input type="text" name="name" id="teamName" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required></td>
                        <td>
                            <select name="sport_type" id="teamSportType">
                                <option value="">-</option>
                                <?php
                                    foreach($controller->model::TYPES as $value => $name)
                                    {
                                        echo "<option value='$value'>$name</option>";
                                    }
                                ?>
                            </select>
                        </td>
                        <td><input type="text" name="city" id="teamCity" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required ></td>
                        <td><input type="date" name="foundation_date" id="teamFoundationDate" required></td> 
                        <td>
			                <button type="reset" class="btn btn-danger">Limpiar</button>
			                <button type="submit" class="btn btn-success">Guardar</button>
                        </td>
                    </tr>
		            <input type="hidden" name="teams_action" value="add">
                </form>
            </tfoot>
        </table>
    </body>
</html>