        <?php
            include '../header.php';
            require_once (realpath($_SERVER["DOCUMENT_ROOT"]).'\teams-manager\src\Controllers\TeamController.php');
            $controller = new TeamController();
            $teamDetails = $controller->view();
        ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Tipo de Deporte</th>
                        <th scope="col">Ciudad</th>
                        <th scope="col">Fecha de fundación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $teamDetails->name;?></td>
                        <td><?php echo $controller->model::TYPES[$teamDetails->sport_type];?></td>
                        <td><?php echo $teamDetails->city;?></td>
                        <td><?php echo date('d-m-Y', strtotime($teamDetails->foundation_date));?></td>
                    </tr>
                </tbody>
            </table>
    </body>
</html>