<div class="col-sm-12 text-center">
    <h2>Builder</h2>
</div>
<div class="col-sm-12 text-center builder"> 
    <div class="row justify-content-center">
        <table>
            <thead class="text-center filter-bg">
                <td><h5d>DB-table</h5d></td>
                <td><h5d>| Model-file</h5d></td>
                <td><h5d>| Controller-file</h5d></td>
                <td><h5d>| View-index</h5d></td>
                <td><h5d>| View-update</h5d></td>
                <td><h5d>| Menu-record</h5d></td>
            </thead>
            <?php foreach ($data['collection'] as $name => $singleColumn) {
                if ($singleColumn != 'id') { ?>
                    <tr>
                        <td class="text-left"><h5c><?= $name ?><h5c></td> 
                            <td>
                                <?= $this->template->drawChecker($singleColumn['model']) ?>
                            </td>
                            <td>
                                <?= $this->template->drawChecker($singleColumn['controller']) ?>
                            </td>
                            <td>
                                <?= $this->template->drawChecker($singleColumn['view_index']) ?>
                            </td>
                            <td>
                                <?= $this->template->drawChecker($singleColumn['view']) ?>
                            </td>
                            <td>
                                <?= $this->template->drawChecker($singleColumn['menu']) ?>
                            </td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                    <tr class="filter-bg text-center">
                        <td colspan="6"><strong>Files and menu status</strong></td>
                    </tr>
        </table>
    </div>
    <br><hr>
</div>
<div class="col-sm-4 text-center">
    <h3>(Re)build module</h3>
    <a href="<?= URL ?>builder/index"><i class="fas fa-snowplow display-1"></i></a>
</div>
<div class="col-sm-4 text-center"> 
    <h3>(Re)build edit form</h3>
    <div class="row justify-content-center">
            <?php foreach ($data['collection'] as $name => $singleColumn) {
                if ($singleColumn != 'id') { ?>
                    <div class="col-sm-12 text-left">
                        <a href="<?= URL ?>builder/form/<?= $name ?>" class="" title="Create form from <?= $name ?> table"><i class="fas fa-snowplow h4"> - <?= $name ?></i></a>
                    </div>
            <?php
                }
            }
            ?>
        </table>
    </div>
</div>
<div class="col-sm-4 text-center">
    <h3>Configuration</h3>
    <a href="<?= URL ?>install"><i class="fas fa-sliders-h display-1"></i></a>
</div>