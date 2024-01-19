<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Added default title in case $title is not set-->
    <title><?= ($title ?? 'Title not set') ?></title>
    <link rel="icon" href="<?php echo base_url();?>resources/images/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.22.1/bootstrap-table.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>resources/css/main.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
<main class="container justify-content-center align-items-center d-flex">
    <div class="card col-sm-10">
        <div class="card-header">
            <h4>Es sieht so aus also seien Sie ein wenig zu spät für die Demo</h4>
        </div>
        <div class="card-body">
            <div class="container">
                Falls Sie sich trotzdem für die Webseitenversion der Demo interessieren, können Sie sich gerne bei uns melden.
            </div>
            <div class="container mt-2">
                <a type="button" class="btn" href="mailto:s4jodeff@uni-trier.de">Email schreiben</a>
                <button id="copyButton" class="btn btn-secondary" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="E-Mail wurde ins Clipboard kopiert!">E-Mail-Adresse Kopieren</button>
                <input type="text" value="s4jodeff@uni-trier.de" id="myInput" style="display: none;">
            </div>




        </div>
    </div>
</main>
</body>
<script>
    document.getElementById('copyButton').addEventListener('click', function() {
        // Get the text field
        var copyText = document.getElementById("myInput");

        // Show the text field
        copyText.style.display = 'block';

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        document.execCommand("copy");

        // Hide the text field again
        copyText.style.display = 'none';

        // Show the popover
        var popover = new bootstrap.Popover(this);
        popover.show();

        // Hide the popover after 2 seconds
        setTimeout(function() {
            popover.hide();
        }, 2000);
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.22.1/bootstrap-table.min.js"></script>
</html>
