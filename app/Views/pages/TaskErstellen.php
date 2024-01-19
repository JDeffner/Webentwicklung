<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container justify-content-center align-items-center d-flex">
    <div class="card ms-3 me-3 col-sm-8">
        <div class="card-header">
            <h4>Neue Task erstellen oder bearbeiten</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php
                if(isset($id))
                    echo base_url('tasks/bearbeiten/'.$id);
                    else echo base_url('tasks/erstellen');?>">
<!--                //$.ajax({-->
<!--                //    url: '--><?php ////echo base_url('tasks/bearbeiten/'); ?><!--//'+id,-->
<!--                //    method: "GET",-->
<!--                //    success: function (response){-->
<!--                //        console.log(JSON.parse(response));-->
<!--                //    }-->
<!--                // type: 'post',-->
<!--                // data: {-->
<!--                //     id: id,-->
<!--                //     tasks: name,-->
<!--                //     personenid: person,-->
<!--                //     spaltenid: spalte,-->
<!--                //     erinnerungsdatum: erinnerungDatum,-->
<!--                //     erinnerung: erinnerung,-->
<!--                //     notizen: notiz,-->
<!--                //     taskartenid: taskart-->
<!--                // },-->
<!--                // success: function (response){-->
<!--                //     console.log(response);-->
<!--                // }-->
<!--                // })-->
            </form>
        </div>
    </div>
 </main>
<?= $this->endSection() ?>