
<div>
    <input type="text" id="tree-search" placeholder="Search..." />
</div>

<div style="margin-bottom: 10px;">
    <div class="btn-group">
        <a class="btn create-doc" href="<?php echo CHtml::normalizeUrl(array("create"))?>?cat_id=<?php echo $this->currentNodeId?>&Group[is_folder]=0" data-toggle="tooltip" data-original-title="New element">
            <i class="icon-file"></i>
        </a>
        <a class="btn create-folder" href="<?php echo CHtml::normalizeUrl(array("create"))?>?cat_id=<?php echo $this->currentNodeId?>&Group[is_folder]=1" data-toggle="tooltip" data-original-title="New category">
            <i class="icon-folder-open"></i>
        </a>
    </div>

    <div class="btn-group" style="margin-right: 5px;">

        <?php if ($this->currentNodeId > 1): ?>
            <a class="btn" href="<?php echo CHtml::normalizeUrl(array("update"))?>/id/<?php echo $this->currentNodeId?>?cat_id=<?php echo $this->currentNodeId?>" data-toggle="tooltip" data-original-title="Edit">
                <i class="icon-pencil"></i>
            </a>
        <?php endif; ?>

        <?php if (!$this->showDocs): ?>
            <?php //todo remain get params ?>
            <a class="btn" href="<?php echo CHtml::normalizeUrl(array("index"))?>?cat_id=<?php echo $this->currentNodeId?>" data-toggle="tooltip" data-original-title="List of elements in the category">
                <i class="icon-list"></i>
            </a>
        <?php endif; ?>

    </div>

    <?php if ($this->currentNodeId > 1): ?>
        <a class="btn delete-doc" data-toggle="tooltip" data-original-title="Remove">
            <i class="icon-trash"></i>
        </a>
    <?php endif; ?>
</div>

<div id="<?php echo $this->elementId?>">
    <?php echo $treeHtml?>
</div>



<script type="text/javascript">
    $(function() {
        var id = '<?php echo $this->elementId?>';
        var $tree = $('#'+id);
        var searchLaunched = false;
        var $search = $('#tree-search');
        var checkboxesSelector = '.grid-view tr td:first-child input[type=checkbox]';
        var checkboxAllSelector = '.grid-view tr th:first-child input[type=checkbox]';
        var bulkMoveSelector = '#bulk-move-docs';
        var readyToMove = false;


        // init
        $tree.jstree({
            'core' : {
                'check_callback':true,
                'themes' : {
                    'responsive' : true,
                    'stripes' : true
                }
            },
            "types" : {
                "#" : { "valid_children" : [] },
                "default" : { "valid_children" : ["default","file"] },
                "file" : { "icon" : "jstree-file", "valid_children" : [] }
            },
            'plugins' : ['search', 'dnd', 'wholerow', 'types']
        })
            .on('select_node.jstree', function (e, data) {
                if (data && data.selected && data.selected.length && data.node.data.id != '<?php echo $this->currentNodeId?>') {
                    // move documents from grid view
                    if ( readyToMove ) {
                        var movingNodeIds = [];

                        $(checkboxesSelector +':checked').each(function () {
                            movingNodeIds.push( $(this).val() );
                        });
                        var idsString = 'ids[]='+ movingNodeIds.join('&ids[]=');

                        window.location.href = "/admin/group/group/moveDoc?"+ idsString +'&parentId='+ data.node.data.id;
                    }
                    // open node
                    else {
                        //todo remain get params
                        window.location.href = data.node.a_attr.href;
                    }
                }
            })
            .on('move_node.jstree', function (e, data) {
                var prevSibling = $tree.jstree(true).get_prev_dom(data.node, true);
                var prevId = prevSibling ? $(prevSibling).data().id : null;
                var nodeId = data.node.data.id;
                var parentId = $('#'+ data.parent).data().id;
                var prevUrl = prevId != null ? '/prevId/'+ prevId : '';

                window.location.href = "/admin/group/group/moveCat/id/"+ nodeId +'/parentId/'+ parentId + prevUrl;
            });


        // search
        $search.keyup(function () {
            if (searchLaunched) {
                clearTimeout(searchLaunched);
            }

            to = setTimeout(function () {
                var v = $search.val();
                $tree.jstree(true).search(v);
            }, 250);
        });

        // create
        $('.create-doc, .create-folder').on('click', function() {
            var node = $tree.jstree(true).get_selected();

            if (!node.length) {
                return false;
            }

            var data = $('#'+ node[0]).data();

            if (data.jstree.type == 'file') {
                alert('You may add elements into categories only. You have to switch type of the entry to category.');
                return false;
            }
        });

        // delete
        $('.delete-doc').on('click', function() {
            var node = $tree.jstree(true).get_selected();
            if (!node.length) {
                return false;
            }
            var id = $('#'+ node[0]).data().id;

            $.ajax({
                type: "POST",
                url: "/admin/group/group/countChildren/id/"+ id,
                dataType: "json",

                success: function (data) {
                    if ((data.number > 0 && confirm('This element contains child elements.\nDo you want to remove it anyway?')) ||
                        (data.number < 1 && confirm('Are you sure you want to remove this element?'))) {
                        //todo remain get params
                        window.location.href = '/admin/group/group/delete/id/'+ id +'?withRedirect=1';
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });

            return false;
        });

        // actions on checkboxes changing
        $(checkboxesSelector +', '+ checkboxAllSelector).on('change', function() {
            setTimeout(function() {
                if ( $(checkboxesSelector +':checked').length < 1 ) {
                    setReadyToMove( false );
                }
            }, 100);
        });

        // move
        $(bulkMoveSelector).on('click', function() {
            setReadyToMove( !readyToMove );
        });

        function setReadyToMove(value) {
            readyToMove = value;

            if (readyToMove) {
                $(bulkMoveSelector).addClass('btn-success')
                                    .text('Click on a category');
            }
            else {
                $(bulkMoveSelector).removeClass('btn-success')
                                    .text('Move selected entries');
            }
        }


        // select node after loading
        $('#'+id).jstree(true).select_node('<?php echo $this->getCurrentNodeFullId()?>');

        var node = $('#'+id).jstree(true).get_selected();

        $('#'+id).jstree(true).open_node(node);
    });
</script>