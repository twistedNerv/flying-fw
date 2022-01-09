<?php $this->config->includeScript('builder.js');?>
<div class="col-sm-12 text-center">
    <h2>Module builder - create input form</h2>
    <h3><?=$data['table']?></h3>
</div>
<div class="col-sm-12 text-center builder">
    <form action="<?= URL ?>builder/form/<?=$data['table']?>" method="post">
        <input type="hidden" name="action" value="create-view-update-custom">
        <div class="row">
            <div class="col-sm-12">
                <table>
                    <thead class="text-center filter-bg">
                        <td><h5c>Column</h5c></td>
                        <td><h5c>Type</h5c></td>
                        <td width="30%"><h5c>Label</h5c></td>
                        <td><h5c>Placeholder</h5c></td>
                        <td><h5c>Required</h5c></td>
                        <td><h5c>Readonly</h5c></td>
                        <td><h5c>Disabled</h5c></td>
                        <td><h5c>View display</h5c></td>
                    </thead>
                <?php foreach($data['columns'] as $singleColumn) { 
                    if ($singleColumn != 'id') { ?>
                        <tr>
                            <td class="text-left"><h5d><?=$singleColumn?><h5d></td> 
                            <td>
                                <select name="<?=$data['table']?>-<?=$singleColumn?>-type" class="form-control">
                                    <option value="">Not included</option>
                                    <option value="text">Input text</option>
                                    <option value="password">Password</option>
                                    <option value="number">Number</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="editor">Editor</option>
                                    <option value="email">E-mail</option>
                                    <option value="date">Date</option>
                                    <option value="select">Select</option>
                                    <option value="radio">Radio</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="color">Color</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="<?=$data['table']?>-<?=$singleColumn?>-label" value="<?=$singleColumn?>">
                            </td>
                            <td>
                                <input type="text" name="<?=$data['table']?>-<?=$singleColumn?>-placeholder" value="<?=$singleColumn?>">
                            </td>
                            <td>
                                <input type="hidden" name="<?=$data['table']?>-<?=$singleColumn?>-required" value="0">
                                <input type="checkbox" class="form-control" name="<?=$data['table']?>-<?=$singleColumn?>-required" id="<?=$data['table']?>-<?=$singleColumn?>-required" value="1">
                            </td>
                            <td>
                                <input type="hidden" name="<?=$data['table']?>-<?=$singleColumn?>-readonly" value="0">
                                <input type="checkbox" class="form-control" name="<?=$data['table']?>-<?=$singleColumn?>-readonly" id="<?=$data['table']?>-<?=$singleColumn?>-readonly" value="1">
                            </td>
                            <td>
                                <input type="hidden" name="<?=$data['table']?>-<?=$singleColumn?>-disabled" value="0">
                                <input type="checkbox" class="form-control" name="<?=$data['table']?>-<?=$singleColumn?>-disabled" id="<?=$data['table']?>-<?=$singleColumn?>-disabled" value="1">
                            </td>
                            <td>
                                <input type="hidden" name="<?=$data['table']?>-<?=$singleColumn?>-viewdisplay" value="0">
                                <input type="checkbox" class="form-control" name="<?=$data['table']?>-<?=$singleColumn?>-viewdisplay" id="<?=$data['table']?>-<?=$singleColumn?>-viewdisplay" value="1">
                            </td>
                        </tr>
                <?php 
                    }
                } ?>
                    <tr class="filter-bg text-center">
                        <td colspan="8"><strong>If the view files index.php and update.php already exist they will be overwritten!!!</strong></td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-12"><br>
                <button type="submit" class="btn btn-primary">Create view</button>
                <a class='btn btn-danger' href='<?=URL?>builder/form'>Cancel</a>
            </div>
        </div>
    </form>
</div>
<div class="col-sm-12">
    <?php  /*echo $data['status']*/ ?>
</div>