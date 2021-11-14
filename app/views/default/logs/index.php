<div class="col-sm-12 text-center"> 
    <h2>Log review</h2>
</div>
<div class="col-sm-12"> 
    <div class="raow">
        <form action="<?= URL ?>logs/index" method="post">
            <div class="col-sm-12 filter-bg">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="row">
                            <div class="col-sm-12">
                                <strong>Search log:</strong><input type="text" class="form-control filter-condition-search" id="person-surname" name="filter-condition-search" placeholder="Insert string..." value="<?php echo $this->tools->getPost('filter-condition-search') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 filter-logs-date">
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>From:</strong>
                                <input type="date" class="form-control" name="filter-condition-logs_datetime-from" value="<?php echo ($this->tools->getPost('filter-condition-logs_datetime-from')) ? date('Y-m-d', strtotime($this->tools->getPost('filter-condition-logs_datetime-from'))) : ""; ?>" min="01/01/1900" max="31/12/2020">
                            </div>  
                            <div class="col-sm-6">
                                <strong>To:</strong>
                                <input type="date" class="form-control" name="filter-condition-logs_datetime-to" value="<?php echo ($this->tools->getPost('filter-condition-logs_datetime-to')) ? date('Y-m-d', strtotime($this->tools->getPost('filter-condition-logs_datetime-to'))) : ""; ?>" min="01/01/1900" max="31/12/2020">
                            </div>  
                        </div>  
                    </div>  
                    <div class="col-sm-1">
                        <strong>Class:</strong>
                        <select name="filter-condition-type" class="form-control">
                            <option value=""> - - - </option>
                            <?php foreach ($data['typeset'] as $singleType) { ?>
                                <option value="<?=$singleType['type']?>" <?= ($this->tools->getPost('filter-condition-type') == $singleType['type']) ? 'selected' : ''; ?>><?=$singleType['type']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <strong>User:</strong>
                        <select name="filter-condition-user" class="form-control">
                            <option value=""> - - - </option>
                            <?php foreach ($data['userset'] as $singleUser) { ?>
                                <option value="<?=$singleUser['uid']?>" <?= ($this->tools->getPost('filter-condition-user') == $singleUser['uid']) ? 'selected' : ''; ?>><?=$singleUser['uname']?> <?=$singleUser['usurname']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4 filter-swab-order">
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>Order by:</strong>
                                <select name="filter-order-by" class="form-control">
                                    <option value=""> - - - </option>
                                    <option value="type" <?= ($this->tools->getPost('filter-order-by') == 'type') ? 'selected' : ''; ?>>class</option>
                                    <option value="logdatetime" <?= ($this->tools->getPost('filter-order-by') == 'logdatetime') ? 'selected' : ''; ?>>date</option>
                                    <option value="userid" <?= ($this->tools->getPost('filter-order-by') == 'userid') ? 'selected' : ''; ?>>user</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <strong>Direction:</strong>
                                <select name="filter-order-direction" class="form-control">
                                    <option value=""> - - - </option>
                                    <option value="DESC" <?= ($this->tools->getPost('filter-order-direction') == 'DESC') ? 'selected' : ''; ?>>Descending</option>
                                    <option value="ASC" <?= ($this->tools->getPost('filter-order-direction') == 'ASC') ? 'selected' : ''; ?>>Ascending</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <strong>Limit:</strong>
                                <select name="filter-limit-limit" class="form-control">
                                    <option value="25" <?= ($this->tools->getPost('filter-limit-limit') == '25') ? 'selected' : ''; ?>>25</option>
                                    <option value="50" <?= ($this->tools->getPost('filter-limit-limit') == '50') ? 'selected' : ''; ?>>50</option>
                                    <option value="100" <?= ($this->tools->getPost('filter-limit-limit') == '100') ? 'selected' : ''; ?>>100</option>
                                    <option value="200" <?= ($this->tools->getPost('filter-limit-limit') == '200') ? 'selected' : ''; ?>>200</option>
                                    <option value="500" <?= ($this->tools->getPost('filter-limit-limit') == '500') ? 'selected' : ''; ?>>500</option>
                                    <option value="1000" <?= ($this->tools->getPost('filter-limit-limit') == '1000') ? 'selected' : ''; ?>>1000</option>
                                </select>
                            </div>  
                        </div>
                    </div>
                    <div class="col-sm-1 filter-logs-submit">
                        <button type="submit" class="btn btn-primary filter-logs-submit-btn no-print">Search</button>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <table class="table logs-table text-center">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Class</th>
                                <th>Log</th>
                                <th>User</th>
                                <th>Ip</th>
                            </tr>
                        </thead>
                        <tbody class="logs-list">
                            <?php
                            foreach ($data['logsset'] as $singleLog) {
                                ?>
                                <tr>
                                    <td><?= $singleLog['logdatetime'] ?></td>
                                    <td><?= $singleLog['type'] ?></td>
                                    <td><?= $singleLog['log'] ?></td>
                                    <td><?= $singleLog['user_name'] ?> <?= $singleLog['user_surname'] ?></td>
                                    <td><?= $singleLog['ip'] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>