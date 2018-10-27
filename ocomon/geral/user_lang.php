<?php  
header('Content-Type: text/html; charset=iso-8859-1');
/*                        Copyright 2005 Flávio Ribeiro

         This file is part of OCOMON.

         OCOMON is free software; you can redistribute it and/or modify
         it under the terms of the GNU General Public License as published by
         the Free Software Foundation; either version 2 of the License, or
         (at your option) any later version.

         OCOMON is distributed in the hope that it will be useful,
         but WITHOUT ANY WARRANTY; without even the implied warranty of
         MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
         GNU General Public License for more details.

         You should have received a copy of the GNU General Public License
         along with Foobar; if not, write to the Free Software
         Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */session_start();

	include ("../../includes/include_geral.inc.php");
	include ("../../includes/include_geral_II.inc.php");

	$conec = new conexao;
	$conect=$conec->conecta('MYSQL');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8">
<?php	
	include ('includes/header.php');
?>	
</head>
<body bgcolor="<?php echo BODY_COLOR;?>">
<?php
	$auth = new auth;
	$auth->testa_user($_SESSION['s_usuario'],$_SESSION['s_nivel'],$_SESSION['s_nivel_desc'],4);

	$sqlUserLang = "SELECT * FROM uprefs WHERE upref_uid = ".$_SESSION['s_uid']."";
	$execUserLang = mysqli_query($conect, $sqlUserLang) or die (TRANS('MSG_ERR_RESCUE_INFO_THEME_USER'));
	$rowUL = mysqli_fetch_array($execUserLang);
	$hasUL = mysqli_num_rows($execUserLang);
?>

	<br>
	<b><?php echo TRANS('TTL_THEME');?>: </b>
	<br>

	<form name='form1' method='post' action='<?php echo $_SERVER['PHP_SELF'];?>' > <!-- //onSubmit="return valida()" -->
		<table border='0' cellpadding='5' cellspacing='0'  width='60%' >
<?php
	if (!isset($_POST['submit'])) {

		$files = array();
		$files = getDirFileNames('../../includes/languages/');
?>
			<tr>
				<td>
					<b><?php echo TRANS('OPT_LANG','ARQUIVO DE IDIOMA');?></b>
				</td>
				<td>
					<select name='lang' id='idLang' class='select'> <!--//<input type='text' name='lang' id='idLang' class='text' value='<?php echo $row['conf_language'];?>'></td> -->
					<!-- //print "<option value=''></option> -->
<?php			
		for ($i=0; $i<count($files); $i++) {  
?>
						<option value='<?php echo $files[$i]; ?>' 
<?php
			if ($files[$i]==$rowUL['upref_lang']) 
				echo 'selected';
?>
			><?php echo $files[$i];?></option>				
<?php
		}
?>		
					</select>
				</td>
			</tr>
		<!-- </tr>
			<tr>
				<td colspan='2'>&nbsp;</td></tr> -->
		<tr>
		<tr>
			<td align='center'><input type='submit' name='submit' class='button' value='<?php echo TRANS('BT_LOAD','',0);?>'></td>
			<td align='center'>
				<input type='button' name='cancelar' class='button' value='<?php echo TRANS('BT_CANCEL'); ?>' onClick="javascript:history.back();">
			</td>
		</tr>
<?php
	} else
	if (isset($_POST['submit']) ) {

		if (!empty($hasUL)){
		//update
			$qry = "UPDATE uprefs SET upref_lang = '".$_POST['lang']."' WHERE upref_uid = ".$_SESSION['s_uid']."";
		} else {
		//insert
			$qry = "INSERT INTO uprefs (upref_uid, upref_lang) values (".$_SESSION['s_uid'].", '".$_POST['lang']."')";
		}
		
		$execQry = mysqli_query($conect, $qry) or die ($qry);

		$_SESSION['s_language'] = $_POST['lang'];
?>		
		<script>mensagem('<?php echo TRANS('MSG_LANG_LOAD_SUCESS','sucesso',0); ?>'); window.open('../../index.php','_parent',''); </script>
<?php
		//?LOAD=ADMIN
	}
?>
		</table>
	</form>

	<script type="text/javascript">
	<!--
		function valida(){

			var ok = validaForm('idLang','COMBO','<?php print TRANS('OPT_LANG'); ?>',1);

			return ok;
		}
	//-->
	</script>
</body>
</html>