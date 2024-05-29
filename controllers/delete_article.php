<?php
include_once '../includes/db_connect.php'; // Database connection
include_once '../models/Article.php'; // Article model

session_start();

// Checking if the user is logged in and if the article ID is provided
if (isset($_SESSION['user_id']) && isset($_GET['article_id'])) {
  // Getting the user ID and article ID
  $user_id = $_SESSION['user_id'];
  $article_id = $_GET['article_id'];

  // Creating an instance of the Article model
  $articleModel = new Article($conn);

  // Calling the deleteArticle method of the Article model
  if ($articleModel->deleteArticle($user_id, $article_id)) {
      echo "<script type='text/javascript'>alert('Articolo rimosso con successo.');
              window.location.href = '../views/profilo.php';  
            </script>";
  } else {
      echo "<script type='text/javascript'>alert('Errore nella rimozione dell'articolo. Controlla se hai i permessi.');
              window.location.href = '../views/profilo.php';  
            </script>";
      exit();
  }
} else {
  echo "<script type='text/javascript'>alert('Utente non connesso o ID dell'articolo non fornito');
          window.location.href = '../views/profilo.php';  
        </script>";
  exit();
}
?>