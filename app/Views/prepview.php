<!DOCTYPE html>
<html>
<head>
	<title>Prepocessing</title>
</head>
<body>
	
	<table style="margin:20px;" border="1">
		<tr>
			<th>Data</th>
		</tr>
		<?php foreach($name as $a): ?>
		<tr>
			<td><?= $a['kalimat'] ?></td>
		</tr>
		<?php endforeach ?>
	</table>
</body>
</html>