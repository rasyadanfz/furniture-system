<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="m-4">
    <div class="border border-black rounded-lg p-4 absolute top-[45%] left-1/2 translate-x-[-50%] translate-y-[-50%] ">
        <h1 class="text-3xl font-bold text-center mb-8">
            Login
        </h1>
        <div class="w-[400px]">
            <form action="/auth/login" method="POST">
                <div class="flex flex-col">
                    <label for="username" class="text-lg">Username:</label>
                    <input type="text" name="username" class="py-2 px-3 border border-black rounded-md  ">
                </div>
                <div class="flex flex-col">
                    <label for="password" class="text-lg">Password:</label>
                    <input type="password" name="password" class="py-2 px-3 border border-black rounded-md">
                </div>
                <button type="submit" class="py-2 px-3 border border-black rounded-lg hover:bg-gray-300 my-3">Login</button>
            </form>
            <div class="flex gap-x-3 ">
                <p class="text-base">Don't have an account?</p>
                <a href="/register" class="text-base underline underline-offset-2 font-semibold">Register</a>
            </div>
        </div>
    </div>
</body>
</html>
