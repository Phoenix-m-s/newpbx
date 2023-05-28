<?php global $i; $i=0;?>
<div class="content active">


   <!-- <div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?/*=EXTENSION_25*/?></h2>
    </div><!-- content-header -->

    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?=RELA_DIR?>extension.php?action=showExtensions">
                   edit Extension</i>
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">
        <form name="addExtension" id="addExtension" role="form" data-validate="form" enctype="multipart/form-data" class="form-horizontal form-bordered formtimecondition" autocomplete="off" novalidate="novalidate" method="post">

        <div id="panel-tablesorter" class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-actions">
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?=COLLAPSE?>">
                        <i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div><!-- panel-actions -->
                <h3 class="panel-title"><?=EXTENSION_25?></h3>

            </div><!-- panel-heading -->
            <?php if ($msg != null) {?>
                <div class="col-xs-12 col-md-12 col-md-12 col-lg-12 alert alert-warning">
                    <?=$msg?>
                </div>
                <?php } ?>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-md-12 center-block">
                            <input name="id" id=id type="hidden" value="<?=$list['extension_id']?>"/>

                            <div class="jumbotron no-bg ">

                                <!---------------------------------- Extension_Name ------------------------------------------->
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label"
                                                   for="extension_name"><?=EXTENSION_15?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" class="form-control" name="extension_name"
                                                       id="extension_name" autocomplete="off"
                                                       placeholder="<?=EXTENSION_15?>" required
                                                       value="<?=$list['extension_name']?>">
                                            </div>
                                        </div>
                                    </div>

                                    <!---------------------------------- Extension_No ------------------------------------------->
                                    <div class="col-xs-12 col-md-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label" for="extension_no"><?=EXTENSION_16?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" class="form-control" name="extension_no" id="extension_no" autocomplete="off" placeholder="<?=EXTENSION_16?>" required value="<?=$list[ 'extension_no' ]?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!---------------------------------- UserName ------------------------------------------->
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label" for="username"><?=EXTENSION_30?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" class="form-control" name="username" id="username" autocomplete="off" placeholder="<?=EXTENSION_30?>" required value="<?=$list[ 'username' ]?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!---------------------------------- Password ------------------------------------------->
                                    <div class="col-xs-12 col-md-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label" for="password"><?=EXTENSION_37?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" class="form-control" name="password" id="password" autocomplete="off" placeholder="<?=EXTENSION_37?>" required value="<?=$list[ 'password' ]?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---------------------------------- caller_id_number ------------------------------------------->
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label"
                                                   for="caller_id_number"><?=EXTENSION_28?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" class="form-control" name="caller_id_number"
                                                       id="caller_id_number" autocomplete="off"
                                                       placeholder="<?=EXTENSION_29?>"
                                                       value="<?=$list['caller_id_number']?>">
                                            </div>
                                        </div>
                                    </div>

                                    <!---------------------------------- ring_number ------------------------------------------->
                                    <div class="col-xs-12 col-md-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label"
                                                   for="ring_number"><?=EXTENSION_31?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" class="form-control" name="ring_number" id="ring_number"
                                                       autocomplete="off" placeholder="<?=EXTENSION_31?>" required
                                                       value="<?=$list['ring_number']?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row hidden-xs"></div>

                                <!---------------------------------- Secret ------------------------------------------->
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label"
                                                   for="secret"><?=EXTENSION_17?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" class="form-control" name="secret" id="secret"
                                                       autocomplete="off" placeholder="<?=EXTENSION_17?>" required
                                                       value="<?=$list['secret']?>">
                                            </div>
                                        </div>
                                    </div>

                                    <!---------------------------------- Reaped Secret ------------------------------------------->
                                    <div class="col-xs-12 col-md-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label"
                                                   for="secret2"><?=EXTENSION_18?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" class="form-control" name="secret2" id="secret2"
                                                       autocomplete="off" placeholder="<?=EXTENSION_18?>" required
                                                       value="<?=$list['secret']?>">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row hidden-xs"></div>

                                <!---------------------------------- Internal_Recording ------------------------------------------->
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-md-4">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-md-12 pull-left">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="internal_recording" value="1" id="internal_recording" type="checkbox"
                                                               <?=($list['internal_recording'] == '1') ? 'checked="checked"' : '' ?>> <?=EXTENSION_19?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!---------------------------------- External_Recording ------------------------------------------->
                                    <div class="col-xs-12 col-md-12 col-md-4">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-md-12 pull-left">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="external_recording" value="1" id="external_recording" type="checkbox"
                                                               <?=($list['external_recording'] == '1') ? 'checked="checked"' : '' ?>> <?=EXTENSION_20?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <!---------------------------------- Voice Mail_Status ------------------------------------------->

                                    <div class="form-group col-md-12 col-md-3">
                                        <div class="col-xs-12 col-md-12 pull-left">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="voicemail_status"  value="1" id="voicemail_status" type="checkbox"
                                                           <?=($list['voicemail_status'] == 1) ? 'checked="checked"' : '' ?>><?=EXTENSION_21?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!---------------------------------- Voice Mail_Email ------------------------------------------->
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label"
                                                   for="voicemail_email"><?=EXTENSION_22?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="email" class="form-control" name="voicemail_email"
                                                       id="voicemail_email" autocomplete="off"
                                                       placeholder="<?=EXTENSION_22?>" required
                                                       value="<?=$list['voicemail_email']?>">
                                            </div>
                                        </div>
                                    </div>

                                <!---------------------------------- Voice Mail_Pass ------------------------------------------->
                                    <div class="col-xs-12 col-md-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-md-4 pull-left control-label"
                                                   for="voicemail_pass"><?=EXTENSION_23?>:</label>
                                            <div class="col-xs-12 col-md-6 pull-left">
                                                <input type="text" class="form-control" name="voicemail_pass" id="voicemail_pass"
                                                       placeholder=<?=EXTENSION_23?>" required value="<?=$list['voicemail_pass']?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>




