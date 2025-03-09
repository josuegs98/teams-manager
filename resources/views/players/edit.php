        <?php
            include '../header.php';
            require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\src\Controllers\PlayerController.php');
            require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\src\Models\Team.php');
            $teamObj = new Team();
            $controller = new PlayerController();
            $controller->index();
        ?>
        <h3>Editar Jugador</h3>
        <?php
            if(isset($_SESSION['teamOperationResult']) && $_SESSION['teamOperationResult'] != "")
            {
                if($_SESSION['operationStatus'] == 'success')
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$_SESSION['teamOperationResult'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                else
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_SESSION['teamOperationResult'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }               
        ?>
        <form action="../../../src/router/TeamRouter.php" method="POST" autocomplete="off" enctype="multipart/form-data">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Dorsal</th>
                        <th scope="col">Capitán</th>
                        <th scope="col">Equipo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="row"><input type="text" name="name" id="playerName" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" value="<?php echo $controller->player->name; ?>" required></td>
                        <td><input type="number" name="number" id="playerNumber" step="1" value="<?php echo $controller->player->number; ?>" required ></td>
                        <td><input type="checkbox" name="is_captain" id="playerCaptain" <?php echo ($controller->player->is_captain ? 'checked' : '') ?>></td> 
                        <td>
                            <select name="team_id" id="playerTeam">
                                <?php
                                    foreach($teamObj->getAll() as $team)
                                    {
                                        if($team->id == $controller->player->team_id)
                                            echo "<option value='$team->id' selected>".$teamObj->getDetailedName($team->id)."</option>";
                                        else
                                            echo "<option value='$team->id'>".$teamObj->getDetailedName($team->id)."</option>";
                                    }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="teams_action" value="savePlayerChanges">
                            <input type="hidden" name="player_id" value="<?php echo $controller->player->id; ?>">
                            <button type="reset" class="btn btn-danger">Limpiar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </body>
</html>