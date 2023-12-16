<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
    <div id="overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black opacity-50 z-10"></div>
    <h1 class="text-[40px] font-bold">Daftar Furnitur</h1>
    <button id="search" class="p-2 mb-4 border border-black rounded-lg hover:bg-gray-300">Cari Furnitur Sesuai Kebutuhan</button>
    <div id="searchBox" class="hidden z-20 absolute top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%] bg-white p-3 border border-black rounded-lg">
        <div class="flex justify-between">
            <h2 class="text-3xl mb-5 font-bold">Cari Furnitur</h2>
            <p id="close" class="font-bold text-2xl pr-4 hover:cursor-pointer">X</p>
        </div>
        <p class="mb-5 font-semibold">Masukkan nilai (1-10) untuk setiap faktor berikut yang kamu butuhkan.</p>
        <form action="/furniture/search" method="get" class="flex flex-col gap-x-3">
            <div class="flex gap-x-8 justify-between">
                <div class="flex grow flex-col gap-y-1 mb-2">
                    <label for="durability">Nilai ketahanan (1-10)</label>
                    <input type="number" name="durability" min=1 max=10 class="border px-2 py-1 border-black rounded-md">
                </div>
                <div class="flex grow flex-col gap-y-1 mb-2">
                    <label for="durability">Nilai tekstur (1-10)</label>
                    <input type="number" name="texture" min=1 max=10 class="border px-2 py-1 border-black rounded-md">
                </div>
            </div>
            <div class="flex flex-col gap-y-1 mb-2">
                <label for="durability">Nilai kemudahan merawat (1-10)</label>
                <input type="number" name="maintainability" min=1 max=10 class="border px-2 py-1 border-black rounded-md">
            </div>
            <button class="text-black border border-black px-2 py-1 rounded-md hover:bg-gray-300 mt-2">Cari</button>
        </form>
    </div>
    <div class="grid grid-cols-8 border-black border-b-2 text-center py-2">
            <div class="text-[20px]">Nama</div>
            <div class="text-[20px] font-semibold">Jenis Material</div>
            <div class="text-[20px] font-semibold">Merek Material</div>
            <div class="text-[20px] font-semibold">Warna</div>
            <div class="text-[20px] font-semibold">Berat</div>
            <div class="text-[20px] font-semibold">Stok</div>
            <div class="text-[20px] font-semibold">Rating</div>
            <div class="text-[20px] font-semibold">Harga</div>
        </div>
    <?php foreach ($furnitures as $furniture_item): ?>
        <a href ='/furniture/<?= $furniture_item->id ?>' class="grid grid-cols-8 py-2 text-center hover:bg-gray-300" >
            <div class="text-[20px]"><?= $furniture_item->nama ?></div>
            <div class="text-[20px]"><?= $furniture_item->jenisMaterial ?></div>
            <div class="text-[20px]"><?= $furniture_item->merekMaterial ?></div>
            <div class="text-[20px]"><?= $furniture_item->warna ?></div>
            <div class="text-[20px]"><?= $furniture_item->berat ?></div>
            <div class="text-[20px]"><?= $furniture_item->stok ?></div>
            <div class="text-[20px]"><?= $furniture_item->rating ?></div>
            <div class="text-[20px]">Rp <?= number_format($furniture_item->harga, 0, ',', '.') ?></div>
        </a>
    <?php endforeach ?>

    <script>
        const search = document.querySelector('#search');
        const searchBox = document.querySelector('#searchBox');
        const htmlAll = document.querySelector('#htmlAll');
        const overlay = document.querySelector('#overlay');
        const close = document.querySelector('#close');

        search.addEventListener('click', () => {
            searchBox.classList.toggle('hidden');
            htmlAll.classList.add("bg-[rgba(0,0,0,0.5)]");
            overlay.classList.toggle('hidden');
        })

        close.addEventListener('click', () => {
            searchBox.classList.toggle('hidden');
            overlay.classList.toggle('hidden');
            htmlAll.classList.remove("bg-[rgba(0,0,0,0.5)]");
        })
        

    </script>
<?= $this->endSection(); ?>