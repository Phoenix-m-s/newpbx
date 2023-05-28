
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
            <li>
                <a class="text-24"><?php echo ADD; ?><?php echo CAMPAGIN; ?></a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->

    <div class="content-body">
        <form action="<?php print RELA_DIR; ?>campaign.php?action=addCampaign" method="post" data-validate="form" role="form" class="form-horizontal form-bordered" enctype="multipart/form-data">

        <?php
        $message = $messageStack->output('campaign');
        if(isset($message) && $message['message'] != '')
        {
            echo $message;
        }
        ?>

        <div class="row xsmallSpace"></div>

        <div id="panel-1" class="panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo ADD; ?><?php echo Campagin; ?></h3>

                <div class="panel-actions">
                    <button data-collapse="#panel-1" title="Collapse-Expand" class="btn-panel">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div>
            </div>
            <div class="panel-body">

                <div class="col-xs-12 col-sm-12 col-md-12 center-block">
                    <div class="row">
                            <!-- seperator -->
                            <div class="row xsmallSpace"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="campaignName" class="col-sm-4 col-md-4 control-label pull-left"><?php echo CAMPAGIN; ?> <?php echo NAME; ?>: </label>
                                        <div class="col-sm-6 col-md-6">
                                            <input type="text" name="campaignName" id="campaignName" class="form-control" required>
                                        </div><!--/cols-->
                                    </div><!--/form-group-->
                                </div>
                            </div>
                            <!-- seperator -->

                            <div class="row xsmallSpace"></div>

                       <!--     <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="extensionNumber" class="col-sm-5 control-label pull-left"> Extension :</label>
                                        <div class="col-sm-7">
                                            <select type="number" name="extensionNumber" id="extensionNumber" class="select2">
                                            <?php
