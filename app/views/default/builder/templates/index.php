<div class="col-sm-12 text-center"> 
    <h2>[f[tablename_capital]f]</h2>
</div>
<div class="col-sm-12 text-center board-section builder"> 
    <table>
        <thead class="text-center filter-bg">[f[head_inputs]f]
        </thead>
    <?php foreach ($data['items'] as $singleItem) { ?>
        <tr>[f[inputs]f]
        </tr>
    <?php } ?>
    </table>
</div>