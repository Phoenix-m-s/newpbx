<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-24">Admin List</a>
            </li>
        </ul><!--/control-nav-->
    </div>
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

        */?><!--
        <div class="alert <?php /*echo ($message['type']=='error'? 'alert-danger':'alert-success') ;*/?> fade in">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <p><?php /*echo $message['message']; */?></p>
        </div>
        --><?php
/*        }*/?>

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
                        <form name="add_customer_form" id="add_customer_form" role="form" data-validate="form"
                              enctype="multipart/form-data" class="form-horizontal form-bordered" autocomplete="off"
                              novalidate="novalidate" method="post">

                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 pull-left control-label"
                                               for="username"><?php echo USERNAME; ?>: </label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" class="form-control" name="username" id="username"
                                                    autocomplete="off"
                                                   placeholder="<?php echo EXAMPLE; ?> admin" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 pull-left control-label" for="name"><?php echo NAME; ?>
                                            : </label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" class="form-control" name="name" id="name" minLength="2"
                                                   placeholder="<?php echo EXAMPLE; ?> " autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row xsmallSpace"></div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 pull-left control-label"
                                               for="family"><?php echo FAMILY; ?>: ‌</label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" class="form-control valid" name="family" id="family"
                                                   placeholder="<?php echo EXAMPLE; ?> " autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <!--
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 pull-left control-label" for="cell_phone"><?php echo PHONE_NUMBER; ?>: </label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="text" class="form-control" name="cell_phone" id="cell_phone" placeholder="<?php echo EXAMPLE; ?> 09123456789" required>
                                        </div>
                                    </div>
                                </div>
                                -->
                            </div>
                            <div class="row xsmallSpace"></div>


                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 pull-left control-label"
                                               for="password_new"><?=EXTENSION_06;?>: </label>
                                        <div class="col-sm-8 pull-left">
                                            <input type="password" class="form-control" name="password_new"
                                                   id="password_new" placeholder="<?php echo EXAMPLE; ?> 123456"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-sm-4 pull-left control-label"
                                                   for="confirm_password"><?=RE_PASSWORD;?>: </label>
                                            <div class="col-sm-8 pull-left">
                                                <input type="password" class="form-control" name="confirm_password"
                                                       id="confirm_password" placeholder="<?php echo EXAMPLE; ?> 123456"
                                                       required>
                                            </div>
                                        </div>
                                    </div><!--/form-group-->
                                </div>
                                <!--addAdmin-->
                                <input type="hidden" name="<?=$list['token']?>" value="1">
                            </div>
                            <div class="row xsmallSpace"></div>
                            <div class="row xsmallSpace"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="pull-left">
                                        <button type="submit" name="" id="submit"
                                                class="btn btn-icon btn-success">
                                            <i class="fa fa-plus"></i>
                                            Submit
                                        </button>
                                    </p>
                                </div>
                            </div>
                            <input type="hidden" name="action" value="addAdmin"/>
                        </form>

                        <div class="content-body">
                            <div class="mat-card mat-elevation-z3">
                                <div class="mat-card-title">
                                    show User
                                </div>

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
                                                        <th>member_id</th>
                                                        <th>status</th>
                                                        <th>tools</th>
                                                    </tr>
                                                    </thead>

                                                    <tfoot>
                                                    <th><input type="text" name="search_1" class="search_init form-control"/></th>
                                                    <th><input type="text" name="search_2" class="search_init form-control"/></th>
                                                    <th><input type="text" name="search_3" class="search_init form-control"/></th>
                                                    <th><input type="text" name="search_4" class="search_init form-control"/></th>


                                                    <th>
                                                        <select name="search_5" class="search_init form-control" id="status">
                                                            <option value="">All</option>
                                                            <option value="0">Incompleted</option>
                                                            <option value="1">Runing</option>
                                                            <option value="2">Finished</option>
                                                        </select>
                                                    </th>
                                                    <th><input type="text" name="search_6" class="search_init form-control"/></th>
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


    <script>
        $(document).ready(function () {

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
                "ajax": "<?=RELA_DIR?>admin.list.php?action=filterUser<?=$export['status'] ?>"
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

        });

    </script>