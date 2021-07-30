<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div>

    <div class="container-fluid">
        <div>
            <h1>User</h1>
        </div>
        <form class="d-flex mb-3" role="form" action="<?= site_url('user/search'); ?>" method="post">
            <?= csrf_field(); ?>
            <input class="form-control me-2" name="username" type="search" placeholder="Cari User" aria-label="Search">
            <button type="submit" class="btn btn-info">Search</button>
        </form>
    </div>
</div>
<!-- <nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <form class="d-flex"> <input class="form-control me-2" type="search" placeholder="Cari Barang" aria-label="Search"> <button class="btn btn-outline-success" type="submit">Search</button> </form>
    </div>
</nav> -->
<table class="table">
    <thead>
        <th>Id</th>
        <th>Username</th>
        <th>Created By</th>
        <th>Created Date</th>
    </thead>
    <tbody>
        <?php foreach ($data['users'] as $index => $user) : ?>
            <tr>
                <td><?= $user->id_user ?></td>
                <td><?= $user->username ?></td>
                <td><?= $user->created_by ?></td>
                <td><?= $user->created_date ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<div style="float:left">
    <?= $data['pager']->links('default', 'custom_pagination') ?>
</div>

<?= $this->endSection() ?>