<?php
// Starting a session
session_start();

// Include necessary files
include_once '../models/User.php'; // Include the User model
include_once '../includes/db_connect.php'; // Include the database connection

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username and password
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "Errore: Le password non coincidono.";
        exit;
    }

    // Check if user already exists
    $user = new User($conn); // Create a new User object
    if ($user->userExists($username)) {
        echo "Errore: L'utente esiste gi&agrave;.";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $inserted = $user->insertUser($username, $hashedPassword);

    // Check for successful insertion
    if ($inserted) {
        // Inserting the username in the created session
        $_SESSION['username'] = $username;
        echo "<script type='text/javascript'>alert('Utente registrato correttamente.');</script>";
    } else {
        echo "<script type='text/javascript'>alert('Errore durante la registrazione dell'utente.');</script>";
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <link rel="stylesheet" href="../assets/styles/styles.css">
  <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <title>Progetto Eco</title>
</head>
<body>
  
  <!--==================== HEADER ====================-->
  <header class="header" id="header">
    <nav class="nav container">
      <a href="../index.php" class="nav__logo" style="display: flex; align-items: center;">
        <img src="../assets/images/logo.png" alt="logo" draggable="false" style="height: 40px; width: 40px; margin-right: 15px;">
        <p>Progetto Eco</p>
      </a>
      <div class="nav__menu" id="nav-menu">
        <ul class="nav__list">
          <li class="nav__item" id="home">
            <a href="../index.php" class="nav__link">Home</a>
          </li>

          <li class="nav__item" id="articoli">
            <a href="listaArticoli.php" class="nav__link">Articoli</a>
          </li>

          <li class="nav__item" id="crea">
            <a href="crea.php" class="nav__link">Crea</a>
          </li>

          <li class="nav__item" id="chisiamo">
            <a href="chisiamo.php" class="nav__link">Chi siamo</a>
          </li>
        </ul>

        <!-- Close button -->
        <div class="nav__close" id="nav-close">
          <i class="ri-close-line"></i>
        </div>
      </div>

      <div class="nav__actions">
        <!-- Search button -->
        <i class="ri-search-line nav__search" id="search-btn"></i>

        <!-- Login button -->
        <i class="ri-user-line nav__login" id="login-btn"></i>

        <!-- Toggle button -->
        <div class="nav__toggle" id="nav-toggle">
          <i class="ri-menu-line"></i>
        </div>
      </div>
    </nav>
  </header>

  <!--==================== SEARCH ====================-->
  <div class="search" id="search">
    <form action="" class="search__form">
      <i class="ri-search-line search__icon"></i>
      <input type="search" placeholder="Cosa stai cercando?" class="search__input">
    </form>

    <i class="ri-close-line search__close" id="search-close"></i>
  </div>

  <!--==================== LOGIN ====================-->
  <div class="login" id="login">
    <form action="../controllers/login.php" name="login_form" method="POST" class="login__form">
      <h2 class="login__title">Accedi</h2>
      
      <div class="login__group">
        <div>
          <label for="username" class="login__label">Nome utente</label>
          <input type="text" name="username" placeholder="Inserisci il tuo username" id="username" class="login__input" required>
        </div>
          
        <div>
          <label for="password" class="login__label">Password</label>
          <input type="password" name="password" placeholder="Inserisci la tua password" id="password" class="login__input" required>
        </div>
      </div>

      <div>
        <!--
        <p class="login__signup">
          Non hai ancora creato un account? <a href="registrati.php">Registrati</a>
        </p>
        <a href="#" class="login__forgot">
          Password dimenticata?
        </a> -->

        <button type="submit" class="login__button">Accedi</button>
      </div>
    </form>

    <i class="ri-close-line login__close" id="login-close"></i>
  </div>
  
  <div style="width: 100%; height: 150px;"></div>

  <!--==================== SIGNUP ====================-->
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="login__form">
    <h2 class="login__title">Registrati</h2>
    
    <div class="login__group">
      <div>
        <label for="username" class="login__label">Nome utente</label>
        <input type="text" placeholder="Inserisci il tuo username" id="username" name="username" class="login__input" required>
      </div>
        
      <div>
        <label for="password" class="login__label">Password</label>
        <input type="password" placeholder="Inserisci una password" name="password" class="login__input" required>
      </div>

      <div>
        <label for="confirm_password" class="login__label">Conferma password</label>
        <input type="password" placeholder="Inserisci la stessa password" name="confirm_password" class="login__input" required>
      </div>
    </div>

    <button type="submit" class="login__button">Registrati</button>
  </form>

  <!--==================== FOOTER ====================-->
  <?php @include("../includes/footer.html"); ?>
  </main>

  <!--=============== MAIN JS ===============-->
  <script src="../assets/main.js"></script>  
</body>
</html>