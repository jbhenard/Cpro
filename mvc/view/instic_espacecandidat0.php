<?php
session_start();

// Tableau contenant les messages d'erreur lies a la validation de chaque
// champ du formulaire.
// On utilisera le nom du champ comme cle du tableau
$errsCEC = array();
$errsFE = array(); //Formation(s) envisagée(s)
$parametres = array();

//Connexion à la base
include_once '../model/connexion_sql.php';

if (isset($_SESSION['user'])) $user=$_SESSION['user'];
else $user='';

//======================================================================================================
//Select Formation(s) envisagee(s)
//======================================================================================================
    $reponseFE = $bdd->query("SELECT * FROM personnefe WHERE user = '$user' AND active='Oui' ORDER BY clef DESC LIMIT 1;") or die('Erreur SELECT !');
    //echo 'rt= '.$reponseEC->rowCount();
       if ($reponseFE->rowCount() == 1) {
            $rowFE = $reponseFE->fetch(PDO::FETCH_ASSOC);
            $formationenvisagees=$rowFE['formationenvisagees'];            
            $active=$rowFE['active'];            


            $tabchoix=explode("-", $formationenvisagees);
            $tabchoix2=array();
            $nbchoix=substr_count($formationenvisagees,'-');            

            //echo "nb choix= ".$nbchoix;

            foreach ($tabchoix as $value) {
               // echo "<br/>". $value;
                $tabchoix2[$value][0]=$value;                
                //echo "<br/> tab2['$value'][0]= ".$tabchoix2[$value][0];               
            }

            //foreach ($tabchoix2 as $key => $value) {
            //    echo "<br/> clef = ".$key;            
            //
            //if (!empty($tabchoix2['l3choix2'][0]))  echo "<br/> tab2['l3choix2'][0]= ".$tabchoix2['l3choix2'][0];
        }
//foreach ($tabchoix2 as $champs) {
  //  foreach ($champs as $valeur) {
    //   echo "<br/> tab2[?][0]= ".$valeur;        
    //}   
//}

//echo "<br/> tab2[][1]= ".$tabchoix2[][0];       
       else {
            $formationenvisagees='';            
            $active='';
       }



//======================================================================================================
// Submit Création espace Candidat
//======================================================================================================
// S'il s'agit du premier affichage, le bouton submit n'a pas ete presse
// il n'y a pas de validation a effectuer. Sinon $_POST["submit"] n'est pas
// vide (et contient la valeur "Enregistrer")
if (!empty($_POST["submit"]) > 0) {

    if (empty($_POST["titre"])) $errsCEC["titre"][] = "Veuillez renseigner le Titre!";
    if (empty($_POST["nom"])) $errsCEC["nom"][] = "Veuillez renseigner le Nom!";
    if (empty($_POST["prenom"])) $errsCEC["prenom"][] = "Veuillez renseigner le Prénom!";
    if (empty($_POST["mail"])) $errsCEC["mail"][] = "Veuillez renseigner l'Adresse de courriel!";
    if (empty($_POST["mdp1"])) $errsCEC["mdp1"][] = "Veuillez renseigner le mot de passe!";
    if (empty($_POST["mdp2"])) $errsCEC["mdp2"][] = "Veuillez renseigner le mot de passe de confirmation!";

    $email=$_POST["mail"];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        //L'email n'est pas bonne.
        $errsCEC["verifmmail"][] = "Veuillez renseigner une Adresse de courriel valide!";
    }

    $mdp1=$_POST['mdp1'];
    $mdp2=$_POST['mdp2'];
	//echo "<br/> Mdp1 saisi= ".$mdp1."<br/>";    
	//echo "<br/> Mdp2 saisi= ".$mdp2."<br/>";

    if ($mdp1 != $mdp2)  {
        $errsCEC["Mdp"][] = "Veuillez saisir des mots de passes identiques!";
    }

    if (count($errsCEC) == 0) {
        // Les données du formulaires ont été validée (pas d'erreur trouvée)
        // faire ce qui doit être fait (envoi de mail, enregistrement en base)
        // et rediriger vers la page suivante
        $titre=$_POST['titre'];
        //echo $titre."<br/>";
        $nom=$_POST['nom'];
        //echo $nom."<br/>";
        $prenom=$_POST['prenom'];
        //echo $prenom;
        $user=$_POST['mail'];
        //echo "<br/>".$user;
        
		//Méthode $_GET ci-après
		$_SESSION['mdp']=$mdp1;
        header("Location: http://localhost/cpro_dev/register.php?titre=$titre&nom=$nom&prenom=$prenom&mail=$user&mdp1=$mpd1");
	 	//header("Location: http://localhost/cpro_dev/instic_creationcompte.php?");
        die();
    }
}



//======================================================================================================
// Submit Formation(s) envisagée(s)
//======================================================================================================
if (!empty($_POST["submitFE"]) > 0) {
    //echo " FE appuyée!";
    $choix='';
    if (!empty($_POST["l1choix1"])) $choix.='l1choix1-';
    if (!empty($_POST["l1choix2"])) $choix.='l1choix2-';

    if (!empty($_POST["l2choix1"])) $choix.='l2choix1-';
    if (!empty($_POST["l2choix2"])) $choix.='l2choix2-';

    if (!empty($_POST["l3choix1"])) $choix.='l3choix1-';
    if (!empty($_POST["l3choix2"])) $choix.='l3choix2-';

    if (!empty($_POST["l4choix1"])) $choix.='l4choix1-';
    if (!empty($_POST["l4choix2"])) $choix.='l4choix2-';

    if (!empty($_POST["l5choix1"])) $choix.='l5choix1-';
    if (!empty($_POST["l5choix2"])) $choix.='l5choix2-';

    if (!empty($_POST["l6choix1"])) $choix.='l6choix1-';
    if (!empty($_POST["l6choix2"])) $choix.='l6choix2-';

    if (!empty($_POST["l7choix1"])) $choix.='l7choix1-';
    if (!empty($_POST["l7choix2"])) $choix.='l7choix2-';
    
    if (!empty($_POST["l8choix1"])) $choix.='l8choix1-';
    if (!empty($_POST["l8choix2"])) $choix.='l8choix2-';

    if (!empty($_POST["l9choix1"])) $choix.='l9choix1-';
    if (!empty($_POST["l9choix2"])) $choix.='l9choix2-';

    if (!empty($_POST["l10choix1"])) $choix.='l10choix1-';
    if (!empty($_POST["l10choix2"])) $choix.='l10choix2-';

    if ($choix == '') $errsFE["l1choix1"][] = "Veuillez renseigner une ou des formation(s)!";
    else {
        //echo "choix= ".$choix;
        $parametres['FE']['nom']=$nom;
        $parametres['FE']['prenom']=$prenom;
        $parametres['FE']['email']=$user;
        
        $_SESSION['tab']=$parametres;
        $_SESSION['choix']=$choix;
        //Méhode $_GET ci-après
        header("Location: http://localhost/cpro_dev/registerFE.php");
        die();
    };

}


