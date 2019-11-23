<!DOCTYPE html>
<html>
	<p>
		<?php if(isset($message)) { ?>
			<p><?= $message ?></p>
		<?php } ?>
		
		
		<?php $nbJoueuses = mysqli_fetch_assoc($nbJ)?>
		<p>Nombre total de joueuses: <?= $nbJoueuses['nbJ'] ?> </p>
		
		<?php $nbQuartiers = mysqli_fetch_assoc($nbQ)?>
		<p>Nombre de quartiers: <?= $nbQuartiers['nbQ'] ?> </p>
		
		
		<?php $nbCommunes = mysqli_fetch_assoc($nbC)?>
		<p>Nombre de communes: <?= $nbCommunes['nbC'] ?> </p>
		
		<?php $nbDepartements = mysqli_fetch_assoc($nbD)?>
		<p>Nombre de departements: <?= $nbDepartements['nbD'] ?> </p>
		
		<table id="statistiqueTab">
			<?php while ($joueuses = mysqli_fetch_assoc($critiques)) { ?>
					<tr>
						<th>id</th>
						<th>Joueuse</th>
					</tr>
					<tr>
						<td><?= $joueuses['idJ'] ?></td>
						<td><?= $joueuses['nomJ'] ?></td>
					</tr>
			<?php } ?>
		</table>
	</p>
</html>
