<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
    <main class="container-fluid">
        <div class="card ms-3 me-3">
            <div class="card-header">
                <h4>Table Content</h4>
            </div>
            <div class="card-body">
                <? foreach ((isset($personen) ? $personen : null) as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['vorname'] ?></td>
                        <td><?= $item['nachname'] ?></td>
                        <td><?= $item['email'] ?></td>
                        <td><?= $item['passwort'] ?></td>
                    </tr>
                <? endforeach; ?>
            </div>
        </div>
    </main>
<?= $this->endSection() ?>