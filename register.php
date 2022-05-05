<?php
include "header.php";

$error = false;
$error_senha = false;
$error_mail = false;
$success = false;
$name = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {

    $conn = connect_db();

    $name = mysqli_real_escape_string($conn,$_POST["name"]);
    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $password = mysqli_real_escape_string($conn,$_POST["password"]);
    $confirm_password = mysqli_real_escape_string($conn,$_POST["confirm_password"]);

    if ($password == $confirm_password && filter_var($email, FILTER_VALIDATE_EMAIL)) { 
      $password = md5($password);

      $sql = "INSERT INTO $table_users
              (username, email, user_password) VALUES
              ('$name', '$email', '$password');";

      if(mysqli_query($conn, $sql)){
        $success = true;
      }
      else {
        $error_msg = mysqli_error($conn);
        $error = true;    }
    }
    else {
      if($password != $confirm_password){
        $error_msg = "Senha não confere com a confirmação.";
        $error_senha = true;
      }else{
        $error_msg = "Digite um email válido";
        $error_mail = true;
      }
    }
  }
  else {
    $error_msg = "Por favor, preencha todos os dados.";
    $error = true;
  }
}
?>



<?php if ($success): ?>
  <article class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"><div class="message-body">Usuário criado com sucesso!</div></article>
  <p>
    Seguir para <a href="login.php">login</a>.
  </p>
<?php endif; ?>

<?php if ($error): ?>
  <article class="">
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
  </span>
      <?php echo $error_msg; ?></div></article>
<?php endif; ?>
<?php if (!$success): ?>
  <br>
  <h1 class="font-bold text-xl">Dados para registro de novo usuário</h1>
  <div class=" min-h-full flex items-center justify-center py-10 px-4 sm:px-4 lg:px-4 rounded-lg bg-white  ">
      <div class="min-h-full flex items-center justify-center">
  <form action="register.php" method="post" >

    <div>
	<p>Nome:</p>
      <input class="	
          block
          w-full
          px-3
          py-1.5
          text-base
          font-normal
          text-gray-700
          bg-white bg-clip-padding
          border border-solid border-gray-300
          rounded
          transition
          ease-in-out
          m-0
          focus:text-gray-700 focus:bg-white focus:border-green-600 focus:outline-none" type="text" name="name" placeholder="Nome de Usuário" value="<?php echo $name; ?>" required><br>
    </div>

    <div class="">
	<p>E-mail:</p>
      <input class="
        w-full
        px-3
        py-1.5
        text-base
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-green-600 focus:outline-none" type="text" name="email" placeholder="Email:" value="<?php echo $email; ?>" required><br>
    </div>
    <?php if ($error_mail): ?>
      <article class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"><?php echo $error_msg; ?></div></article>
    <?php endif; ?>

    <div class="">
	<p>Senha:</p>
      <input class="
        w-full
        px-3
        py-1.5
        text-base
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-green-600 focus:outline-none" type="password" name="password" placeholder="Senha:" value="" required><br>
    </div>
    <?php if ($error_senha): ?>
      <article class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"><div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"><?php echo $error_msg; ?></div></article>
    <?php endif; ?>

    <div class="">
	<p>Repitir senha:</p>
      <input class="
        w-full
        px-3
        py-1.5
        text-base
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-green-600 focus:outline-none" type="password" name="confirm_password" placeholder="Confirmação da Senha:" value="" required><br>
    </div><br>

    <?php if ($error_senha): ?>
      <article class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
      <div class="bg-red-100 border border-red-400 text-red-700 px-1 py-4 rounded relative">
        <?php echo $error_msg; ?></div></article><br>
    <?php endif; ?>

    <input class="ml-8 whitespace-nowrap inline-flex items-left justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700" type="submit" name="submit" value="Criar usuário">
  </form>
  </div>
<?php endif; ?>

</p>

<?php
include "footer.php";
?>