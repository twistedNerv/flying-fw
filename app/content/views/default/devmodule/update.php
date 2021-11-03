<div class="col-sm-12 text-center"> 
    <h2>Devmodule</h2>
</div>
<div class="col-sm-4 text-right"> 
    <div class="row">
        <div class="col-sm-12">
            <h4>Devmodule</h4>
        </div>
        <div class="col-sm-12">
            <?php
            foreach ($data['items'] as $singleItem) {
                $selectedDevmoduleClass = ($data['selectedDevmodule']->id == $singleItem['id']) ? "font-weight-bold" : "";
                ?>
                <div>
                    <span class='<?= $selectedDevmoduleClass ?>'><?= $singleItem['id'] ?></span> | 
                    <a href='<?= URL ?>devmodule/update/<?= $singleItem['id'] ?>' title='Edit devmodule'><i class='far fa-edit'></i></a> |
                    <a href='<?= URL ?>devmodule/remove/<?= $singleItem['id'] ?>' title='Delete devmodule' onclick='return confirm("Really want to delete?");'><i class='fas fa-times'></i></a>
                </div>
                <?php }
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
    <?php if ($data['selectedDevmodule']->id) { ?>
            <a href="<?= URL ?>devmodule/update">Add devmodule</a>
            <h4>Edit devmodule</h4>
        <?php } else { ?>
            <h4>Add devmodule</h4>
    <?php } ?>
        <div class="devmodule-settings">
            <form action="<?= URL ?>devmodule/update<?php echo ($data['selectedDevmodule']->id) ? "/" . $data['selectedDevmodule']->id : "" ?>" method="post">
                <input type="hidden" name="action" value="handledevmodule">
                <div class='form-group'>
                    <label for='devmodule-testtext'>testtext</label>
                    <input type='text' class='form-control' name='devmodule-testtext' id='devmodule-testtext' placeholder='testtext' value='<?php echo ($data['selectedDevmodule']->testtext) ? $data['selectedDevmodule']->testtext : ''; ?>'>
                </div>
                <div class='form-group'>
                    <label for='devmodule-testpassword'>testpassword</label>
                    <input type='password' class='form-control' name='devmodule-testpassword' id='devmodule-testpassword' placeholder='testpassword' value='<?php echo ($data['selectedDevmodule']->testpassword) ? $data['selectedDevmodule']->testpassword : ''; ?>'>
                </div>
                <div class='form-group'>
                    <label for='devmodule-testnumber'>testnumber</label>
                    <input type='number' class='form-control' name='devmodule-testnumber' id='devmodule-testnumber' placeholder='testnumber' value='<?php echo ($data['selectedDevmodule']->testnumber) ? $data['selectedDevmodule']->testnumber : ''; ?>'>
                </div>
                <div class='form-group'>
                    <label for='devmodule-testdescription'>testdescription</label>
                    <textarea class='form-control' name='devmodule-testdescription' id='devmodule-testdescription' placeholder='testdescription'><?php echo ($data['selectedDevmodule']->testdescription) ? $data['selectedDevmodule']->testdescription : ''; ?></textarea>
                </div>
                <div class='form-group'>
                    <label for='devmodule-testeditor'>testeditor</label>
                    <textarea class='form-control easy-edit-me' name='devmodule-testeditor' id='devmodule-testeditor' placeholder='testeditor'><?php echo ($data['selectedDevmodule']->testeditor) ? $data['selectedDevmodule']->testeditor : ''; ?></textarea>
                </div>
                <div class='form-group'>
                    <label for='devmodule-testemail'>testemail</label>
                    <input type='email' class='form-control' name='devmodule-testemail' id='devmodule-testemail' placeholder='testemail' value='<?php echo ($data['selectedDevmodule']->testemail) ? $data['selectedDevmodule']->testemail : ''; ?>'>
                </div>
                <div class='form-group'>
                    <label for='devmodule-testdate'>testdate</label>
                    <input type='date' class='form-control' name='devmodule-testdate' id='devmodule-testdate' placeholder='testdate' value='<?php echo ($data['selectedDevmodule']->testdate) ? $data['selectedDevmodule']->testdate : ''; ?>'>
                </div>
                <div class='form-group'>
                    <label for='devmodule-testcolor'>testcolor</label>
                    <input type='color' class='form-control' name='devmodule-testcolor' id='devmodule-testcolor' placeholder='testcolor' value='<?php echo ($data['selectedDevmodule']->testcolor) ? $data['selectedDevmodule']->testcolor : ''; ?>'>
                </div>
                <div class='form-group'>
                    <label for='devmodule-testselect'>testselect</label>
                    <select class='form-control' name='devmodule-testselect' id='devmodule-testselect'>
                        <option value='first' <?php echo ($data['selectedDevmodule']->testselect == 'first') ? 'selected' : '' ?>>First choice</option>
                        <option value='second' <?php echo ($data['selectedDevmodule']->testselect == 'second') ? 'selected' : '' ?>>Second choice</option>
                    </select>
                </div>
                <div class='form-group'>
                    <label for='devmodule-testradio'>testradio</label>
                    <input type='radio' class='form-control' name='devmodule-testradio' id='devmodule-testradio-first' value='first' <?php echo ($data['selectedDevmodule']->testradio == 'first') ? 'checked' : ''; ?>>
                    <label for='devmodule-testradio-first'>First</label>
                    <input type='radio' class='form-control' name='devmodule-testradio' id='devmodule-testradio-second' value='second' <?php echo ($data['selectedDevmodule']->testradio == 'second') ? 'checked' : ''; ?>>
                    <label for='devmodule-testradio-second'>Second</label>
                </div>
                <div class='form-group'>
                    <label for='devmodule-testcheckbox'>testcheckbox</label>
                    <input type='hidden' name='devmodule-testcheckbox'  value='0'>
                    <input type='checkbox' class='form-control' name='devmodule-testcheckbox' value='1' <?php echo ($data['selectedDevmodule']->testcheckbox == 1) ? 'checked' : ''; ?>>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class='btn btn-danger' href="<?= URL ?>devmodule/update">Cancel</a>
        </form>
    </div>
    <script>
        jQuery(document).ready(function () {
            new EasyEditor('#devmodule-testeditor');
        });
    </script>
</div>