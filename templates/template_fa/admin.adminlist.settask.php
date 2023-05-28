<?php
global $admin_info;
$admin_permission = $admin_info['permission_pbx'];
?>
<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"></a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <?php if ($message != null) { ?>
        <?php foreach ($message as $msg) { ?>
            <div class="col-xs-12 col-md-12 col-md-12 col-lg-12 alert alert-warning">
                <?php echo $msg ?>
            </div>
        <?php } ?>
    <?php } ?>
    <div class="content-body">
        <form name="add_customer_form" id="add_customer_form" role="form" data-validate="form" enctype="multipart/form-data" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
            <div id="panel-sortable" class="panel panel-default" data-boxid="1">
                <div class="panel-heading">
                    <div class="panel-actions">
                        <button data-collapse="#panel-sortable" title="collapse" class="btn-panel">
                            <i class="fa fa-caret-down text-midnight text-18"></i>
                        </button>
                    </div><!-- /panel-actions -->
                    <h3 class="panel-title sortable-widget-handle">Admin Info</h3>
                </div><!-- /panel-heading -->
                <div class="panel-body">
                    <script type="text/javascript">

                        var $body = $('body'),
                            RecordID,
                            $destination = $('.destination-holder'),
                            isMemberInfo = <?php echo $member_info != -1 ? 'true' : 'false'; ?>,
                            result = JSON.parse('<?php echo json_encode($list , true) ?>');

                           // debugger;
                        console.log('get json data from server: ');
                        console.log(result);

                        function show_confirm(id,s,os)
                        {
                            if (confirm("Are you sure?"))
                            {
                                window.location="<?php$_SERVER['PHP_SELF']?>?action=status&id="+id+"&status="+s+"&os="+os;
                            }
                        }


                        function checked1(checkBox,className)
                        {
                            className	=	"c"+className;
                            $temp		=	checkBox.checked;
                            $('.'+className+'').attr('checked',$temp);
                        }

                        $(function(){
                            $('input[id^="check_"]').on('click',function(){
                                var self = $(this),
                                    inputs = $(self).closest('.panel').find('input[id^="permission"]');
                                if($(this).is(':checked')) {
                                    inputs.prop('checked',true);
                                } else {
                                    inputs.prop('checked',false);
                                }
                            });
                        });

                            $("form").submit(function(e){

                                e.preventDefault();

                                let data = {},
                                    cntErr = 0;

                                $(this).find('input[type=checkbox]').each(function() {
                                    if ($(this).prop('required') && !$(this).val().length) {
                                        cntErr++;
                                    } else {
                                        data[$(this).attr('name')] = $(this).is(':checked') ? 1 : 0;
                                    }
                                });

                                if (cntErr) {
                                    swal({
                                        title: '',
                                        html: "Please fill required items",
                                        type: 'warning',
                                        confirmButtonText: 'OK',
                                        confirmButtonClass: 'btn btn-warning btn-block'
                                    });
                                } else {
                                    data['admin_id'] = result['id'];

                                    console.log($body.find('.deviceModelItemId').length);

                                    $.httpRequest(result['url'] + '?action='+result['submit_action'], 'POST', data, false, true)
                                        .then(function(response) {
                                            //debugger;
                                            console.log(response);
                                            return;
                                            let resp = JSON.parse(response);

                                            let html = '';
                                            if (typeof resp.msg === 'string') {
                                                html = resp.msg;
                                            } else {
                                                $.each(resp.msg, function(i, v) {
                                                    html += '<div>' + v + '</div><br>';
                                                });
                                            }

                                            if (parseInt(resp.result) === 1) {
                                                $('.deviceModelItemId').val(resp.deviceId);
                                                swal({
                                                    title: '',
                                                    html: html,
                                                    type: 'success',
                                                    confirmButtonText: 'OK',
                                                    confirmButtonClass: 'btn btn-success btn-block'
                                                }).then(function() {
                                                    $('.mac-address-container').html('Mac Address : <a href="<?=RELA_DIR?>extension.php?action=download&name='+resp.path+'" class="text-danger text-underline" target="_blank"><i class="fa fa-download margin-right"></i>' + ($body.find('[name="macAddress"]').val()) + '</a>');

                                                    $showVoipConfigModal.modal('hide');
                                                });
                                            } else if (parseInt(resp.result) === -1) {
                                                swal({
                                                    title: '',
                                                    html: html,
                                                    type: 'error',
                                                    confirmButtonText: 'OK',
                                                    confirmButtonClass: 'btn btn-danger btn-block'
                                                });
                                            } else {
                                                swal({
                                                    title: '',
                                                    text: 'A problem has been detected, please try again.',
                                                    type: 'error',
                                                    confirmButtonText: 'OK',
                                                    confirmButtonClass: 'btn btn-danger btn-block'
                                                });
                                            }
                                        });
                                }
                                $body.find('#VoipConfigModal').modal('hide');
                                console.log(data);

                            });

                    </script>
                    <div>
                        <div>
                            <div id="panel-permissions" class="panel panel-success">
                                <div class="panel-body">
                                    <h2 class="card-title text-16 text-danger"><i class="fa fa-lock"></i> Permissions</h2>
                                </div>

                                <form method="post">
                                    <input name="action" type="hidden" id="action" value="setAdminTask">
                                    <div class="panel-body">
                                        <?php //showWarningMsg($message); showMsg($redirect) ?>

                                        <?php
                                        $c=0;
                                        foreach($list['permissions'] as $pageName=>$class)
                                        {
                                            //print_r($class);
                                            $c++;
                                            if($admin_info['compid']!=1 && ($pageName== 'advertisment.controller.admin' || $pageName=='company.controller'))
                                            {
                                                continue;
                                            }
                                            else
                                            {

                                                ?>
                                                <div class="panel panel-default mat-elevation-z">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">
                                                            <div class="nice-checkbox">
                                                                <input type="checkbox" name="check_<?php echo $c; ?>" id="check_<?php echo $c;?>" value="All">
                                                                <label for="check_<?php echo $c;?>" class="text-success rtl">
                                                                    <span class="text-inverse text-16"><?php echo $pageName;?></span>
                                                                </label>
                                                            </div><!--/nice-checkbox-->
                                                        </h3>
                                                    </div><!-- /panel-heading -->

                                                    <div class="panel-body">
                                                        <table class="pull-right">
                                                            <tbody>
                                                            <tr>
                                                                <?php
                                                                foreach($class->action as $action=>$arrayAction) {
                                                                    $class->getPointAction($arrayAction['action']);
                                                                    $codAction=$class->getPointAction($arrayAction['action']);
                                                                    ?>
                                                                    <td style="padding: 0 1em;">
                                                                        <div class="nice-checkbox">
                                                                            <input type="checkbox" name="permission[<?php echo $codAction; ?>]" id="permission[<?php echo $codAction;?>]" value="<?php echo $codAction;?>" <?php if($admin_permission[$codAction-1]==1) {print 'checked="checked"';} ?>>
                                                                            <label for="permission[<?php echo $codAction;?>]" class="text-success rtl">
                                                                                <span class="text-inverse text-13"><?php echo $arrayAction['label'];?></span>
                                                                            </label>
                                                                        </div><!--/nice-checkbox-->
                                                                    </td>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>

                                        <div class="pull-left">
                                            <button id="submit" type="submit" class="btn btn-icon btn-success mat-elevation-z mat-button radius-all"><i class="fa fa-check-circle"></i>Submit</button>
                                            <a href="<?php echo RELA_DIR."admin.list.php" ?>" class="btn btn-link text-danger btn-sm">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!--/content -->
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<?php /*

*/?>
