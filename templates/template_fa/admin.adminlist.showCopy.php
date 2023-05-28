<script>
    $(document).ready(function () {
        alert("admin.adminlist.show");

        //***************#campaign_list for Permission table --- zj
        //	datatable
        var dataTable = $('#campaign_list');

        var oTable = dataTable.DataTable({
            /*data:[
             ['1', '1', '1', '1', '1', '1', '1', '1', '1', '1','1'],
             ['1', '1', '1', '1', '1', '1', '1', '1', '1', '1','1']
             ],*/
            "processing": true,
            "serverSide": true,
            "sPaginationType": "bs_full",
            "oLanguage": {
                "sProcessing": "Loading ..."
            },
            "aaSorting": [],
            "ajax": "<?=RELA_DIR?>admin.list.php?action=filterUser<?=$export['status'];?>"
        });

        // Apply the search
        var timerId;
        oTable.columns().every(function () {
            var that = this;
            $('input , select', this.footer()).on('keyup change', function () {
                var d = this;
                clockStop();
                clockStart();
                function clockStart() {
                    if (timerId) return;
                    timerId = setInterval(update, 1200);
                }

                function clockStop() {
                    if (!timerId) return;
                    clearInterval(timerId);
                    timerId = null;
                }

                function update() {
                    clockStop();
                    that.search(d.value).draw();
                }

            });
        });

        $('body').on('click', '.remove-item', function(e) {
            e.preventDefault();

            var dataUrl = $(this).attr('data-url'),
                confirmation = confirm('Are you sure want to delete this item?');

            if (confirmation) {
                window.location.replace(dataUrl);
            } else {
                return false;
            }
        });
    });
</script>
<!--    move up <script> by zj    -->

<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20">Admin List</a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <div class="content-body">
        <!-- APP CONTENT
        ================================================== -->
        <!-- DASHBOARD
================================================== -->
        <!-- Dashboard  -->

        <?php
        /*$message = $messageStack->getMessages('admin.list');
        //print_r($messageStack->getMessages('showPrice'));die();
        if(isset($message['message']) && $message['message'] != '')
        {

        */?>
        <!--
        <div class="alert <?php /*echo ($message['type']=='error'? 'alert-danger':'alert-success') ;*/?> fade in">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <p><?php /*echo $message['message']; */?></p>
        </div>
        --><?php
        /*        }*/?>

        <div class="container">
            <div class="margin-top text-left margin-left margin-bottom">
                <a href="<?=RELA_DIR.'admin.list.php?action=addAdmin'?>" class="margin-bottom btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?=ADD?> new admin</a>
                <div id="panel-tablesorter" class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Permission</h3>
                        <div class="panel-actions">
                            <button data-collapse="#panel-tablesorter" title="" class="btn-panel"
                                    data-original-title="<?php echo COLLAPSE; ?>">
                                <i class="fa fa-caret-down text-midnight text-18"></i>
                            </button>
                        </div><!-- /panel-actions -->
                    </div><!-- /panel-heading -->

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12 col-md-12 center-block">
                                <div class="content-body">
                                    <div class="mat-card mat-elevation-z3">
                                        <div class="mat-content">
                                            <div class="row mt-double">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="table-responsive table-responsive-datatables">
                                                        <table id="campaign_list" class="table table-striped table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>username</th>
                                                                <th>name</th>
                                                                <th>family</th>
                                                                <th>comp_name</th>
                                                                <th>type</th>
                                                                <th>tools</th>
                                                            </tr>
                                                            </thead>


                                                            <tfoot>
                                                            <th><input type="text" name="search_1" class="search_init form-control"/></th>
                                                            <th><input type="text" name="search_2" class="search_init form-control"/></th>
                                                            <th><input type="text" name="search_3" class="search_init form-control"/></th>
                                                            <th><input type="text" name="search_4" class="search_init form-control"/></th>
                                                            </th>

                                                            <th>
                                                                <select name="search_5" class="search_init form-control" id="status">
                                                                    <option value="">All</option>
                                                                    <option value="1">admin</option>
                                                                    <option value="2">member</option>
                                                                </select>
                                                            </th>

                                                            <th><input type="text" name="search_6" class="search_init form-control"/>

                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!--        ******************** add zj **************************  -->
