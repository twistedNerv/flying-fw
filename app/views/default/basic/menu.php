<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?=URL?>"><img src="<?=URL?>public/<?=TEMPLATE?>/images/home.png" width="25px"/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navbarNav" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li class='nav-item'>
                
            </li>
            <?php 
//            echo "<pre>";
//            var_dump($allMenuItems);
//            echo "</pre>";
            $childrenParents = array_unique(array_column($allMenuItems, 'parent'));
            //var_dump($childrenParents);
            foreach ($parentGroups as $singleParent) {
                if (!in_array($singleParent['id'], $childrenParents)) {
                    echo "<li class='nav-item'>";
                    echo "<a href='" . URL . $singleParent['url'] . "' class='nav-link'><strong>" . $singleParent['title'] . "</strong><span class='sr-only'>(current)</span></a>";
                    echo "</li>";
                } else {
                    echo '<li class="dropdown dropdown-nav-item"><a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#"><strong>' . $singleParent['title'] . '</strong><span class="caret"></span></a><ul class="dropdown-menu">';
                    foreach($allMenuItems as $singleItem) {
                        if ($singleItem['parent'] == $singleParent['id']) {
                            echo '<li><a href="' . URL . $singleItem['url'] . '" class="dropdown-item">' . $singleItem['title'] . '</a></li>';
                        }
                    }
                    echo '</ul></li>';
                }
            } ?>
            <?php 
            if($this->session->get('activeUser')['level'] >= 4) {
                if($this->session->get('activeUser')) { ?>
                    <li class="nav-item dropdown" style="position:absolute;right:0;">
                        <a class="nav-link dropdown-toggle admin-menu-dropdown" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"> Admin</i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg-right dropdown-secondary" aria-labelledby="navbarDropdownMenuLink-55">
                            <?php foreach($allAdminMenuItems as $singleAdminMenuItem) {
                                echo "<a class='dropdown-item' href='" . URL . $singleAdminMenuItem['url'] . "'>" . $singleAdminMenuItem['title'] . "</a>";
                            } ?>
                            <a class='dropdown-item' href='<?=URL?>user/logout'>Logout</a>
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