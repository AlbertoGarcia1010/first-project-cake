<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $this->request->getAttribute('csrfToken') ?>">
    <title>Admin Dashboard</title>
    
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">

    <!-- Iconos de Google -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Materialize JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.0/css/jquery.dataTables.min.css">

    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
    
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        main {
            flex: 1 0 auto;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            width: 250px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .badge-table-primary.badge{
            background-color: blue;
            color: aliceblue;
        }
        .badge-table-success.badge{
            background-color: green;
            color: aliceblue;
        }
        .badge-table-warning.badge{
            background-color: yellow;
            color: aliceblue;
        }
        .badge-table-danger.badge{
            background-color: red;
            color: aliceblue;
        }
        @media (max-width: 992px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
<nav class="blue">
    <div class="nav-wrapper">
        <a href="#!" class="brand-logo center">Admin Dashboard</a>
        <a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="#!"><i class="material-icons">notifications</i></a></li>
            <li><a href="#!"><i class="material-icons">account_circle</i></a></li>
        </ul>
    </div>
</nav>
<ul class="sidenav sidenav-fixed sidebar blue lighten-5" id="mobile-nav">
    <li>
        <div class="user-view">
            <div class="background blue lighten-4"></div>
            <a href="#user"><img class="circle" src="https://via.placeholder.com/100"></a>
            <a href="#name"><span class="black-text name">Admin User</span></a>
            <a href="#email"><span class="black-text email">admin@example.com</span></a>
        </div>
    </li>
    <li><a href="#!"><i class="material-icons">dashboard</i>Dashboard</a></li>
    <li><a href="/roles"><i class="material-icons">supervisor_account</i>Roles</a></li>
    <li><a href="#!"><i class="material-icons">person</i>Usuarios</a></li>
    <li><a href="#!"><i class="material-icons">settings</i>Configuración</a></li>
    <li><div class="divider"></div></li>
    <li><a href="#!"><i class="material-icons">exit_to_app</i>Salir</a></li>
</ul>
    <main class="content">
        <div class="container">
            <?= $this->fetch('content') ?> <!-- Aquí se carga el contenido de cada vista -->
        </div>

    </main>
<script>
    $(document).ready(function(){
        // Inicializar el sidebar de Materialize
        $('.sidenav').sidenav();
    });
</script>

</body>
</html>





<!-- Estructura básica de la pantalla Admin -->
