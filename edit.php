<?php
require 'db_credentials.php';
include "header.php";


$conn = mysqli_connect($servername,$username,$password,$dbname);
if (!$conn) {
  die("Problemas ao conectar com o BD!<br>".
       mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET["thread_id"])) {

    $id = $_GET['thread_id'];
    $id = mysqli_real_escape_string($conn, $id);

    $sql = "SELECT thread_id,thread_subject FROM forum_thread WHERE thread_id = ". $id;

    if(!($thread = mysqli_query($conn,$sql))){
      die("Problemas para carregar os assuntos do BD!<br>".
           mysqli_error($conn));
    }
  }
}

mysqli_close($conn);

if (mysqli_num_rows($thread) != 1) {
  die("Id de assunto incorreto.");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Blog</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/bootstrap.css">
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <style media="screen">
    .alert a:hover{
      text-decoration: none;
    }
    .alert .tarefa {
      font-size: 1.3em;
    }

    h3.panel-title{
      font-weight: bold;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-xs-offset-3 col-xs-6">
      <h1 class="text-2xl font-bold">Editar</h1><br><br>
<?php $thread = mysqli_fetch_assoc($thread); ?>
      <form action="index.php" method="POST">
        <div class="form-group">
          
          <input type="hidden" name="thread_id" value="<?php echo $thread["thread_id"] ?>">
          <label class="text-lg font-bold">Editar Assunto</label><br>
          <input required type="text" name="novo_assunto" class="form-control" 
				value="<?php echo $thread["thread_subject"] ?>">
        </div>
      </form>
    </div>
  </div>
</div>
<?php
include "footer.php";
?>