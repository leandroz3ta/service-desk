<?php 
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
	include ('includes/header.php');

	$_SESSION['s_page_invmon'] = $_SERVER['PHP_SELF'];

	$cab = new headers;
	$cab->set_title(TRANS(".TRANS('TTL_INVMON')."));

	$auth = new auth;
	$auth->testa_user($_SESSION['s_usuario'],$_SESSION['s_nivel'],$_SESSION['s_nivel_desc'],2);

	$conec = new conexao;
	$conect=$conec->conecta('MYSQL');

	$hoje = date("Y-m-d H:i:s");


	$cor  = TD_COLOR;
	$cor1 = TD_COLOR;
	$cor3 = BODY_COLOR;

	$queryB = "SELECT count(*) from equipamentos";
	$resultadoB = mysqli_query($conect, $queryB);
	//$total = mysql_result($resultadoB,0);
	$row = mysqli_fetch_row($resultadoB);
	$total = $row[0];

	// Select para retornar a quantidade e percentual de equipamentos cadastrados no sistema
	$query= "SELECT count( l.loc_reitoria )  AS qtd, count(  *  )  / ".$total." * 100 AS porcento,
				l.loc_reitoria AS cod_reitoria, l.loc_id AS tipo_local, t.tipo_nome AS equipamento,
				t.tipo_cod AS tipo, r.reit_nome AS reitoria FROM equipamentos AS c, tipo_equip AS t,
				localizacao AS l, reitorias AS r WHERE c.comp_tipo_equip = t.tipo_cod AND
				c.comp_local = l.loc_id AND l.loc_reitoria = r.reit_cod GROUP  BY l.loc_reitoria
				ORDER  BY reitoria, qtd DESC";

	$resultado = mysqli_query($conect, $query);
	$linhas = mysqli_num_rows($resultado);
?>
	<table border='0' cellpadding='5' cellspacing='0' align='center' width='80%' bgcolor='<?php echo $cor3; ?>'>
		<tr>
			<td width='80%' align='center'>
				<b><?php echo TRANS('TTL_TOTAL_EQUIP_CAD_MAJOR'); ?>:</b>
			</td>
		</tr>

		<tr>
			<td class='line'>
				<fieldset>
					<legend><?php echo TRANS('TTL_EQUIP_X_MAJOR'); ?></legend>
					<table border='0' cellpadding='5' cellspacing='0' align='center' width='80%' bgcolor='<?php echo $cor3; ?>'>
						<tr>
							<td bgcolor='<?php echo $cor3; ?>'>
								<b><?php echo TRANS('COL_MAJOR'); ?></b>
							</td>
							<td bgcolor='<?php echo $cor3; ?>'>
								<b><?php echo TRANS('COL_QTD'); ?></b>
							</td>
							<td bgcolor='<?php echo $cor3; ?>'>
								<b><?php echo TRANS('COL_PORCENTEGE'); ?>
							</td>
						</tr>
<?php						
		$i=0;
		$j=2;

		while ($row = mysqli_fetch_array($resultado)) {
			$color =  BODY_COLOR;
			$j++;
?>			
				 		<tr>
							<td bgcolor='<?php echo $color; ?>'>
								<a href='mostra_consulta_comp.php?comp_tipo_equip=<?php echo $row['tipo']; ?>&comp_reitoria=<?php echo $row['cod_reitoria']; ?>&ordena=modelo,etiqueta' title='<?php echo TRANS('HNT_LIST_EQUIP_CAD_FOR_TYPE_LOCAL'); ?>'><?php echo $row['reitoria']; ?> </a>
							</td>
							<td bgcolor='<?php echo $color; ?>'>
								<a href='estat_equipporreitoria.php'><?php echo $row['qtd']; ?></a>
							</td>
							<td bgcolor='<?php echo $color; ?>'>
								<?php echo $row['porcento']; ?>%
							</td>
						</tr>
<?php
			$i++;
		}
?>
			<tr>
				<td bgcolor='<?php echo $cor3; ?>'>
					<b></b>
				</td>
				<td bgcolor='<?php echo $cor3; ?>'>
					<b><?php echo TRANS('TOTAL').': '.$total; ?></b>
				</td>
				<td bgcolor='<?php echo $cor3; ?>'>
					<b>%</b>
				</td>
			</tr>
		</table>
	</fieldset>";

	<table width='80%' align='center'>
		<tr>
			<td width='80%' align='center'><b><?php echo TRANS('SLOGAN_OCOMON'); ?>
				<a href='http://www.unilasalle.edu.br' target='_blank'><?php echo TRANS('COMPANY'); ?></a>.</b>
			</td>
		</tr>
	</table>
</body>
</html>