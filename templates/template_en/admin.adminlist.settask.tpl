<script type="text/javascript">

    function show_confirm(id,s,os)
    {
        if (confirm("Are you sure?"))
        {
            window.location="<?=$_SERVER['PHP_SELF']?>?action=status&id="+id+"&status="+s+"&os="+os;
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


</script>
<div class="content active">
    <div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?php echo DEFINE_PERMISSION; ?></h2>
    </div><!--/content-header -->

    <div class="content-body">
        <!-- APP CONTENT
        ================================================== -->
        <!-- DASHBOARD
    ================================================== -->
        <!-- Dashboard  -->
        <?php
        $message = $messageStack->getMessages('admin.list');

        if(isset($message[0]) && $message[0] != '')
        {
            ?>
            <div class="alert alert-danger fade in">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <p><?php echo $message[0]; ?></p>
            </div>
        <?php
        }?>

        <div id="panel-tablesorter" class="panel panel-warning">
            <div class="panel-heading bg-white">
                <h3 class="panel-title"><?php echo ACCESS; ?></h3>
                <div class="panel-actions">
                    <button data-expand="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?php echo RESIZE; ?>">
                        <i class="fa fa-expand"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->

            <form action="" method="post" enctype="multipart/form-data" >
                <div class="panel-body">


                    <?php
                    $c=0;
                    foreach($temp['PagePermission'] as $pageName=>$class) {
                        $c++;

                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <div class="nice-checkbox">
                                    <input type="checkbox" name="check_<?=$c;?>" id="check_<?=$c;?>" value="All">
                                    <label for="check_<?=$c;?>" class="text-success">
                                        <span class="text-inverse"><?=$pageName;?></span>
                                    </label>
                                </div><!--/nice-checkbox-->
                            </h3>
                        </div><!-- /panel-heading -->

                        <div class="panel-body">
                            <table class="pull-left">
                                <tbody>

                                    <?php
                                    $i=1;

                                    foreach($class->action as $action=>$arrayAction) {
                                        $class->getPointAction($arrayAction['action']);
                                        $codAction=$class->getPointAction($arrayAction['action']);
                                        if(!($i%6) || $i==1)
                                        {
                                    ?>
                                    <tr>
                                    <?php
                                    }
                                    ?>
                                    <td colspan="2" style="padding: 0 1em;">
                                        <div class="nice-checkbox">
                                            <input type="checkbox" name="permission[<?=$codAction;?>]" id="permission[<?=$codAction;?>]" value="<?=$codAction;?>" <?php if($temp['admin_permission'][$codAction-1]==1) {print 'checked="checked"';} ?>>
                                            <label for="permission[<?=$codAction;?>]" class="text-success">
                                                <span class="text-inverse"><?php echo $arrayAction['label'];?></span>
                                            </label>
                                        </div><!--/nice-checkbox-->
                                    </td>
                                    <?php
                                      if(!($i%4) || $i==1)
                                        {
                                    ?>
                                    </tr>
                                    <?php
                                    }
                                    $i++;
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <input name="action" type="hidden" id="action" value="setAdminTask" />
                </div>

                <div class="panel-footer clearfix bg-cloud">
                    <div class="pull-left">
                        <a href="<?php echo RELA_DIR."admin.list.php" ?>" class="btn btn-danger btn-sm"><?php echo CANCELED; ?></a>
                        <button type="submit" class="btn btn-success btn-sm" name="submit"><?php echo CONFIRMED; ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!--/content -->