<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div>
        <h1>User</h1>
    </div>
    <form class="d-flex mb-3" role="form" action="<?= site_url('User/search'); ?>" method="post">
        <?= csrf_field(); ?>
        <input class="form-control me-2" name="username" type="search" placeholder="Cari User" aria-label="Search">
        <button type="submit" class="btn btn-info">Search</button>
    </form>
</div>
<div class="container">
    <table class="table">
        <thead>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Created Date</th>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            <?php foreach ($data['users'] as $index => $user) : ?>
                <tr>
                    <td><?= $user->id_user ?></td>
                    <td><?= $user->username ?></td>
                    <td><?php
                        $role = $user->role;
                        if ($role == 0) {
                            echo 'Owner';
                        } else if ($role == 1) {
                            echo 'Admin';
                        } else {
                            echo 'Customer';
                        }
                        ?></td>
                    <td><?= $user->created_date ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <div style="float:left">
        <?= $data['pager']->links('default', 'custom_pagination') ?>
    </div>
</div>
<?= $this->endSection(); ?>