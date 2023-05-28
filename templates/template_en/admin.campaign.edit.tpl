
<!--script-->
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function()
    {
        $('.campaign-child').addClass('active');
        var DSTOption = $('#DSTOption');
        DSTOption.click(function()
        {
            $.ajax
            ({
                type:'POST',
                url:'dstOption.php?action=dstOptionCamp',
                data:{"DSTOption":DSTOption.val()},
                success: function (html)
                {
                    $('#subDstOption').html(html);
                }
            });
        });

        $.ajax
        ({
            type:'POST',
            url:'dstOption.php?action=dstOption',
            data:{"DSTOption":DSTOption.val()},
            success: function (html)
            {
                $('#subDstOption').html(html);
            }
        });
    });
</script>
<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li><a class="text-24"><?php echo EDIT_01; ?> <?=CAMPAGIN;?></a></li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->

    <div class="content-body">
    <?php
        $message = $messageStack->output('campaign');
        if(isset($message) && $message['message'] != '')
        {
            echo $message;
        }
        ?>

        <div class="row xsmallSpace"></div>
        <form action="<?php print RELA_DIR; ?>campaign.php?action=edit" method="post" data-validate="form" role="form" class="form-horizontal form-bordered" enctype="multipart/form-data">
            <input type="hidden" name="campId" value="<?php print $temp['campaigns']['campID']; ?>">
            <div id="panel-1" class="panel panel-default">
                <div class="panel-heading ">
                    <h3 class="panel-title"><?php echo EDIT_01; ?> <?=CAMPAGIN;?></h3>
                    <div class="panel-actions">
                        <button data-collapse="#panel-1" title="Collapse-Expand" class="btn-panel">
                            <i class="fa fa-caret-down text-midnight text-18"></i>

                        </button>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="col-xs-12 col-sm-11 col-md-11 center-block">
                        <div class="row">
                            <div class="col-md-6 pull-left">
                                <!-- seperator -->
                                <div class="row xsmallSpace"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="campaignName" class="col-sm-4 control-label pull-left"><?=CAMPAGIN;?> <?=NAME;?>: </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="campaignName" id="campaignName" class="form-control" value="<?php print $temp['campaigns']['name']; ?>" required>
                                            </div><!--/cols-->
                                        </div><!--/form-group-->
                                    </div>
                                </div>
                                <!-- seperator -->

                                <div class="row xsmallSpace"></div>

                          <!--      <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="extensionNumber" class="col-sm-5 control-label pull-left"> Extension :</label>
                                            <div class="col-sm-7">

                                                <select type="number" name="extensionNumber" id="extensionNumber" class="select2">
                                                <?php
