<!DOCTYPE html>
<html>
	<p>
		<?php if(isset($message)) { ?>
			<p><?= $message ?></p>
		<?php } ?>
		
		
		<?php $nbJoueuses = mysqli_fetch_assoc($nbJ)?>
		<p>Nombre total de Joueuses: <?= $nbJoueuses['nbJ'] ?> </p>
		
		<?php $nbQuartiers = mysqli_fetch_assoc($nbQ)?>
		<p>Nombre de Quartiers: <?= $nbQuartiers['nbQ'] ?> </p>
		
		
		<?php $nbCommunes = mysqli_fetch_assoc($nbC)?>
		<p>Nombre de Communes: <?= $nbCommunes['nbC'] ?> </p>
		
		<?php $nbDepartements = mysqli_fetch_assoc($nbD)?>
		<p>Nombre de Departements: <?= $nbDepartements['nbD'] ?> </p>
		
		<table id="statistiqueTab">
			<?php while ($Joueuses = mysqli_fetch_assoc($critiques)) { ?>
					<tr>
						<th>id</th>
						<th>Joueuse</th>
					</tr>
					<tr>
						<td><?= $Joueuses['idJ'] ?></td>
						<td><?= $Joueuses['nomJ'] ?></td>
					</tr>
			<?php } ?>
		</table>
	</p>
</html>
