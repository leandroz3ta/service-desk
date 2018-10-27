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
	$cab->set_title(TRANS('TTL_INVMON'));

	$auth = new auth;
	$auth->testa_user($_SESSION['s_usuario'],$_SESSION['s_nivel'],$_SESSION['s_nivel_desc'],2);

	$conec = new conexao;
	$conect=$conec->conecta('MYSQL');

	$hoje = date("Y-m-d H:i:s");


	$cor  = TD_COLOR;
	$cor1 = TD_COLOR;
	$cor3 = BODY_COLOR;

	$queryB = "SELECT count(*) from equipamentos, localizacao where comp_local = loc_id and loc_dominio is not null"; //todos equipamentos que possuem domínio definido
	$resultadoB = mysqli_query($conect, $queryB);
	//$total = mysql_result($resultadoB,0);
	$row = mysqli_fetch_row($resultadoB);
	$total = $row[0];

	if (!isset($discrimina)) $discrimina = true;

	// Select para retornar a quantidade e percentual de equipamentos cadastrados no sistema
	$query= "SELECT count( l.loc_dominio )  AS qtd, count(  *  )  / ".$total." * 100 AS porcento,
				l.loc_dominio AS cod_dominio, l.loc_id AS tipo_local, t.tipo_nome AS equipamento,
				t.tipo_cod AS tipo, d.dom_desc AS dominio FROM equipamentos AS c, tipo_equip AS t,
				localizacao AS l, dominios AS d WHERE c.comp_tipo_equip = t.tipo_cod AND
				c.comp_local = l.loc_id AND l.loc_dominio = d.dom_cod GROUP  BY l.loc_dominio";

	if (isset($_GET['discrimina']) && $_GET['discrimina']==1) {
		$query.= " , equipamento ";
		$coluna = "<td bgcolor=".$cor3."><b>".TRANS('MNL_CAD_EQUIP')."</td>";
		$discrimina = 0;
	} else {
		$coluna = "";
		$discrimina = 1;
	}

		$query.=" ORDER  BY dominio, qtd DESC";

		$resultado = mysqli_query($conect, $query);
		$linhas = mysqli_num_rows($resultado);

		//$discrimina = !$discrimina;
?>
	<table border='0' cellpadding='5' cellspacing='0' align='center' width='80%' bgcolor='<?php echo $cor3;?>'>
		<tr>
			<td width='80%' align='center'>
				<b><?php echo TRANS('TTL_TOTAL_EQUIP_CAD_FOR_DOMAIN');?>:</b>
			</td>
		</tr>
		<tr>
			<td class='line'>
				<fieldset>
					<legend><?php echo TRANS('TTL_EQUIP_X_DOMAIN');?></legend>
					<table border='0' cellpadding='5' cellspacing='0' align='center' width='80%' bgcolor='<?php echo $cor3;?>'>
						<tr>
							<td bgcolor='<?php echo $cor3;?>'>
								<b><?php echo TRANS('COL_DOMAIN');?>
								<?php echo $coluna;?></b>
							</td>
							<td bgcolor='<?php echo $cor3;?>'>
								<b><?php echo TRANS('COL_QTD');?></b>
							</td>
							<td bgcolor='<?php echo $cor3;?>'>
								<b><?php echo TRANS('COL_PORCENTEGE');?></b>
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
							<td bgcolor='<?php echo $color;?>'>
								<?php echo $row['dominio'];?>
							</td>
<?php							
				if(isset($_GET['discrimina']) && $_GET['discrimina'] == 1) {
?>
							<td bgcolor='<?php echo $color;?>'><?php echo $row['equipamento'];?>
							</td>
<?php
				}
?>
							<td bgcolor='<?php echo $color;?>'>
								<a href='<?php echo $_SERVER['PHP_SELF'];?>?discrimina=<?php echo $discrimina;?>'><?php echo $row['qtd'];?></a>
							</td>
							<td bgcolor='<?php echo $color;?>'><?php echo $row['porcento'];?>% </td>
						</tr>
<?php						
				$i++;
			}
?>
						<tr>
							<td bgcolor='<?php echo $cor3;?>'>
								<b></b>
							</td>
							<td bgcolor='<?php echo $cor3;?>'>
								<b></b>
							</td>
							<td bgcolor='<?php echo $cor3;?>'>
								<b><?php echo TRANS('TOTAL');?>: <?php echo $total;?></b>
							</td>
						</tr>
					</table>
				</fieldset>

				<table width='80%' align='center'>
<?php					
		// print "<tr><td class='line'></TD></tr>";
		// print "<tr><td class='line'></TD></tr>";
		// print "<tr><td class='line'></TD></tr>";
		// print "<tr><td class='line'></TD></tr>";
		// print "</TABLE>";

		// print "<TABLE width='80%' align='center'>";
		// print "<tr><td class='line'></TD></tr>";
		// print "<tr><td class='line'></TD></tr>";
		// print "<tr><td class='line'></TD></tr>";
		// print "<tr><td class='line'></TD></tr>";
?>
					<tr>
						<td width='80%' align='center'>
							<b><?php echo TRANS('SLOGAN_OCOMON');?> 
							<a href='http://www.unilasalle.edu.br' target='_blank'><?php echo TRANS('COMPANY');?></a>.
							</b>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>