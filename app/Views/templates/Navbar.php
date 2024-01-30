<nav class="navbar navbar-expand-md mb-4">
    <div class="container-fluid">
        <a class="navbar-brand ps-4" href="<?php echo base_url();?>">
            <img src="<?php echo base_url();?>resources/images/MinMaxLogo.svg" alt="logo.svg" height="60">
        </a>


        <div class="navbar-collapse collapse" id="navbarDropdown">
            <?php $title ?? $title = 'No Title Set'; ?>
            <ul class="navbar-nav nav-underline me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($title == 'Tasks') ? 'active" aria-current="page"' : '"' ?> href="<?php echo base_url('tasks');?>">Tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($title == 'Boards') ? 'active" aria-current="page"' : '"' ?> href="<?php echo base_url('boards');?>">Boards</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($title == 'Spalten') ? 'active" aria-current="page"' : '"' ?> href="<?php echo base_url('spalten');?>">Spalten</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo ($title == 'Personen' || $title == 'Taskarten' || $title == 'Tasks-Admin') ? 'active" aria-current="page"' : '"' ?> role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo base_url() ?>admin/personen">Personen</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url() ?>admin/tasks">Tasks</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url() ?>admin/taskarten">Taskarten</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="navbar-text me-4">
            <div class="dropdown">
                <?php echo isset($_COOKIE['userid']) ? $_COOKIE['username'].' '.$_COOKIE['userlastname'] : 'Gast'; ?>
                <?php if($_COOKIE['permissionLevel'] == '2') { ?>
                    <i class="fa-solid fa-user-shield dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #e21d1d;"></i>
                <?php } else if($_COOKIE['permissionLevel'] == '1') { ?>
                        <i class="fa-solid fa-user" style="color: #0d46d5;"></i>
                <?php } else { ?>
                    <i class="fa-solid fa-user" style="color: #21d50d;"></i>
                <?php } ?>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?php echo base_url('benutzer/'.$_COOKIE['userid']); ?>"><i class="fa-solid fa-user"></i> Profil</a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url();?>"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </div>
        </div>


        <button class="navbar-toggler custom-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDropdown"
                aria-controls="navbarDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
