<div class="col-sm-12 text-center"> 
    <h2>Board posts</h2>
</div>
<div class="col-sm-4 text-right"> 
    <div class="row">
        <div class="col-sm-12">
            <h4>Posts</h4>
        </div>
        <div class="col-sm-12">
            <?php
            foreach ($data['items'] as $singleItem) {
                $selectedBoardClass = ($data['selectedBoard']->id == $singleItem['id']) ? "font-weight-bold" : "";
                echo "<div>
                        <span class='" . $selectedBoardClass . "'>" . $singleItem['title'] . " (" . $singleItem['postdate'] . ")</span> | 
                        <a href='" . URL . "board/update/" . $singleItem['id'] . "' title='Edit post'><i class='far fa-edit'></i></a> |
                        <a href='" . URL . "board/remove/" . $singleItem['id'] . "' title='Remove post' onclick='return confirm(&#34;You really want to remove?&#34;);'><i class='fas fa-times' title='Remove post'></i></a>
                      </div>";
            }
            ?>
        </div>
    </div>
</div>
<div class="col-sm-8">
    <?php if ($data['selectedBoard']->id) { ?>
        <a href="<?= URL ?>board/update">Add post</a>
        <h4>Edit post</h4>
    <?php } else { ?>
        <h4>Add post</h4>
    <?php } ?>
    <div class="user-settings">
        <form action="<?= URL ?>board/update<?php echo ($data['selectedBoard']->id) ? "/" . $data['selectedBoard']->id : "" ?>" method="post">
            <input type="hidden" name="action" value="handleboard">
            <div class="form-group">
                <input type="text" class="form-control" name="board-title" placeholder="Title" value="<?php echo ($data['selectedBoard']->id) ? $data['selectedBoard']->title : ""; ?>">
            </div>
            <div class="form-group">
                <label for="board-content">Description</label>
                <textarea type="text" id="board-content" class="form-control" name="board-content" required>
                    <?php echo ($data['selectedBoard']->id) ? $data['selectedBoard']->content : ""; ?>
                </textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a class='btn btn-danger' href="<?= URL ?>board/update">Cancel</a>
        </form>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        new EasyEditor('#board-content');
    });
</script>
<style>
    .easyeditor {
        min-height: 100px;
    }
</style>