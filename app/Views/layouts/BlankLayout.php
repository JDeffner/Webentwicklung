<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Added default title in case $title is not set-->
    <title><?= (isset($title) ? $title : 'Title not set') ?></title>
    <link rel="icon" href="<?php echo base_url();?>resources/images/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.22.1/bootstrap-table.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>resources/css/main.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.22.1/bootstrap-table.min.js"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-md mb-4 ps-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo base_url();?>">
                <img src="<?php echo base_url();?>resources/images/WE_Logo.svg" alt="logo.svg" height="60">
            </a>

            <button class="navbar-toggler custom-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDropdown"
                    aria-controls="navbarDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </nav>
</header>

<?= $this->renderSection('content') ?>

<footer>
    <div class="container-xxl mb-3 mt-3 py-md-3 d-flex flex-wrap justify-content-between">
                <span class="footer-text">
                    © MinMax GmbH 2023
                </span>
        <span class="footer-text">
                    <a class="footer-link" href="#">Impressum</a>
                    <a class="footer-link ms-1" href="#">AGB</a>
                    <a class="footer-link ms-1" href="#">Datenschutz</a>
                </span>
    </div>
</footer>
</body>
</html>