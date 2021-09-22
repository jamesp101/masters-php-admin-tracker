<?php
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  
</head>

<body>
    <h1>Cases</h1>

    <main class="container">
        <?php include 'table.php'; ?>

    </main>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://unpkg.com/axios/dist/axios.min.js"></script>
</body>

</html>