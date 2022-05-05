<?php
include "header.php";

if ($login == true) {
if($_SERVER['REQUEST_METHOD'] != 'POST'){
?>    
    <form id="form-test" class="form-horizontal" method="POST" action="">
        <div>
                <div>
                    <input required type="text" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" name="threadTitle" placeholder="Título da pergunta" value="">
                </div>
            </div>

            <div>                                        
                <div>
                    <textarea required class="
        form-control
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
        focus:text-gray-700 focus:bg-white focus:border-green-600 focus:outline-none
      " name="post" placeholder="Digite o sua pergunta!" value=""></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="create-thread-btn">
                    <button type="submit" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700">Publicar</button>
                </div>
            </div>
        </form>
    
<?php    
}else{

    $conn = connect_db();
    $stmt = mysqli_stmt_init($conn);

    /* open transaction*/
    mysqli_begin_transaction($conn);

    try {
        mysqli_stmt_prepare($stmt, "INSERT INTO forum_thread (thread_subject, account_id, username)
                                    VALUES (? , ? , ? )");
        $thread_subject = $_POST["threadTitle"];
        $account_id = $user_id;
        $username = $user_name;

        /* bind parameters for markers */
        mysqli_stmt_bind_param($stmt, "sis", $thread_subject, $account_id, $username);

        /* execute query */
        mysqli_stmt_execute($stmt);

        /* fetch value */
        mysqli_stmt_fetch($stmt);

        /* close statement */
        mysqli_stmt_close($stmt);

        $stmt = mysqli_stmt_init($conn);

        mysqli_stmt_prepare($stmt, "INSERT INTO post (content, account_id, username, thread_id, first_post)
                                VALUES (? , ? , ? , ? , TRUE )");
        $content = $_POST["post"];
        $account_id = $user_id;
        $username = $user_name;
        $thread_id = mysqli_insert_id($conn);

        mysqli_stmt_bind_param($stmt, "sisi", $content, $account_id, $username, $thread_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        /* commit transaction */
        mysqli_commit($conn);

    } catch (mysqli_sql_exception $exception) {
        mysqli_rollback($conn);

        throw $exception;
    }

    mysqli_close($conn);
}
?>
<?php } else { ?>

<div>
  Você precisa estar logado para adicionar uma resposta!
</div>

<?php
}
include "footer.php";
?>