<!-------------------------------------- Success Section(Left Side) -------------------------------------->

<!--                                    <h4>Success Part</h4>
-->
                                    <div class="row hidden-xs"></div>

                                    <!----------------------- Success Dial Destination ----------------------->
                                    <div class="row">
                                        <div class="col-xs-12 col-md-3">
                                            <label class="col-xs-12 col-md-12 pull-left control-label" for="">
                                               <!--Dial Destination:--></label>
                                            <div class="col-xs-12 col-md-12">
                                                <select name="successDialDestination" class="successDialDestination select2 col-xs-12 col-md-11 no-padding no-marginTop" id="1" title="">
                                                    <option value="successDirectDial" <?=($list['successDialDestination'] == 'successDirectDial') ? 'selected' : ''?> >Direct Dial</option>
                                                    <option value="successTimeCondition" <?=($list['successDialDestination'] == 'successTimeCondition') ? 'selected' : ''?> >Time Condition</option>
                                                    <option value="successVoiceMail" <?=($list['successDialDestination'] == 'successVoiceMail') ? 'selected' : ''?> >Voice Mail</option>
                                                    <option value="successForwarding" <?=($list['successDialDestination'] == 'successForwarding') ? 'selected' : ''?> >Forwarding</option>
                                                </select>
                                            </div>
                                        </div>
                                    <!----------------------- Success Forward ----------------------->
                                        <div class="col-xs-12 col-md-3">
                                            <label class="col-xs-12 col-md-12 pull-left control-label margin-lr" for="">
                                               <!--  Forward:--></label>
                                            <div class="successForward col-xs-12 col-md-12 no-padding no-marginTop" id="1-1">
                                                <?php if ($list['successDialDestination'] == 'successDirectDial') { ?>
                                                    <input type="hidden" name="successForward" value="">
                                                    <input type="hidden" name="successDSTOption" value="">
                                                <?php } elseif ($list['successDialDestination'] == 'successTimeCondition') { ?>
                                                    <div id="successTimeConditionLink" style='cursor: pointer; color:black;'><i class="fa fa-clock-o fa-3x" aria-hidden="true"></i></div>
                                                    <input type="hidden" name="successForward" value="">
                                                    <input type="hidden" name="successDSTOption" value="">
                                                <?php } elseif ($list['successDialDestination'] == 'successVoiceMail') { ?>
                                                    <select name='successForward' class='forward pull-left select2 col-xs-12 col-md-11' title="">
                                                        <?php foreach ($list['voiceMailList'] as $key => $value) { ?>
                                                            <option value='<?=$value?>' <?=( $list['successForward'] == $value) ? 'selected' : ''?>>
                                                                <?=$value?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                <?php } elseif ($list['successDialDestination'] == 'successForwarding') {?>
                                                    <label class="col-xs-12 col-md-3  pull-left control-label">Forward:</label>
                                                    <div class="col-xs-12 col-md-8 pull-left">
                                                        <select name='successForward' class='forward col-xs-12 col-md-11 pull-left select2' title="">
                                                            <?php foreach ($list['forwardList'] as $key => $value) {?>
                                                                <option value='<?=$value?>' <?=($list['successForward'] == $value) ? 'selected' : ''?>>
                                                                    <?=$value?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>


                                    <!----------------------- Success DSTOption ----------------------->
                                        <div class="col-xs-12 col-md-3">
                                            <label class="col-xs-12 col-md-12 pull-left control-label margin-lr" for="">
                                               <!-- DSTOption:--></label>
                                            <div class="successDSTOption col-xs-12 col-md-12" data-status="successDSTOption" id="1-2">
                                                <?php if ($list['successDialDestination'] == 'successVoiceMail' & $list['successForward'] == 'customMessageByRecord') {?>
                                                    <div id="successTCRecordVoiceLink" class="col-xs-12 col-md-11" style="text-align: center;">
                                                        <input type="text" name="voiceTitle" class="form-control" id="voiceTitle1" title="Input the Voice Title" placeholder="Input The Voice Title" required>
                                                        <audio controls src="" id="audio"></audio>
                                                        <div class="row">
                                                            <a class="record" id="record_1" style="text-decoration: none" >
                                                                <i class="fa fa-circle button" aria-hidden="true"></i>
                                                            </a>
                                                            <a class="disabled one record_1_one" id="pause" style="text-decoration: none">
                                                                <i class="fa fa-pause button" aria-hidden="true"></i>
                                                            </a>
                                                            <a class="disabled one record_1_one" id="play" style="text-decoration: none">
                                                                <i class="fa fa-play button" aria-hidden="true"></i>
                                                            </a>
                                                            <a class="disabled one record_1_one" id="save" style="text-decoration: none">
                                                                <i class="fa fa-upload button" aria-hidden="true"></i>
                                                            </a>
                                                        </div>

                                                        <input class="button" type="checkbox" id="live" title="">
                                                        <label for="live">Live Output</label>
                                                        <canvas id="record_1_level" height="100" width="200"></canvas>
                                                        <div id="lightBox" class="modal fade" tabindex="-1">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dimdiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                                                        <h4 class="modal-title"></h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-xs-12 col-md-12 col-md-12">
                                                                                <img src="" alt="" class="img-responsive center-block">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="record_1_id" value="" name="FDSTOption">
                                                <?php } elseif ($list['successDialDestination'] == 'successVoiceMail' & $list['successForward'] == 'customMessageByList') { ?>
                                                    <select name="successDSTOption" class="successDSTOption select2 col-xs-12 col-md-11" id="successDSTOption" title="" required>
                                                        <?php foreach ($list['voiceList'] as $value) {?>
                                                            <option value="<?=$value['file_name']?>" <?=($value['file_name'] == $list['successDSTOption'])?'selected':''?>><?=$value['title']?></option>
                                                        <?php } ?>
                                                    </select>
                                                <?php } elseif ($list['successDialDestination'] == 'successForwarding' & $list['successForward'] == 'internal') { ?>
                                                    <select name='successDSTOption col-xs-12 col-md-11' class='successDSTOption select2' title="">
                                                        <?php foreach ($list['extensionList'] as $key => $value) {?>
                                                            <option value='<?=$value?>' <?=($list['successDSTOption'] == $value) ? 'selected' : ''?> >
                                                                <?=$value?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                <?php } elseif ($list['successDialDestination'] == 'successForwarding' & $list['successForward'] == 'external') { ?>
                                                    <input type='text' value="<?=$list['successDSTOption']?>" class='form-control successDSTOption col-xs-12 col-md-11' name='successDSTOption'
                                                           id='external' placeholder='Enter Phone Number'>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div><!-- End of Success DSTOption -->
                               <!-- End of Success Section (Left Side) -->

<!-------------------------------------- Failed Section(Right Side) -------------------------------------->

<!--                                    <h4>Failed Part</h4>
-->

                                    <!----------------------- Failed Dial Destination ----------------------->
                                    <div class="row margin-top">
                                        <div class="col-xs-12 col-md-3">
                                            <label class="col-xs-12 col-md-12 pull-left control-label margin-lr" for="">
                                               <!-- failed Dial Destination:--></label>
                                            <div class="col-xs-12 col-md-12">
                                                <select name="failedDialDestination" class="failedDialDestination select2 col-xs-12 col-md-11" title="">
                                                    <option value="failedTimeCondition" <?=($list['failedDialDestination'] == 'failedTimeCondition') ? 'selected' : ''?> >Time Condition</option>
                                                    <option value="failedVoiceMail" <?=($list['failedDialDestination'] == 'failedVoiceMail') ? 'selected' : ''?> >Voice Mail</option>
                                                    <option value="failedForwarding" <?=($list['failedDialDestination'] == 'failedForwarding') ? 'selected' : ''?> >Forwarding</option>
                                                </select>
                                            </div>
                                        </div>


                                    <!----------------------- Failed Forward ----------------------->
                                        <div class="col-xs-12 col-md-3">
                                            <label class="col-xs-12 col-md-12 pull-left control-label" for="">
                                               <!-- failed Forward:--></label>
                                            <div class="failedForward col-xs-12 col-md-12" id="0-1" >
                                                <?php if ($list['failedDialDestination'] == 'failedTimeCondition') { ?>
                                                    <div id="failedTimeConditionLink" style='cursor:pointer; color:black;'><i class="fa fa-clock-o fa-3x" aria-hidden="true"></i></div>
                                                    <input type="hidden" name="failedForward" value="">
                                                    <input type="hidden" name="failedDSTOption" value="">
                                                <?php } elseif ($list['failedDialDestination'] == 'failedVoiceMail') { ?>
                                                    <select name='failedForward' class='forward select2 col-xs-12 col-md-11' title="">
                                                        <?php foreach ($list['voiceMailList'] as $key => $value) { ?>
                                                            <option value='<?=$value?>' <?=($list['failedForward'] == $value)?'selected':''?>> <?=$value?> </option>
                                                        <?php } ?>
                                                    </select>
                                                <?php } elseif ($list['failedDialDestination'] == 'failedForwarding') { ?>
                                                    <select name='failedForward' class='forward select2 col-xs-12 col-md-11' title="">
                                                        <?php foreach ($list['forwardList'] as $key => $value) { ?>
                                                            <option value='<?=$value?>' <?=($list['failedForward'] == $value)?'selected':''?>><?=$value?></option>
                                                        <?php } ?>
                                                    </select>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    <!----------------------- Failed DSTOption ----------------------->
                                        <div class="col-xs-12 col-md-3">
                                            <label class="col-xs-12 col-md-12 pull-left control-label margin-lr" for="">
                                                <!--failed DSTOption:--></label>
                                            <div class="failedDSTOption col-xs-12 col-md-12" data-status="failedDSTOption" id="0-2">
                                                <?php if ($list['failedDialDestination'] == 'failedVoiceMail' & $list['failedForward'] == 'customMessageByRecord') { ?>
                                                    <div id="failedTCRecordVoiceLink" class="col-xs-12 col-md-11" style="text-align: center;">
                                                        <input type="text" name="voiceTitle" class="form-control" id="voiceTitle0" title="Input the Voice Title" placeholder="Input The Voice Title" required>
                                                        <audio controls src="" id="audio"></audio>
                                                        <div class="row">
                                                            <a class="record" id="record_0" style="text-decoration: none" >
                                                                <i class="fa fa-circle button" aria-hidden="true"></i>
                                                            </a>
                                                            <a class="disabled one record_0_one" id="pause" style="text-decoration: none">
                                                                <i class="fa fa-pause button" aria-hidden="true"></i>
                                                            </a>
                                                            <a class="disabled one record_0_one" id="play" style="text-decoration: none">
                                                                <i class="fa fa-play button" aria-hidden="true"></i>
                                                            </a>
                                                            <a class="disabled one record_0_one" id="save" style="text-decoration: none">
                                                                <i class="fa fa-upload button" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                        <input class="button" type="checkbox" id="live"/>
                                                        <label for="live">Live Output</label>
                                                        <canvas id="record_0_level" height="100" width="200"></canvas>
                                                        <div id="lightBox" class="modal fade" tabindex="-1">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dimdiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title"></h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-xs-12 col-md-12 col-md-12">
                                                                                <img src="" alt="" class="img-responsive center-block">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="record_0_id" value="" name="FDSTOption">
                                                <?php } elseif ($list['failedDialDestination'] == 'failedVoiceMail' & $list['failedForward'] == 'customMessageByList') { ?>
                                                    <select name="failedDSTOption" class="failedDSTOption select2 col-xs-12 col-md-11" id="failedDSTOption" title="" required>
                                                        <?php foreach ($list['voiceList'] as $value) {?>
                                                            <option value="<?=$value['file_name']?>" <?=($value['file_name'] == $list['failedDSTOption'])?'selected':''?>><?=$value['title']?></option>
                                                        <?php } ?>
                                                    </select>
                                                <?php } elseif ($list['failedDialDestination'] == 'failedForwarding' & $list['failedForward'] == 'internal') { ?>
                                                    <select name='failedDSTOption'  class='failedDSTOption select2 col-xs-12 col-md-11' title="">
                                                        <?php foreach ($list['extensionList'] as $key => $value) {?>
                                                            <option value='<?=$value?>' <?=($list['failedDSTOption'] == $value)?'selected':''?>><?=$value?></option>
                                                        <?php } ?>
                                                    </select>
                                                <?php } elseif ($list['failedDialDestination'] == 'failedForwarding' & $list['failedForward'] == 'external') { ?>
                                                    <input type='text' value="<?=$list['failedDSTOption']?>" class='form-control col-xs-12 col-md-11' name='failedDSTOption' id='external' placeholder='Enter Phone Number'>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>
                                <!-- End of Failed Section (Right Side) -->
                            <!----------------------- Submit Button ----------------------->
                            <div class="row col-md-6 pull-left margin-top">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Reset all the session data related to extension -->
                                        <div title="Reset Session" id="unsetSession" class="col-md-2" style="cursor:pointer; text-align: center;">
                                            <i class="fa fa-refresh fa-2x" aria-hidden="true"></i>
                                            <p>Reset Form</p>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- End of Submit Button -->

                            <div class="largeSpace hidden-xs"></div>
                            <input TYPE="hidden" NAME="<?=$list['token']?>" VALUE="1">
                            <input type="hidden" name="id" value="<?=$list['Extension_ID']?>">

                    </div>
                </div>
            </div>
        </div>

    </div>
            <p class="pull-left">
                <button title="Submit" type="submit" name="action" id="action"  class="btn btn-success btn-icon">
                    <i class="fa fa-download"></i>Submit
                </button>
            </p>
        </form>
</div><!----------------------- content ------------------------------------>

<script type="text/javascript" language="javascript" class="init">

        $(document).ready(function(){

        var VoiceMailStatus = $('#voicemail_status');

        if (VoiceMailStatus.is(':checked')) {
            $("#voicemail_pass").removeAttr('disabled');

        } else {
            $("#voicemail_pass").attr({
                'disabled': 'disabled'
            });
        }

        if (VoiceMailStatus.is(':checked')) {
            $( "#voicemail_email" ).removeAttr( 'disabled' );
        } else {
            $( "#voicemail_email" ).attr( {
                'disabled': 'disabled'
            });
        }

        VoiceMailStatus.bind('change', function(){
            if ( $( this ).is( ':checked' ) )
                $( "#voicemail_pass" ).removeAttr( 'disabled' );
            else
                $( "#voicemail_pass" ).attr( {
                    'disabled': 'disabled'
                });
        });

        VoiceMailStatus.bind( 'change', function(){
            if ( $( this ).is( ':checked' ) )
                $( "#voicemail_email" ).removeAttr( 'disabled' );
            else
                $( "#voicemail_email" ).attr( {
                    'disabled': 'disabled'
                });
        });

        <?php if (isset($_SESSION['extensionForm'][$_GET['id']]) and !empty($_SESSION['extensionForm'][$_GET['id']])) {?>
            $('.fa-refresh').addClass('fa-spin');
            <?php } ?>

        $('#unsetSession').on('click', function(){
            <?php unset($_SESSION['extensionForm'][$list['extension_id']])?>
            window.location = "extension.php?action=editExtension&id=<?=$list['extension_id']?>";
        });

//------------------------------- Setting SESSION With The Form Value -------------------------------//

        $(document).on('click','#successTimeConditionLink',function(){
            var form = $('.formtimecondition')[0];
            var formData = new FormData(form);

            $.ajax({
                url: 'extension.php?action=sendFormAjax&status=extension',
                type: 'post',
                data: formData,
                cash: false,
                contentType: false,
                processData: false,
                success: function () {
                    window.location = "extension.php?action=successTimeCondition&id=<?=$list['extension_id']?>";
                }
            });
        });

        $(document).on('click','#failedTimeConditionLink',function(){
            var form = $('.formtimecondition')[0];
            var formData = new FormData(form);
            $.ajax({
                url: 'extension.php?action=sendFormAjax?status=extension',
                type: 'post',
                data: formData,
                cash: false,
                contentType: false,
                processData: false,
                success: function() {
                    window.location = "extension.php?action=failedTimeCondition&id=<?=$list['extension_id']?>";
                }
            });
        });

        $('.menu-hidden').removeClass('hidden');

//----------------------------- Success Dial Destination part of the Form (Left Side) -----------------------------//

        $(document).on("change", ".successDialDestination", function(e){
            e.preventDefault();
            $('.successDSTOption').hide();
            var value = $(this).find('option:selected').val();
            var ExtensionId = <?=$list['extension_id']?>;

            $.ajax({
                url  : 'extension.php?action=dialDestination',
                data : {dialDestination: value,id: ExtensionId},
                type : 'POST',
                success: function (response) {
                    $('.successForward').html(response);
                    $('.successForward').find('select').select2();
                }
            });
        });

        $(document).on("change", ".successForward", function(){

            $('.successDSTOption').show();
            var value = $(this).find('option:selected').val();
            var ExtensionId = <?=$list['extension_id']?>;

            $.ajax({
                url  : 'extension.php?action=successForward',
                data : {forward: value, id: ExtensionId },
                type : 'POST',
                success: function (response) {
                    $('.successDSTOption').html(response);
                    $('.successDSTOption').find('select').select2();
                }
            });
        });

//----------------------------- Failed Dial Destination part of the Form (Right Side) -----------------------------//

        $(document).on('change', '.failedDialDestination', function(){

            $('.failedDSTOption').hide();
            var value = $(this).find('option:selected').val();
            var ExtensionId = <?=$list['extension_id']?>;

                $.ajax({
                url  : 'extension.php?action=dialDestination',
                data : {dialDestination: value,id: ExtensionId},
                type : 'POST',
                success: function (response) {
                    $('.failedForward').html(response);
                    $('.failedForward').find('select').select2();
                }
            });
        });

        $(document).on("change", ".failedForward", function(){

            $('.failedDSTOption').show();
            var value = $(this).find('option:selected').val();
            var extensionId = <?=$list['extension_id']?>;

            $.ajax({
                url  : 'extension.php?action=failedForward',
                data : {forward: value, id: extensionId},
                type : 'POST',
                success: function (response) {
                    $('.failedDSTOption').html(response);
                    $('.failedDSTOption').find('select').select2();
                }
            });
        });

//----------------------------- Recording Voice Section -----------------------------//

        function restore() {
            $("#record, #live").removeClass("disabled");
            $("#pause").replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
            $(".one").addClass("disabled");
            Fr.voice.stop();
        }

        $(document).on("click", ".record:not(.disabled)", function(){
            RecordID = $(this).attr('id');
            elem = $(this);
            Fr.voice.record($("#live").is(":checked"), function() {
                elem.addClass("disabled");
                $("#live").addClass("disabled");
                $("."+RecordID+"_one").removeClass("disabled");

                /**
                 * The Waveform canvas
                 */
                analyser = Fr.voice.context.createAnalyser();
                analyser.fftSize = 2048;
                analyser.minDecibels = -90;
                analyser.maxDecibels = -10;
                analyser.mdoothingTimeConstant = 0.85;
                Fr.voice.input.connect(analyser);

                var bufferLength = analyser.frequencyBinCount;
                var dataArray = new Uint8Array(bufferLength);

                WIDTH = 200, HEIGHT = 100;
                canvasCtx = $("#"+RecordID+"_level")[0].getContext("2d");
                canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);

                function draw() {
                    drawVisual = requestAnimationFrame(draw);
                    analyser.getByteTimeDomainData(dataArray);
                    canvasCtx.fillStyle = 'rgb(200, 200,



 200)';
                    canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);
                    canvasCtx.lineWidth = 2;
                    canvasCtx.strokeStyle = 'rgb(0, 0, 0)';

                    canvasCtx.beginPath();
                    var sliceWidth = WIDTH * 1.0 / bufferLength;
                    var x = 0;
                    for(var i = 0; i < bufferLength; i++) {
                        var v = dataArray[i] / 128.0;
                        var y = v * HEIGHT/2;

                        if (i === 0) {
                            canvasCtx.moveTo(x, y);
                        } else {
                            canvasCtx.lineTo(x, y);
                        }

                        x += sliceWidth;
                    }
                    canvasCtx.lineTo(WIDTH, HEIGHT/2);
                    canvasCtx.stroke();
                };
                draw();
            });
        });

        $(document).on("click", "#pause:not(.disabled)", function(){
            if ($(this).hasClass("resume")) {
                Fr.voice.resume();
                $(this).replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
            }else{
                Fr.voice.pause();
                $(this).replaceWith('<a class="one resume" id="pause" style="text-decoration: none"><i class="fa fa-play button" aria-hidden="true"></i></a>');
            }
        });

        $(document).on("click", "#stop:not(.disabled)", function(){
            restore();
        });

        $(document).on("click", "#play:not(.disabled)", function(){
            Fr.voice.export(function(url) {
                $("#audio").attr("src", url);
                $("#audio")[0].play();
            }, "URL");
            restore();
        });

        $(document).on("click", "#save:not(.disabled)", function(e){
            e.preventDefault();
            var id = RecordID.replace('record_','');
            var forwardID = '#' + id + '-1';
            var DSTOption = '#' + id + '-2';
            var status = $(DSTOption).data('status');
            var tag = $('<option value="customMessageByList" selected="selected">customMessageByList</option>');
            var extensionID = <?=$_GET['id']?>;
            var voiceTitle = $('#voiceTitle'+id).val();
            var url = "extension.php?action=saveVoice&status="+status+"&extension_id="+extensionID+"&voiceTitle="+voiceTitle;
            Fr.voice.export(function(blob){
                var formData = new FormData();
                formData.append('file', blob);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $(document).find(forwardID).find('select').find('option[value="customMessageByRecord"]').attr("selected",null);
                        $(document).find(forwardID).find('select').find('option[value="customMessageByList"]').remove().end().append(tag);
                        $(document).find(DSTOption).find('#TCRecordVoiceLink').remove();
                        $(document).find(DSTOption).html(response);
                        $(document).find(DSTOption).find('select').select2();

                    }
                });

            }, "blob");
            restore();
        });

    });/* end of document.ready */
</script>

<style>
    .button {
        background: #555;
        border: 1px dotted black;
        border-radius: 50px;
        margin:auto 20px 20px auto;
        font-size: 15px;
        color: #000;
    }

    .button:hover, .button:focus  {
        box-shadow: 0 5px 10px #000;
        color: #fff;
    }

    .disabled {
        box-shadow:none;
        opacity:0.7;
    }

    canvas {
        display: block;
    }
</style>
