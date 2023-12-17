<!doctype html>
<html lang="en" id="htmlAll">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Furniture System</title>
    <link rel="stylesheet" href="/css/style.css">
  </head>
<body>
<nav class="flex justify-between items-center py-4 px-6 bg-white drop-shadow-md border-b-0.5 border-black">
    <a href="/" class="font-bold text-3xl hover:scale-110 transition duration-200 ease-in-out text-[#e89402] font-sans">WoodWonders</a>
    <div class="flex items-center gap-x-5 ">
      <a href="/pesanan" class="text-lg mr-4 text-[#e89402] font-semibold hover:scale-110 transition duration-200 ease-in-out">Orders</a>
      <div class="relative mr-6">
        <div id="userProfile" class="hover:cursor-pointer flex items-center gap-x-2 hover:scale-110 transition duration-200 ease-in-out">
          <img src="/image/user_icon.png" alt="user" class="w-10 h-10 rounded-full object-cover" class="text-white">
          <div class="text-lg text-black font-semibold"><?= session()->get('username') ?></div>
        </div>
        <a id="logoutButton" href="/auth/logout" class="absolute hidden text-lg text-red-500 font-semibold bg-white border-2 border-black rounded-md px-8 py-1 hover:bg-red-100 top-15 right-0 mt-2.5">Logout</a>
      </div>
      
    </div>
</nav>

<div class=" px-5">
    <?= $this->renderSection('content') ?>
</div>

<script>
    const logoutButton = document.querySelector('#logoutButton');
    const userProfile = document.querySelector('#userProfile');

    userProfile.addEventListener('click', () => {
        logoutButton.classList.toggle('hidden');
    })


</script>
</body>
</html>