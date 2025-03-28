        <?php
            include '../header.php';
            require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\src\Controllers\TeamController.php');
            $teamController = new TeamController();
            $teamDetails = $teamController->view();
            $captain = $teamController->model->getCaptain($teamDetails->id);
        ?>
        <h3 class="text-center m-4">Equipo</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Tipo de Deporte</th>
                    <th scope="col">Ciudad</th>
                    <th scope="col">Fecha de fundación</th>
                    <th scope="col">Capitán</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $teamDetails->name;?></td>
                    <td><?php echo $teamController->model::TYPES[$teamDetails->sport_type];?></td>
                    <td><?php echo $teamDetails->city;?></td>
                    <td><?php echo date('d-m-Y', strtotime($teamDetails->foundation_date));?></td>
                    <td><?php echo (!is_null($captain) ? $captain->name : ''); ?></td>
                </tr>
            </tbody>
        </table>
        <h3 class="text-center m-4">Jugadores</h3>
        <?php
            if(isset($_SESSION['teamOperationResult']) && $_SESSION['teamOperationResult'] != "")
            {
                if($_SESSION['operationStatus'] == 'success')
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$_SESSION['teamOperationResult'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                else
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_SESSION['teamOperationResult'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                
                $_SESSION['operationStatus'] = "";
                $_SESSION['teamOperationResult'] = "";
            }               
        ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Dorsal</th>
                    <th scope="col">Capitán</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach($teamController->teamPlayers as $player)
                    {
                        $row = 
                            "<tr>
                                <td scope='row'>".$player->name."</td>
                                <td>".$player->number."</td>
                                <td>".($player->is_captain ? 'Sí' : 'No')."</td>
                                <td>
                                    <div class='container text-center'>
                                        <div class='row'>
                                            <div class='col-sm'>
                                                <form action='../../../src/router/TeamRouter.php' method='POST' autocomplete='off' enctype='multipart/form-data'>
                                                    <input type='hidden' name='teams_action' value='updatePlayer'>
                                                    <input type='hidden' name='id' value='".$player->id."'>
                                                    <input type='hidden' name='team_id' value='".$teamDetails->id."'>
                                                    <button type='submit' class='btn btn-info'>Modificar</button>
                                                </form>
                                            </div>
                                            <div class='col-sm'>
                                                <form action='../../../src/router/TeamRouter.php' method='POST' autocomplete='off' enctype='multipart/form-data'>
                                                    <input type='hidden' name='teams_action' value='deletePlayer'>
                                                    <input type='hidden' name='id' value='".$player->id."'>
                                                    <input type='hidden' name='team_id' value='".$teamDetails->id."'>
                                                    <button type='submit' class='btn btn-danger'>Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                        echo $row;
                    }
                    ?>
                </tr>
                <tr>
                    <th scope="row" colspan="4">Crear un Jugador nuevo</th>
                </tr>
            </tbody>
            <tfoot>
                <form action="../../../src/router/TeamRouter.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <tr>
                        <td scope="row"><input type="text" class="border border-primary form-control" name="name" id="playerName" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required></td>
                        <td><input type="number" class="border border-primary form-control" name="number" id="playerNumber" step="1" required ></td>
                        <td><input type="checkbox" class="border border-primary form-check-input" name="is_captain" id="playerCaptain"></td> 
                        <td>
			                <button type="reset" class="btn btn-danger">Limpiar</button>
			                <button type="submit" class="btn btn-success">Guardar</button>
                        </td>
                    </tr>
		            <input type="hidden" name="teams_action" value="addPlayer">
		            <input type="hidden" name="team_id" value="<?php echo $teamDetails->id ?>">
                </form>
            </tfoot>
        </table>
    </body>
</html>