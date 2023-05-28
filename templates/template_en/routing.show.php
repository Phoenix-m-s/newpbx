<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?= RELA_DIR ?>trunk.php?action=showTrunk">Routing</a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">
        <form name="routing" id="routing" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">

            <div id="panel-tablesorter" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=Routing_13?></h3>
                    <div class="panel-actions">
                        <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?=COLLAPSE;?>">
                            <i class="fa fa-caret-down text-midnight text-18"></i>
                        </button>
                    </div><!-- /panel-actions -->
                </div><!-- /panel-heading -->

                <div class="panel-body">
                    <div class="row">
                        <div class="row my-list">
                            <?php foreach ($list as $item){
                                if($item['comp_id'] != '') { ?>
                                <div class="my-list-item">
                                    <div class="col-xs-12 col-md-12 col-md-5">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label" for="trunk_type">Company :</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <select class="valid select2" name="company_list[]" required>
                                                    <?php foreach ($list['companies'] as $value){ ?>
                                                        <option <?php echo $value['id'] == $item['comp_id'] ? 'selected' : ''; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-12 col-md-5">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label" for="pass">Phone: </label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input value="<?php echo $item['phone']; ?>" type="text" class="form-control my-phone" autocomplete="off" placeholder="Phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-12 col-md-2">
                                        <a class="delete-condition" style="position:absolute; top:6px; left: -8px; z-index: 10;"><i class="fa fa-trash text-red text-18"></i></a>
                                    </div>
                                </div>

                            <?php }} ?>
                        </div>
                        <div>
                            <ul class="push-to-bottom plus-outbound" style="padding-left: 1em">
                                <li>
                                    <button type="button" id="more-item" class="clone-row btn btn-primary btn-icon">
                                        <i class="fa fa-plus"></i> Add More
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="row hidden-xs"></div>

                    </div>
                </div>
            </div>

            <input name="id" type="hidden">
            <input name="comp_id" type="hidden">
            <input type="hidden" name="action">

            <button type="submit" class="btn btn-success btn-icon">
                <i class="fa fa-download"></i> Submit
            </button>
        </form>

    </div><!--/content -->

    <script>

        var array = [];

        $(document).ready(function () {
            var $body = $('body');
            var $cloneMyList = [
                '<div class="my-list-item">',
                    '<div class="col-xs-12 col-md-12 col-md-5">',
                        '<div class="form-group">',
                            '<label class="col-xs-12 col-md-4 pull-left control-label" for="trunk_type">Company :</label>',
                            '<div class="col-xs-12 col-md-6 pull-left">',
                                '<select class="valid select2" name="company_list[]" required>',
                                    <?php foreach ($list['companies'] as $value){ ?>
                                    '<option <?php echo $value['id'] == $item['comp_id'] ? 'selected' : ''; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>',
                                    <?php } ?>
                                '</select>',
                            '</div>',
                        '</div>',
                    '</div>',
                    '<div class="col-xs-12 col-md-12 col-md-5">',
                        '<div class="form-group">',
                            '<label class="col-xs-12 col-md-4 pull-left control-label" for="pass">Phone: </label>',
                            '<div class="col-xs-12 col-md-6 pull-left">',
                                '<input value="<?php echo $item['phone']; ?>" type="text" class="form-control my-phone" autocomplete="off" placeholder="Phone">',
                            '</div>',
                        '</div>',
                    '</div>',
                    '<div class="col-xs-12 col-md-12 col-md-2">',
                        '<a class="delete-condition" style="position:absolute; top:6px; left: -8px; z-index: 10;"><i class="fa fa-trash text-red text-18"></i></a>',
                    '</div>',
                '</div>'
            ].join('');

            let result = JSON.parse('<?php echo json_encode($list); ?>');

            console.log(result);

            $body.on('click', '.delete-condition', function() {
                $(this).parents('.my-list-item').remove();
            });

            $('#more-item').on('click' , function () {
                appendInList().then(function() {
                    $('.my-list-item:last-child').find('select').select2();
                });
            });

            function appendInList() {
                return new Promise(function(resolve) {
                    $('.my-list').append($cloneMyList);
                    resolve();
                });
            }

            $('#routing').on('submit', function(e) {
                let array = [];
                e.preventDefault();
                $( ".my-list-item").each(function() {
                    let obj = {
                        "comp_id" : $(this).find('select option:selected').val(),
                        "phone" : $(this).find('.my-phone').val(),
                    }
                    array.push(obj);
                });

                $.httpRequest("routing.php?action=editRouting", 'post', {data : array})
                    .then(function (response) {
                        let result = JSON.parse(response);
                        swal({
                            title: '',
                            html: result.msg,
                            type: result.result === 1 ? 'success' : 'error',
                            confirmButtonText: 'OK',
                            confirmButtonClass: 'btn '+(result.result === 1 ? 'btn-success' : 'btn-danger')+' btn-block'
                        }).then(function() {
                            if (result.result === 1) {
                                window.location.replace('<?php echo RELA_DIR; ?>routing.php');
                            }
                        });
                    });
            });


        });
    </script>
</div>

