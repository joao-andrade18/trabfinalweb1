<?php
require "authenticate.php";
include "db_functions.php";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>LetMeAsk</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>

<div class="relative bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
      <div class="flex justify-start lg:w-0 lg:flex-1">
        <a href="index.php">
          <p class="font-bold text-lg">LetMeAsk</p>
        </a>
      </div>
      <div class="-mr-2 -my-2 md:hidden">
        <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
          <span class="sr-only">Open menu</span>
          <!-- Heroicon name: outline/menu -->
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
      <nav class="hidden md:flex space-x-10">
            <table>
                <tr>
                    <?php if (!$login) { ?>
                    <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
                        <a href="login.php" class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900"> Login </a>
                        <a href="register.php" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700"> Cadastrar </a>
                    </div>
                        <?php } else { ?>
                            Olá <?php echo $user_name   . "!"?><br>
                            <a class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900" href="logout.php"> Sair</a>
                        <?php } ?>
                    </nav>
                    </div>
                </div>
            </tr>
            </table>
        </div>
    
    <div class="wrapper">
        <?php if ($login) { ?>
            <div class="create-thread-btn"><a class="button is-link is-light hover:text-green-700 transition duration-150 ease-in-out" data-bs-toggle="" title="" href="create_forum_thread.php">Crie uma pergunta!</a></div>
        <?php } ?>
       

       