?>
<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="ie ie6 lte9 lte8 lte7" lang="fr-FR" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 7]>     <html class="ie ie7 lte9 lte8 lte7" lang="fr-FR" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 8]>     <html class="ie ie8 lte9 lte8" lang="fr-FR" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if IE 9]>     <html class="ie ie9 lte9" lang="fr-FR" prefix="og: http://ogp.me/ns#"> <![endif]-->
<!--[if gt IE 9]>  <html> <![endif]-->
<!--[if !IE]><!--> <html lang="fr-FR" prefix="og: http://ogp.me/ns#"> <!--<![endif]-->
<head>
    <meta charset="UTF-8" />
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1' />

    <meta name="author" content="designthemes"/>

    <!--[if lt IE 9]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->

    <title>INSTIC - Institut supérieur des techniques industrielles et de la communication</title>

    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.instic.fr/feed" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="http://www.instic.fr/xmlrpc.php" />

    <link href='http://www.instic.fr/wp-content/uploads/2015/01/favicon.png' rel='shortcut icon' type='image/x-icon' />
    <link href='http://www.instic.fr/wp-content/themes/guru/images/apple-touch-icon.png' rel='apple-touch-icon-precomposed'/>
    <link href='http://www.instic.fr/wp-content/themes/guru/images/apple-touch-icon-114x114.png' sizes='114x114' rel='apple-touch-icon-precomposed'/>
    <link href='http://www.instic.fr/wp-content/themes/guru/images/apple-touch-icon-72x72.png' sizes='72x72' rel='apple-touch-icon-precomposed'/>
    <link href='http://www.instic.fr/wp-content/themes/guru/images/apple-touch-icon-144x144.png' sizes='144x144' rel='apple-touch-icon-precomposed'/>
    <style type="text/css">@media only screen and (max-width:320px), (max-width: 479px), (min-width: 480px) and (max-width: 767px), (min-width: 768px) and (max-width: 959px),
    (max-width:1200px) { .banner { display:none !important; } }</style>
    <script type='text/javascript'>
        var mytheme_urls = {
            theme_base_url:'http://www.instic.fr/wp-content/themes/guru/'
            ,framework_base_url:'http://www.instic.fr/wp-content/themes/guru/framework/'
            ,ajaxurl:'http://www.instic.fr/wp-admin/admin-ajax.php'
            ,url:'http://www.instic.fr'
            ,stickynav:'disable'
            ,scroll:'enable'
        };
    </script>

    <!-- This site is optimized with the Yoast SEO plugin v3.3.4 - https://yoast.com/wordpress/plugins/seo/ -->
    <meta name="description" content="INSTIC : Institut supérieur des techniques industrielles et de la communication. Vous êtes étudiants et souhaitez vous former en alternance ou en initiale."/>
    <meta name="robots" content="noodp"/>
    <link rel="canonical" href="http://www.instic.fr/" />
    <meta property="og:locale" content="fr_FR" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="INSTIC - Institut supérieur des techniques industrielles et de la communication" />
    <meta property="og:description" content="INSTIC : Institut supérieur des techniques industrielles et de la communication. Vous êtes étudiants et souhaitez vous former en alternance ou en initiale." />
    <meta property="og:url" content="http://www.instic.fr/" />
    <meta property="og:site_name" content="INSTIC" />
    <meta property="og:image" content="http://www.instic.fr/wp-content/uploads/offe-alternance.png" />
    <meta property="og:image" content="http://www.instic.fr/wp-content/uploads/formations-INSTIC.png" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="INSTIC : Institut supérieur des techniques industrielles et de la communication. Vous êtes étudiants et souhaitez vous former en alternance ou en initiale." />
    <meta name="twitter:title" content="INSTIC - Institut supérieur des techniques industrielles et de la communication" />
    <meta name="twitter:site" content="@instic_ecole" />
    <meta name="twitter:image" content="http://www.instic.fr/wp-content/uploads/offe-alternance.png" />
    <meta name="twitter:creator" content="@instic_ecole" />
    <script type='application/ld+json'>{"@context":"http:\/\/schema.org","@type":"WebSite","url":"http:\/\/www.instic.fr\/","name":"INSTIC","potentialAction":{"@type":"SearchAction","target":"http:\/\/www.instic.fr\/?s={search_term_string}","query-input":"required name=search_term_string"}}</script>
    <!-- / Yoast SEO plugin. -->

    <link rel="alternate" type="application/rss+xml" title="INSTIC &raquo; Flux" href="http://www.instic.fr/feed" />
    <link rel="alternate" type="application/rss+xml" title="INSTIC &raquo; Flux des commentaires" href="http://www.instic.fr/comments/feed" />
    <script type="text/javascript">
        window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/72x72\/","ext":".png","source":{"concatemoji":"http:\/\/www.instic.fr\/wp-includes\/js\/wp-emoji-release.min.js?ver=931338860a52f1d30c1477a93366f485"}};
        !function(a,b,c){function d(a){var c,d,e,f=b.createElement("canvas"),g=f.getContext&&f.getContext("2d"),h=String.fromCharCode;if(!g||!g.fillText)return!1;switch(g.textBaseline="top",g.font="600 32px Arial",a){case"flag":return g.fillText(h(55356,56806,55356,56826),0,0),f.toDataURL().length>3e3;case"diversity":return g.fillText(h(55356,57221),0,0),c=g.getImageData(16,16,1,1).data,d=c[0]+","+c[1]+","+c[2]+","+c[3],g.fillText(h(55356,57221,55356,57343),0,0),c=g.getImageData(16,16,1,1).data,e=c[0]+","+c[1]+","+c[2]+","+c[3],d!==e;case"simple":return g.fillText(h(55357,56835),0,0),0!==g.getImageData(16,16,1,1).data[0];case"unicode8":return g.fillText(h(55356,57135),0,0),0!==g.getImageData(16,16,1,1).data[0]}return!1}function e(a){var c=b.createElement("script");c.src=a,c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var f,g,h,i;for(i=Array("simple","flag","unicode8","diversity"),c.supports={everything:!0,everythingExceptFlag:!0},h=0;h<i.length;h++)c.supports[i[h]]=d(i[h]),c.supports.everything=c.supports.everything&&c.supports[i[h]],"flag"!==i[h]&&(c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&c.supports[i[h]]);c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&!c.supports.flag,c.DOMReady=!1,c.readyCallback=function(){c.DOMReady=!0},c.supports.everything||(g=function(){c.readyCallback()},b.addEventListener?(b.addEventListener("DOMContentLoaded",g,!1),a.addEventListener("load",g,!1)):(a.attachEvent("onload",g),b.attachEvent("onreadystatechange",function(){"complete"===b.readyState&&c.readyCallback()})),f=c.source||{},f.concatemoji?e(f.concatemoji):f.wpemoji&&f.twemoji&&(e(f.twemoji),e(f.wpemoji)))}(window,document,window._wpemojiSettings);
    </script>
    <style type="text/css">
        img.wp-smiley,
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 .07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }
    </style>
    <link rel='stylesheet' id='dt-sc-css-css'  href='http://www.instic.fr/wp-content/plugins/designthemes-core-features/shortcodes/css/shortcodes.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='dt-animations-css'  href='http://www.instic.fr/wp-content/plugins/designthemes-core-features/page-builder/css/animations.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='lptw-style-css'  href='http://www.instic.fr/wp-content/plugins/advanced-recent-posts/lptw-recent-posts.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='contact-form-7-css'  href='http://www.instic.fr/wp-content/plugins/contact-form-7/includes/css/styles.css?ver=4.4.2' type='text/css' media='all' />
    <link rel='stylesheet' id='responsive_map_css-css'  href='http://www.instic.fr/wp-content/plugins/responsive-maps-plugin/includes/css/rsmaps.css?ver=2.22' type='text/css' media='all' />
    <link rel='stylesheet' id='chosen-css'  href='http://www.instic.fr/wp-content/plugins/wp-job-manager/assets/css/chosen.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='wp-job-manager-frontend-css'  href='http://www.instic.fr/wp-content/plugins/wp-job-manager/assets/css/frontend.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='default-css'  href='http://www.instic.fr/wp-content/themes/guru-child/style.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='shortcode-css'  href='http://www.instic.fr/wp-content/themes/guru/css/shortcode.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='skin-css'  href='http://www.instic.fr/wp-content/themes/guru/skins/dark-blue/style.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='animations-css'  href='http://www.instic.fr/wp-content/themes/guru/css/animations.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='menumenu-css'  href='http://www.instic.fr/wp-content/themes/guru/css/meanmenu.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='isotope-css'  href='http://www.instic.fr/wp-content/themes/guru/css/isotope.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='prettyphoto-css'  href='http://www.instic.fr/wp-content/themes/guru/css/prettyPhoto.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='style.fontawesome-css'  href='http://www.instic.fr/wp-content/themes/guru/css/font-awesome.min.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='responsive-css'  href='http://www.instic.fr/wp-content/themes/guru/css/responsive.css?ver=931338860a52f1d30c1477a93366f485' type='text/css' media='all' />
    <link rel='stylesheet' id='mytheme-google-fonts-css'  href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Droid+Serif:400,400italic,700,700italic|Pacifico|Patrick+Hand|Crete+Round:400' type='text/css' media='all' />
    <link rel="stylesheet" type="text/css" href="http:///localhost/cpro_dev/styleinstic.css"/>

    <!-- This site uses the Google Analytics by MonsterInsights plugin v5.5.2 - Universal disabled - https://www.monsterinsights.com/ -->
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-41384789-3']);
        _gaq.push(['_gat._forceSSL']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <!-- / Google Analytics by MonsterInsights -->
    <!--[if IE]>
    <style type="text/css" media="screen">
        .rounded, #secondary .testi-author img, .menu-thumb .rounded img, .dt-sc-pr-tb-col .dt-sc-rounded, .dt-sc-progress, .dt-sc-progress .dt-sc-bar {
            behavior: url(http://www.instic.fr/wp-content/themes/guru/PIE.php);
        }
    </style>
    <![endif]-->
    <script type='text/javascript' src='http://www.instic.fr/wp-includes/js/jquery/jquery.js?ver=1.12.4'></script>
    <script type='text/javascript' src='http://www.instic.fr/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1'></script>
    <script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/modernizr-2.6.2.min.js?ver=931338860a52f1d30c1477a93366f485'></script>

    <style type="text/css">
        body { background-repeat:no-repeat;background-color:rgba(216,216,216,0.5); }
        body {color:#000000; font-size:14px; }
        a { color:#009ee3; }a:hover { color:#009fe3; }H1 {color:#009ee3; font-size:24px; }
        H2 {color:#29547d; font-size:18px; }
        H3 {color:#000000; font-size:18px; }
        H4 {color:#000000; font-size:16px; }
        H5 {color:#0a0a0a; font-size:16px; }
        H6 {color:#29547d; font-size:16px; }
        .top-bar { background-color: #000000; }
        .blanc {color:#ffffff; }
    </style>
    <link rel='https://api.w.org/' href='http://www.instic.fr/wp-json/' />
    <link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://www.instic.fr/xmlrpc.php?rsd" />
    <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://www.instic.fr/wp-includes/wlwmanifest.xml" />

    <link rel='shortlink' href='http://www.instic.fr/' />
    <link rel="alternate" type="application/json+oembed" href="http://www.instic.fr/wp-json/oembed/1.0/embed?url=http%3A%2F%2Fwww.instic.fr%2F" />
    <link rel="alternate" type="text/xml+oembed" href="http://www.instic.fr/wp-json/oembed/1.0/embed?url=http%3A%2F%2Fwww.instic.fr%2F&#038;format=xml" />
    <script>(function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script><style type="text/css">	.ssba {
    padding: 10px;



}
.ssba img
{
    width: 25px !important;
    padding: 5px;
    border:  0;
    box-shadow: none !important;
    display: inline !important;
    vertical-align: middle;
}
.ssba, .ssba a
{
    text-decoration:none;
    border:0;
    background: none;

    font-size: 	14px;
    color: 		#009fe3!important;
    font-weight: bold;
}
.fb_iframe_widget span { width: 146px !important; }</style><script type="text/javascript">
    (function(url){
        if(/(?:Chrome\/26\.0\.1410\.63 Safari\/537\.31|WordfenceTestMonBot)/.test(navigator.userAgent)){ return; }
        var addEvent = function(evt, handler) {
            if (window.addEventListener) {
                document.addEventListener(evt, handler, false);
            } else if (window.attachEvent) {
                document.attachEvent('on' + evt, handler);
            }
        };
        var removeEvent = function(evt, handler) {
            if (window.removeEventListener) {
                document.removeEventListener(evt, handler, false);
            } else if (window.detachEvent) {
                document.detachEvent('on' + evt, handler);
            }
        };
        var evts = 'contextmenu dblclick drag dragend dragenter dragleave dragover dragstart drop keydown keypress keyup mousedown mousemove mouseout mouseover mouseup mousewheel scroll'.split(' ');
        var logHuman = function() {
            var wfscr = document.createElement('script');
            wfscr.type = 'text/javascript';
            wfscr.async = true;
            wfscr.src = url + '&r=' + Math.random();
            (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(wfscr);
            for (var i = 0; i < evts.length; i++) {
                removeEvent(evts[i], logHuman);
            }
        };
        for (var i = 0; i < evts.length; i++) {
            addEvent(evts[i], logHuman);
        }
    })('//www.instic.fr/?wordfence_logHuman=1&hid=97E3164F75BCA8737DF3080BE9AA4899');
</script><style type="text/css" id="custom-background-css">
    body.custom-background { background-color: #f4f4f4; }
</style>
</head>

<body class="home page page-id-2 page-template page-template-tpl-home page-template-tpl-home-php custom-background boxed guru-child">
<div class="main-content">
    <!-- wrapper div starts here -->
    <div id="wrapper">

        <div class="top-bar">
            <div class="container">
                <div class="float-left">
                    <a href="http://www.instic.fr/?p=6615" title="connexion-digital-learning" target="_blank">Se connecter à la plateforme digital learning</a>                     </div>
                <div class="float-right"></div>
            </div>
        </div>

        <!-- header starts here -->
        <div id="header-wrapper">
            <header>
                <!-- main menu container starts here -->
                <div class="menu-main-menu-container header1">
                    <div class="container">
                        <div id="logo">								<a href="http://www.instic.fr" title="INSTIC">
                            <img class="normal_logo" src="http://www.instic.fr/wp-content/uploads/2015/01/logo-accueil2.png" alt="INSTIC" title="INSTIC" />
                            <img class="retina_logo" src="http://www.instic.fr/wp-content/uploads/2015/01/logo-accueil2.png" alt="INSTIC" title="INSTIC" style="width:174px; height:94px;"/>
                        </a>
                        </div>
                        <div id="primary-menu">
                            <nav id="main-menu"><ul id="menu-main-menu" class="menu"><li id="menu-item-5092" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-depth-0 menu-item-megamenu-parent  megamenu-4-columns-group"><a>L&rsquo;école</a>
                                <div class='megamenu-child-container'>

                                    <ul class="sub-menu">
                                        <li id="menu-item-7629" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-depth-1"><a href="#">Dispositifs</a>
                                            <ul class="sub-menu">
                                                <li id="menu-item-4835" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/presentation-ecole">Carte d&rsquo;identité</a></li>
                                                <li id="menu-item-6198" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/compte-personnel-de-formation-cpf">Compte personnel de formation (CPF)</a></li>
                                                <li id="menu-item-6896" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/digital-learning">Digital Learning</a></li>
                                            </ul>
                                        </li>
                                        <li id="menu-item-7634" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-depth-1"><a href="#">Documentation</a>
                                            <ul class="sub-menu">
                                                <li id="menu-item-5185" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-depth-2"><a href="http://www.instic.fr/wp-content/uploads/le-contrat-de-professionnalisation.pdf" onclick="_gaq.push(['_trackEvent','download','http://www.instic.fr/wp-content/uploads/le-contrat-de-professionnalisation.pdf']);" >Le contrat de professionnalisation</a></li>
                                                <li id="menu-item-5186" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-depth-2"><a href="http://www.instic.fr/wp-content/uploads/demarcher-entreprise.pdf" onclick="_gaq.push(['_trackEvent','download','http://www.instic.fr/wp-content/uploads/demarcher-entreprise.pdf']);" >Comment démarcher une entreprise</a></li>
                                                <li id="menu-item-4863" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/reglement-interieur">Règlement intérieur</a></li>
                                            </ul>
                                        </li>
                                        <li id="menu-item-7630" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-depth-1"><a href="#">Entreprises</a>
                                            <ul class="sub-menu">
                                                <li id="menu-item-4844" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/entreprises-partenaires">Entreprises partenaires</a></li>
                                                <li id="menu-item-7627" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/offres">Offres alternance</a></li>
                                            </ul>
                                        </li>
                                        <li id="menu-item-7631" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-depth-1"><a href="#">Inscription / Demande d&rsquo;info</a>
                                            <ul class="sub-menu">
                                                <li id="menu-item-7119" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/reunions-dinformation">Réunions d&rsquo;information</a></li>
                                                <li id="menu-item-7632" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/dossier-de-candidature">Dossier de candidature</a></li>
                                                <li id="menu-item-5187" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/contact">Contact</a></li>
                                            </ul>
                                        </li>
                                    </ul>

                                </div>
                            </li>
                                <li id="menu-item-16" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-depth-0 menu-item-megamenu-parent  megamenu-4-columns-group"><a href="http://www.instic.fr/formations">Formations</a>
                                    <div class='megamenu-child-container'>

                                        <ul class="sub-menu">
                                            <li id="menu-item-35" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-depth-1"><a href="http://www.instic.fr/pao-infographie-web">PAO / Infographie / Webdesign</a>
                                                <ul class="sub-menu">
                                                    <li id="menu-item-38" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/infographiste-multimedia">Bac +2 Infographiste multimédia</a></li>
                                                    <li id="menu-item-6381" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/cqp-concepteur-realisateur-graphique-2">CQP Concepteur réalisateur graphique</a></li>
                                                    <li id="menu-item-7121" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/reunions-dinformation-infographieweb">Réunions d&rsquo;information Infographie/Web</a></li>
                                                </ul>
                                            </li>
                                            <li id="menu-item-53" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-depth-1"><a href="http://www.instic.fr/developpement-web">Développement Web</a>
                                                <ul class="sub-menu">
                                                    <li id="menu-item-5482" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/bac-2-developpeur-logiciel">Bac +2 Développeur(se) logiciel</a></li>
                                                    <li id="menu-item-44" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/concepteur-developpeur-informatique">Bac +3 Concepteur(trice) développeur(se) informatique</a></li>
                                                    <li id="menu-item-7123" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/reunions-dinformation-infographieweb">Réunions d&rsquo;information Infographie/Web</a></li>
                                                </ul>
                                            </li>
                                            <li id="menu-item-19" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-depth-1"><a href="http://www.instic.fr/cao-dao-design-industriel">CAO / DAO / Design Industriel</a>
                                                <ul class="sub-menu">
                                                    <li id="menu-item-22" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/tscism-technicien-en-conception-industrielle-systemes-mecaniques">Bac +2 Technicien Supérieur en conception industrielle de systèmes mécaniques</a></li>
                                                    <li id="menu-item-5447" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/cqp-dessinateur-bureau-detude">CQP Dessinateur bureau d&rsquo;étude</a></li>
                                                    <li id="menu-item-5557" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/cqp-concepteur-modelisateur-numerique-de-produit-ou-de-systemes-mecaniques">CQP Concepteur modélisateur numérique de produit ou de systèmes mécaniques</a></li>
                                                    <li id="menu-item-7122" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/reunions-information-cao-dao">Réunions d&rsquo;information CAO/DAO</a></li>
                                                </ul>
                                            </li>
                                            <li id="menu-item-57" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-depth-1"><a href="http://www.instic.fr/developpement-durable-qualite-securite-environnement">Dév. durable / Qualité, Sécurité, Environnement</a>
                                                <ul class="sub-menu">
                                                    <li id="menu-item-102" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/bac-3-bachelor-animateur-qualite-securite-environnement">Bac +3 Bachelor Animateur Qualité, Sécurité, Environnement</a></li>
                                                    <li id="menu-item-105" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/bac-5-master-management-operationnel-du-developpement-durable">Bac +5 Master management Opérationnel du Développement durable</a></li>
                                                    <li id="menu-item-111" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/cqp-animateur-hygiene-securite-environnement">CQP Animateur hygiène, sécurité, environnement</a></li>
                                                    <li id="menu-item-7120" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-2"><a href="http://www.instic.fr/reunions-dinformation-qsedev-durable">Réunions d&rsquo;information QSE/Dév. durable</a></li>
                                                </ul>
                                            </li>
                                        </ul>

                                    </div>
                                </li>
                                <li id="menu-item-5093" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-depth-0 menu-item-simple-parent "><a href="http://www.instic.fr/dossier-de-candidature">Inscription</a>


                                    <ul class="sub-menu">
                                        <li id="menu-item-5327" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-1"><a href="http://www.instic.fr/dossier-de-candidature">Dossier de candidature</a></li>
                                        <li id="menu-item-4857" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-1"><a href="http://www.instic.fr/tarifs">Tarifs</a></li>
                                        <li id="menu-item-4866" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-1"><a href="http://www.instic.fr/demande-documentation">Demande de documentation</a></li>
                                        <li id="menu-item-7118" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-1"><a href="http://www.instic.fr/reunions-dinformation">Réunions d&rsquo;information</a></li>
                                    </ul>
                                </li>
                                <li id="menu-item-5095" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-depth-0 menu-item-simple-parent "><a href="http://www.instic.fr/?page_id=4843">Entreprises</a>


                                    <ul class="sub-menu">
                                        <li id="menu-item-7625" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-1"><a href="http://www.instic.fr/offres">Offres alternance</a></li>
                                        <li id="menu-item-7639" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-1"><a href="http://www.instic.fr/deposez-offre-demploi">Déposez votre offre d&#8217;emploi</a></li>
                                    </ul>
                                </li>
                                <li id="menu-item-78" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-0 menu-item-simple-parent "><a href="http://www.instic.fr/contact">Contact</a></li>
                                <li id="menu-item-82" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-depth-0 menu-item-simple-parent "><a href="http://www.instic.fr/blog">Blog</a></li>
                            </ul>                            </nav>
                        </div>
                    </div>
                </div>
                <!-- main menu container ends here -->
            </header>
        </div>
        <!-- header ends here -->

        <!-- content starts here -->
        <div class="content">
            <div class="container">
                <section class="content-full-width" id="primary">
                    <article id="post-2" class="post-2 page type-page status-publish hentry"><div  class='column dt-sc-full-width  first'><aside id="wdslider-1" class="widget  widget_wdslider wdslider"><div class="widget-title"><h3>accueil INSTIC</h3><div class="title-sep"><span></span></div></div><script type='text/javascript' src='http://www.instic.fr/wp-content/plugins/slider-wd/js/jquery.mobile.js?ver=1.1.42'></script>
                        <script type='text/javascript' src='http://www.instic.fr/wp-content/plugins/slider-wd/js/wds_frontend.js?ver=1.1.42'></script>
                        <style>
                            .wds_bigplay_0,
                            .wds_slideshow_image_0,
                            .wds_slideshow_video_0 {
                                display: block;
                            }
                            .wds_bulframe_0 {
                                display: none;
                                background-image: url('');
                                margin: 0px;
                                position: absolute;
                                z-index: 3;
                                -webkit-transition: left 1s, right 1s;
                                transition: left 1s, right 1s;
                                width: 188px;
                                height: 95px;
                            }
                            #wds_container1_0 #wds_container2_0 {
                                text-align: center;
                                margin: 0px ;
                                visibility: hidden;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_image_wrap_0,
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_image_wrap_0 * {
                                box-sizing: border-box;
                                -moz-box-sizing: border-box;
                                -webkit-box-sizing: border-box;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_image_wrap_0 {
                                background-color: rgba(255, 255, 255, 0.00);
                                border-width: 0px;
                                border-style: none;
                                border-color: #000000;
                                border-radius: ;
                                border-collapse: collapse;
                                display: inline-block;
                                position: relative;
                                text-align: center;
                                width: 100%;
                                max-width: 940px;
                                box-shadow: ;
                                overflow: hidden;
                                z-index: 0;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_image_0 {
                                padding: 0 !important;
                                margin: 0 !important;
                                float: none !important;
                                vertical-align: middle;
                                background-position: center center;
                                background-repeat: no-repeat;
                                background-size: cover;
                                width: 100%;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_image_container_0 {
                                display: /*table*/block;
                                position: absolute;
                                text-align: center;
                                none: 0px;
                                vertical-align: middle;
                                width: 100%;
                                height: /*inherit*/100%;
                            }

                            @media only screen and (min-width: 0px) and (max-width: 320px) {
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_thumbnails_0 {
                                    height: 16px;
                                    width: 64px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_0 {
                                    font-size: 12px;
                                    margin: 2px;
                                    width: 12px;
                                    height: 12px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_pp_btn_cont {
                                    font-size: 20px;
                                    height: 20px;
                                    width: 20px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_left_btn_cont,
                                #wds_container1_0 #wds_container2_0 .wds_right_btn_cont {
                                    height: 20px;
                                    font-size: 20px;
                                    width: 20px;
                                }
                            }
                            @media only screen and (min-width: 321px) and (max-width: 480px) {
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_thumbnails_0 {
                                    height: 22px;
                                    width: 88px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_0 {
                                    font-size: 18px;
                                    margin: 2px;
                                    width: 18px;
                                    height: 18px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_pp_btn_cont {
                                    font-size: 30px;
                                    height: 30px;
                                    width: 30px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_left_btn_cont,
                                #wds_container1_0 #wds_container2_0 .wds_right_btn_cont {
                                    height: 30px;
                                    font-size: 30px;
                                    width: 30px;
                                }
                            }
                            @media only screen and (min-width: 481px) and (max-width: 640px) {
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_thumbnails_0 {
                                    height: 26px;
                                    width: 104px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_0 {
                                    font-size: 20px;
                                    margin: 3px;
                                    width: 20px;
                                    height: 20px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_pp_btn_cont {
                                    font-size: 40px;
                                    height: 40px;
                                    width: 40px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_left_btn_cont,
                                #wds_container1_0 #wds_container2_0 .wds_right_btn_cont {
                                    height: 40px;
                                    font-size: 40px;
                                    width: 40px;
                                }
                            }
                            @media only screen and (min-width: 641px) and (max-width: 768px) {
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_thumbnails_0 {
                                    height: 26px;
                                    width: 104px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_0 {
                                    font-size: 20px;
                                    margin: 3px;
                                    width: 20px;
                                    height: 20px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_pp_btn_cont {
                                    font-size: 40px;
                                    height: 40px;
                                    width: 40px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_left_btn_cont,
                                #wds_container1_0 #wds_container2_0 .wds_right_btn_cont {
                                    height: 40px;
                                    font-size: 40px;
                                    width: 40px;
                                }
                            }
                            @media only screen and (min-width: 769px) and (max-width: 800px) {
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_thumbnails_0 {
                                    height: 26px;
                                    width: 104px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_0 {
                                    font-size: 20px;
                                    margin: 3px;
                                    width: 20px;
                                    height: 20px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_pp_btn_cont {
                                    font-size: 40px;
                                    height: 40px;
                                    width: 40px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_left_btn_cont,
                                #wds_container1_0 #wds_container2_0 .wds_right_btn_cont {
                                    height: 40px;
                                    font-size: 40px;
                                    width: 40px;
                                }
                            }
                            @media only screen and (min-width: 801px) and (max-width: 1024px) {
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_thumbnails_0 {
                                    height: 26px;
                                    width: 104px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_0 {
                                    font-size: 20px;
                                    margin: 3px;
                                    width: 20px;
                                    height: 20px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_pp_btn_cont {
                                    font-size: 40px;
                                    height: 40px;
                                    width: 40px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_left_btn_cont,
                                #wds_container1_0 #wds_container2_0 .wds_right_btn_cont {
                                    height: 40px;
                                    font-size: 40px;
                                    width: 40px;
                                }
                            }
                            @media only screen and (min-width: 1025px) and (max-width: 1366px) {
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_thumbnails_0 {
                                    height: 26px;
                                    width: 104px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_0 {
                                    font-size: 20px;
                                    margin: 3px;
                                    width: 20px;
                                    height: 20px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_pp_btn_cont {
                                    font-size: 40px;
                                    height: 40px;
                                    width: 40px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_left_btn_cont,
                                #wds_container1_0 #wds_container2_0 .wds_right_btn_cont {
                                    height: 40px;
                                    font-size: 40px;
                                    width: 40px;
                                }
                            }
                            @media only screen and (min-width: 1367px) and (max-width: 1824px) {
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_thumbnails_0 {
                                    height: 26px;
                                    width: 104px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_0 {
                                    font-size: 20px;
                                    margin: 3px;
                                    width: 20px;
                                    height: 20px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_pp_btn_cont {
                                    font-size: 40px;
                                    height: 40px;
                                    width: 40px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_left_btn_cont,
                                #wds_container1_0 #wds_container2_0 .wds_right_btn_cont {
                                    height: 40px;
                                    font-size: 40px;
                                    width: 40px;
                                }
                            }
                            @media only screen and (min-width: 1825px) and (max-width: 3000px) {
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_thumbnails_0 {
                                    height: 26px;
                                    width: 104px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_0 {
                                    font-size: 20px;
                                    margin: 3px;
                                    width: 20px;
                                    height: 20px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_pp_btn_cont {
                                    font-size: 40px;
                                    height: 40px;
                                    width: 40px;
                                }
                                #wds_container1_0 #wds_container2_0 .wds_left_btn_cont,
                                #wds_container1_0 #wds_container2_0 .wds_right_btn_cont {
                                    height: 40px;
                                    font-size: 40px;
                                    width: 40px;
                                }
                            }

                            #wds_container1_0 #wds_container2_0 .wds_slideshow_video_0 {
                                padding: 0 !important;
                                margin: 0 !important;
                                float: none !important;
                                width: 100%;
                                vertical-align: middle;
                                display: inline-block;
                            }
                            #wds_container1_0 #wds_container2_0 #wds_slideshow_play_pause_0 {
                                color: #000000;
                                cursor: pointer;
                                position: relative;
                                z-index: 13;
                                width: inherit;
                                height: inherit;
                                font-size: inherit;
                            }
                            #wds_container1_0 #wds_container2_0 #wds_slideshow_play_pause_0:hover {
                                color: #000000;
                                cursor: pointer;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_left-ico_0,
                            #wds_container1_0 #wds_container2_0 .wds_right-ico_0 {
                                background-color: rgba(255, 255, 255, 0.00);
                                border-radius: 20px;
                                border: 0px none #FFFFFF;
                                border-collapse: separate;
                                color: #000000;
                                left: 0;
                                top: 0;
                                -moz-box-sizing: content-box;
                                box-sizing: content-box;
                                cursor: pointer;
                                line-height: 0;
                                width: inherit;
                                height: inherit;
                                font-size: inherit;
                                position: absolute;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_left-ico_0 {
                                left: -4000px;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_right-ico_0 {
                                left: 4000px;
                            }
                            #wds_container1_0 #wds_container2_0 #wds_slideshow_play_pause_0 {
                                opacity: 0;
                                filter: "Alpha(opacity=0)";
                            }
                            #wds_container1_0 #wds_container2_0 .wds_left-ico_0:hover,
                            #wds_container1_0 #wds_container2_0 .wds_right-ico_0:hover {
                                color: #000000;
                                cursor: pointer;
                            }

                            #wds_container1_0 #wds_container2_0 .wds_none_selectable_0 {
                                -webkit-touch-callout: none;
                                -webkit-user-select: none;
                                -khtml-user-select: none;
                                -moz-user-select: none;
                                -ms-user-select: none;
                                user-select: none;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slide_container_0 {
                                display: table-cell;
                                margin: 0 auto;
                                position: absolute;
                                vertical-align: middle;
                                width: 100%;
                                height: 100%;
                                overflow: hidden;
                                cursor: inherit;
                                cursor: inherit;
                                cursor: inherit;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slide_container_0:active {
                                cursor: inherit;
                                cursor: inherit;
                                cursor: inherit;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slide_bg_0 {
                                margin: 0 auto;
                                width: /*inherit*/100%;
                                height: /*inherit*/100%;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slider_0 {
                                height: /*inherit*/100%;
                                width: /*inherit*/100%;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_image_spun_0 {
                                width: /*inherit*/100%;
                                height: /*inherit*/100%;
                                display: table-cell;
                                filter: Alpha(opacity=100);
                                opacity: 1;
                                position: absolute;
                                vertical-align: middle;
                                z-index: 2;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_image_second_spun_0 {
                                width: /*inherit*/100%;
                                height: /*inherit*/100%;
                                display: table-cell;
                                filter: Alpha(opacity=0);
                                opacity: 0;
                                position: absolute;
                                vertical-align: middle;
                                z-index: 1;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_grid_0 {
                                display: none;
                                height: 100%;
                                overflow: hidden;
                                position: absolute;
                                width: 100%;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_gridlet_0 {
                                opacity: 1;
                                filter: Alpha(opacity=100);
                                position: absolute;
                            }

                            /* Dots.*/
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_container_0 {
                                opacity: 1;
                                filter: "Alpha(opacity=100)";
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_container_0 {
                                display: block;
                                overflow: hidden;
                                position: absolute;
                                width: 100%;
                                bottom: 0;
                                /*z-index: 17;*/
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_thumbnails_0 {
                                left: 0px;
                                font-size: 0;
                                margin: 0 auto;
                                position: relative;
                                z-index: 15;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_0 {
                                display: inline-block;
                                position: relative;
                                color: #FFFFFF;
                                cursor: pointer;
                                z-index: 17;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_active_0 {
                                opacity: 1;
                                filter: Alpha(opacity=100);
                                color: #FFFFFF;

                            }
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_dots_deactive_0 {
                            }

                            #wds_container1_0 #wds_container2_0 .wds_slideshow_image_spun1_0 {
                                display: table;
                                width: /*inherit*/100%;
                                height: /*inherit*/100%;
                            }
                            #wds_container1_0 #wds_container2_0 .wds_slideshow_image_spun2_0 {
                                display: table-cell;
                                vertical-align: middle;
                                text-align: center;
                                overflow: hidden;
                            }
                        </style>
                        <script>
                            var wds_data_0 = [];
                            var wds_event_stack_0 = [];
                            var wds_clear_layers_effects_in_0 = [];
                            var wds_clear_layers_effects_out_0 = [];
                            var wds_clear_layers_effects_out_before_change_0 = [];
                            if (0) {
                                var wds_duration_for_change_0 = 500;
                                var wds_duration_for_clear_effects_0 = 530;
                            }
                            else {
                                var wds_duration_for_change_0 = 0;
                                var wds_duration_for_clear_effects_0 = 0;
                            }
                            wds_clear_layers_effects_in_0["0"] = [];
                            wds_clear_layers_effects_out_0["0"] = [];
                            wds_clear_layers_effects_out_before_change_0["0"] = [];
                            wds_data_0["0"] = [];
                            wds_data_0["0"]["id"] = "15";
                            wds_data_0["0"]["image_url"] = "http://www.instic.fr/wp-content/uploads/slider-wd//inscriptions-ecole-ete.jpg";
                            wds_data_0["0"]["thumb_url"] = "http://www.instic.fr/wp-content/uploads/slider-wd//thumb/inscriptions-ecole-ete.jpg";
                            wds_data_0["0"]["is_video"] = "image";
                            wds_data_0["0"]["slide_layers_count"] = 0;
                            wds_data_0["0"]["bg_fit"] = "cover";
                            wds_data_0["0"]["bull_position"] = "bottom";
                            wds_data_0["0"]["full_width"] = "0";
                            wds_data_0["0"]["image_thumb_url"] = "http://www.instic.fr/wp-content/uploads/slider-wd//thumb/inscriptions-ecole-ete.jpg";
                            wds_clear_layers_effects_in_0["1"] = [];
                            wds_clear_layers_effects_out_0["1"] = [];
                            wds_clear_layers_effects_out_before_change_0["1"] = [];
                            wds_data_0["1"] = [];
                            wds_data_0["1"]["id"] = "16";
                            wds_data_0["1"]["image_url"] = "http://www.instic.fr/wp-content/uploads/slider-wd//offres-alternance.jpg";
                            wds_data_0["1"]["thumb_url"] = "http://www.instic.fr/wp-content/uploads/slider-wd//thumb/offres-alternance.jpg";
                            wds_data_0["1"]["is_video"] = "image";
                            wds_data_0["1"]["slide_layers_count"] = 0;
                            wds_data_0["1"]["bg_fit"] = "cover";
                            wds_data_0["1"]["bull_position"] = "bottom";
                            wds_data_0["1"]["full_width"] = "0";
                            wds_data_0["1"]["image_thumb_url"] = "http://www.instic.fr/wp-content/uploads/slider-wd//thumb/offres-alternance.jpg";
                            wds_clear_layers_effects_in_0["2"] = [];
                            wds_clear_layers_effects_out_0["2"] = [];
                            wds_clear_layers_effects_out_before_change_0["2"] = [];
                            wds_data_0["2"] = [];
                            wds_data_0["2"]["id"] = "7";
                            wds_data_0["2"]["image_url"] = "http://www.instic.fr/wp-content/uploads/slider-wd//caroussel-rentrees-decalees.jpg";
                            wds_data_0["2"]["thumb_url"] = "http://www.instic.fr/wp-content/uploads/slider-wd//thumb/caroussel-rentrees-decalees.jpg";
                            wds_data_0["2"]["is_video"] = "image";
                            wds_data_0["2"]["slide_layers_count"] = 0;
                            wds_data_0["2"]["bg_fit"] = "cover";
                            wds_data_0["2"]["bull_position"] = "bottom";
                            wds_data_0["2"]["full_width"] = "0";
                            wds_data_0["2"]["image_thumb_url"] = "http://www.instic.fr/wp-content/uploads/slider-wd//thumb/caroussel-rentrees-decalees.jpg";
                            wds_clear_layers_effects_in_0["3"] = [];
                            wds_clear_layers_effects_out_0["3"] = [];
                            wds_clear_layers_effects_out_before_change_0["3"] = [];
                            wds_data_0["3"] = [];
                            wds_data_0["3"]["id"] = "14";
                            wds_data_0["3"]["image_url"] = "http://www.instic.fr/wp-content/uploads/slider-wd//caroussel-reu-information (1).jpg";
                            wds_data_0["3"]["thumb_url"] = "http://www.instic.fr/wp-content/uploads/slider-wd//thumb/caroussel-reu-information (1).jpg";
                            wds_data_0["3"]["is_video"] = "image";
                            wds_data_0["3"]["slide_layers_count"] = 0;
                            wds_data_0["3"]["bg_fit"] = "cover";
                            wds_data_0["3"]["bull_position"] = "bottom";
                            wds_data_0["3"]["full_width"] = "0";
                            wds_data_0["3"]["image_thumb_url"] = "http://www.instic.fr/wp-content/uploads/slider-wd//thumb/caroussel-reu-information (1).jpg";

                        </script>
                        <div id="wds_container1_0">
                            <div class="wds_loading">
                                <div class="wds_loading_img"></div>
                            </div>
                            <div id="wds_container2_0">
                                <div class="wds_slideshow_image_wrap_0">
                                    <div id="wds_slideshow_image_container_0" class="wds_slideshow_image_container_0">
                                        <div class="wds_slideshow_dots_container_0" onmouseleave="wds_hide_thumb(0)">
                                            <div class="wds_slideshow_dots_thumbnails_0">
                                                <i id="wds_dots_0_0"
                                                   class="wds_slideshow_dots_0 fa fa-square wds_slideshow_dots_active_0"
                                                   onclick="wds_change_image_0(parseInt(jQuery('#wds_current_image_key_0').val()), '0', wds_data_0)">
                                                </i>
                                                <i id="wds_dots_1_0"
                                                   class="wds_slideshow_dots_0 fa fa-square-o wds_slideshow_dots_deactive_0"
                                                   onclick="wds_change_image_0(parseInt(jQuery('#wds_current_image_key_0').val()), '1', wds_data_0)">
                                                </i>
                                                <i id="wds_dots_2_0"
                                                   class="wds_slideshow_dots_0 fa fa-square-o wds_slideshow_dots_deactive_0"
                                                   onclick="wds_change_image_0(parseInt(jQuery('#wds_current_image_key_0').val()), '2', wds_data_0)">
                                                </i>
                                                <i id="wds_dots_3_0"
                                                   class="wds_slideshow_dots_0 fa fa-square-o wds_slideshow_dots_deactive_0"
                                                   onclick="wds_change_image_0(parseInt(jQuery('#wds_current_image_key_0').val()), '3', wds_data_0)">
                                                </i>
                                            </div>
                                        </div>
                                        <div class="wds_slide_container_0" id="wds_slide_container_0">
                                            <div class="wds_slide_bg_0">
                                                <div class="wds_slider_0">
                                  <span class="wds_slideshow_image_spun_0" id="wds_image_id_0_15">
                    <span class="wds_slideshow_image_spun1_0">
                      <span class="wds_slideshow_image_spun2_0">
                        <span img_id="wds_slideshow_image_0"
                              class="wds_slideshow_image_0"
                              onclick="window.open('http://www.instic.fr/dossier-de-candidature', '_self')"
                              style="cursor: pointer;background-image: url('http://www.instic.fr/wp-content/uploads/slider-wd//inscriptions-ecole-ete.jpg');">
                                                </span>
                      </span>
                    </span>
                  </span>
                                                    <span class="wds_slideshow_image_second_spun_0" id="wds_image_id_0_16">
                    <span class="wds_slideshow_image_spun1_0">
                      <span class="wds_slideshow_image_spun2_0">
                        <span img_id="wds_slideshow_image_second_0"
                              class="wds_slideshow_image_0"
                              onclick="window.open('http://www.instic.fr/offres', '_blank')"
                              style="cursor: pointer;">
                                                </span>
                      </span>
                    </span>
                  </span>
                                                    <span class="wds_slideshow_image_second_spun_0" id="wds_image_id_0_7">
                    <span class="wds_slideshow_image_spun1_0">
                      <span class="wds_slideshow_image_spun2_0">
                        <span img_id="wds_slideshow_image_second_0"
                              class="wds_slideshow_image_0"
                              onclick="window.open('http://www.instic.fr/wp-content/uploads/Dossier-de-candidature-INSTIC.pdf', '_blank')"
                              style="cursor: pointer;">
                                                </span>
                      </span>
                    </span>
                  </span>
                                                    <span class="wds_slideshow_image_second_spun_0" id="wds_image_id_0_14">
                    <span class="wds_slideshow_image_spun1_0">
                      <span class="wds_slideshow_image_spun2_0">
                        <span img_id="wds_slideshow_image_second_0"
                              class="wds_slideshow_image_0"
                              onclick="window.open('http://www.instic.fr/reunions-dinformation', '_self')"
                              style="cursor: pointer;">
                                                </span>
                      </span>
                    </span>
                  </span>
                                                    <input type="hidden" id="wds_current_image_key_0" value="0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            var wds_trans_in_progress_0 = false;
                            var wds_transition_duration_0 = 800;
                            if (4 < 4) {
                                if (4 != 0) {
                                    wds_transition_duration_0 = (4 * 1000) / 4;
                                }
                            }
                            var wds_playInterval_0;
                            var progress = 0;
                            var bottom_right_deggree_0;
                            var bottom_left_deggree_0;
                            var top_left_deggree_0;
                            var curent_time_deggree_0 = 0;
                            var circle_timer_animate_0;
                            function circle_timer_0(angle) {
                                circle_timer_animate_0 = jQuery({deg: angle}).animate({deg: 360}, {
                                    duration: 4000,
                                    step: function(now) {
                                        curent_time_deggree_0 = now;
                                        if (now >= 0) {
                                            if (now < 271) {
                                                jQuery('#top_right_0').css({
                                                    '-moz-transform':'rotate('+now+'deg)',
                                                    '-webkit-transform':'rotate('+now+'deg)',
                                                    '-o-transform':'rotate('+now+'deg)',
                                                    '-ms-transform':'rotate('+now+'deg)',
                                                    'transform':'rotate('+now+'deg)',

                                                    '-webkit-transform-origin': 'left bottom',
                                                    '-ms-transform-origin': 'left bottom',
                                                    '-moz-transform-origin': 'left bottom',
                                                    'transform-origin': 'left bottom'
                                                });
                                            }
                                        }
                                        if (now >= 90) {
                                            if (now < 271) {
                                                bottom_right_deggree_0 = now - 90;
                                                jQuery('#bottom_right_0').css({
                                                    '-moz-transform':'rotate('+bottom_right_deggree_0 +'deg)',
                                                    '-webkit-transform':'rotate('+bottom_right_deggree_0 +'deg)',
                                                    '-o-transform':'rotate('+bottom_right_deggree_0 +'deg)',
                                                    '-ms-transform':'rotate('+bottom_right_deggree_0 +'deg)',
                                                    'transform':'rotate('+bottom_right_deggree_0 +'deg)',

                                                    '-webkit-transform-origin': 'left top',
                                                    '-ms-transform-origin': 'left top',
                                                    '-moz-transform-origin': 'left top',
                                                    'transform-origin': 'left top'
                                                });
                                            }
                                        }
                                        if (now >= 180) {
                                            if (now < 361) {
                                                bottom_left_deggree_0 = now - 180;
                                                jQuery('#bottom_left_0').css({
                                                    '-moz-transform':'rotate('+bottom_left_deggree_0 +'deg)',
                                                    '-webkit-transform':'rotate('+bottom_left_deggree_0 +'deg)',
                                                    '-o-transform':'rotate('+bottom_left_deggree_0 +'deg)',
                                                    '-ms-transform':'rotate('+bottom_left_deggree_0 +'deg)',
                                                    'transform':'rotate('+bottom_left_deggree_0 +'deg)',

                                                    '-webkit-transform-origin': 'right top',
                                                    '-ms-transform-origin': 'right top',
                                                    '-moz-transform-origin': 'right top',
                                                    'transform-origin': 'right top'
                                                });
                                            }
                                        }
                                        if (now >= 270) {
                                            if (now < 361) {
                                                top_left_deggree_0  = now - 270;
                                                jQuery('#top_left_0').css({
                                                    '-moz-transform':'rotate('+top_left_deggree_0 +'deg)',
                                                    '-webkit-transform':'rotate('+top_left_deggree_0 +'deg)',
                                                    '-o-transform':'rotate('+top_left_deggree_0 +'deg)',
                                                    '-ms-transform':'rotate('+top_left_deggree_0 +'deg)',
                                                    'transform':'rotate('+top_left_deggree_0 +'deg)',

                                                    '-webkit-transform-origin': 'right bottom',
                                                    '-ms-transform-origin': 'right bottom',
                                                    '-moz-transform-origin': 'right bottom',
                                                    'transform-origin': 'right bottom'
                                                });
                                            }
                                        }
                                    }
                                });
                            }
                            /* Stop autoplay.*/
                            window.clearInterval(wds_playInterval_0);
                            var wds_current_key_0 = '0';
                            var wds_current_filmstrip_pos_0 = 0;
                            function wds_move_dots_0() {
                                var image_left = jQuery(".wds_slideshow_dots_active_0").position().left;
                                var image_right = jQuery(".wds_slideshow_dots_active_0").position().left + jQuery(".wds_slideshow_dots_active_0").outerWidth(true);
                                var wds_dots_width = jQuery(".wds_slideshow_dots_container_0").outerWidth(true);
                                var wds_dots_thumbnails_width = jQuery(".wds_slideshow_dots_thumbnails_0").outerWidth(true);
                                var long_filmstrip_cont_left = jQuery(".wds_slideshow_dots_thumbnails_0").position().left;
                                var long_filmstrip_cont_right = Math.abs(jQuery(".wds_slideshow_dots_thumbnails_0").position().left) + wds_dots_width;
                                if (wds_dots_width > wds_dots_thumbnails_width) {
                                    return;
                                }
                                if (image_left < Math.abs(long_filmstrip_cont_left)) {
                                    jQuery(".wds_slideshow_dots_thumbnails_0").animate({
                                        left: -image_left
                                    }, {
                                        duration: 500
                                    });
                                }
                                else if (image_right > long_filmstrip_cont_right) {
                                    jQuery(".wds_slideshow_dots_thumbnails_0").animate({
                                        left: -(image_right - wds_dots_width)
                                    }, {
                                        duration: 500
                                    });
                                }
                            }
                            function wds_testBrowser_cssTransitions_0() {
                                return wds_testDom_0('Transition');
                            }
                            function wds_testBrowser_cssTransforms3d_0() {
                                return wds_testDom_0('Perspective');
                            }
                            function wds_testDom_0(prop) {
                                /* Browser vendor CSS prefixes.*/
                                var browserVendors = ['', '-webkit-', '-moz-', '-ms-', '-o-', '-khtml-'];
                                /* Browser vendor DOM prefixes.*/
                                var domPrefixes = ['', 'Webkit', 'Moz', 'ms', 'O', 'Khtml'];
                                var i = domPrefixes.length;
                                while (i--) {
                                    if (typeof document.body.style[domPrefixes[i] + prop] !== 'undefined') {
                                        return true;
                                    }
                                }
                                return false;
                            }
                            function wds_set_dots_class_0() {
                                jQuery(".wds_slideshow_dots_0").removeClass("wds_slideshow_dots_active_0").addClass("wds_slideshow_dots_deactive_0");
                                jQuery("#wds_dots_" + wds_current_key_0 + "_0").removeClass("wds_slideshow_dots_deactive_0").addClass("wds_slideshow_dots_active_0");
                                jQuery(".wds_slideshow_dots_0").removeClass("fa-square").addClass("fa-square-o");
                                jQuery("#wds_dots_" + wds_current_key_0 + "_0").removeClass("fa-square-o").addClass("fa-square");
                            }
                            function wds_grid_0(cols, rows, ro, tx, ty, sc, op, current_image_class, next_image_class, direction, random, roy, easing) {
                                /* If browser does not support CSS transitions.*/
                                if (!wds_testBrowser_cssTransitions_0()) {
                                    return wds_fallback_0(current_image_class, next_image_class, direction);
                                }
                                wds_trans_in_progress_0 = true;
                                /* Set active thumbnail.*/
                                wds_set_dots_class_0();
                                /* The time (in ms) added to/subtracted from the delay total for each new gridlet.*/
                                var count = (wds_transition_duration_0) / (cols + rows);
                                /* Gridlet creator (divisions of the image grid, positioned with background-images to replicate the look of an entire slide image when assembled)*/
                                function wds_gridlet(width, height, top, img_top, left, img_left, src, imgWidth, imgHeight, c, r) {
                                    var delay = random ? Math.floor((cols + rows) * count * Math.random()) : (c + r) * count;
                                    /* Return a gridlet elem with styles for specific transition.*/
                                    var grid_div = jQuery('<span class="wds_gridlet_0" />').css({
                                        display: "block",
                                        width : imgWidth,/*"100%"*/
                                        height : jQuery(".wds_slideshow_image_spun_0").height() + "px",
                                        top : -top,
                                        left : -left,
                                        backgroundImage : src,
                                        backgroundSize: jQuery(".wds_slideshow_image_0").css("background-size"),
                                        backgroundPosition: jQuery(".wds_slideshow_image_0").css("background-position"),
                                        /*backgroundColor: jQuery(".wds_slideshow_image_wrap_0").css("background-color"),*/
                                        backgroundRepeat: 'no-repeat'
                                    });
                                    return jQuery('<span class="wds_gridlet_0" />').css({
                                        display: "block",
                                        width : width,/*"100%"*/
                                        height : height,
                                        top : top,
                                        left : left,
                                        backgroundSize : imgWidth + 'px ' + imgHeight + 'px',
                                        backgroundPosition : img_left + 'px ' + img_top + 'px',
                                        backgroundRepeat: 'no-repeat',
                                        overflow: "hidden",
                                        transition : 'all ' + wds_transition_duration_0 + 'ms ' + easing + ' ' + delay + 'ms',
                                        transform : 'none'
                                    }).append(grid_div);
                                }
                                /* Get the current slide's image.*/
                                var cur_img = jQuery(current_image_class).find('span[img_id^="wds_slideshow_image"]');
                                /* Create a grid to hold the gridlets.*/
                                var grid = jQuery('<span style="display: block;" />').addClass('wds_grid_0');
                                /* Prepend the grid to the next slide (i.e. so it's above the slide image).*/
                                jQuery(current_image_class).prepend(grid);
                                /* vars to calculate positioning/size of gridlets*/
                                var cont = jQuery(".wds_slide_bg_0");
                                var imgWidth = cur_img.width();
                                var imgHeight = cur_img.height();
                                var contWidth = cont.width(),
                                        contHeight = cont.height(),
                                        imgSrc = cur_img.css('background-image'),/*.replace('/thumb', ''),*/
                                        colWidth = Math.floor(contWidth / cols),
                                        rowHeight = Math.floor(contHeight / rows),
                                        colRemainder = contWidth - (cols * colWidth),
                                        colAdd = Math.ceil(colRemainder / cols),
                                        rowRemainder = contHeight - (rows * rowHeight),
                                        rowAdd = Math.ceil(rowRemainder / rows),
                                        leftDist = 0,
                                        img_leftDist = (jQuery(".wds_slide_bg_0").width() - cur_img.width()) / 2;
                                /* tx/ty args can be passed as 'auto'/'min-auto' (meaning use slide width/height or negative slide width/height).*/
                                tx = tx === 'auto' ? contWidth : tx;
                                tx = tx === 'min-auto' ? - contWidth : tx;
                                ty = ty === 'auto' ? contHeight : ty;
                                ty = ty === 'min-auto' ? - contHeight : ty;
                                /* Loop through cols*/
                                for (var i = 0; i < cols; i++) {
                                    var topDist = 0,
                                            img_topDst = (jQuery(".wds_slide_bg_0").height() - cur_img.height()) / 2,
                                            newColWidth = colWidth;
                                    /* If imgWidth (px) does not divide cleanly into the specified number of cols, adjust individual col widths to create correct total.*/
                                    if (colRemainder > 0) {
                                        var add = colRemainder >= colAdd ? colAdd : colRemainder;
                                        newColWidth += add;
                                        colRemainder -= add;
                                    }
                                    /* Nested loop to create row gridlets for each col.*/
                                    for (var j = 0; j < rows; j++)  {
                                        var newRowHeight = rowHeight,
                                                newRowRemainder = rowRemainder;
                                        /* If contHeight (px) does not divide cleanly into the specified number of rows, adjust individual row heights to create correct total.*/
                                        if (newRowRemainder > 0) {
                                            add = newRowRemainder >= rowAdd ? rowAdd : rowRemainder;
                                            newRowHeight += add;
                                            newRowRemainder -= add;
                                        }
                                        /* Create & append gridlet to grid.*/
                                        grid.append(wds_gridlet(newColWidth, newRowHeight, topDist, img_topDst, leftDist, img_leftDist, imgSrc, imgWidth, imgHeight, i, j));
                                        topDist += newRowHeight;
                                        img_topDst -= newRowHeight;
                                    }

                                    img_leftDist -= newColWidth;
                                    leftDist += newColWidth;
                                }
                                /* Show grid & hide the image it replaces.*/
                                grid.show();
                                cur_img.css('opacity', 0);
                                /* Add identifying classes to corner gridlets (useful if applying border radius).*/
                                grid.children().first().addClass('rs-top-left');
                                grid.children().last().addClass('rs-bottom-right');
                                grid.children().eq(rows - 1).addClass('rs-bottom-left');
                                grid.children().eq(- rows).addClass('rs-top-right');
                                /* Execution steps.*/
                                setTimeout(function () {
                                    grid.children().css({
                                        opacity: op,
                                        transform: 'rotate('+ ro +'deg) rotateY('+ roy +'deg) translateX('+ tx +'px) translateY('+ ty +'px) scale('+ sc +')'
                                    });
                                }, 1);
                                jQuery(next_image_class).css('opacity', 1);
                                /* After transition.*/
                                var cccount = 0;
                                var obshicccount = cols * rows;
                                grid.children().one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(wds_after_trans_each));
                                function wds_after_trans_each() {
                                    if (++cccount == obshicccount) {
                                        wds_after_trans();
                                    }
                                }
                                function wds_after_trans() {
                                    jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
                                    jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
                                    cur_img.css('opacity', 1);
                                    grid.remove();
                                    wds_trans_in_progress_0 = false;
                                    if (typeof wds_event_stack_0 !== 'undefined') {
                                        if (wds_event_stack_0.length > 0) {
                                            key = wds_event_stack_0[0].split("-");
                                            wds_event_stack_0.shift();
                                            wds_change_image_0(key[0], key[1], wds_data_0, true);
                                        }
                                    }
                                }
                            }
                            function wds_none_0(current_image_class, next_image_class, direction) {
                                jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
                                jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
                                /* Set active thumbnail.*/
                                wds_set_dots_class_0();
                            }
                            function wds_fade_0(current_image_class, next_image_class, direction) {
                                /* Set active thumbnail.*/
                                wds_set_dots_class_0();
                                if (wds_testBrowser_cssTransitions_0()) {
                                    jQuery(next_image_class).css('transition', 'opacity ' + wds_transition_duration_0 + 'ms linear');
                                    jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
                                    jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
                                }
                                else {
                                    jQuery(current_image_class).animate({'opacity' : 0, 'z-index' : 1}, wds_transition_duration_0);
                                    jQuery(next_image_class).animate({
                                        'opacity' : 1,
                                        'z-index': 2
                                    }, {
                                        duration: wds_transition_duration_0,
                                        complete: function () {  }
                                    });
                                    /* For IE.*/
                                    jQuery(current_image_class).fadeTo(wds_transition_duration_0, 0);
                                    jQuery(next_image_class).fadeTo(wds_transition_duration_0, 1);
                                }
                            }
                            function wds_sliceH_0(current_image_class, next_image_class, direction) {
                                if (direction == 'right') {
                                    var translateX = 'min-auto';
                                }
                                else if (direction == 'left') {
                                    var translateX = 'auto';
                                }
                                wds_grid_0(1, 8, 0, translateX, 0, 1, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
                            }
                            function wds_fan_0(current_image_class, next_image_class, direction) {
                                if (direction == 'right') {
                                    var rotate = 45;
                                    var translateX = 100;
                                }
                                else if (direction == 'left') {
                                    var rotate = -45;
                                    var translateX = -100;
                                }
                                wds_grid_0(1, 10, rotate, translateX, 0, 1, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
                            }
                            function wds_scaleIn_0(current_image_class, next_image_class, direction) {
                                wds_grid_0(1, 1, 0, 0, 0, 0.5, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
                            }
                            function wds_iterator_0() {
                                var iterator = 1;
                                if (0) {
                                    iterator = Math.floor((wds_data_0.length - 1) * Math.random() + 1);
                                }
                                return iterator;
                            }
                            function wds_change_image_0(current_key, key, wds_data_0, from_effect) {
                                if (wds_data_0[key]["is_video"] == 'image') {
                                    jQuery('<img />').attr("src", wds_data_0[key]["image_url"])
                                            .load(function() {
                                                jQuery(this).remove();
                                                wds_change_image_when_loaded_0(current_key, key, wds_data_0, from_effect);
                                            })
                                            .error(function() {
                                                jQuery(this).remove();
                                                wds_change_image_when_loaded_0(current_key, key, wds_data_0, from_effect);
                                            });
                                }
                                else {
                                    wds_change_image_when_loaded_0(current_key, key, wds_data_0, from_effect);
                                }
                            }
                            function wds_change_image_when_loaded_0(current_key, key, wds_data_0, from_effect) {
                                /* Pause videos.*/
                                jQuery("#wds_slideshow_image_container_0").find("iframe").each(function () {
                                    if (typeof jQuery(this)[0].contentWindow != "undefined") {
                                        jQuery(this)[0].contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');
                                        jQuery(this)[0].contentWindow.postMessage('{ "method": "stop" }', "*");
                                        jQuery(this)[0].contentWindow.postMessage('stop', '*');
                                    }
                                });
                                /* Pause layer videos.*/
                                jQuery(".wds_video_layer_frame_0").each(function () {
                                    if (typeof jQuery(this)[0].contentWindow != "undefined") {
                                        jQuery(this)[0].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
                                        jQuery(this)[0].contentWindow.postMessage('{ "method": "pause" }', "*");
                                        jQuery(this)[0].contentWindow.postMessage('pause', '*');
                                    }
                                });
                                if (wds_data_0[key]) {
                                    if (jQuery('.wds_ctrl_btn_0').hasClass('fa-pause') || ('1')) {
                                        play_0();
                                    }
                                    if (!from_effect) {
                                        /* Change image key.*/
                                        jQuery("#wds_current_image_key_0").val(key);
                                        if (current_key == '-1') { /* Filmstrip.*/
                                            current_key = jQuery(".wds_slideshow_thumb_active_0").children("img").attr("image_key");
                                        }
                                        else if (current_key == '-2') { /* Dots.*/
                                            /*current_key = jQuery(".wds_slideshow_dots_active_0").attr("image_key");*/
                                            currId = jQuery(".wds_slideshow_dots_active_0").attr("id");
                                            current_key = currId.replace('wds_dots_', '').replace('_0', '');
                                        }
                                    }
                                    if (wds_trans_in_progress_0) {
                                        wds_event_stack_0.push(current_key + '-' + key);
                                        return;
                                    }
                                    var direction = 'right';
                                    var int_curr_key = parseInt(wds_current_key_0);
                                    var int_key = parseInt(key);
                                    var last_pos = wds_data_0.length - 1;
                                    if (int_curr_key > int_key) {
                                        direction = 'left';
                                    }
                                    else if (int_curr_key == int_key) {
                                        return;
                                    }
                                    if (int_key == 0) {
                                        if (int_curr_key == last_pos) {
                                            direction = 'right';
                                        }
                                    }
                                    if (int_key == last_pos) {
                                        if (int_curr_key == 0) {
                                            direction = 'left';
                                        }
                                    }
                                    /* Set active thumbnail position.*/
                                    wds_current_filmstrip_pos_0 = key * (jQuery(".wds_slideshow_filmstrip_thumbnail_0").width() + 2 + 2 * 0);
                                    wds_current_key_0 = key;
                                    /* Change image id.*/
                                    jQuery("div[img_id=wds_slideshow_image_0]").attr('image_id', wds_data_0[key]["id"]);
                                    var current_image_class = "#wds_image_id_0_" + wds_data_0[current_key]["id"];
                                    var next_image_class = "#wds_image_id_0_" + wds_data_0[key]["id"];
                                    if (wds_data_0[key]["is_video"] == 'image') {
                                        jQuery(next_image_class).find(".wds_slideshow_image_0").css("background-image", 'url("' + wds_data_0[key]["image_url"] + '")');
                                    }
                                    var current_slide_layers_count = wds_data_0[current_key]["slide_layers_count"];
                                    var next_slide_layers_count = wds_data_0[key]["slide_layers_count"];

                                    /* Clear layers before image change.*/
                                    function set_layer_effect_out_before_change(m) {
                                        wds_clear_layers_effects_out_before_change_0[current_key][m] = setTimeout(function() {
                                            if (wds_data_0[current_key]["layer_" + m + "_type"] != 'social') {
                                                jQuery('#wds_0_slide' + wds_data_0[current_key]["id"] + '_layer' + wds_data_0[current_key]["layer_" + m + "_id"]).css('-webkit-animation-duration' , 0.6 + 's').css('animation-duration' , 0.6 + 's');
                                                jQuery('#wds_0_slide' + wds_data_0[current_key]["id"] + '_layer' + wds_data_0[current_key]["layer_" + m + "_id"]).removeClass().addClass( wds_data_0[current_key]["layer_" + m + "_layer_effect_out"] + ' wds_animated');
                                                jQuery('#wds_0_slide' + wds_data_0[current_key]["id"] + '_layer' + wds_data_0[current_key]["layer_" + m + "_id"]).addClass(jQuery('#wds_0_slide' + wds_data_0[current_key]["id"] + '_layer' + wds_data_0[current_key]["layer_" + m + "_id"]).data("class"));
                                            }
                                            else {
                                                jQuery('#wds_0_slide' + wds_data_0[current_key]["id"] + '_layer' + wds_data_0[current_key]["layer_" + m + "_id"]).css('-webkit-animation-duration' , 0.6 + 's').css('animation-duration' , 0.6 + 's');
                                                jQuery('#wds_0_slide' + wds_data_0[current_key]["id"] + '_layer' + wds_data_0[current_key]["layer_" + m + "_id"]).removeClass().addClass( wds_data_0[current_key]["layer_" + m + "_layer_effect_out"] + ' fa fa-' + wds_data_0[current_key]["layer_" + m + "_social_button"] + ' wds_animated');
                                            }
                                        }, 10);
                                    }
                                    if (0) {
                                        for (var m = 0; m < current_slide_layers_count; m++) {
                                            if (jQuery('#wds_0_slide' + wds_data_0[current_key]["id"] + '_layer' + wds_data_0[current_key]["layer_" + m + "_id"]).css('opacity') != 0) {
                                                set_layer_effect_out_before_change(m);
                                            }
                                        }
                                    }
                                    /* Loop through current slide layers for clear effects.*/
                                    setTimeout(function() {
                                        for (var k = 0; k < current_slide_layers_count; k++) {
                                            clearTimeout(wds_clear_layers_effects_in_0[current_key][k]);
                                            clearTimeout(wds_clear_layers_effects_out_0[current_key][k]);
                                            if (wds_data_0[current_key]["layer_" + k + "_type"] != 'social') {
                                                jQuery('#wds_0_slide' + wds_data_0[current_key]["id"] + '_layer' + wds_data_0[current_key]["layer_" + k + "_id"]).removeClass().addClass('wds_layer_'+ wds_data_0[current_key]["layer_" + k + "_id"]);
                                            }
                                            else {
                                                jQuery('#wds_0_slide' + wds_data_0[current_key]["id"] + '_layer' + wds_data_0[current_key]["layer_" + k + "_id"]).removeClass().addClass('fa fa-' + wds_data_0[current_key]["layer_" + k + "_social_button"] + ' wds_layer_' + wds_data_0[current_key]["layer_" + k + "_id"]);
                                            }
                                        }
                                    }, wds_duration_for_clear_effects_0);
                                    /* Loop through layers in.*/
                                    for (var j = 0; j < next_slide_layers_count; j++) {
                                        wds_set_layer_effect_in_0(j, key);
                                    }
                                    /* Loop through layers out if pause button not pressed.*/
                                    for (var i = 0; i < next_slide_layers_count; i++) {
                                        wds_set_layer_effect_out_0(i, key);
                                    }
                                    setTimeout(function() {
                                        if (typeof jQuery().finish !== 'undefined') {
                                            if (jQuery.isFunction(jQuery().finish)) {
                                                jQuery(".wds_line_timer_0").finish();
                                            }
                                        }
                                        jQuery(".wds_line_timer_0").css({width: 0});
                                        wds_fade_0(current_image_class, next_image_class, direction);
                                        if ('none' != 'none') {
                                            if (1 || jQuery('.wds_ctrl_btn_0').hasClass('fa-pause')) {
                                                if ('none' == 'top' || 'none' == 'bottom') {
                                                    if (!jQuery(".wds_ctrl_btn_0").hasClass("fa-play")) {
                                                        jQuery(".wds_line_timer_0").animate({
                                                            width: "100%"
                                                        }, {
                                                            duration: 4000,
                                                            specialEasing: {width: "linear"}
                                                        });
                                                    }
                                                }
                                                else if ('none' != 'none') {
                                                    if (typeof circle_timer_animate_0 !== 'undefined') {
                                                        circle_timer_animate_0.stop();
                                                    }
                                                    jQuery('#top_right_0').css({
                                                        '-moz-transform':'rotate(0deg)',
                                                        '-webkit-transform':'rotate(0deg)',
                                                        '-o-transform':'rotate(0deg)',
                                                        '-ms-transform':'rotate(0deg)',
                                                        'transform':'rotate(0deg)',

                                                        '-webkit-transform-origin': 'left bottom',
                                                        '-ms-transform-origin': 'left bottom',
                                                        '-moz-transform-origin': 'left bottom',
                                                        'transform-origin': 'left bottom'
                                                    });
                                                    jQuery('#bottom_right_0').css({
                                                        '-moz-transform':'rotate(0deg)',
                                                        '-webkit-transform':'rotate(0deg)',
                                                        '-o-transform':'rotate(0deg)',
                                                        '-ms-transform':'rotate(0deg)',
                                                        'transform':'rotate(0deg)',

                                                        '-webkit-transform-origin': 'left top',
                                                        '-ms-transform-origin': 'left top',
                                                        '-moz-transform-origin': 'left top',
                                                        'transform-origin': 'left top'
                                                    });
                                                    jQuery('#bottom_left_0').css({
                                                        '-moz-transform':'rotate(0deg)',
                                                        '-webkit-transform':'rotate(0deg)',
                                                        '-o-transform':'rotate(0deg)',
                                                        '-ms-transform':'rotate(0deg)',
                                                        'transform':'rotate(0deg)',

                                                        '-webkit-transform-origin': 'right top',
                                                        '-ms-transform-origin': 'right top',
                                                        '-moz-transform-origin': 'right top',
                                                        'transform-origin': 'right top'
                                                    });
                                                    jQuery('#top_left_0').css({
                                                        '-moz-transform':'rotate(0deg)',
                                                        '-webkit-transform':'rotate(0deg)',
                                                        '-o-transform':'rotate(0deg)',
                                                        '-ms-transform':'rotate(0deg)',
                                                        'transform':'rotate(0deg)',

                                                        '-webkit-transform-origin': 'right bottom',
                                                        '-ms-transform-origin': 'right bottom',
                                                        '-moz-transform-origin': 'right bottom',
                                                        'transform-origin': 'right bottom'
                                                    });
                                                    if (!jQuery(".wds_ctrl_btn_0").hasClass("fa-play")) {
                                                        /* Begin circle timer on next.*/
                                                        circle_timer_0(0);
                                                    }
                                                    else {
                                                        curent_time_deggree_0 = 0;
                                                    }
                                                }
                                            }
                                        }
                                        wds_move_dots_0();
                                        if (wds_data_0[key]["is_video"] != 'image') {
                                            jQuery("#wds_slideshow_play_pause_0").css({display: 'none'});
                                        }
                                        else {
                                            jQuery("#wds_slideshow_play_pause_0").css({display: ''});
                                        }
                                    }, wds_duration_for_change_0);
                                }
                            }
                            function wds_resize_slider_0() {
                                if ('style' == 'text') {
                                    wds_set_text_dots_cont(0);
                                }
                                var slide_orig_width = 940;
                                var slide_orig_height = 475;
                                /* var slide_width = jQuery("#wds_container1_0").parent().width(); */
                                var slide_width = wds_get_overall_parent(jQuery("#wds_container1_0"));
                                if (slide_width > slide_orig_width) {
                                    slide_width = slide_orig_width;
                                }
                                var ratio = slide_width / slide_orig_width;

                                var slide_height = slide_orig_height;
                                if (slide_orig_width > slide_width) {
                                    slide_height = Math.floor(slide_width * slide_orig_height / slide_orig_width);
                                }

                                jQuery(".wds_slideshow_image_wrap_0, #wds_container2_0").height(slide_height + 0);
                                jQuery(".wds_slideshow_image_container_0").height(slide_height);
                                jQuery(".wds_slideshow_image_0").height(slide_height);
                                jQuery(".wds_slideshow_video_0").height(slide_height);
                                jQuery(".wds_slideshow_image_0 img").each(function () {
                                    var wds_theImage = new Image();
                                    wds_theImage.src = jQuery(this).attr("src");
                                    var wds_origWidth = wds_theImage.width;
                                    var wds_origHeight = wds_theImage.height;
                                    var wds_imageWidth = jQuery(this).attr("wds_image_width");
                                    var wds_imageHeight = jQuery(this).attr("wds_image_height");
                                    var wds_width = wds_imageWidth;
                                    if (wds_imageWidth > wds_origWidth) {
                                        wds_width = wds_origWidth;
                                    }
                                    var wds_height = wds_imageHeight;
                                    if (wds_imageHeight > wds_origHeight) {
                                        wds_height = wds_origHeight;
                                    }
                                    jQuery(this).css({
                                        maxWidth: (parseFloat(wds_imageWidth) * ratio) + "px",
                                        maxHeight: (parseFloat(wds_imageHeight) * ratio) + "px",
                                    });
                                    if (jQuery(this).attr("wds_scale") != "on") {
                                        jQuery(this).css({
                                            width: (parseFloat(wds_imageWidth) * ratio) + "px",
                                            height: (parseFloat(wds_imageHeight) * ratio) + "px"
                                        });
                                    }
                                    else if (wds_imageWidth > wds_origWidth || wds_imageHeight > wds_origHeight) {
                                        if (wds_origWidth / wds_imageWidth > wds_origHeight / wds_imageHeight) {
                                            jQuery(this).css({
                                                width: (parseFloat(wds_imageWidth) * ratio) + "px"
                                            });
                                        }
                                        else {
                                            jQuery(this).css({
                                                height: (parseFloat(wds_imageHeight) * ratio) + "px"
                                            });
                                        }
                                    }

                                });
                                jQuery(".wds_slideshow_image_0 span, .wds_slideshow_image_0 i").each(function () {
                                    jQuery(this).css({
                                        fontSize: (parseFloat(jQuery(this).attr("wds_fsize")) * ratio) + "px",
                                        lineHeight: "1.25em",
                                        paddingLeft: (parseFloat(jQuery(this).attr("wds_fpaddingl")) * ratio) + "px",
                                        paddingRight: (parseFloat(jQuery(this).attr("wds_fpaddingr")) * ratio) + "px",
                                        paddingTop: (parseFloat(jQuery(this).attr("wds_fpaddingt")) * ratio) + "px",
                                        paddingBottom: (parseFloat(jQuery(this).attr("wds_fpaddingb")) * ratio) + "px",
                                    });
                                });
                            }
                            /* Generate background position for Zoom Fade effect.*/
                            function wds_genBgPos_0() {
                                var bgSizeArray = [0, 70];
                                var bgSize = bgSizeArray[Math.floor(Math.random() * bgSizeArray.length)];

                                var bgPosXArray = ['left', 'right'];
                                var bgPosYArray = ['top', 'bottom'];
                                var bgPosX = bgPosXArray[Math.floor(Math.random() * bgPosXArray.length)];
                                var bgPosY = bgPosYArray[Math.floor(Math.random() * bgPosYArray.length)];
                                jQuery(".wds_slideshow_image_0").css({
                                    backgroundPosition: bgPosX + " " + bgPosY,
                                    backgroundSize : (100 + bgSize) + "%",
                                    webkitAnimation: '4s linear 0s alternate infinite wdszoom' + bgSize,
                                    mozAnimation: '4s linear 0s alternate infinite wdszoom' + bgSize,
                                    animation: '4s linear 0s alternate infinite wdszoom' + bgSize
                                });
                            }
                            jQuery(window).resize(function () {
                                wds_resize_slider_0();
                            });
                            function wds_full_width_0() {
                                var left = jQuery("#wds_container1_0").offset().left;
                                jQuery(".wds_slideshow_image_wrap_0").css({
                                    left: (-left + 0) + "px",
                                    width: (jQuery(window).width() - 0) + "px",
                                    maxWidth: "none"
                                });
                            }
                            if ("http://www.instic.fr/wp-content/uploads/slider-wd//inscriptions-ecole-ete.jpg" != '') {
                                jQuery('<img />').attr("src", "http://www.instic.fr/wp-content/uploads/slider-wd//inscriptions-ecole-ete.jpg").load(function() {
                                    jQuery(this).remove();
                                    wds_ready_0();
                                });
                            }
                            else {
                                jQuery(document).ready(function () {
                                    wds_ready_0();
                                });
                            }
                            function wds_ready_0() {
                                jQuery("#wds_container1_0").mouseover(function(e) {
                                    wds_stop_animation_0();
                                });
                                jQuery("#wds_container1_0").mouseout(function(e) {
                                    if (!e) {
                                        var e = window.event;
                                    }
                                    var reltg = (e.relatedTarget) ? e.relatedTarget : e.toElement;
                                    if (typeof reltg.tagName != "undefined") {
                                        while (reltg.tagName != 'BODY') {
                                            if (reltg.id == this.id){
                                                return;
                                            }
                                            reltg = reltg.parentNode;
                                        }
                                    }
                                    wds_play_animation_0();
                                });
                                if ('style' == 'text') {
                                    wds_set_text_dots_cont(0);
                                }
                                jQuery(".wds_slideshow_image_0 span, .wds_slideshow_image_0 i").each(function () {
                                    jQuery(this).attr("wds_fpaddingl", jQuery(this).css("paddingLeft"));
                                    jQuery(this).attr("wds_fpaddingr", jQuery(this).css("paddingRight"));
                                    jQuery(this).attr("wds_fpaddingt", jQuery(this).css("paddingTop"));
                                    jQuery(this).attr("wds_fpaddingb", jQuery(this).css("paddingBottom"));
                                });
                                if (4000) {
                                    jQuery("#wds_container2_0").hover(function () {
                                        jQuery(".wds_right-ico_0").animate({left: 0}, 700, "swing");
                                        jQuery(".wds_left-ico_0").animate({left: 0}, 700, "swing");
                                        jQuery("#wds_slideshow_play_pause_0").animate({opacity: 1, filter: "Alpha(opacity=100)"}, 700, "swing");
                                    }, function () {
                                        jQuery(".wds_right-ico_0").css({left: 4000});
                                        jQuery(".wds_left-ico_0").css({left: -4000});
                                        jQuery("#wds_slideshow_play_pause_0").css({opacity: 0, filter: "Alpha(opacity=0)"});
                                    });
                                }
                                if (!1) {
                                    jQuery("#wds_container2_0").hover(function () {
                                        jQuery(".wds_slideshow_dots_container_0").animate({opacity: 1, filter: "Alpha(opacity=100)"}, 700, "swing");
                                    }, function () {
                                        jQuery(".wds_slideshow_dots_container_0").css({opacity: 0, filter: "Alpha(opacity=0)"});
                                    });
                                }

                                wds_resize_slider_0();
                                jQuery("#wds_container2_0").css({visibility: 'visible'});
                                jQuery(".wds_loading").hide();

                                var curr_img_id = wds_data_0[parseInt(jQuery('#wds_current_image_key_0').val())]["id"];
                                jQuery("#wds_image_id_0_" + curr_img_id).css('transition', 'opacity ' + wds_transition_duration_0 + 'ms linear');
                                var isMobile = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));

                                if (isMobile) {
                                    if (1) {
                                        wds_swipe();
                                    }
                                }
                                else {
                                    if (0) {
                                        wds_swipe();
                                    }
                                }
                                function wds_swipe() {
                                    if (typeof jQuery().swiperight !== 'undefined') {
                                        if (jQuery.isFunction(jQuery().swiperight)) {
                                            jQuery('#wds_container1_0').swiperight(function () {
                                                wds_change_image_0(parseInt(jQuery('#wds_current_image_key_0').val()), (parseInt(jQuery('#wds_current_image_key_0').val()) - wds_iterator_0()) >= 0 ? (parseInt(jQuery('#wds_current_image_key_0').val()) - wds_iterator_0()) % wds_data_0.length : wds_data_0.length - 1, wds_data_0);
                                                return false;
                                            });
                                        }
                                    }
                                    if (typeof jQuery().swipeleft !== 'undefined') {
                                        if (jQuery.isFunction(jQuery().swipeleft)) {
                                            jQuery('#wds_container1_0').swipeleft(function () {
                                                wds_change_image_0(parseInt(jQuery('#wds_current_image_key_0').val()), (parseInt(jQuery('#wds_current_image_key_0').val()) + wds_iterator_0()) % wds_data_0.length, wds_data_0);
                                                return false;
                                            });
                                        }
                                    }
                                }

                                var wds_click = isMobile ? 'touchend' : 'click';

                                var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel"; /* FF doesn't recognize mousewheel as of FF3.x */
                                var wds_play_pause = 0;
                                function wds_play_pause_0() {
                                    if (jQuery(".wds_ctrl_btn_0").hasClass("fa-play") || wds_play_pause) {
                                        wds_play_pause = 0;
                                        /* Play.*/
                                        jQuery(".wds_slideshow_play_pause_0").attr("title", "Pause");
                                        jQuery(".wds_slideshow_play_pause_0").attr("class", "wds_ctrl_btn_0 wds_slideshow_play_pause_0 fa fa-pause");

                                        /* Finish current animation and begin the other.*/
                                        if (1) {
                                            if ('none' != 'top') {
                                                if ('none' != 'bottom') {
                                                    if (typeof circle_timer_animate_0 !== 'undefined') {
                                                        circle_timer_animate_0.stop();
                                                    }
                                                    circle_timer_0(curent_time_deggree_0);
                                                }
                                            }
                                        }
                                        play_0();
                                        if (0) {
                                            document.getElementById("wds_audio_0").play();
                                        }
                                    }
                                    else {
                                        /* Pause.*/
                                        /* Pause layers out effect.*/
                                        wds_play_pause = 1;
                                        var current_key = jQuery('#wds_current_image_key_0').val();
                                        var current_slide_layers_count = wds_data_0[current_key]["slide_layers_count"];
                                        setTimeout(function() {
                                            for (var k = 0; k < current_slide_layers_count; k++) {
                                                clearTimeout(wds_clear_layers_effects_out_0[current_key][k]);
                                            }
                                        }, wds_duration_for_clear_effects_0);

                                        window.clearInterval(wds_playInterval_0);
                                        jQuery(".wds_slideshow_play_pause_0").attr("title", "Play");
                                        jQuery(".wds_slideshow_play_pause_0").attr("class", "wds_ctrl_btn_0 wds_slideshow_play_pause_0 fa fa-play");
                                        if (0) {
                                            document.getElementById("wds_audio_0").pause();
                                        }
                                        if (typeof jQuery().stop !== 'undefined') {
                                            if (jQuery.isFunction(jQuery().stop)) {
                                            }
                                        }
                                    }
                                }
                                /* Mouswheel navigation.*/
                                if (0) {
                                    jQuery('.wds_slide_container_0').bind(mousewheelevt, function(e) {
                                        var evt = window.event || e; /* Equalize event object.*/
                                        evt = evt.originalEvent ? evt.originalEvent : evt; /* Convert to originalEvent if possible.*/
                                        var delta = evt.detail ? evt.detail*(-40) : evt.wheelDelta; /* Check for detail first, because it is used by Opera and FF.*/
                                        if (delta > 0) {
                                            /* Scroll up.*/
                                            wds_change_image_0(parseInt(jQuery('#wds_current_image_key_0').val()), (parseInt(jQuery('#wds_current_image_key_0').val()) - wds_iterator_0()) >= 0 ? (parseInt(jQuery('#wds_current_image_key_0').val()) - wds_iterator_0()) % wds_data_0.length : wds_data_0.length - 1, wds_data_0);
                                        }
                                        else {
                                            /* Scroll down.*/
                                            wds_change_image_0(parseInt(jQuery('#wds_current_image_key_0').val()), (parseInt(jQuery('#wds_current_image_key_0').val()) + wds_iterator_0()) % wds_data_0.length, wds_data_0);
                                        }
                                        return false;
                                    });
                                }
                                /* Keyboard navigation.*/
                                if (0) {
                                    jQuery(document).on('keydown', function (e) {
                                        if (e.keyCode === 39 || e.keyCode === 38) { /* Right arrow.*/
                                            wds_change_image_0(parseInt(jQuery('#wds_current_image_key_0').val()), (parseInt(jQuery('#wds_current_image_key_0').val()) + wds_iterator_0()) % wds_data_0.length, wds_data_0);
                                        }
                                        else if (e.keyCode === 37 || e.keyCode === 40) { /* Left arrow.*/
                                            wds_change_image_0(parseInt(jQuery('#wds_current_image_key_0').val()), (parseInt(jQuery('#wds_current_image_key_0').val()) - wds_iterator_0()) >= 0 ? (parseInt(jQuery('#wds_current_image_key_0').val()) - wds_iterator_0()) % wds_data_0.length : wds_data_0.length - 1, wds_data_0);
                                        }
                                        else if (e.keyCode === 32) { /* Space.*/
                                            wds_play_pause_0();
                                        }
                                    });
                                }
                                /* Play/pause.*/
                                jQuery("#wds_slideshow_play_pause_0").on(wds_click, function () {
                                    wds_play_pause_0();
                                });
                                if (1) {
                                    play_0();

                                    jQuery(".wds_slideshow_play_pause_0").attr("title", "Pause");
                                    jQuery(".wds_slideshow_play_pause_0").attr("class", "wds_ctrl_btn_0 wds_slideshow_play_pause_0 fa fa-pause");
                                    if (0) {
                                        document.getElementById("wds_audio_0").play();
                                    }
                                    if ('none' != 'none') {
                                        if ('none' != 'top') {
                                            if ('none' != 'bottom') {
                                                circle_timer_0(0);
                                            }
                                        }
                                    }
                                }
                                function wds_preload_0(preload_key) {
                                    if (wds_data_0[preload_key]["is_video"] == 'image') {
                                        jQuery('<img />')
                                                .load(function() {
                                                    jQuery(this).remove();
                                                    if (preload_key < wds_data_0.length - 1) wds_preload_0(preload_key + 1);
                                                })
                                                .error(function() {
                                                    jQuery(this).remove();
                                                    if (preload_key < wds_data_0.length - 1) wds_preload_0(preload_key + 1);
                                                })
                                                .attr("src", wds_data_0[preload_key]["image_url"]);
                                    }
                                    else {
                                        if (preload_key < wds_data_0.length - 1) wds_preload_0(preload_key + 1);
                                    }
                                }
                                wds_preload_0(0);
                                var first_slide_layers_count_0 = wds_data_0[0]["slide_layers_count"];
                                if (first_slide_layers_count_0) {
                                    /* Loop through layers in.*/
                                    for (var j = 0; j < first_slide_layers_count_0; j++) {
                                        wds_set_layer_effect_in_0(j, 0);
                                    }
                                    /* Loop through layers out.*/
                                    for (var i = 0; i < first_slide_layers_count_0; i++) {
                                        wds_set_layer_effect_out_0(i, 0);
                                    }
                                }
                                jQuery(".wds_slideshow_filmstrip_0").hover(function() {
                                    jQuery(".wds_slideshow_filmstrip_left_0 i, .wds_slideshow_filmstrip_right_0 i").animate({opacity: 1, filter: "Alpha(opacity=100)"}, 700, "swing");
                                }, function () {
                                    jQuery(".wds_slideshow_filmstrip_left_0 i, .wds_slideshow_filmstrip_right_0 i").animate({opacity: 0, filter: "Alpha(opacity=0)"}, 700, "swing");
                                });
                                jQuery("#wds_container1_0").hover(function() {

                                }, function () {

                                });
                                jQuery("#wds_slideshow_play_pause_0").on("click", ".fa-play", function() {

                                });
                                jQuery("#wds_slideshow_play_pause_0").on("click", ".fa-pause", function() {

                                });
                            }
                            function wds_stop_animation_0() {
                                window.clearInterval(wds_playInterval_0);
                                /* Pause layers out effect.*/
                                var current_key = jQuery('#wds_current_image_key_0').val();
                                var current_slide_layers_count = wds_data_0[current_key]["slide_layers_count"];
                                setTimeout(function() {
                                    for (var k = 0; k < current_slide_layers_count; k++) {
                                        clearTimeout(wds_clear_layers_effects_out_0[current_key][k]);
                                    }
                                }, wds_duration_for_clear_effects_0);
                                if (0) {
                                    document.getElementById("wds_audio_0").pause();
                                }
                                if (typeof jQuery().stop !== 'undefined') {
                                    if (jQuery.isFunction(jQuery().stop)) {
                                        if ('none' == 'top' || 'none' == 'bottom') {
                                            jQuery(".wds_line_timer_0").stop();
                                        }
                                        else if ('none' != 'none') {
                                            circle_timer_animate_0.stop();
                                        }
                                    }
                                }
                            }
                            function wds_play_animation_0() {
                                if (jQuery(".wds_ctrl_btn_0").hasClass("fa-play")) {
                                    return;
                                }
                                play_0();
                                if ('none' != 'none') {
                                    if ('none' != 'bottom') {
                                        if ('none' != 'top') {
                                            if (typeof circle_timer_animate_0 !== 'undefined') {
                                                circle_timer_animate_0.stop();
                                            }
                                            circle_timer_0(curent_time_deggree_0);
                                        }
                                    }
                                }
                                if (0) {
                                    document.getElementById("wds_audio_0").play();
                                }
                            }
                            /* Effects in part.*/
                            function wds_set_layer_effect_in_0(j, key) {
                                wds_clear_layers_effects_in_0[key][j] = setTimeout(function(){
                                    if (wds_data_0[key]["layer_" + j + "_type"] != 'social') {
                                        jQuery('#wds_0_slide' + wds_data_0[key]["id"] + '_layer' + wds_data_0[key]["layer_" + j + "_id"]).css('-webkit-animation-duration' , wds_data_0[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's').css('animation-duration' , wds_data_0[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's');
                                        jQuery('#wds_0_slide' + wds_data_0[key]["id"] + '_layer' + wds_data_0[key]["layer_" + j + "_id"]).removeClass().addClass( wds_data_0[key]["layer_" + j + "_layer_effect_in"] + ' wds_animated');
                                        jQuery('#wds_0_slide' + wds_data_0[key]["id"] + '_layer' + wds_data_0[key]["layer_" + j + "_id"]).addClass(jQuery('#wds_0_slide' + wds_data_0[key]["id"] + '_layer' + wds_data_0[key]["layer_" + j + "_id"]).data("class"));
                                    }
                                    else {
                                        jQuery('#wds_0_slide' + wds_data_0[key]["id"] + '_layer' + wds_data_0[key]["layer_" + j + "_id"]).css('-webkit-animation-duration' , wds_data_0[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's').css('animation-duration' , wds_data_0[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's');
                                        jQuery('#wds_0_slide' + wds_data_0[key]["id"] + '_layer' + wds_data_0[key]["layer_" + j + "_id"]).removeClass().addClass( wds_data_0[key]["layer_" + j + "_layer_effect_in"] + ' fa fa-' + wds_data_0[key]["layer_" + j + "_social_button"] + ' wds_animated');
                                    }
                                    /* Play video on layer in.*/
                                    if (wds_data_0[key]["layer_" + j + "_type"] == "video") {
                                        if (wds_data_0[key]["layer_" + j + "_video_autoplay"] == "on") {
                                            jQuery('#wds_0_slide' + wds_data_0[key]["id"] + '_layer' + wds_data_0[key]["layer_" + j + "_id"]).find("iframe").each(function () {
                                                jQuery(this)[0].contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
                                                jQuery(this)[0].contentWindow.postMessage('{ "method": "play" }', "*");
                                            });
                                        }
                                    }
                                }, wds_data_0[key]["layer_" + j + "_start"]);
                            }
                            /* Effects out part.*/
                            function wds_set_layer_effect_out_0(i, key) {
                                wds_clear_layers_effects_out_0[key][i] = setTimeout(function() {
                                    if (wds_data_0[key]["layer_" + i + "_layer_effect_out"] != 'none') {
                                        if (wds_data_0[key]["layer_" + i + "_type"] != 'social') {
                                            jQuery('#wds_0_slide' + wds_data_0[key]["id"] + '_layer' + wds_data_0[key]["layer_" + i + "_id"]).css('-webkit-animation-duration' , wds_data_0[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's').css('animation-duration' , wds_data_0[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's');
                                            jQuery('#wds_0_slide' + wds_data_0[key]["id"] + '_layer' + wds_data_0[key]["layer_" + i + "_id"]).removeClass().addClass( wds_data_0[key]["layer_" + i + "_layer_effect_out"] + ' wds_animated');
                                        }
                                        else {
                                            jQuery('#wds_0_slide' + wds_data_0[key]["id"] + '_layer' + wds_data_0[key]["layer_" + i + "_id"]).css('-webkit-animation-duration' , wds_data_0[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's').css('animation-duration' , wds_data_0[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's');
                                            jQuery('#wds_0_slide' + wds_data_0[key]["id"] + '_layer' + wds_data_0[key]["layer_" + i + "_id"]).removeClass().addClass( wds_data_0[key]["layer_" + i + "_layer_effect_out"] + ' fa fa-' + wds_data_0[key]["layer_" + i + "_social_button"] + ' wds_animated');
                                        }
                                    }
                                }, wds_data_0[key]["layer_" + i + "_end"]);
                            }
                            function play_0() {
                                if ('none' != 'none') {
                                    if (1 || jQuery('.wds_ctrl_btn_0').hasClass('fa-pause')) {
                                        jQuery(".wds_line_timer_0").animate({
                                            width: "100%"
                                        }, {
                                            duration: 4000,
                                            specialEasing: {width: "linear"}
                                        });
                                    }
                                }
                                window.clearInterval(wds_playInterval_0);
                                /* Play.*/
                                wds_playInterval_0 = setInterval(function () {
                                    var curr_img_index = parseInt(jQuery('#wds_current_image_key_0').val());
                                    if ('1' == 0) {
                                        if (curr_img_index == 3) {
                                            return false;
                                        }
                                    }
                                    var iterator = 1;
                                    if (0) {
                                        iterator = Math.floor((wds_data_0.length - 1) * Math.random() + 1);
                                    }
                                    wds_change_image_0(parseInt(jQuery('#wds_current_image_key_0').val()), (parseInt(jQuery('#wds_current_image_key_0').val()) + iterator) % wds_data_0.length, wds_data_0);
                                }, parseInt('4000') + wds_duration_for_change_0);
                            }
                            jQuery(window).focus(function() {
                                if (!jQuery(".wds_ctrl_btn_0").hasClass("fa-play")) {
                                    if (1) {
                                        play_0();
                                        if ('none' != 'none') {
                                            if ('none' != 'top') {
                                                if ('none' != 'bottom') {
                                                    if (typeof circle_timer_animate_0 !== 'undefined') {
                                                        circle_timer_animate_0.stop();
                                                    }
                                                    circle_timer_0(curent_time_deggree_0);
                                                }
                                            }
                                        }
                                    }
                                }
                                var i_0 = 0;
                                jQuery(".wds_slider_0").children("span").each(function () {
                                    if (jQuery(this).css('opacity') == 1) {
                                        jQuery("#wds_current_image_key_0").val(i_0);
                                    }
                                    i_0++;
                                });
                            });
                            jQuery(window).blur(function() {
                                wds_event_stack_0 = [];
                                window.clearInterval(wds_playInterval_0);
                                if (typeof jQuery().stop !== 'undefined') {
                                    if (jQuery.isFunction(jQuery().stop)) {
                                        if ('none' == 'top' || 'none' == 'bottom') {
                                            jQuery(".wds_line_timer_0").stop();
                                        }
                                        else if ('none' != 'none') {
                                            circle_timer_animate_0.stop();
                                        }
                                    }
                                }
                            });
                        </script>
                    </aside></div><div class='dt-sc-hr '></div><div  class='column dt-sc-one-third  first'><h3 style="text-align: center;">ACTUALITE</h3>
                        <div id="basic-container"><article class="basic-layout lptw-columns-fixed layout-no-overlay" style="width: 300px; height: 190px; padding-bottom: 10px; ">
                            <header>
                                <a class="overlay overlay-no-overlay lptw-post-thumbnail-link" href="http://www.instic.fr/aternance-ateliers-daide-a-recherche-dentreprises-7837" target="_self"><span class="fluid-image-wrapper"><img src="http://www.instic.fr/wp-content/uploads/atelier-recherche-entreprise-alternance-300x200.jpg" alt="Aternance : ateliers d&rsquo;aide à la recherche d&rsquo;entreprises" class="fluid" /></span>
                                </a><div class="lptw-post-header"><a class="lptw-post-title title-no-overlay" href="http://www.instic.fr/aternance-ateliers-daide-a-recherche-dentreprises-7837" target="_self">Aternance : ateliers d&rsquo;aide à la recherche d&rsquo;entreprises</a>
                            </div>
                            </header></article>
                        </div>
                        <a href='http://www.instic.fr/blog' target="_self" class='dt-sc-button  small  aligncenter '  style="background-color:#009fe3;border-color:#009fe3;">VOIR TOUT</a></div><div  class='column dt-sc-one-third  '><h3 style="text-align:center;"><a href="http://www.instic.fr/offres">OFFRES ALTERNANCE</a></h3>
                        <p><a href="http://www.instic.fr/offres"><img src="http://www.instic.fr/wp-content/uploads/offe-alternance.png" alt="offres alternance INSTIC" width="300" height="200" class="alignleft size-full wp-image-7302"></a></p>
                        <a href='http://www.instic.fr/offres' target="_self" class='dt-sc-button  small  aligncenter '  style="background-color:#009fe3;border-color:#009fe3;">VOIR TOUT</a></div>

                        <div  class='column dt-sc-one-third  '><h3 style="text-align: center;">FORMATIONS</h3>
                        <p><a title="Formations" href="http://www.instic.fr/formations"><img class=" wp-image-7235 size-full aligncenter" src="http://www.instic.fr/wp-content/uploads/formations-INSTIC.png" alt="listing-formation" width="300" height="200"></a></p>
                        <a href='http://www.instic.fr/formations' target="_self" class='dt-sc-button  small  aligncenter '  style="background-color:#009fe3;border-color:#009fe3;">VOIR TOUT</a>
                        </div>

                        <div  class='column dt-sc-full-width  first'></div><div class='dt-sc-hr '></div><div  class='column dt-sc-full-width  first'>

                        <!-- Code JB HENARD -->
                            <div id="tasks">
                                <ul class="tabs primary clearfix">
                                    <li><a href="http://localhost/cpro_dev/instic_creationcompte.php" class="blanc">Créer un nouveau compte</a></li>
                                    <li><a href="http://localhost/cpro_dev/instic_inscription.php" class="blanc">Se connecter</a></li>
                                    <li><a href="http://localhost/cpro_dev/instic_nouveaumdp.php" class="blanc">Demander un nouveau mot de passe</a></li>
                                </ul>
                            </div>

                            <h4 class="blanc" id="h4menu">Création espace Candidat</h4>
                            <form method="post" id="user-register-form" accept-charset="UTF-8">
                                <div class="form-item form-type-textfield form-item-name">
                                    <label for="edit-name" class="blanc">Titre du Candidat <span class="form-required blanc" title="Ce champ est obligatoire.">*</span></label>
                                    <input style="margin-bottom: 2px;" class="username form-text required" type="text" id="edit-name" name="titre" value="<?php if(isset($_POST['titre'])) {echo $_POST['titre'];} ?>" size="60" maxlength="60" />
                                    <div class="description">
                                        Saisir Monsieur, Madame, Professeur, etc.
                                    </div>

                                    <label for="edit-name" class="blanc">Nom du Candidat <span class="form-required blanc" title="Ce champ est obligatoire.">*</span></label>
                                    <input class="username form-text required" type="text" id="edit-name" name="nom" value="<?php if(isset($_POST['nom'])) {echo $_POST['nom'];} ?>" size="60" maxlength="60" />

                                    <label for="edit-name" class="blanc">Prénom du Candidat <span class="form-required blanc" title="Ce champ est obligatoire.">*</span></label>
                                    <input style="margin-bottom: 2px;" class="username form-text required" type="text" id="edit-name" name="prenom" value="<?php if(isset($_POST['prenom'])) {echo $_POST['prenom'];} ?>" size="60" maxlength="60" />
                                    <div class="description">
                                        Les espaces sont autorisés ; la ponctuation n'est pas autorisée à l'exception des points, traits d'union, apostrophes et tirets bas.
                                    </div>
                                </div>

                                <div class="form-item form-type-textfield form-item-mail">
                                    <label for="edit-mail" class="blanc">Adresse de courriel <span class="form-required blanc" title="Ce champ est obligatoire.">*</span></label>
    <!--
    <input style="margin-bottom: 2px;" type="text" id="edit-mail" name="mail" value="<?php if(isset($_POST['mail'])) {echo $_POST['mail'];} ?>" size="60" maxlength="254" class="form-text required" />
    -->
    <input style="margin-bottom: 2px;" type="text" id="mail" data-inputmask="'alias': 'email'" name="mail" value="<?php if(isset($_POST['mail'])) {echo $_POST['mail'];} ?>" size="15" maxlength="60" class="form-text required" />
                                    <div class="description">
                                        Une adresse électronique valide. Le système enverra tous les courriels à cette adresse.
                                        L'adresse électronique ne sera pas rendue publique et ne sera utilisée que pour la réception d'un nouveau mot de passe ou pour la réception de certaines notifications désirées.
                                    </div>
                                </div>

                                <div class="form-item form-type-password-confirm form-item-pass">
                                    <div class="form-item form-type-password form-item-pass-pass1">
                                        <label for="edit-pass-pass1" class="blanc">Mot de passe <span class="form-required blanc" title="Ce champ est obligatoire.">*</span></label>
                                        <input class="password-field form-text required" type="password" id="edit-pass-pass1" name="mdp1" value="<?php if(isset($_POST['mdp1'])) {echo $_POST['mdp1'];} ?>" size="25" maxlength="128" />
                                    </div>
                                    <div class="form-item form-type-password form-item-pass-pass2">
                                        <label for="edit-pass-pass2" class="blanc">Confirmer le mot de passe <span class="form-required blanc" title="Ce champ est obligatoire.">*</span></label>
                                        <input style="margin-bottom: 2px;" class="password-confirm form-text required" type="password" id="edit-pass-pass2" name="mdp2" value="<?php if(isset($_POST['mdp2'])) {echo $_POST['mdp2'];} ?>" size="25" maxlength="128" />
                                    </div>

                                    <div class="description">
                                        Saisissez un mot de passe pour le nouveau compte dans les deux champs.
                                    </div>
                                </div>

                                <div class="description">
                                    <?php
                                    // Si des erreurs ont été trouvée, les afficher sous forme de liste
                                    if (count($errsCEC) > 0) {
                                        echo "<ul>";
                                        echo "<br/>";
                                        echo "<li>Attention!</li>";
                                        foreach ($errsCEC as $champEnErreur => $erreursDuChamp) {
                                            foreach ($erreursDuChamp as $erreur) {
                                                echo "<li>".$erreur."</li>";
                                            }
                                        }
                                        echo "</ul>";
                                    }
                                    ?>
                                </div>
                                <div class="form-actions form-wrapper" id="edit-actions">
                                    <input type="submit" id="edit-submit" name="submit" value="Créer un nouveau compte" class="form-submit" />
                                </div>
                            </form>

                             <!--
                            ================================================================================================================
                            Formation(s) envisagée(s)
                            ================================================================================================================
                            -->
                            <br/>

                            <hr/>
                            <h5 class="h5menu"">Formation(s) envisagée(s)</h5>
                            <form method="post" id="user-register-form" accept-charset="UTF-8">
                                <table class="margetable" style="background">
                                    <th style="text-align: left; width: 580px;">ARTS GRAPHIQUES / WEBDESIGN</th><th>Initial</th><th>Alternance</th>
                                    <tr class="margetable">
                                        <td class="txtmilieu margetable blanc" style="width: 580px; text-align: left; background-color: #009ee3; border-color: #009ee3;">
                                            <label for="edit-mail" class="margetable blanc">Infographiste Multimédia (BAC + 2)</label>
                                        </td>                                            
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l1choix1" name="l1choix1" value="1" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($errsFE['l1choix1'])) { ?> autofocus <?php } ?> <?php if(!empty($tabchoix2['l1choix1'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l1choix2" name="l1choix2" value="2" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l1choix2'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                    </tr>
                                    <tr class="margetable">
                                        <td class="txtmilieu margetable blanc" style="width: 580px; text-align: left; background-color: #009ee3; border-color: #009ee3;">
                                            <label for="edit-mail" class="margetable blanc">CQP Concepteur réalisateur graphiste (BAC + 2)</label>
                                        </td>                                            
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l2choix1" name="l2choix1" value="1" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l2choix1'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l2choix2" name="l2choix2" value="2" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l2choix2'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                    </tr>
                                </table>
                                
                                <table class="margetable" style="background">
                                    <th style="width: 580px; text-align: left;">DEVELOPPEMENT WEB</th><th>Initial</th><th>Alternance</th>
                                    <tr class="margetable">
                                        <td class="txtmilieu margetable blanc" style="width: 580px; text-align: left; background-color: #009ee3; border-color: #009ee3;">
                                            <label for="edit-mail" class="margetable blanc">Développeur logiciel (BAC + 2)</label>
                                        </td>                                            
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l3choix1" name="l3choix1" value="1" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l3choix1'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l3choix2" name="l3choix2" value="2" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l3choix2'][0])) { ?> checked <?php } ?>/>
                                            <!--if (!empty($tabchoix2['l3choix2'][0]))-->
                                        </td>
                                    </tr>
                                    <tr class="margetable">
                                        <td class="txtmilieu margetable blanc" style="width: 580px; text-align: left; background-color: #009ee3; border-color: #009ee3;">
                                            <label for="edit-mail" class="margetable blanc">Concepteur développeur informatique (BAC + 3)</label>
                                        </td>                                            
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l4choix1" name="l4choix1" value="1" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l4choix1'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l4choix2" name="l4choix2" value="2" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l4choix2'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                    </tr>
                                </table>
                                
                                <table class="margetable" style="background">
                                    <th style="width: 580px; text-align: left;">BUREAUX D'ETUDES</th><th>Initial</th><th>Alternance</th>
                                    <tr class="margetable">
                                        <td class="txtmilieu margetable blanc" style="width: 580px; text-align: left; background-color: #009ee3; border-color: #009ee3;">
                                            <label for="edit-mail" class="margetable blanc">Technicien supérieur en conception industrielle de systèmes mécaniques (BAC + 2)</label>
                                        </td>                                            
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l5choix1" name="l5choix1" value="1" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l5choix1'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l5choix2" name="l5choix2" value="2" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l5choix2'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                    </tr>
                                    <tr class="margetable">
                                        <td class="txtmilieu margetable blanc" style="width: 580px; text-align: left; background-color: #009ee3; border-color: #009ee3;">
                                            <label for="edit-mail" class="margetable blanc">CQP Dessinateur Bureau d'étude (option mécanique/électricité ou bâtiment)(BAC + 2)</label>
                                        </td>                                            
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l6choix1" name="l6choix1" value="1" size="5" maxlength="5" class="form-text required margetable"/>
                                        </td>
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l6choix2" name="l6choix2" value="2" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l6choix2'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                    </tr>
                                    <tr class="margetable">
                                        <td class="txtmilieu margetable blanc" style="width: 580px; text-align: left; background-color: #009ee3; border-color: #009ee3;">
                                            <label for="edit-mail" class="margetable blanc">CQP Concepteur modélisateur numérique de produits ou de systèmes mécaniques (BAC + 3)</label>
                                        </td>                                            
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l7choix1" name="l7choix1" value="1" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l7choix1'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l7choix2" name="l7choix2" value="2" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l7choix2'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                    </tr>
                                </table>
                                
                                <table class="margetable" style="background">
                                    <th style="width: 580px; text-align: left;">DEVELOPPEMENT DURABLE</th><th>Initial</th><th>Alternance</th>
                                    <tr class="margetable">
                                        <td class="txtmilieu margetable blanc" style="width: 580px; text-align: left; background-color: #009ee3; border-color: #009ee3;">
                                            <label for="edit-mail" class="margetable blanc">CQP Technicien de la qualité</label>
                                        </td>                                            
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l8choix1" name="l8choix1" value="1" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l8choix1'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l8choix2" name="l8choix2" value="2" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l8choix2'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                    </tr>
                          
                                    <tr class="margetable">
                                        <td class="txtmilieu margetable blanc" style="width: 580px; text-align: left; background-color: #009ee3; border-color: #009ee3;">
                                            <label for="edit-mail" class="margetable blanc">Bachelor Animateur Qualité, Sécurité, Environnement (BAC + 3)</label>
                                        </td>                                            
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l9choix1" name="l9choix1" value="1" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l9choix1'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l9choix2" name="l9choix2" value="2" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l9choix2'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                    </tr>
                                    <tr class="margetable">
                                        <td class="txtmilieu margetable blanc" style="width: 580px; text-align: left; background-color: #009ee3; border-color: #009ee3;">
                                            <label for="edit-mail" class="margetable blanc">Master Management Opérationnel du Développement Durable (BAC + 5)</label>
                                        </td>                                            
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l10choix1" name="l10choix1" value="1" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l10choix1'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                        <td class="margetable" style="background-color: #009ee3; border-color: #009ee3;">
                                            <input style="margin: 0px 0 2px;" type="checkbox" id="l10choix2" name="l10choix2" value="2" size="5" maxlength="5" class="form-text required margetable" <?php if(!empty($tabchoix2['l10choix2'][0])) { ?> checked <?php } ?>/>
                                        </td>
                                    </tr>
                                </table>
                                
                                    <div class="description">
                                    <?php
                                    // Si des erreurs ont été trouvée, les afficher sous forme de liste
                                    if (count($errsFE) > 0) {
                                        echo "<ul>";
                                        echo "<br/>";
                                        echo "<li>Attention!</li>";
                                        foreach ($errsFE as $champEnErreur => $erreursDuChamp) {
                                            foreach ($erreursDuChamp as $erreur) {
                                                echo "<li>".$erreur."</li>";
                                            }
                                        }
                                        echo "</ul>";
                                    }
                                    ?>
                                </div>

                                <div class="form-actions form-wrapper" id="edit-actions">                                
                                    <input type="submit" id="edit-submit" name="submitFE" value="MàJ Formation(s) envisagée(s)" class="form-submit" />
                                </div>

                            </form>

                            <!-- Fin code JB HENARD -->


                        </div>

                        <div class='dt-sc-hr '></div>
                        <div  class='column dt-sc-three-fourth  first'>
                            <h4>INSTIC</h4>
                        <h5>Institut supérieur des techniques industrielles et de la communication</h5>
                        <address>99 Rue de Gerland, 69007 Lyon  04.72.72.01.01 &#8211; messages@instic.fr  www.instic.fr</address>
                        <p>&nbsp;</p></div><div  class='column dt-sc-one-fourth  '><h4><font><font><font><font><font><font><font><font><font><font>REJOIGNEZ-NOUS !</font></font></font></font></font></font></font></font></font></font></h4>
                        <p><font><font><ul class='social-media'><li><a href="https://www.facebook.com/insticformation" onclick="_gaq.push(['_trackEvent', 'outbound-article', 'https://www.facebook.com/insticformation', '']);" class='fa fa-facebook'></a></li><li><a href="https://twitter.com/instic_ecole?lang=fr" onclick="_gaq.push(['_trackEvent', 'outbound-article', 'https://twitter.com/instic_ecole?lang=fr', '']);" class='fa fa-twitter'></a></li><li><a href="https://www.linkedin.com/company/instic" onclick="_gaq.push(['_trackEvent', 'outbound-article', 'https://www.linkedin.com/company/instic', '']);" class='fa fa-linkedin'></a></li><li><a href="https://plus.google.com/u/0/+InsticFr" onclick="_gaq.push(['_trackEvent', 'outbound-article', 'https://plus.google.com/u/0/+InsticFr', '']);" class='fa fa-google-plus'></a></li></ul><p class='social-media-text'>Suivez INSTIC&nbsp;!</p></font></font></p></div>
                        <div class="social-bookmark"></div>                  </article>
                </section>
            </div>
        </div>
        <!-- content ends here -->

        <footer id="footer">
            <div class="footer-top-links">
                <div class="container">
                    <ul id="menu-menu-footer" class="menu"><li id="menu-item-6790" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-2 current_page_item menu-item-6790"><a href="http://www.instic.fr/">INSTIC – Institut supérieur des techniques industrielles et de la communication</a></li>
                        <li id="menu-item-6791" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6791"><a href="http://www.cti-formation.fr/offres-en-cours" onclick="_gaq.push(['_trackEvent', 'outbound-widget', 'http://www.cti-formation.fr/offres-en-cours', 'Offres alternance']);" >Offres alternance</a></li>
                        <li id="menu-item-4909" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4909"><a href="http://www.instic.fr/demande-documentation">Demande de documentation</a></li>
                        <li id="menu-item-4910" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4910"><a href="http://www.instic.fr/tarifs">Tarifs</a></li>
                        <li id="menu-item-4913" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4913"><a href="http://www.instic.fr/entreprises-partenaires">Entreprises partenaires</a></li>
                        <li id="menu-item-4914" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4914"><a href="http://www.instic.fr/presentation-ecole">Carte d&rsquo;identité</a></li>
                        <li id="menu-item-6795" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6795"><a href="http://www.instic.fr/pao-infographie-web">PAO / Infographie / Webdesign</a></li>
                        <li id="menu-item-6792" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6792"><a href="http://www.instic.fr/cao-dao-design-industriel">CAO / DAO / Design Industriel</a></li>
                        <li id="menu-item-6794" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6794"><a href="http://www.instic.fr/developpement-web">Développement Web</a></li>
                        <li id="menu-item-6793" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-6793"><a href="http://www.instic.fr/developpement-durable-qualite-securite-environnement">Développement durable / Qualité / Sécurité / Environnement</a></li>
                        <li id="menu-item-4928" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4928"><a href="http://www.cti-formation.fr/" onclick="_gaq.push(['_trackEvent', 'outbound-widget', 'http://www.cti-formation.fr/', 'www.cti-formation']);" title="www.cti-formation">www.cti-formation</a></li>
                    </ul>
                </div>
            </div>


            <div class="footer-info">
                <div class="container">

                    <ul class="menu"><li class="page_item page-item-5335"><a href="http://www.instic.fr/bac-2-developpeur-logiciel">Bac +2 Développeur(se) logiciel</a></li>
                        <li class="page_item page-item-37"><a href="http://www.instic.fr/infographiste-multimedia">Bac +2 Infographiste multimédia</a></li>
                        <li class="page_item page-item-21"><a href="http://www.instic.fr/tscism-technicien-en-conception-industrielle-systemes-mecaniques">Bac +2 Technicien Supérieur en conception industrielle de systèmes mécaniques</a></li>
                        <li class="page_item page-item-101"><a href="http://www.instic.fr/bac-3-bachelor-animateur-qualite-securite-environnement">Bac +3 Bachelor Animateur Qualité, Sécurité, Environnement</a></li>
                        <li class="page_item page-item-43"><a href="http://www.instic.fr/concepteur-developpeur-informatique">Bac +3 Concepteur(trice) développeur(se) informatique</a></li>
                        <li class="page_item page-item-104"><a href="http://www.instic.fr/bac-5-master-management-operationnel-du-developpement-durable">Bac +5 Master management Opérationnel du Développement durable</a></li>
                        <li class="page_item page-item-81"><a href="http://www.instic.fr/blog">Blog</a></li>
                        <li class="page_item page-item-18"><a href="http://www.instic.fr/cao-dao-design-industriel">CAO / DAO / Design Industriel</a></li>
                        <li class="page_item page-item-6195"><a href="http://www.instic.fr/compte-personnel-de-formation-cpf">Compte personnel de formation (CPF)</a></li>
                        <li class="page_item page-item-6615"><a href="http://www.instic.fr/digital-learning-connexion">Connexion digital learning</a></li>
                        <li class="page_item page-item-77"><a href="http://www.instic.fr/contact">Contact</a></li>
                        <li class="page_item page-item-110"><a href="http://www.instic.fr/cqp-animateur-hygiene-securite-environnement">CQP Animateur hygiène, sécurité, environnement</a></li>
                        <li class="page_item page-item-5402"><a href="http://www.instic.fr/cqp-concepteur-modelisateur-numerique-de-produit-ou-de-systemes-mecaniques">CQP Concepteur modélisateur numérique de produit ou de systèmes mécaniques</a></li>
                        <li class="page_item page-item-6374"><a href="http://www.instic.fr/cqp-concepteur-realisateur-graphique-2">CQP Concepteur réalisateur graphique</a></li>
                        <li class="page_item page-item-5338"><a href="http://www.instic.fr/cqp-dessinateur-bureau-detude">CQP Dessinateur bureau d&rsquo;étude</a></li>
                        <li class="page_item page-item-6691"><a href="http://www.instic.fr/deconnexion-digital-learning">Déconnexion digital learning</a></li>
                        <li class="page_item page-item-4865"><a href="http://www.instic.fr/demande-documentation">Demande de documentation</a></li>
                        <li class="page_item page-item-7610"><a href="http://www.instic.fr/deposez-offre-demploi">Déposez votre offre d&#8217;emploi</a></li>
                        <li class="page_item page-item-56"><a href="http://www.instic.fr/developpement-durable-qualite-securite-environnement">Développement durable / Qualité / Sécurité / Environnement</a></li>
                        <li class="page_item page-item-51"><a href="http://www.instic.fr/developpement-web">Développement Web</a></li>
                        <li class="page_item page-item-6876"><a href="http://www.instic.fr/digital-learning">Digital Learning</a></li>
                        <li class="page_item page-item-5289"><a href="http://www.instic.fr/dossier-de-candidature">Dossier de candidature</a></li>
                        <li class="page_item page-item-74"><a href="http://www.instic.fr/entreprises">Entreprises</a></li>
                        <li class="page_item page-item-4843"><a href="http://www.instic.fr/entreprises-partenaires">Entreprises partenaires</a></li>
                        <li class="page_item page-item-6970"><a href="http://www.instic.fr/erreur">Erreur</a></li>
                        <li class="page_item page-item-4891"><a href="http://www.instic.fr/espace-entreprise">Espace entreprise</a></li>
                        <li class="page_item page-item-15"><a href="http://www.instic.fr/formations">Formations</a></li>
                        <li class="page_item page-item-71"><a href="http://www.instic.fr/inscription">Inscription</a></li>
                        <li class="page_item page-item-5632"><a href="http://www.instic.fr/inscription-reunion-dinformation-pao-web-informatique">Inscription réunion d&rsquo;information Arts graphiques / Web / Informatique et réseaux</a></li>
                        <li class="page_item page-item-6162"><a href="http://www.instic.fr/inscription-reunion-dinformation-bureau-detudes-cao-qse-developpement-durable">inscription réunion d&rsquo;information Bureau d&rsquo;études / CAO / QSE / Développement durable</a></li>
                        <li class="page_item page-item-2 current_page_item"><a href="http://www.instic.fr/">INSTIC &#8211; Institut supérieur des techniques industrielles et de la communication</a></li>
                        <li class="page_item page-item-6071"><a href="http://www.instic.fr/joomla-bases-et-perfectionnement-cms">Joomla : Bases et perfectionnement &#8211; CMS</a></li>
                        <li class="page_item page-item-7609"><a href="http://www.instic.fr/offres">Offres alternance</a></li>
                        <li class="page_item page-item-34"><a href="http://www.instic.fr/pao-infographie-web">PAO / Infographie / Webdesign</a></li>
                        <li class="page_item page-item-4834"><a href="http://www.instic.fr/presentation-ecole">Présentation école</a></li>
                        <li class="page_item page-item-4862"><a href="http://www.instic.fr/reglement-interieur">Règlement intérieur</a></li>
                        <li class="page_item page-item-7078"><a href="http://www.instic.fr/reunions-dinformation">Réunions d&rsquo;information</a></li>
                        <li class="page_item page-item-7081"><a href="http://www.instic.fr/reunions-information-cao-dao">Réunions d&rsquo;information CAO/DAO</a></li>
                        <li class="page_item page-item-7100"><a href="http://www.instic.fr/reunions-dinformation-infographieweb">Réunions d&rsquo;information Infographie/Web</a></li>
                        <li class="page_item page-item-7111"><a href="http://www.instic.fr/reunions-dinformation-qsedev-durable">Réunions d&rsquo;information QSE/Dév. durable</a></li>
                        <li class="page_item page-item-4856"><a href="http://www.instic.fr/tarifs">Tarifs</a></li>
                    </ul>                </div>
            </div>
        </footer>
    </div>
</div>
<link rel='stylesheet' id='wds_frontend-css'  href='http://www.instic.fr/wp-content/plugins/slider-wd/css/wds_frontend.css?ver=1.1.42' type='text/css' media='all' />
<link rel='stylesheet' id='wds_effects-css'  href='http://www.instic.fr/wp-content/plugins/slider-wd/css/wds_effects.css?ver=1.1.42' type='text/css' media='all' />
<link rel='stylesheet' id='wds_font-awesome-css'  href='http://www.instic.fr/wp-content/plugins/slider-wd/css/font-awesome-4.0.1/font-awesome.css?ver=4.0.1' type='text/css' media='all' />
<script type='text/javascript' src='http://www.instic.fr/wp-content/plugins/designthemes-core-features/shortcodes/js/jquery.tipTip.minified.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/plugins/designthemes-core-features/shortcodes/js/jquery.tabs.min.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/plugins/designthemes-core-features/shortcodes/js/jquery.viewport.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/plugins/designthemes-core-features/shortcodes/js/shortcodes.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/plugins/designthemes-core-features/page-builder/js/jquery.inview.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/plugins/designthemes-core-features/page-builder/js/custom-public.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-includes/js/masonry.min.js?ver=3.1.2'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-includes/js/jquery/jquery.masonry.min.js?ver=3.1.2'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/plugins/advanced-recent-posts/lptw-recent-posts.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/plugins/contact-form-7/includes/js/jquery.form.min.js?ver=3.51.0-2014.06.20'></script>
<script type='text/javascript'>
    /* <![CDATA[ */
    var _wpcf7 = {"loaderUrl":"http:\/\/www.instic.fr\/wp-content\/plugins\/contact-form-7\/images\/ajax-loader.gif","recaptchaEmpty":"Merci de confirmer que vous n\u2019\u00eates pas un robot.","sending":"Envoi en cours...","cached":"1"};
    /* ]]> */
</script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/plugins/contact-form-7/includes/js/scripts.js?ver=4.4.2'></script>
<script type='text/javascript' src='http://w.sharethis.com/button/st_insights.js'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/plugins/simple-share-buttons-adder/js/ssba.min.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/retina.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.sticky.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.smartresize.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.nicescroll.min.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery-smoothscroll.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery-easing-1.3.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.inview.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.validate.min.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.carouFredSel-6.2.0-packed.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.isotope.min.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.prettyPhoto.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.ui.totop.min.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.meanmenu.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/contact.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.donutchart.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.fitvids.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.bxslider.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.parallax-1.1.3.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/jquery.animateNumber.min.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-content/themes/guru/framework/js/public/custom.js?ver=931338860a52f1d30c1477a93366f485'></script>
<script type='text/javascript' src='http://www.instic.fr/wp-includes/js/wp-embed.min.js?ver=931338860a52f1d30c1477a93366f485'></script>

<!-- JBH debut -  jquery.inputmask 3.x - jquery.inputmask is a jQuery plugin which creates an input mask. 
<script src="javascripts/scale.fix.js"></script>
<script src="extra/phone-codes/phone.js"></script>
-->
<script src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
<script src="dist/jquery.inputmask.bundle.js"></script>  

<script language="javascript">
$(document).ready(function(){ $(":input").inputmask(); });
</script>
<!-- JBH debut -->

</body>
</html>
<!-- Dynamic page generated in 1.388 seconds. -->
<!-- Cached page generated by WP-Super-Cache on 2016-07-21 12:47:11 -->

<!-- Compression = gzip -->