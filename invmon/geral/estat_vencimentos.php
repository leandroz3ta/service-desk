<?php 
 /*                        Copyright 2005 Fl�vio Ribeiro

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
	include ('includes/header.php');

	$_SESSION['s_page_invmon'] = $_SERVER['PHP_SELF'];

	$cab = new headers;
	$cab->set_title(TRANS('TTL_INVMON'));

	$auth = new auth;
	$auth->testa_user($_SESSION['s_usuario'],$_SESSION['s_nivel'],$_SESSION['s_nivel_desc'],2);

	$conec = new conexao;
	$conect=$conec->conecta('MYSQL');

	$hoje = date("Y-m-d H:i:s");


	$cor  = TD_COLOR;
	$cor1 = TD_COLOR;
	$cor3 = BODY_COLOR;

	$query = $QRY["vencimentos"];
	$result = mysqli_query($conect, $query);

	//----------------TABELA  -----------------//
?>
	<br><br>
	<p align='center'><?php echo TRANS('TTL_PREVIEWS_EXP_GUARANTEE'); ?>: <a href='estat_vencimentos_full.php'><?php echo TRANS('SHOW_FULL_5_YEARS');?></a>
	</p>
	<table cellspacing='0' border='1' align='center' style="{border-collapse:collapse;}">
		<tr>
			<td >
				<b><?php echo TRANS('COL_DATE_2');?></b>
			</td>
			<td >
				<b><?php echo TRANS('COL_AMOUNT');?></b>
			</td>
			<td >
				<b><?php echo TRANS('COL_TYPE_2');?></b>
			</td>
			<td >
				<b><?php echo TRANS('COL_MODEL_2');?></b>
			</td>
		</tr>
<?php			
	//-----------------FINAL DA TABELA  -----------------------//

	$tt_garant = 0;
	while ($row=mysqli_fetch_array($result)) {
		$temp1 = explode(" ",$row['vencimento']);
		$temp = explode(" ",datab($row['vencimento']));
		$vencimento1 = $temp1[0];
		$vencimento = $temp[0];
		$tt_garant+= $row['quantidade'];
?>		
		<tr>
			<td>
				<a onClick="popup('mostra_consulta_comp.php?VENCIMENTO=<?php echo $vencimento1;?>')"><?php echo $vencimento;?></a>
			</td>
			<td align='center'><a onClick="popup('mostra_consulta_comp.php?VENCIMENTO=<?php echo $vencimento1; ?>')"><?php echo $row['quantidade'];?></a>
			</td>
			<td>
				<?php echo $row['tipo'];?>
			</td>
			<td>
				<?php echo $row['fabricante'];?> <?php echo $row['modelo'];?>
			</td>
		</tr>
<?php			
	} // while
?>	
		<tr>
			<td>
				<b><?php echo TRANS('COL_OVERALL');?></b>
			</td>
			<td colspan='3'>
				<b><?php echo $tt_garant;?></b>
			</td>
		</tr>
	</table>
	<br><br>
	<table width='80%' align='center'>
		<tr>
			<td width='80%' align='center'>
				<b><?php echo TRANS('SLOGAN_OCOMON');?> <a href='http://www.unilasalle.edu.br' target='_blank'><?php echo TRANS('COMPANY');?></a>.</b>
			</td>
		</tr>
	</table>
</body>
</html>