/*                                            include_once(ROOT_DIR . "component/extension.operation.class.php");
                                            $operation=new extension_operation();
                                            $result=$operation->getExtensionList();

                                            if($result['result']!=1)
                                            {
                                                return $result['msg'];

                                            }

                                            foreach($operation->extensionList as $key=>$value){
                                                */?>
                                                <option value="<?php /*echo $value['Extension_No'];*/?>"><?php /*echo $value['Extension_No'];*/?></option>
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
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-12 col-md-12  pull-left control-label" for="DSTOption"><?php echo ANNOUNCE_16?>:</label>
                                        <div class="col-xs-12 col-sm-12 col-md-12 pull-left">
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
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-12 pull-left control-label" for="subDstOption">sub DstOption</label>
                                        <div class="col-xs-12 col-sm-12 pull-left" id="subDstOption">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-12 pull-left control-label" for="sip_id"><?php echo OUTBOUND_16?>:</label>
                                        <div class="col-xs-12 col-sm-12 pull-left">

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
                            </div>

                            <div class="row">
                              <!--  <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 pull-left control-label" for="sip_id">:</label>
                                        <div class="col-xs-12 col-sm-8 pull-left">
                                            <input name="tel_num" id="tel_num" class="form-control">
                                        </div>
                                    </div>
                                </div>-->
                            </div>

                            <!-- seperator -->
                            <div class="row xsmallSpace"></div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="startAndStopDate" class="col-sm-4 col-md-4 control-label pull-left"><?php echo START_DATE; ?>: </label>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="input-group input-group-in">
                                                <span class="input-group-addon text-silver"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="startDate" id="startDate" class="form-control">
                                            </div>
                                        </div><!--/cols-->
                                    </div><!--/form-group-->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="startAndStopDate" class="col-sm-4 col-md-4 control-label pull-left"><?php echo END_DATE; ?>: </label>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="input-group input-group-in">
                                                <span class="input-group-addon text-silver"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="stopDate" id="stopDate" class="form-control">
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
                                        <label for="channelNumber" class="col-sm-4 col-md-4 control-label pull-left"><?php echo CHANNEL_NUMBER; ?>: </label>
                                        <div class="col-sm-6 col-md-6">
                                            <input type="number" name="channelNumber" id="channelNumber" class="form-control">
                                        </div><!--/cols-->
                                    </div><!--/form-group-->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="scheduleGroup" class="col-sm-4 col-md-4 control-label pull-left"><?php echo SCHEDULE_GROUP; ?>: </label>
                                        <div class="col-sm-6 col-md-6">
                                            <select name="scheduleGroup" id="scheduleGroup" style="width:100%" data-input="select2" placeholder="Select Group">
                                                <option value=""></option>
                                                <?php
                                                foreach ($temp['campaigns'] as $camId=>$value) { ?>
                                                    <option value="<?= $camId; ?>"><?= $value['name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div><!--/cols-->
                                    </div><!--/form-group-->
                                </div>
                            </div>

                            <div class="row xsmallSpace"></div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label pull-left"><?php echo EXTENTION_LIST_TYPE; ?>: ‌</label>
                                        <div class="col-sm-8">
                                            <div class="col-sm-6 pull-left">
                                                <div class="nice-radio text-primary">
                                                    <input type="radio" name="numberListType" id="radio-1" value="importTextFile" checked />
                                                    <label for="radio-1"><span class="text-inverse"><?=IMPORT_TEXT_FILE;?></span></label>
                                                </div><!--/nice-radio-->
                                            </div>
                                            <div class="col-sm-6 pull-left">

                                                <div class="nice-radio text-primary">
                                                    <input type="radio" name="numberListType" id="radio-2" value="generateNumber" />
                                                    <label for="radio-2"><span class="text-inverse"><?=GENERATE_NUMBER;?></span></label>
                                                </div><!--/nice-radio-->
                                            </div>
                                        </div>
                                    </div><!--/form-group-->
                                </div>
                            </div>

                            <!-- seperator -->
                            <div class="row xsmallSpace"></div>
                        <div class="col-md-12 pull-left">

                            <!-- seperator -->
                            <div class="row xsmallSpace"></div>
                            <div id="uploadPart" class="panel panel-default border-teal">
                                <!-- seperator -->
                                <div class="row xsmallSpace"></div>

                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label pull-left" for="fileinput_widget"><?php echo RIGHTMENU_06; ?></label>
                                        <div class="col-sm-8">

                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span class="btn btn-icon btn-icon-right btn-primary btn-file">
                                                <i class="fa fa-upload"></i>
                                                <span class="fileinput-new">Choose File</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="fileinput_inline" id="fileinput_inline">
                                            </span>
                                                <span class="fileinput-filename"></span>
                                                <button class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</button>
                                            </div>

                                        </div><!-- /cols -->
                                    </div><!-- /form-group -->

                                </div>
                            </div>

                            <div id="generateNumPart" class="panel panel-default border-success hide">
                                <div class="panel-body">

                                    <!-- seperator -->
                                    <div class="row xsmallSpace"></div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6 pull-left">
                                                <div class="form-group">
                                                    <label for="prefixNum" class="col-sm-4 col-xs-12 col-md-4 control-label pull-left">Prefix Number: </label>
                                                    <div class="col-sm-6 col-md-6">
                                                        <input type="text" name="prefixNum" id="prefixNum" class="form-control">
                                                    </div><!--/cols-->
                                                </div><!--/form-group-->
                                            </div>
                                            <div class="col-md-6 pull-left">
                                                <div class="form-group">
                                                    <label for="fromNum" class="col-sm-4 col-xs-12 col-md-4 control-label pull-left">From Number: </label>
                                                    <div class="col-sm-6 col-md-6">
                                                        <input type="text" name="fromNum" id="fromNum" class="form-control">
                                                    </div><!--/cols-->
                                                </div><!--/form-group-->
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-6 pull-left">
                                                <div class="form-group">
                                                    <label for="toNum" class="col-sm-5 col-xs-5 col-md-4 control-label pull-left">To Number: </label>
                                                    <div class="col-sm-6 col-md-6">
                                                        <input type="text" name="toNum" id="toNum" class="form-control">
                                                    </div><!--/cols-->
                                                </div><!--/form-group-->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- seperator -->
                                    <div class="row xsmallSpace"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="pull-left" style="margin-bottom: 35px">
            <button type="submit" class="btn btn-success btn-icon"><i class="fa fa-download"></i>submit<?php echo ADD; ?> Campagin</button>
        </div>
        </form>
    </div><!--/content-body -->
</div>
