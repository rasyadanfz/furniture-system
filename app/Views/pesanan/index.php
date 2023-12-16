<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div>
    <h1 class="text-[36px] font-bold mb-6">Daftar Pesanan</h1>
    <div>
        <?php foreach ($pesanans as $pesanan): ?>
            <p><?= $pesanan['furniture_name'] ?></p>
            <p><?= $pesanan['waktuPesanan'] ?></p>
            <p><?= $pesanan['kuantitas'] ?></p>
            <p><?= $pesanan['total_harga'] ?></p>
            <p><?= $pesanan['kuantitas'] ?></p>
        <?php endforeach ?>
    </div>
</div>

<?= $this->endSection(); ?>