<!DOCTYPE html>
<html>
	<head>
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="edit.css" />
	</head>
	<body>
		<header>
		<h1><?php echo $header ?></h1>
		</header>
		
		<nav>
			<div class="nav1">
				<ul>
					<li><a href="/index">Home</a></li>
					
					<li><a href="">Categories</a>
						<ul class="ul_sub">		
							<li><a href="displaycat">Display Categories</a></li>
							<?php 
							if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
							echo '<li><a href="addcat">Add Category</a></li>';
							} 
							?>         
						</ul>
					</li>

					<li><a href="">Articles</a>
						<ul class="ul_sub">
							<li><a href="listarticle">Display Articles</a></li>
							<?php 
							if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
							echo '<li><a href="addarticle">Add Articles</a></li>';
							}
							?>
						</ul>
					</li>
				
				<?php 
					if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
					echo '<li><a href="">Admin Area</a>
						<ul class="ul_sub">
							<li><a href="addcat">Add Category</a></li>
							<li><a href="addarticle">Add Article</a></li>
							<li><a href="addadmin">Create Admin</a></li>
							<li><a href="viewadmin">View All Admin</a></li>
							<li><a href="viewlog">View Site Log</a></li>
							';
						echo '</ul></li>';
						}
						?>
					</li>
					
					<li><?php 
					if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
						echo'<li><form action="logout" method="POST" >
						<input type="submit" name="submit" value="Logout" style="width: 130px; height: 40px; ">
						</form></li>';
						} else {
						echo '<li><a href="login">Login</a></li>';
						};
						?> 
					</li>
				</ul>
			</div>
		</nav>
		
		<main>
			<?php echo $content; ?>
		</main>
		<!-- These links are provided from https://simplesharebuttons.com/html-share-buttons/ -->
			<div class="social_media">	
				 <a href="http://www.facebook.com/sharer.php?u=http://192.168.56.2/ target="_blank">
					<img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" />
				</a>
				
				<a href="mailto:?Subject=Blog : Articles&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 http://192.168.56.2/">
					<img src="https://simplesharebuttons.com/images/somacro/email.png" alt="Email" />
				</a>
			
				<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://192.168.56.2/" target="_blank">
					<img src="https://simplesharebuttons.com/images/somacro/linkedin.png" alt="LinkedIn" />
				</a>
				
				<a href="https://plus.google.com/share?url=http://192.168.56.2/" target="_blank">
					<img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" />
				</a>
			</div>
		<footer>
			<p>&copy; Mehul Chamunda 2015/2016 - 14406068 PHP & MySQL Assignment 2<p>
		</footer>
	</body>
</html>