<?php
require_once __DIR__ . '/../config/configurationprincipale.php';

$query = 'SELECT * FROM categorie WHERE id_categorie=' . $_GET['id_categorie'];
$stmt = $pdo->query($query);
$details = $stmt->fetchAll();
include __DIR__ . '/../includes/header_admin.php';
?>




<table class="table">
	<tr>
		<th>ID</th>
		<th>titre</th>
		<th>mots</th>

	</tr>
	<?php foreach ($details as $detail) : ?>
		<tr>
			<td><?= $detail['id_categorie'] ?></td>
			<td><?= $detail['titre'] ?></td>
			<td><?= $detail['mots'] ?></td>
		</tr>
	<?php endforeach; ?>
</table>


<?php

include __DIR__ . '/../assets/includes/footer_admin.php';