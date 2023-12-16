<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="w-3/12 m-4">
        <h1 class="text-3xl font-bold mb-4">Register</h1>
        <form action="/auth/register" method="POST">
            <div class="flex flex-col">
                <label for="nama" class="text-lg">Name</label>
                <input type="text" name="nama" class="py-2 px-3 border border-black rounded-md">
            </div>
            <div class="flex flex-col">
                <label for="username" class="text-lg">Username</label>
                <input type="text" name="username" class="py-2 px-3 border border-black rounded-md">
            </div>
            <div class="flex flex-col">
                <label for="password" class="text-lg">Password</label>
                <input type="password" name="password" class="py-2 px-3 border border-black rounded-md">
            </div>
            <button type="submit" class="py-2 px-3 border border-black rounded-lg hover:bg-gray-300 my-3">Register</button>
        </form>
        <div class="flex gap-x-3">
            <p class="text-base">Don't have an account?</p>
            <a href="/login" class="text-base underline underline-offset-2 font-semibold">Login</a>
        </div>
    </div>
</body>
</html>
