<?php
include "header.php";

$error = false;
$password = $email = "";

if (!$login && $_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["email"]) && isset($_POST["password"])) {

    $conn = connect_db();

    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $password = mysqli_real_escape_string($conn,$_POST["password"]);
    $password = md5($password);

    $sql = "SELECT account_id,username,email,user_password FROM $table_users
            WHERE email = '$email';";

    $result = mysqli_query($conn, $sql);
    if($result){
      if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($user["user_password"] == $password) {

          $_SESSION["user_id"] = $user["account_id"];
          $_SESSION["user_name"] = $user["username"];
          $_SESSION["user_email"] = $user["email"];
          $_SESSION["signed_in"] = $login;

          header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
          exit();
        }
        else {
          $error_msg = "Senha incorreta!";
          $error = true;
        }
      }
      else{
        $error_msg = "Usuário não encontrado!";
        $error = true;
      }
    }
    else {
      $error_msg = mysqli_error($conn);
      $error = true;
    }
  }
  else {
    $error_msg = "Por favor, preencha todos os dados.";
    $error = true;
  }
}
?>

<?php if ($login): ?>
    <h3>Você já está logado!</h3>
  </body>
  </html>
  <?php exit(); ?>
<?php endif; ?>

<?php if ($error): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
<?php endif; ?>

<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full space-y-8">
    <div>
      <h1 class="mx-auto h-16 w-auto text-4xl font-bold text-center text-green-500"> LetMeAsk</h1>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Login</h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Ou
        <a href="register.php" class="font-medium text-green-600 hover:text-green-500"> Cadastro </a>
      </p>
    </div>
    <form class="mt-8 space-y-6" action="login.php" method="POST">
      <input type="hidden" name="remember" value="true">
      <div class="rounded-md shadow-sm -space-y-px">
        <div>
          <label for="email-address" class="sr-only">Email</label>
          <input 
          id="email-address" 
          name="email" 
          type="email" 
          autocomplete="email" 
          class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" placeholder="Email" 
          value="<?php echo $email; ?>" required>
        </div>
        <div>
          <label for="password" class="sr-only">Senha</label>
          <input
          id="password" 
          name="password" 
          type="password" 
          autocomplete="current-password"
          value="" 
          required 
          class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" 
          placeholder="Senha">
        </div>
      </div>

      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-green-500 border-gray-300 rounded">
          <label for="remember-me" class="ml-2 block text-sm text-gray-900"> Lembre-me </label>
        </div>

        <div class="text-sm">
          <a href="#" class="font-medium text-green-600 hover:text-green-500"> Esqueçeu sua senha? </a>
        </div>
      </div>

      <div>
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <!-- Heroicon name: solid/lock-closed -->
            <svg class="h-5 w-5 text-green-500 group-hover:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
          </span>
          Login
        </button>
      </div>
    </form>
  </div>
</div>

<?php
include "footer.php";
?>