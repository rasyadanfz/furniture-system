<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="mt-4">
    <h1 class="text-[36px] font-bold"><?= $furnitures->nama ?></h1>
    <div class="flex gap-x-20">
        <div>
            <p class="text-[30px] my-6">Detail</p>
            <div class="flex flex-col gap-y-6">
                <div class="flex gap-x-10">
                    <div>
                        <p class="text-[20px] font-semibold">Jenis Material</p>
                        <p class="text-[20px]"><?= $furnitures->jenisMaterial ?></p>
                    </div>
                    <div>
                        <p class="text-[20px] font-semibold">Merek Material</p>
                        <p class="text-[20px]"><?= $furnitures->merekMaterial ?></p>
                    </div>
                    <div>
                        <p class="text-[20px] font-semibold">Warna</p>
                        <p class="text-[20px]"><?= $furnitures->warna ?></p>
                    </div>
                </div>
                <div class="flex gap-x-10">
                    <div>
                        <p class="text-[20px] font-semibold">Berat Furnitur</p>
                        <p class="text-[20px]"><?= $furnitures->berat ?></p>
                    </div>
                    <div>
                        <p class="text-[20px] font-semibold">Rating</p>
                        <p class="text-[20px]"><?= $furnitures->rating ?></p>
                    </div>
                </div>
            </div>
            <p class="text-[30px] my-6">Pembelian</p>
            <div class="flex gap-x-10">
                <div class="flex flex-col">
                    <p class="text-[20px] font-semibold">Stok Furnitur</p>
                    <p class="text-[20px]"><?= $furnitures->stok ?></p>
                </div>
                <div class="flex flex-col">
                    <p class="text-[20px] font-semibold">Harga</p>
                    <p class="text-[20px]">Rp <?= number_format($furnitures->harga, 0, ',', '.') ?></p>
                </div>
            </div>
            <div class="mt-6">
                <form id="buyForm" action="/pesanan/create" method="post" class="flex flex-col w-[400px]">
                    <div class="flex justify-between items-center">
                        <label for="qty" class="text-[18px] font-semibold">Masukkan jumlah pembelian</label>
                        <input id="quantity" type="number" name="qty" min=1 max=<?= $furnitures->stok ?> class="border text-black border-black px-3 py-1 rounded-md" placeholder="0">
                    </div>
                    <div>
                        <p class="text-[20px] font-semibold">Total Harga: </p>
                        <p id="total_price">Rp 0</p>
                    </div>
                    <div class="grow-0 mt-2">
                        <button onclick="submitWithId()" class="text-black w-full grow-0 border border-black px-4 py-2 rounded-md hover:bg-gray-300 mt-2">Beli</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="rating_group">
            <div class="text-[30px] my-6">Rating (0-5)</div>
            <div class="flex flex-col gap-y-2"> 
                <?php foreach($review_group as $key => $review): ?>
                    <div class="text-[20px]"><span class="font-semibold"><?= $key ?>:</span> <?= $review ?> reviews</div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>

<script>
    const price = document.querySelector('#total_price');
    const qtyTracker = document.querySelector('#quantity');
    let intPrice;
    
    qtyTracker.addEventListener("change", (e) => {
        const total_price = (e.target.value * <?= $furnitures->harga ?>);
        price.innerHTML =  'Rp ' + total_price.toLocaleString('id-ID');
        intPrice = parseInt(total_price);
    })

    function submitWithId(){
        const buyForm = document.querySelector('#buyForm');
        const furniture_id = <?= $furnitures->id ?>;
    
        const hiddenInputID = document.createElement('input');
        const hiddenInputPrice = document.createElement('input');
        hiddenInputID.type = 'hidden';
        hiddenInputID.name = 'furniture_id';
        hiddenInputID.value = furniture_id;
        hiddenInputPrice.type = 'hidden';
        hiddenInputPrice.name = 'price';
        hiddenInputPrice.value = intPrice;
        buyForm.appendChild(hiddenInputID);
        buyForm.appendChild(hiddenInputPrice);
    
        form.submit();
    }
</script>

<?= $this->endSection() ?>