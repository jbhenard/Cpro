<?php
session_start();
if(!isset($_SESSION['google_data'])):header("Location:index.php");endif;
?>
<html>
<?php include('../vue/cpro/instic_menu_haut.php') ?>

<style type="text/css">
h1
{
font-family:Arial, Helvetica, sans-serif;
color:#999999;
}
.wrapper{width:600px; margin-left:auto;margin-right:auto;}
.welcome_txt{
	margin: 20px;
	background-color: #EBEBEB;
	padding: 10px;
	border: #D6D6D6 solid 1px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
}
.google_box{
	margin: 20px;
	background-color: #FFF0DD;
	padding: 10px;
	border: #F7CFCF solid 1px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
}
.google_box .image{ text-align:center;}
</style>

<!-- Bootstrap -->
<!--<link href="http://cpro.jbh/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="http://cpro.jbh/css/bootstrap.min.css" rel="stylesheet"> 

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body class="home page page-id-2 page-template page-template-tpl-home page-template-tpl-home-php custom-background boxed guru-child">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cpro.jbh/js/jquery-3.1.0.min.js"></script>
<script src="http://cpro.jbh/js/jquery-ui.js"></script>
<script src="http://cpro.jbh/js/bootstrap.min.js"></script>

<div class="main-content">
    <!-- wrapper div starts here -->
    <div id="wrapper">        
       <div class="main-content">
	<!-- wrapper div starts here -->
    <div id="wrapper">
    
		            <div class="top-bar">
                <div class="container">
                	<div class="float-left">
		<a href="http://www.instic.fr/wp-content/uploads/Dossier-de-candidature-INSTIC.pdf">Télécharger notre dossier d'inscription.</a>
		</div>
                	<div class="float-right"></div>
                </div>
            </div>
   
  		<?php include('../vue/cpro/instic_menu_flottant.php') ?>
  		
  		<!-- content starts here -->
        <div class="content">
            <div style="background-color:#ffffff;">
                <section class="content-full-width" id="primary">
                    <article id="post-2" class="post-2 page type-page status-publish hentry">

                    <div  class='column dt-sc-full-width  first' style="background-color:#ffffff;">

                    </div>
                    <div class='dt-sc-hr '></div>

                        <div><h3 style="text-align: center;"></h3></div>

                        <div><h3 style="text-align:center;">Page d'accueil</h3>
                        	<header id="main-content-header" class="clearfix">                        
							<div id="tasks">
								<ul class="nav nav-tabs">		
		<li role="presentation"><a href="http://cpro.jbh/cpro.php">Se connecter</a></li>
		<li role="presentation"><a href="http://cpro.jbh/GoogleLogin/index.php"><img src="../../images/google2.png"></a></li>
		<li role="presentation" class="active"><a href="http://cpro.jbh/FacebookLogin/index.php"><img src="../../images/facebook2.png"></a></li>
		<li role="presentation"><a href="http://cpro.jbh/controleur/cpro/controleurCNC.php">Cr&eacute;er un espace candidat</a></li>      
		<li role="presentation"><a href="http://cpro.jbh/controleur/cpro/controleurMDP.php">Demander un nouveau MdP</a></li>      
								</ul>
							</div>  
							</header>           
                        </div>
                        
                        <div  class='column dt-sc-one-third  '><h3 style="text-align: center;"></h3></div>

                        <div  class='column dt-sc-full-width  first' style="background-color:#ffffff;"></div>
                        <div class='dt-sc-hr '></div>
                        
                        <div   style="background-color:#ffffff;">

                        <div>
  		
  		<!-- Code JB HENARD -->     
 
<div class="wrapper" style="background-color:black;">
    <h1 style="color:back;">Google Profile Details </h1>
    <?php
    echo '<div class="welcome_txt">Welcome <b>'.$_SESSION['google_data']['given_name'].'</b></div>';
    echo '<div class="google_box">';
    echo '<p class="image"><img src="'.$_SESSION['google_data']['picture'].'" alt="" width="300" height="220"/></p>';
    echo '<p><b>Google ID : </b>' . $_SESSION['google_data']['id'].'</p>';
    echo '<p><b>Name : </b>' . $_SESSION['google_data']['name'].'</p>';
    echo '<p><b>Email : </b>' . $_SESSION['google_data']['email'].'</p>';
    echo '<p><b>Gender : </b>' . $_SESSION['google_data']['gender'].'</p>';
    echo '<p><b>Locale : </b>' . $_SESSION['google_data']['locale'].'</p>';
    echo '<p><b>Google+ Link : </b>' . $_SESSION['google_data']['link'].'</p>';
    echo '<p><b>You are login with : </b>Google</p>';
    echo '<p><b>Logout from <a href="logout.php?logout">Google</a></b></p>';
    echo '</div>';
    ?>
</div>

 <!-- Fin code JB HENARD -->                                                
                                                
                        </div>

                        <div class='dt-sc-hr '></div>
                        <div  class='column dt-sc-three-fourth  first' style="color: black;"><h4>INSTIC</h4>
                        <h5>Institut sup&eacute;rieur des techniques industrielles et de la communication</h5>
                        <address>99 Rue de Gerland, 69007 Lyon  04.72.72.01.01 &#8211; messages@instic.fr  www.instic.fr</address>
                        <p>&nbsp;</p></div>
                        <div  class='column dt-sc-one-second' style="color: black;">
                        <h4>
                        <font><font><font><font><font><font><font><font><font><font>REJOIGNEZ-NOUS !</font></font></font></font></font></font></font></font></font></font>
                        </h4>
                        <p><font><font><ul class='social-media'><li><a href="https://www.facebook.com/insticformation" onclick="_gaq.push(['_trackEvent', 'outbound-article', 'https://www.facebook.com/insticformation', '']);" class='fa fa-facebook'></a></li><li><a href="https://twitter.com/instic_ecole?lang=fr" onclick="_gaq.push(['_trackEvent', 'outbound-article', 'https://twitter.com/instic_ecole?lang=fr', '']);" class='fa fa-twitter'></a></li><li><a href="https://www.linkedin.com/company/instic" onclick="_gaq.push(['_trackEvent', 'outbound-article', 'https://www.linkedin.com/company/instic', '']);" class='fa fa-linkedin'></a></li><li><a href="https://plus.google.com/u/0/+InsticFr" onclick="_gaq.push(['_trackEvent', 'outbound-article', 'https://plus.google.com/u/0/+InsticFr', '']);" class='fa fa-google-plus'></a></li></ul><p class='social-media-text'>Suivez INSTIC&nbsp;!
                        </p></font></font></p>
                        </div>
                        
                        //Début icônes
						 
                        //Fin icônes
                        
                        <div class="social-bookmark"></div>
                        </article>
                </section>
            </div>
        </div>
        
        <!-- content ends here -->       
</div>
</div>

<script src="http://cpro.jbh/dist/jquery.inputmask.bundle.js"></script>  

<script>
    $(document).ready(function(){
        $(":input").inputmask();

        $("#submitCNC").click(function(){
            alert ('CNC activé infos JS!');    
            var choixsubmit = 'submitCNC';
            window.location.href = "../../controleur/cpro/controleurCNC.php?submitCNC=" + choixsubmit; 
        });
    });
</script>
<!-- JBH debut -->
        
<?php include('../vue/cpro/instic_menu_bas.php') ?>

</body>
</html>