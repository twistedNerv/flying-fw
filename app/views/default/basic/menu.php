<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?=URL?>" title="Domov"><i class="fas fa-home"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navbarNav" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li class='nav-item'>
                
            </li>
            <?php 
            $childrenParents = array_unique(array_column($allMenuItems, 'parent'));
            foreach ($parentGroups as $singleParent) {
                if ($this->session->get('activeUser') && $singleParent['level'] <= $this->session->get('activeUser')['level']){
                    if (!in_array($singleParent['id'], $childrenParents)) {
                        echo "<li class='nav-item'>";
                        echo "<a href='" . URL . $singleParent['url'] . "' class='nav-link' title='" . $singleParent['description'] . "'>" . $singleParent['title'] . "<span class='sr-only'>(current)</span></a>";
                        echo "</li>";
                    } else {
                        echo '<li class="dropdown dropdown-nav-item"><a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" title="' . $singleParent['description'] . '">' . $singleParent['title'] . '<span class="caret"></span></a><ul class="dropdown-menu">';
                        foreach($allMenuItems as $singleItem) {
                            if ($singleItem['parent'] == $singleParent['id'] && $singleItem['level'] <= $this->session->get('activeUser')['level']) {
                                echo '<li><a href="' . URL . $singleItem['url'] . '" class="dropdown-item" title="' . $singleItem['description'] . '">' . $singleItem['title'] . '</a></li>';
                            }
                        }
                        echo '</ul></li>';
                    }
                }
            } ?>
            <?php 
            if($this->session->get('activeUser') && $this->session->get('activeUser')['level'] >= 4) {
                if($this->session->get('activeUser')) { ?>
                    <li class="nav-item dropdown" style="position:absolute;right:0;">
                        <a class="nav-link dropdown-toggle admin-menu-dropdown" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i> <?=$this->session->get('activeUser')['name']?> <?=$this->session->get('activeUser')['surname']?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg-right dropdown-secondary" aria-labelledby="navbarDropdownMenuLink-55">
                            <?php foreach($allAdminMenuItems as $singleAdminMenuItem) {
                                if ($singleAdminMenuItem['level'] <= $this->session->get('activeUser')['level']){
                                    echo "<a class='dropdown-item' href='" . URL . $singleAdminMenuItem['url'] . "'>" . $singleAdminMenuItem['title'] . "</a>";
                                }
                            } ?>
                            <a class='dropdown-item logout-dropdown-item' href='<?=URL?>user/logout'>Logout</a>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="nav-item" style="position:absolute;right:0;">
                        <a href="<?=URL?>user/login" class="nav-link">Login</a>
                    </li>
                <?php } 
            } else { 
                if($this->session->get('activeUser')) { ?> 
                <li class="nav-item" style="position:absolute;right:0;">
                    <a class='nav-link' href='<?=URL?>user/logout'>Logout</a> 
                </li>
                <?php
                } else { ?>
                    <li class="nav-item" style="position:absolute;right:0;">
                        <a href="<?=URL?>user/login" class="nav-link">Login</a>
                    </li>
                <?php }
            }
            ?>
        </ul>
    </div>
</nav>