<div class="col-sm-12 text-center"> 
    <h2>Devmodule</h2>
</div>
<div class="col-sm-12 text-center board-section builder"> 
    <table>
        <thead class="text-center filter-bg">
		<td><h5c>testpassword</h5c></td>
		<td><h5c>testnumber</h5c></td>
		<td><h5c>testdescription</h5c></td>
        </thead>
    <?php foreach ($data['items'] as $singleItem) { ?>
        <tr>
		<td><?= $singleItem['testpassword'] ?></td>
		<td><?= $singleItem['testnumber'] ?></td>
		<td><?= $singleItem['testdescription'] ?></td>
        </tr>
    <?php } ?>
    </table>
</div>