<!--        **************************************************************  -->
        <?php
        echo "admin list:";

        $AdminDirty = AdminUser::getAll()->getList();
        $AdminClean = $AdminDirty['export']['list'];
        foreach ($AdminClean as $key)
        {
            echo $key['username']." - ".$key['name']." - ".$key['family']." - ".$key['cell_phone'];
            echo "<br>";
        }
        ?>
        <!--        ******************* add zj ***************************  -->
        <!--        **************************************************************  -->

        <?php/*
        <div id="panel-tablesorter1" class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title"><?php echo MANAGER_LIST; ?></h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-tablesorter1" title="" class="btn-panel"
                            data-original-title="<?php echo COLLAPSE; ?>">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div><!-- /panel-actions -->
            </div><!-- /panel-heading -->

            <div class="panel-body">
                <div class="table-responsive table-responsive-datatables">

                    <table class="tablesorter table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th style="width:120px !important;"><?php echo USERNAME; ?></th>
                            <th><?php echo NAME; ?></th>
                            <th><?php echo FAMILY; ?></th>
                            <th><?php echo PHONE_NUMBER; ?></th>
                            <th><?php echo PICTURE ?></th>
                            <th><?php echo TOOLS; ?></th>
                        </tr>
                        </thead>
                        <?php

                    $obj = $this->_adminList->fetchAll(PDO::FETCH_ASSOC);

                        foreach( $obj as $v )
                        {
                        $admin_id = $v['admin_id'];
                        $username = $v['username'];
                        $name = $v['name'];
                        $family = $v['family'];
                        $phone = $v['cell_phone'];
                        $filename = ROOT_DIR."statics/adminPics/".$admin_id.'.jpg';
                        $filename1= ROOT_DIR."statics/adminPics/".$admin_id.'.jpeg';
                        $filename2= ROOT_DIR."statics/adminPics/".$admin_id.'.png';

                        if(file_exists($filename))
                        {
                        $pic = $admin_id.'.jpg';
                        }
                        elseif (file_exists($filename1 ))
                        {
                        $pic = $admin_id.'.jpeg';

                        }
                        elseif(file_exists($filename2))
                        {
                        $pic = $admin_id.'.png';
                        }
                        else
                        {
                        $pic = 'No Image';
                        }
                        ?>
                        <tr>
                            <td><?=$username?></td>
                            <td><?=$name?></td>
                            <td><?=$family?></td>
                            <td><?=$phone?></td>
                            <td>
                                <?php
                                if($pic!='No Image')
                                {
                                    ?>

                                <img src="<?php echo RELA_DIR." statics/adminPics/".$pic;?>" alt=""
                                style="max-width:75px;">
                                <?php
                                }else
                                {
                                    echo $pic;
                                }?>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo RELA_DIR ?>admin.list.php?action=removeadmin&admin_id=<?=$admin_id?>"
                                   rel="tooltip" class="fa fa-trash text-danger" title=""
                                   data-original-title="<?php echo DELETE_01; ?>" style="font-size: 20px"></a>
                                <!--
                                 <a href="<?php echo RELA_DIR ?>admin.list.php?action=showsettask&admin_id=<?=$admin_id?>" rel="tooltip" class="fa fa-lock text-warning" title="" data-original-title="Show Permission" style="font-size: 20px"></a>
                                 -->
                                <a href="<?php echo RELA_DIR ?>admin.list.php?action=showeditadminform&admin_id=<?=$admin_id?>"
                                   rel="tooltip" class="fa fa-edit text-primary" title=""
                                   data-original-title="<?php echo EDIT_01; ?>" style="font-size: 20px"></a>
                            </td>

                        </tr>
                        <?php
                    }
                    ?>

                    </table>

                </div>
            </div>


        </div>
*/?>
    </div><!--/content -->
