<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div>
    <div id="overlay" class="hidden fixed top-0 left-0 w-full h-full bg-black opacity-50 z-10"></div>
    <div id="editBox" class="hidden z-20 absolute top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%] bg-white p-3 border border-black rounded-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Change Review Score</h2>
            <p id="close" class="font-bold text-2xl pr-4 hover:cursor-pointer pl-8">X</p>
        </div>
        <form id="editForm" novalidate="novalidate" action="/reviews/update" method="POST" class="flex flex-col gap-x-3">
            <h2 class="mb-5 font-semibold">Change your current review score for the item.</h2>
            <div class="flex flex-col gap-y-2">
                <div>
                    <label for="review_score">Review score (1-10):</label>
                    <input id="scoreInput" placeholder="ex: 1, 2.55, 4.12" type="number" name="review_score" min=1 max=10 class="border px-2 py-1 border-black rounded-md">
                </div>
                <div>
                    <label for="review_durability">Durability score (1-10):</label>
                    <input id="durabilityInput" placeholder="ex: 1, 2.55, 4.12" type="number" name="review_durability" min=1 max=10 class="border px-2 py-1 border-black rounded-md">
                </div>
                <div>
                    <label for="review_texture">Texture score (1-10):</label>
                    <input id="textureInput" placeholder="ex: 1, 2.55, 4.12" type="number" name="review_texture" min=1 max=10 class="border px-2 py-1 border-black rounded-md">
                </div>
                <div>
                    <label for="review_maintainability">Maintainability score (1-10):</label>
                    <input id="maintainabilityInput" placeholder="ex: 1, 2.55, 4.12" type="number" name="review_maintainability" min=1 max=10 class="border px-2 py-1 border-black rounded-md">
                </div>
            </div>
            <button id="editFormBtn" type="submit" class="text-black border border-black px-2 py-1 rounded-md hover:bg-gray-300 mt-2">Ganti</button>
        </form>
    </div>

    <div id="review_new_box" class="hidden z-20 absolute top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%] bg-white p-3 border border-black rounded-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Add Review Score</h2>
            <p id="closeAdd" class="font-bold text-2xl pr-4 hover:cursor-pointer pl-8">X</p>
        </div>
        <form id="addForm" novalidate="novalidate" action="/reviews/create" method="POST" class="flex flex-col gap-x-3">
            <h2 class="mb-5 font-semibold">Add your review score for the item.</h2>
            <div class="flex flex-col gap-y-2">
            <div>
                    <label for="review_score_new">Review score (1-10):</label>
                    <input id="scoreInput_new" placeholder="ex: 1, 2.55, 4.12" type="number" name="review_score_new" min=1 max=10 class="border px-2 py-1 border-black rounded-md">
                </div>
                <div>
                    <label for="review_durability_new">Durability score (1-10):</label>
                    <input id="durabilityInput_new" placeholder="ex: 1, 2.55, 4.12" type="number" name="review_durability_new" min=1 max=10 class="border px-2 py-1 border-black rounded-md">
                </div>
                <div>
                    <label for="review_texture_new">Texture score (1-10):</label>
                    <input id="textureInput_new" placeholder="ex: 1, 2.55, 4.12" type="number" name="review_texture_new" min=1 max=10 class="border px-2 py-1 border-black rounded-md">
                </div>
                <div>
                    <label for="review_maintainability_new">Maintainability score (1-10):</label>
                    <input id="maintainabilityInput_new" placeholder="ex: 1, 2.55, 4.12" type="number" name="review_maintainability_new" min=1 max=10 class="border px-2 py-1 border-black rounded-md">
                </div>
            </div>
            <button id="addFormBtn" type="submit" class="text-black border border-black px-2 py-1 rounded-md hover:bg-gray-300 mt-2">Tambah Review</button>
        </form>
    </div>

    <h1 class="text-[36px] font-bold my-6">Daftar Pesanan</h1>
    <div class="grid grid-cols-6 border-2 py-2 px-2 text-center rounded-t-lg font-semibold text-[18px] border-gray-300 bg-gray-300">
        <p>Nama furnitur</p>
        <p>Waktu Pesanan</p>
        <p>Jumlah</p>
        <p>Total Harga</p>
        <p>Review</p>
        <p>Action</p>
    </div>
    <div class="border text-[18px] text-center border-gray-300">
        <?php foreach ($pesanans as $pesanan): ?>
            <div class="border py-2 border-gray-300 grid grid-cols-6">
                <p><?= $pesanan['furniture_name'] ?></p>
                <p><?= $pesanan['waktuPesanan'] ?></p>
                <p><?= $pesanan['kuantitas'] ?></p>
                <p>Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?></p>
                    <?php if($pesanan['isReviewed']): ?>
                        <p><?= $pesanan['review_score'] ?></p>
                        <button onclick="handleEditBtnClick(<?= $pesanan['id'] ?>)" class="px-3 py-1.5 text-[14px] font-semibold rounded-lg hover:bg-yellow-100 bg-yellow-300 mx-[20%]">Edit Review</button>
                    <?php ?>
                    <?php else: ?>
                        <p class="font-medium text-[20px]">-</p>
                        <button onclick="handleNewBtnClick(<?= $pesanan['id'] ?>)" class="px-3 py-1.5 text-[14px] font-semibold rounded-lg hover:bg-blue-100 bg-blue-300 mx-[20%]">Add Review</button>
                    <?php endif ?>
            </div>
        <?php endforeach ?>
    </div>
