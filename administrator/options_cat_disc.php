<?php
///////////////////////////////////////////////////////////////////////////////////////////
///Script PHP/MYSQL de gestion de petites annonces développé par Script PAG
///Script PAG tout droits réservé. Utilisation sous licence. http://www.script-pag.com
///////////////////////////////////////////////////////////////////////////////////////////

############################################################

require_once('includes/all_adm_functions.php');

///////////////////////////////////
//Vérifier si le super admin est connecté
//////////////////////////////////

if(!empty($_SESSION['valid_admin']))
$valid_admin = $_SESSION['valid_admin'];

if(!check_super_admin() && !check_admin())
redirect("index.php");

///////////////////////////////////
//Initialisation de la variable $error
//////////////////////////////////

$error = '';

///////////////////////////////////
//Gestion de l'erreur
//////////////////////////////////

if(isset($_POST['cat']) && empty($_POST['cat']))
$error = 1;

///////////////////////////////////
//Application ou retrait de la note
//////////////////////////////////

if(!empty($_POST['valide']) && empty($error))
{
	$cat = (int) $_POST['cat'];
	$disc = (!empty($_POST['disc'])) ? $_POST['disc'] : '0';
	
	attribuer_disc($disc, $cat);
	creer_cache_categories();
	$conn = null;
	
	$texte_info = $language_adm['page_disc_cat_re_info'];
	$texte = $language_adm['page_disc_cat_re'];
	
	htm_admin_header();
	htm_menu();
	display_text($texte_info, $texte);
	htm_admin_footer();
}
else
{
	$conn = null;
	htm_admin_header();
	htm_menu();
	htm_option_categorie_disc($error);
	htm_admin_footer();
}