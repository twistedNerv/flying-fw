<?php $this->config->includeScript('builder.js');?>
<div class="col-sm-12 text-center">
    <h2>Module builder</h2>
</div>
<div class="col-sm-12">
    <form action="<?= URL ?>builder" method="post">
        <input type="hidden" name="action" value="build">
        <div class="row">
            <div class="col-sm-4">
                <h4>DB table</h4>
                <select name="tables" class="form-control">
                    <?php
                    echo "<option value='' style='font-style: italic;' disabled selected>Choose table from db</option>";
                    foreach ($data['tables'] as $singleTable) {
                        echo "<option value='" . $singleTable . "'>" . $singleTable . "</option>";
                    }
                    ?>
                </select>
                <label style="font-style: italic;color:grey;">Db scheme file will be created</label>
                <br>
                <div class="radio">
                    <input type="radio" name="type" value="table" id="type-table">
                </div>
            </div>
            <div class="col-sm-4">
                <h4>SQL dump file</h4>
                <select name="schemas" class="form-control">
                    <?php
                    echo "<option value='' style='font-style: italic;' disabled selected>Choose file from dbschemas folder</option>";
                    foreach ($data['schemas'] as $singleSchema) {
                        echo "<option value='" . $singleSchema . "'>" . $singleSchema . "</option>";
                    }
                    ?>
                </select>
                <label style="font-style: italic;color:grey;">Statements from the file will be executed</label>
                <br>
                <div class="radio">
                    <input type="radio" name="type" value="schema" id="type-schema">
                </div>
            </div>
            <div class="col-sm-4">
                <h4>Create new</h4>
                <div class="col-sm-12">
                    <input type="text" class="form-control" name="create" placeholder="Insert module name">
                </div>
                <label style="font-style: italic;color:grey;">Only basic code in files will be created</label>
                <br>
                <div class="radio">
                    <input type="radio" name="type" value="create" id="type-create">
                </div>
            </div>
            <div class="col-sm-12"><hr></div>
            <div class="col-sm-6 text-left">
                Create model
                <input type="hidden" name="wish-model" value="0">
                <input type="checkbox" class="form-control" name="wish-model" id="wish-model" value="1">
            </div>
            <div class="col-sm-6">
                Create view: update
                <input type="hidden" name="wish-view-update" value="0">
                <input type="checkbox" class="form-control" name="wish-view-update" id="wish-view-update" value="1">
            </div>
            <div class="col-sm-12"><hr></div>
            <div class="col-sm-6 text-left">
                Create controller
                <input type="hidden" name="wish-controller" value="0">
                <input type="checkbox" class="form-control" name="wish-controller" id="wish-controller" value="1">
            </div>
            <div class="col-sm-6">
                Create view: index
                <input type="hidden" name="wish-view-index" value="0">
                <input type="checkbox" class="form-control" name="wish-view-index" id="wish-view-index" value="1">
            </div>
            <div class="col-sm-12"><hr></div>
            <div class="col-sm-6 text-left">
            </div>
            <div class="col-sm-6">
                <strike>Create view: grid</strike>
                <input type="hidden" name="wish-view-grid" value="0">
                <input type="checkbox" class="form-control" name="wish-view-grid" id="wish-view-grid" value="1">
            </div>
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
<div class="col-sm-12">
    <?=$data['status']?>
</div>