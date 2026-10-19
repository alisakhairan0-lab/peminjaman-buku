<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $pageTitle ?? 'Data Alumni' ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php?c=admin&a=index">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Alumni</li>
    </ol>

    <!-- Flash Message -->
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?= $_SESSION['flash_message']['type'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['flash_message']['text'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash_message']); endif; ?>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-user-graduate me-1"></i> Daftar Siswa / Anggota Alumni</div>
            <form class="d-flex" method="GET" action="index.php">
                <input type="hidden" name="c" value="alumni">
                <input type="hidden" name="a" value="index">
                <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="Cari NIS / Nama..." value="<?= htmlspecialchars($search ?? '') ?>">
                <button class="btn btn-outline-primary btn-sm" type="submit">Cari</button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Status Akun</th>
                            <th>Tanggal Keluar / Arsip</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($alumni)): ?>
                            <?php $no = 1; foreach ($alumni as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['nis']) ?></td>
                                    <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                                    <td><?= htmlspecialchars($row['username']) ?></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($row['status']) ?></span></td>
                                    <td><?= htmlspecialchars($row['tgl_keluar']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data alumni atau anggota yang diarsipkan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>