/*                                                include_once(ROOT_DIR . "component/extension.operation.class.php");
                                                $operation=new extension_operation();
                                                $result=$operation->getExtensionList();

                                                if($result['result']!=1)
                                                {
                                                    return $result['msg'];

                                                }

                                                foreach($operation->extensionList as $key=>$value){
                                                    */?>
                                                    <option <?php /*if($temp['campaigns']['campExtensions'] == $value['Extension_No']){echo 'selected';} */?> value="<?php /*echo $value['Extension_No'];*/?>"><?php /*echo $value['Extension_No'];*/?></option>
                                                <?php /*}*/?>
                                                    </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>-->

                           <?php //global $conn, $lang;
                            include_once(ROOT_DIR . "model/dstOption.operation.class.php");
                            $DST=new dstOption_operation();
                            $result=$DST->getDstOptionList();

                            if($result['result']!=1)
                            {
                            return $result['msg'];
                            };?>
                            <!--DstOption-->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="DSTOption"><?php echo ANNOUNCE_16?>:</label>
                                        <div class="col-xs-12 col-sm-8 pull-left">
                                            <select class="select2 valid" name="DSTOption" id="DSTOption" required>
                                                <?php foreach($DST->dstOptionList as $key=>$value) {
                                                    ?>
                                                    <option <?php echo $value['DstOptionID'] == $DST->dstOptionList['DSTOption'] ? 'selected' : '' ?> value="<?=$value['DstOptionID']?>"><?=$value['OptionValue']?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--subDstOption-->
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="DSTOption"></label>
                                        <div class="col-xs-12 col-sm-8 pull-left" id="subDstOption" >

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- seperator -->
                                <div class="row xsmallSpace"></div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-4 pull-left control-label" for="sip_id"><?php echo OUTBOUND_16?>:</label>
                                            <div class="col-xs-12 col-sm-8 pull-left">

                                                <select class="valid select2" name="sip_id" id="sip_id" required >
                                                    <?php
                                                    include_once(ROOT_DIR . "model/sip.operation.class.php");
                                                    $operation = new sip_operation();
                                                    $result = $operation->getSipList();

                                                    if($result['result']==-1)
                                                    {
                                                        return $result['msg'];
                                                    }

                                                    foreach($operation->sipList as $key=>$value) {
                                                        ?>
                                                        <option <?php if($value['sip_id'] == $operation->sipList['siptrunk_id']) echo 'selected'; ?> value="<?=$value['sip_name']?>"><?=$value['sip_name']?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                 <!--   <div class="col-xs-12 col-sm-12 col-md-6">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="sip_id">:</label>
                                        <div class="col-xs-12 col-sm-8 pull-left">
                                            <input name="tel_num" id="tel_num" class="form-control">
                                        </div>
                                    </div>-->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="startAndStopDate" class="col-sm-4 control-label pull-left"><?=START_DATE;?>: </label>
                                            <div class="col-sm-8">
                                                <div class="input-group input-group-in">
                                                    <?php
                                                    $startDate = explode(" ",$temp['campaigns']['startDate']);
                                                    ?>
                                                    <span class="input-group-addon text-silver"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" name="startDate" id="startDate" class="form-control" value="<?php echo $startDate[0]; ?>">
                                                </div>
                                            </div><!--/cols-->
                                        </div><!--/form-group-->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="startAndStopDate" class="col-sm-4 control-label pull-left"><?=END_DATE;?>: </label>
                                            <div class="col-sm-8">
                                                <div class="input-group input-group-in">
                                                    <?php
                                                    $endDate = explode(" ",$temp['campaigns']['endDate']);
                                                    ?>
                                                    <span class="input-group-addon text-silver"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" name="stopDate" id="stopDate" class="form-control" value="<?php echo $endDate[0]; ?>">
                                                </div>
                                            </div><!--/cols-->
                                        </div><!--/form-group-->
                                    </div>

                                </div>

                                <!-- seperator -->
                                <div class="row xsmallSpace"></div>



                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="channelNumber" class="col-sm-4 control-label pull-left"><?=CHANNEL_NUMBER;?>: </label>
                                            <div class="col-sm-8">
                                                <input type="number" name="channelNumber" id="channelNumber" class="form-control" value="<?php print $temp['campaigns']['chanelNumber']; ?>">
                                            </div><!--/cols-->
                                        </div><!--/form-group-->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="scheduleGroup" class="col-sm-4 control-label pull-left"><?=SCHEDULE_GROUP;?>: </label>
                                            <div class="col-sm-8">
                                                <select name="scheduleGroup" id="scheduleGroup" style="width:100%" data-input="select2" placeholder="Select Group">
                                                    <option value=""></option>
                                                    <?php
                                                    foreach ($temp['group'] as $camId=>$value) { ?>
                                                        <option <?php if ($temp['campaigns']['scheduleGroupId'] == $camId) print "selected"; ?> value="<?= $camId; ?>"><?= $value['name']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div><!--/cols-->
                                        </div><!--/form-group-->
                                    </div>
                                </div>

                                <!-- seperator -->
                                <div class="row xsmallSpace"></div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer clearfix">
                    <div class="pull-left">
                        <button type="submit" class="btn btn-primary btn-sm btn-icon text-13"><i class="fa fa-plus"></i><?=EDIT_01;?></button>
                    </div>
                </div>
            </div>
        </form>
    </div><!--/content-body -->
</div>
