<!doctype html>
<html lang="en" id="htmlAll">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Furniture System</title>
    <link rel="stylesheet" href="/css/style.css">
  </head>
<body>
<nav class="flex justify-between items-center py-4 px-6 bg-[#c96f02]">
    <a href="/" class="font-bold text-3xl text-black">Home</a>
    <div class="flex items-center gap-x-5">
      <a href="/pesanan" class="text-lg text-black font-semibold">Orders</a>
      <a href="/reviews" class="text-lg text-black font-semibold">Reviews</a>
      <div class="relative">
        <div id="userProfile" class="hover:cursor-pointer flex items-center gap-x-2">
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