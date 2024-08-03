<?php
// Початок сесії


// Перевірка, чи авторизований користувач з логіном "admin"
if(isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
?>

<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><h2><?php echo $_SESSION['username'];?></h2></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 admin-nav">
      	<li class="nav-item dropdown">
      	          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      	            Редагування завдань
      	          </a>
      	          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
      	            <li><a class="dropdown-item" href="admin.php">Додавання програм</a></li>
      	            <li><a class="dropdown-item" href="taskgrup.php">Формування завдань</a></li>
      	            <li><a class="dropdown-item" href="tasklist.php">Завдання для класу</a></li>
      	          </ul>
      	        </li>
      	<li><a href="admin_task_list.php">Сторінка учня з завданнями</a></li>
      	<li><a href="result_admin.php">Результати учнів</a></li>
      	<li><a href="index.php">Головна</a></li>
      </ul>
    </div>
  </div>
</nav>

<?php
}
else if(isset($_SESSION['username'])) {
	?>
	<nav class="navbar navbar-expand-lg navbar-light ">
	  <div class="container-fluid">
	    <a class="navbar-brand" href="#"><?php echo $_SESSION['username'];?></a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	      <ul class="navbar-nav me-auto mb-2 mb-lg-0 admin-nav">
	      	<li><a href="index.php">Головна</a></li>
	      	<li><a href="user_task_list.php">Сторінка учня з завданнями</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<?php
}
else {
	?>
	<nav class="navbar navbar-expand-lg navbar-light ">
	  <div class="container-fluid">
	    <a class="navbar-brand" href="#"><h2>Shleif School</h2></a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    	<ul class="navbar-nav me-auto mb-2 mb-lg-0 admin-nav">
	    		<li><a href="index.php">Головна</a></li>
	    	</ul>
	    </div>
	  </div>
	</nav>
	<?php
}
?>


