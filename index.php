<?php
include "header.php";


$conn = connect_db();


$sql = "SELECT thread_id, thread_subject, username, account_id, creation_date FROM forum_thread";
$threads_db = mysqli_query($conn, $sql);

if (!$threads_db) {
    die("Error: " . $sql . "<br>" . mysqli_error($conn));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["novo_assunto"]) && isset($_POST["thread_id"])){

    $novo_assunto = $_POST["novo_assunto"];
    $id = $_POST["thread_id"];
  
    $sql = "UPDATE forum_thread
            SET thread_subject='". mysqli_real_escape_string($conn, $novo_assunto) ."' 
			      WHERE forum_thread.thread_id=" . mysqli_real_escape_string($conn, $id);
  
    if(!mysqli_query($conn,$sql)){
        die("Problemas para executar ação no BD!<br>".
        mysqli_error($conn));
    }
  }
}

elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
  if(!empty($_GET["acao"])){
    if($_GET["acao"] == "deleta"){
        
        $sql = "";
        $sql = "alter table post DROP FK_thread_id";
        $sql = "DELETE FROM forum_thread	 WHERE thread_id  = " . $_GET["thread_id"];
		
        if(!mysqli_query($conn, $sql))
            die("Erro sql: " . mysqli_error($conn));
     }

    $sql = "SELECT * FROM forum_thread";
    $threads_db = mysqli_query($conn,$sql);

    if(!$threads_db)
        die("Erro sql: " . mysqli_error($conn));

    mysqli_close($conn);
    }
}

?>

<div class="flex flex-col">
  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
      <div class="overflow-hidden">
        <table class="min-w-full">
        <thead class="border-b">
            <tr>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Assunto
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Autor
              </th>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Data
              </th>
			  						<?php if (!$login) { ?>
							<button>
                        <?php } else { ?>
              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Opções
              </th>
                        <?php } ?>

            </tr>
          </thead>
            <?php if (mysqli_num_rows($threads_db) > 0): ?>
                <?php while($thread = mysqli_fetch_assoc($threads_db)): ?>
                    
                    <tbody>
                        <tr class="border-b odd:bg-white even:bg-slate-100" id="thread<?= $thread['thread_id'] ?>"><br>
                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap "><a href="thread_discussion.php?id=
						<?= $thread['thread_id'] ?>"><?= $thread['thread_subject'] ?></a></td>
                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"><?= $thread['username'] ?> </td>
                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"> <?= date('d/m/Y', strtotime($thread['creation_date']))  ?></td>
						<?php if (!$login) { ?>
							<button>
                        <?php } else { ?>

						<td><?php echo "<a href='index.php?acao=deleta&thread_id=" . $thread["thread_id"]. "'> <button>Remover</button> </a>"?></td>
						
						<td><?php echo "<a href='edit.php?thread_id=" . $thread["thread_id"]. "'> <button>Editar</button> </a>"?></td>	
                        <?php } ?>
						
				
					</tr>	
				</tbody>	
                <?php endWhile; ?>
        <?php else: ?>
            Ainda não existe nenhum tópico.
        <?php endIF; ?>
      </table>
    </div>
  </div>
</div>


</div>


<?php
include "footer.php";
?>