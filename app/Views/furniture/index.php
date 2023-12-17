<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
    <div id="overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black opacity-50 z-10"></div>
    <h1 class="text-[40px] font-bold mb-4">Daftar Furnitur</h1>
    <button id="search" class="p-2 border border-black rounded-lg bg-[#e89402] hover:bg-[#fca103] text-black text-[18px] font-medium">Cari Furnitur Sesuai Kebutuhan</button>
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
        <div class="grid grid-cols-4 gap-x-4 gap-y-4 mt-6">
            <?php foreach ($furnitures as $furniture_item): ?>
                <a href ='/furniture/<?= $furniture_item->id ?>' class="p-2 border border-black rounded-lg hover:bg-gray-300 hover:scale-105 transition duration-150 ease-in-out">
                    <div class="flex flex-col gap-y-1">
                        <div>
                            <div class="flex justify-between mb-4">
                                <div class="text-[22px] font-semibold"><?= $furniture_item->nama ?></div>
                                <div class="text-[20px] font-medium">Rp <?= number_format($furniture_item->harga, 0, ',', '.') ?></div>
                            </div>
                            <div class='grid grid-cols-3 gap-x-4'>
                                <div class="flex flex-col gap-y-[2px] grow">
                                    <div class="text-[18px] font-medium">Jenis Material</div>
                                    <div class="text-[16px]"><?= $furniture_item->jenisMaterial ?></div>
                                </div>
                                <div class="flex flex-col gap-y-[2px] grow">
                                    <div class="text-[18px] font-medium">Merek Material</div>
                                    <div class="text-[16px]"><?= $furniture_item->merekMaterial ?></div>
                                </div>
                                <div class="flex flex-col gap-y-[2px] grow">
                                    <div class="text-[18px] font-medium">Warna</div>
                                    <div class="text-[16px]"><?= $furniture_item->warna ?></div>
                                </div>
                            </div>
                            <div class='grid grid-cols-3 gap-x-4 mt-4'>
                                <div class="flex flex-col gap-y-1 grow">
                                    <div class="text-[18px] font-medium">Berat</div>
                                    <div class="text-[16px]"><?= $furniture_item->berat ?></div>
                                </div>
                                <div class="flex flex-col gap-y-1 grow">
                                    <div class="text-[18px] font-medium">Stok</div>
                                    <div class="text-[16px]"><?= $furniture_item->stok ?></div>
                                </div>
                                <div class="flex flex-col gap-y-1 grow">
                                    <div class="text-[18px] font-medium">Rating</div>
                                    <div class="text-[16px]"><?= $furniture_item->rating ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </a>
            <?php endforeach ?>
        </div>

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