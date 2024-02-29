<!DOCTYPE html>
<html lang="en" data-bs-theme="dark" class="custom-scrollbar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Added default title in case $title is not set-->
    <title><?= ($title ?? 'Title not set') ?></title>
    <link rel="icon" href="<?php echo base_url();?>resources/images/favicon.ico" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.22.1/bootstrap-table.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>resources/css/main.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>resources/css/custom.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.22.1/bootstrap-table.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.js" integrity="sha512-NgXVRE+Mxxf647SqmbB9wPS5SEpWiLFp5G7ItUNFi+GVUyQeP+7w4vnKtc2O/Dm74TpTFKXNjakd40pfSKNulg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.css" integrity="sha512-zlYhSecphd+kwRzeCOyj7/u3HZIQ3Q0NP7AN7ZEKhYTdi0AQOGGbc7eA3I/mUffqjdr8G1/9xoS478h+I0MQGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        const BASE_URL = "<?= base_url() ?>"; // Set baseURL for all scripts
    </script>
    <script defer src="<?php echo base_url();?>resources/js/main.js"></script>
<!-- Page specific scripts   -->
    <?php if (isset($title)) : ?>
        <script defer src="<?php echo base_url();?>resources/js/<?= strtolower($title) ?>.js"></script>
    <?php endif; ?>
</head>
<body class="bg-primary-subtle">