</div>

<script>
    const overlay = document.getElementById('overlay');
    const htmlAll = document.getElementById('htmlAll');
    const close = document.querySelector('#close');
    const closeAdd = document.querySelector('#closeAdd'); 
    const addFormBtn = document.querySelector('#addFormBtn');
    const editFormBtn = document.querySelector('#editFormBtn');

    const handleEditBtnClick = async (pesanan_id) => {
        
        const editBox = document.getElementById('editBox');
        htmlAll.classList.add("bg-[rgba(255,255,255,0.5)]");
        overlay.classList.toggle('hidden');
        editBox.classList.toggle('hidden');
        const editForm = document.getElementById('editForm');
        const score_input = document.getElementById('scoreInput');
        const durability_input = document.getElementById('durabilityInput');
        const texture_input = document.getElementById('textureInput');
        const maintainability_input = document.getElementById('maintainabilityInput');
        const current_review_data = await fetch(`/reviews/${pesanan_id}`);
        const data = await current_review_data.json();
        score_input.value = data['rating'];
        durability_input.value = data['durability_score'];
        texture_input.value = data['texture_score'];
        maintainability_input.value = data['maintainability_score'];

        editForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const score_value = (score_input.value).replace(',', '.');
            const durability_value = (durability_input.value).replace(',', '.');
            const texture_value = (texture_input.value).replace(',', '.');
            const maintainability_value = (maintainability_input.value).replace(',', '.');
            handleEditSubmit(pesanan_id);
        });
        
    }

    const handleNewBtnClick = (pesanan_id) => {
        const review_new_box = document.getElementById('review_new_box');
        const addForm = document.getElementById('addForm');
        htmlAll.classList.add("bg-[rgba(255,255,255,0.5)]");
        overlay.classList.toggle('hidden');
        review_new_box.classList.toggle('hidden');
        const score_input = document.getElementById('scoreInput_new');
        const durability_input = document.getElementById('durabilityInput_new');
        const texture_input = document.getElementById('textureInput_new');
        const maintainability_input = document.getElementById('maintainabilityInput_new');
        addForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const score_value = (score_input.value).replace(',', '.');
            const durability_value = (durability_input.value).replace(',', '.');
            const texture_value = (texture_input.value).replace(',', '.');
            const maintainability_value = (maintainability_input.value).replace(',', '.');
            handleNewSubmit(pesanan_id);
        });
    }

    const handleEditSubmit = (pesanan_id) => {
        const editForm = document.getElementById('editForm');
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'pesanan_id';
        hiddenInput.value = pesanan_id;
        editForm.appendChild(hiddenInput);
        editForm.submit();
    }

    const handleNewSubmit = (pesanan_id) => {
        const addForm = document.getElementById('addForm');
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'pesanan_id';
        hiddenInput.value = pesanan_id;
        addForm.appendChild(hiddenInput);
        addForm.submit();
    }

    close.addEventListener('click', () => {
            editBox.classList.toggle('hidden');
            overlay.classList.toggle('hidden');
            htmlAll.classList.remove("bg-[rgba(255,255,255,0.5)]");
        })
    closeAdd.addEventListener('click', () => {
            review_new_box.classList.toggle('hidden');
            overlay.classList.toggle('hidden');
            htmlAll.classList.remove("bg-[rgba(255,255,255,0.5)]");
        })
</script>

<?= $this->endSection(); ?>