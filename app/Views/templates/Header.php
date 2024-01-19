<header>
    <nav class="navbar navbar-expand-md mb-4 ps-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo base_url();?>">
                <img src="<?php echo base_url();?>resources/images/MinMaxLogo.svg" alt="logo.svg" height="60">
            </a>

            <button class="navbar-toggler custom-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDropdown"
                    aria-controls="navbarDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="navbarDropdown">
                <ul class="navbar-nav nav-underline me-auto mb-2 mb-md-0">
                    <li class="nav-item active">
                        <a class="nav-link active" aria-current="page" href="<?php echo base_url('tasks');?>">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('boards');?>">Boards</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('spalten');?>">Spalten</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>