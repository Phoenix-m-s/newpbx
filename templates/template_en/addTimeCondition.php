<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL
 * Date: 1/16/2017
 * Time: 11:22 AM
 */
global $i;
$i = 0;
//print_r_debug($list);
?>
<div class="content active">

    <a href="<?=RELA_DIR?>mainTimeCondition.php">
        <i class="fa fa-home fa-2x" aria-hidden="true">Extension</i>
    </a>

    <div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?=EXTENSION_25?></h2>
    </div><!-- content-header -->

    <div class="content-body">

        <div id="panel-tablesorter" class="panel panel-warning ">
            <div class="panel-heading bg-white">
                <h3 class="panel-title"><?=EXTENSION_25?></h3>
                <div class="panel-actions">
                    <button data-expand="#panel-tablesorter" title="" class="btn-panel"
                            data-original-title="<?=RESIZE?>">
                        <i class="fa fa-expand"></i>
                    </button>
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel"
                            data-original-title="<?=COLLAPSE?>">
                        <i class="fa fa-caret-down"></i>
                    </button>
                </div><!-- panel-actions -->
            </div><!-- panel-heading -->
            <?php if ($msg != null) { ?>
                <div class="col-xs-12 col-md-12 col-md-12 col-lg-12 alert alert-warning">
                    <?= $msg ?>
                </div>
            <?php } ?>

            <div class="panel-body ">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-md-10  center-block">

                        <form name="addExtension" id="addExtension" role="form" data-validate="form"
                              class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate"
                              method="post">

                            <div class="row jumbotron" style="box-shadow:2px 2px 5px black;">
                                <div class="col-xs-12 col-md-12 col-md-12">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-md-3 pull-left control-label ltr ">
                                            Time Condition Name </label>
                                        <div class="col-xs-12 col-md-7 pull-left">
                                            <input type="text" class="form-control" value="<?=$list['name']?>" placeholder="Time Condition Name" name="name" id="name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!------------------------------------------------------------ The Time Condition Part ----------------------------------------------------------------------->

                            <?php

                            if (!empty( $list['monthStart'])) {
                                for ($i = 0; $i < count ( $list['monthStart'] ); $i++) {
                                    if ($list['error'][$i] == 1) {
                                        $style = 'style="background:linear-gradient(to bottom, rgba(255,0,0,0.5), rgba(255,0,0,0.5));"';
                                        echo "<p id='conflictMessage' style=' background:#777; font-size: 20px; color:black; font-weight: bold; height:50px; padding-top: 10px; text-align: center; border-radius: 20px; cursor: pointer; '>
                                The Time You've been Inserted, Has Conflict. Please ReSchedule and Re-Enter New Scheduling Variables
                                              </p>";
                                    } elseif ($list['error'][$i] == 2) {
                                        $style = 'style="background:linear-gradient(to bottom, rgba(255,0,0,0.5), rgba(255,0,0,0.5));"';
                                        echo "<p id='conflictMessage' style='background:#777; font-size: 20px; color:black; font-weight: bold; height:50px; padding-top: 10px; text-align: center; border-radius: 20px; cursor: pointer; '>
                                Hour End Have to be Greater Than Hour Start
                                              </p>";
                                    }
                                    ?>
                                    <!------------------------- Time Table that Comes From DataBase and Each Plus ------------------------->
                                    <div class="jumbotron timeTable timeTable<?= $i ?>" <?php if ($list['error'] != 0 and ($i == count($list['monthStart']) - 1)) {
                                        echo $style;
                                    } ?> style="box-shadow: 5px 4px 15px black;">
                                        <div style="cursor: pointer; font-size: 20px; height:60px;">
                                            <i class="fa fa-window-close deleteTimeTable" aria-hidden="true" id="<?=$i?>"> </i>
                                        </div>

                                        <input type="hidden" id="TCID<?=$i?>" name="TCID<?=$list['id'][$i]?>" value="<?=$list['id'][$i]?>">
                                        <!---------------------------------- Hour Start ------------------------------------------->
                                        <div class="row ">
                                            <div class="col-xs-12 col-md-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                        Start Time </label>
                                                    <div class="col-xs-12 col-md-6 pull-left">
                                                        <input type="text" class="form-control"
                                                               value="<?= !empty( $list['hourStart'][$i] ) ? $list['hourStart'][$i] : '' ?>"
                                                               name="hourStart[]" id="hourStart"
                                                               data-show-meridian="false"
                                                               data-template="dropdown"
                                                               data-input="timepicker" title="" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <!---------------------------------- Hour End ------------------------------------------->
                                            <div class="col-xs-6 col-md-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr "> End Time </label>
                                                    <div class="col-xs-12 col-md-6 pull-left">
                                                        <input type="text" class="form-control"
                                                               value="<?= !empty( $list['hourEnd'][$i] ) ? $list['hourEnd'][$i] : '' ?>"
                                                               name="hourEnd[]" id="hourEnd"
                                                               data-show-meridian="false"
                                                               data-template="dropdown"
                                                               data-input="timepicker" title="" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!---------------------------------- Week Day Start ------------------------------------------->
                                        <div class="row ">
                                            <div class="col-xs-6 col-md-12 col-md-6 ">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                        Days </label>
                                                    <div class="col-xs-6 col-md-6 col-md-6 ">
                                                        <select name="weekDayStart[]" class="weekDayStart select2"
                                                                id="weekDayStart" title="" required>
                                                            <?php foreach ($list['weekDaysName'] as $key => $value) { ?>
                                                                <option value="<?= $key ?>" <?= $key == $list['weekDayStart'][$i] ? 'selected' : '' ?> >
                                                                    <?= $value; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!---------------------------------- Week Day End ------------------------------------------->
                                            <div class="col-xs-6 col-md-12 col-md-6 ">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                        Days </label>
                                                    <div class="col-xs-6 col-md-6 col-md-6 ">
                                                        <select name="weekDayEnd[]" class="weekDayEnd select2"
                                                                id="weekDayEnd" title="" required>
                                                            <?php foreach ($list['weekDaysName'] as $key => $value) { ?>
                                                                <option value="<?= $key ?>" <?= $key == $list['weekDayEnd'][$i] ? 'selected' : '' ?> >
                                                                    <?= $value; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!---------------------------------- Day Start ------------------------------------------->
                                        <div class="row ">
                                            <div class="col-xs-6 col-md-12 col-md-6 ">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                        Days </label>
                                                    <div class="col-xs-6 col-md-6 col-md-6 ">
                                                        <select name="dayStart[]" class="dayStart select2" id="dayStart"
                                                                title="" required>
                                                            <?php foreach ($list['days'] as $key => $value) { ?>
                                                                <option value="<?= $key ?>" <?= $key == $list['dayStart'][$i] ? 'selected' : '' ?> >
                                                                    <?= $value; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!---------------------------------- Day End ------------------------------------------->
                                            <div class="col-xs-6 col-md-12 col-md-6 ">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                        Days </label>
                                                    <div class="col-xs-6 col-md-6 col-md-6 ">
                                                        <select name="dayEnd[]" class="dayEnd select2" id="dayEnd"
                                                                title="" required>
                                                            <?php foreach ($list['days'] as $key => $value) { ?>
                                                                <option value="<?= $key ?>" <?= $key == $list['dayEnd'][$i] ? 'selected' : '' ?> >
                                                                    <?= $value; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!---------------------------------- Month Start ------------------------------------------->
                                        <div class="row">
                                            <div class="col-xs-12 col-md-12 col-md-6 ">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                        Month </label>
                                                    <div class="col-xs-6 col-md-6 col-md-6">
                                                        <select name="monthStart[]"
                                                                class="monthStart select2"
                                                                id="monthStart" title="" required>
                                                            <?php foreach ($list['monthsName'] as $key => $value) { ?>
                                                                <option value="<?= $key ?>" <?= $key == $list['monthStart'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!---------------------------------- Month End ------------------------------------------->
                                            <div class="col-xs-12 col-md-12 col-md-6 ">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                        Month </label>
                                                    <div class="col-xs-6 col-md-6 col-md-6">
                                                        <select name="monthEnd[]" class="monthEnd select2"
                                                                id="monthEnd" title="" required>
                                                            <?php foreach ($list['monthsName'] as $key => $value) { ?>
                                                                <option value="<?= $key ?>" <?= $key == $list['monthEnd'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--------------------------------------------- Dial Destination Part --------------------------------------------->
                                        <div class="row hidden-xs">

                                        </div>
                                        <!---------------------------------- Success Dial Extension ------------------------------------------->

                                        <div class="row hidden-xs"></div>
                                        <h3>Destination Setting</h3>
                                        <div class="row" style="border-top: 1px dotted black; padding: 20px;">
                                            <div class="form-group col-xs-6 col-md-3">
                                                <label class="col-xs-12 col-md-5 pull-left control-label ltr ">
                                                    Dial Extension </label>
                                                <div class="col-xs-6 col-md-7">
                                                    <select name="dialExtension[]" class="dialExtension select2"
                                                            id="<?=$i?>" title="" required>
                                                        <?php foreach ($list['dialExtensionList'] as $key => $value) { ?>
                                                            <option value="<?= $value ?>" <?= $value == $list['dialExtension'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--<div class="form-group col-xs-6 col-md-3">
                                                <div class="col-xs-6 col-md-11" id="<?/*=$i*/?>-3">
                                                    <select name="sub_dst[]" class="dialExtension select2"
                                                            id="<?/*=$i*/?>" title="" required>
                                                        <?php /*foreach ($list['sub_dst_list'] as $key => $value) { */?>
                                                            <option value="<?/*=$value['extension_id']*/?>" <?/*=$value['extension_id'] == $list['sub_dst'][$i] ? 'selected' : '' */?> > <?/*=$value['extension_no']*/?></option>
                                                        <?php /*} */?>
                                                    </select>
                                                </div>
                                            </div>-->
                                            <?php
                                           //        print_r_debug($fields);

                                            ?>

                                            <div class="form-group col-xs-6 col-md-3">
                                                <div class="col-xs-6 col-md-11" id="<?=$i?>-3">

                                                    <select name="sub_dst[]" class="dialExtension select2"
                                                            id="<?=$i?>" title="" required>
                                                            <?php foreach($list['extension_no'] as $key => $value) { ?>
<!--                                                            --><?php //print_r_debug($list['extension_no']);   ?>
                                                            <option value="<?=$key?>" <?=$key == $list['oldValue']['sub_dst'][0] ? 'selected' : '' ?> > <?=$value?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!---------------------------------- Forward ------------------------------------------->

                                            <div class="form-group col-xs-6 col-md-3" >
                                                <div class="col-xs-6 col-md-11 forward" id='<?= $i ?>-1'>
                                                    <?php //print_r_debug($list);?>
                                                    <?php if ($list['dialExtension'][$i] == 'directDial') { ?>
                                                        <input type='hidden' value='' name='DSTOption[]'>
                                                        <input type='hidden' value='' name='forward[]'>
                                                    <?php } elseif ($list['dialExtension'][$i] == 'voiceMail') { ?>
                                                        <select name="forward[]" class="forward select2" title="" required>
                                                            <?php foreach ($list['voiceMailList'] as $key => $value) { ?>
                                                                <option value="<?= $value ?>" <?= $value == $list['forward'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>

                                                            <?php } ?>
                                                        </select>
                                                    <?php } elseif ($list['dialExtension'][$i] == 'forward') { ?>
                                                        <select name="forward[]" class="forward select2" title="" required>
                                                            <?php foreach ($list['forwardList'] as $key => $value) { ?>
                                                                <option value="<?= $value ?>" <?= $value == $list['forward'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    <?php }  elseif ($list['dialExtension'][$i] == 'IVR') { ?>
                                                        <select name="forward[]" class="forward select2" title="" required>
                                                            <?php foreach ($list['IVRList'] as $key => $value) { ?>
                                                                <option value="<?= $value ?>" <?= $value == $list['forward'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                        <input type='hidden' value='' name='DSTOption[]'>
                                                    <?php } elseif ($list['dialExtension'][$i] == 'Queue') { ?>
                                                        <select name="forward[]" class="forward select2" title="" required>
                                                            <?php foreach ($list['queueList'] as $key => $value) { ?>
                                                                <option value="<?= $value ?>" <?= $value == $list['forward'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                        <input type='hidden' value='' name='DSTOption[]'>
                                                    <?php } elseif ($list['dialExtension'][$i] == 'Announce') { ?>
                                                        <select name="forward[]" class="forward select2" title="" required>
                                                            <?php foreach ($list['announceList'] as $key => $value) { ?>
                                                                <option value="<?= $value ?>" <?= $value == $list['forward'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                        <input type='hidden' value='' name='DSTOption[]'>
                                                    <?php } elseif ($list['dialExtension'][$i] == 'HangUp') { ?>
                                                        <input type='hidden' value='' name='forward[]'>
                                                        <input type='hidden' value='' name='DSTOption[]'>
                                                    <?php } elseif ($list['dialExtension'][$i] == 'fax') { ?>
                                                        <!--<input type='text' class='form-control'
                                                                   value="<?/*= $list['forward'][$i] */?>"
                                                                   name='forward[]' id='fax'
                                                                   placeholder='Enter Phone Number'>-->
                                                        <input type='hidden' value='' name='DSTOption[]'>
                                                        <input type='hidden' value='' name='DSTOption[]'>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <!---------------------------------- Dial Destination ------------------------------------------->

                                            <div class="form-group col-xs-6 col-md-3">
                                                <div class="col-xs-6 col-md-11" data-status="DSTOption" id="<?=$i?>-2">
                                                    <?php if ($list['dialExtension'][$i] == 'forward' & $list['forward'][$i] == 'internal') { ?>
                                                        <select name="DSTOption[]" class="DSTOption select2"
                                                                id="DSTOption" title="" required>

                                                            <?php foreach ($list['extensionList'] as $key => $value) { ?>
                                                                <option value="<?= $value ?>" <?= $value == $list['DSTOption'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    <?php } elseif ($list['dialExtension'][$i] == 'forward' & $list['forward'][$i] == 'external') { ?>
                                                        <input type='text' class='form-control'
                                                               value="<?= $list['DSTOption'][$i] ?>"
                                                               name='DSTOption[]' id='external'
                                                               placeholder='Enter Phone Number'>
                                                    <?php } else { ?>

                                                        <?php if ($list['dialExtension'][$i] == 'voiceMail' & $list['forward'][$i] == 'withOutMessage') { ?>
                                                            <input type="hidden" value="" name="DSTOption[]">
                                                        <?php } elseif ($list['dialExtension'][$i] == 'voiceMail' & $list['forward'][$i] == 'defaultMessage') { ?>
                                                            <input type="hidden" value="" name="DSTOption[]">
                                                        <?php } elseif ($list['dialExtension'][$i] == 'voiceMail' & $list['forward'][$i] == 'customMessageByRecord') { ?>
                                                            <div id="TCRecordVoiceLink" class="col-xs-12 col-md-12" style="text-align: center;">
                                                                <input type="text" name="voiceTitle" class="form-control" id="voiceTitle<?=$i?>" title="Input the Voice Title" placeholder="Input The Voice Title" required>
                                                                <audio controls src="" id="audio"></audio>
                                                                <div class="row">
                                                                    <a class="record" id="record_<?=$i?>" style="text-decoration: none" >
                                                                        <i class="fa fa-circle button" aria-hidden="true"></i>
                                                                    </a>
                                                                    <a class="disabled one record_<?=$i?>_one" id="pause" style="text-decoration: none">
                                                                        <i class="fa fa-pause button" aria-hidden="true"></i>
                                                                    </a>
                                                                    <a class="disabled one record_<?=$i?>_one" id="play" style="text-decoration: none">
                                                                        <i class="fa fa-play button" aria-hidden="true"></i>
                                                                    </a>
                                                                    <a class="disabled one record_<?=$i?>_one" id="save" style="text-decoration: none">
                                                                        <i class="fa fa-upload button" aria-hidden="true"></i>
                                                                    </a>
                                                                </div>

                                                                <input class="button" type="checkbox" id="live" title="">
                                                                <label>Live Output</label>
                                                                <canvas id="record_<?=$i?>_level" height="100" width="200"></canvas>
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
                                                        <?php } elseif ($list['dialExtension'][$i] == 'voiceMail' & $list['forward'][$i] == 'customMessageByList') { ?>
                                                            <select name="DSTOption[]" class="DSTOption select2" id="DSTOption" title="" required>
                                                                <?php foreach ($list['voiceList'] as $value) { ?>
                                                                    <option value="<?=$value['upload_id']?>" <?=($value['upload_id'] == $list['DSTOption'][$i])?'selected':''?>><?=$value['title']?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End of jumbotron-->
                                    <?php
                                }
                            }
                            $deleteCounter = count($list['monthStart']);
                            $arrayCounter = $dayCount = 0;
                            if ($list['plus'] == 1){
                                ?>
                                <div class="jumbotron row timeTable timeTable<?= $deleteCounter ?>" style=" box-shadow: 5px 4px 15px black;">
                                    <div style="cursor: pointer; font-size: 20px; height:60px;">
                                        <i style="color:red;" class="fa fa-times deleteTimeTable" aria-hidden="true"
                                           id="<?= $deleteCounter ?>"></i>
                                    </div>

                                    <!---------------------------------- Hour Start ------------------------------------------->
                                    <div class="row ">
                                        <div class="col-xs-12 col-md-12 col-md-6">
                                            <div class="form-group">
                                                <label
                                                        class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                    Start Time </label>
                                                <div class="col-xs-12 col-md-6 pull-left">
                                                    <input type="text" class="form-control"
                                                           value="<?= !empty( $list['hourStart'][$i] ) ? $list['hourEnd'][$i] : '' ?>"
                                                           name="hourStart[]" id="hourStart"
                                                           placeholder="<?= 'hourStart'; ?>" required
                                                           data-show-meridian="false"
                                                           data-template="dropdown"
                                                           data-input="timepicker">
                                                </div>
                                            </div>
                                        </div>

                                        <!---------------------------------- Hour End ------------------------------------------->
                                        <div class="col-xs-6 col-md-6 col-md-6">
                                            <div class="form-group">
                                                <label
                                                        class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                    End Time </label>
                                                <div class="col-xs-12 col-md-6 pull-left">
                                                    <input type="text" class="form-control"
                                                           value="<?= !empty( $list['hourEnd'][$i] ) ? $list['hourEnd'][$i] : '' ?>"
                                                           name="hourEnd[]" id="hourEnd"
                                                           placeholder="<?= 'Hour End'; ?>" required
                                                           data-show-meridian="false"
                                                           data-template="dropdown"
                                                           data-input="timepicker">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!---------------------------------- Week Day Start ------------------------------------------->
                                    <div class="row ">
                                        <div class="col-xs-6 col-md-12 col-md-6 ">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                    Days </label>
                                                <div class="col-xs-6 col-md-6 col-md-6 ">
                                                    <select name="weekDayStart[]" class="weekDayStart select2"
                                                            id="weekDayStart" title="" required>
                                                        <?php foreach ($list['weekDaysName'] as $key => $value) { ?>
                                                            <option value="<?= $key ?>">
                                                                <?= $value; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!---------------------------------- Week Day End ------------------------------------------->
                                        <div class="col-xs-6 col-md-12 col-md-6 ">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                    Days </label>
                                                <div class="col-xs-6 col-md-6 col-md-6 ">
                                                    <select name="weekDayEnd[]" class="weekDayEnd select2" id="weekDayEnd"
                                                            title="" required>
                                                        <?php foreach ($list['weekDaysName'] as $key => $value) { ?>
                                                            <option value="<?= $key ?>">
                                                                <?= $value; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!---------------------------------- Day Start ------------------------------------------->
                                    <div class="row ">
                                        <div class="col-xs-6 col-md-12 col-md-6 ">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                    Days </label>
                                                <div class="col-xs-6 col-md-6 col-md-6 ">
                                                    <select name="dayStart[]" class="dayStart select2" id="dayStart"
                                                            title="" required>
                                                        <?php foreach ($list['days'] as $key => $value) { ?>
                                                            <option value="<?= $key ?>">
                                                                <?= $value; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!---------------------------------- Day End ------------------------------------------->
                                        <div class="col-xs-6 col-md-12 col-md-6 ">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                    Days
                                                </label>
                                                <div class="col-xs-6 col-md-6 col-md-6 ">
                                                    <select name="dayEnd[]" class="dayEnd select2" id="dayEnd" title="" required>
                                                        <?php foreach ($list['days'] as $key => $value) { ?>
                                                            <option value="<?= $key ?>">
                                                                <?= $value; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!---------------------------------- Month Start ------------------------------------------->
                                    <div class="row">
                                        <div class="col-xs-12 col-md-12 col-md-6 ">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                    Month </label>
                                                <div class="col-xs-6 col-md-6 col-md-6">
                                                    <select name="monthStart[]"
                                                            class="monthStart select2"
                                                            id="monthStart" title="" required>
                                                        <?php foreach ($list['monthsName'] as $key => $value) { ?>
                                                            <option value="<?= $key ?>"> <?= $value; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!---------------------------------- Month End ------------------------------------------->
                                        <div class="col-xs-12 col-md-12 col-md-6">
                                            <div class="form-group">
                                                <label
                                                        class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                                    Month </label>
                                                <div class="col-xs-6 col-md-6 col-md-6">
                                                    <select name="monthEnd[]" class="monthEnd select2" id="monthEnd"
                                                            title="" required>
                                                        <?php foreach ($list['monthsName'] as $key => $value) { ?>
                                                            <option value="<?= $key ?>"> <?=$value?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--------------------------------------------- Dial Destination Part --------------------------------------------->
                                    <div class="row mdallSpace hidden-xs"></div>
                                    <!---------------------------------- Dial Extension ------------------------------------------->

                                    <h3 style="margin-left: 30px;">Destination Setting</h3>
                                    <div class="row" style="border-top: 1px dotted black; padding: 20px;">
                                        <div class="form-group col-xs-6 col-md-3">
                                            <label class="col-xs-6 col-md-5 pull-left control-label ltr ">
                                                Dial Extension
                                            </label>
                                            <div class="col-xs-6 col-md-7">
                                                <select name="dialExtension[]" class="dialExtension select2"
                                                        id="<?=$i?>" title="" required >
                                                    <option value="directDial">Direct Dial</option>
                                                    <option value="voiceMail">Voice Mail</option>
                                                    <option value="forward">Forward</option>
                                                    <option value="IVR">IVR</option>
                                                    <option value="Queue">Queue</option>
                                                    <option value="Announce">Announce</option>
                                                    <option value="HangUp">HangUp</option>
                                                    <option value="fax">fax</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group col-xs-6 col-md-3">
                                            <div class="col-xs-6 col-md-11" id="<?=$i?>-3">

                                            </div>
                                        </div>

                                        <!---------------------------------- Forward ------------------------------------------->

                                        <div class="form-group col-xs-6 col-md-3">
                                            <div class="col-xs-6 col-md-11 forward" id='<?=$i?>-1'>
                                                <!----------- there will be a select box using ajax ----------->
                                            </div>
                                        </div>

                                        <!---------------------------------- Dial Destination ------------------------------------------->

                                        <div class="form-group col-xs-6 col-md-3">
                                            <div class="col-xs-6 col-md-11" data-status="DSTOption" id="<?=$i?>-2">
                                                <!----------- there will be a select box using ajax ----------->
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End of jumbotron -->
                                <?php
                                $deleteCounter++;
                                $arrayCounter++;
                                $dayCount++;
                            }
                            ?>
                            <!----------------------------- Submit Section (Buttons) --------------------------------->
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="pull-left">
                                        <button type="submit" name="edit" id="edit" class="btn btn-icon btn-success ltr"> 
                                            <i class="fa fa-plus"></i> 
                                        </button>
                                    </p>
                                </div>
                            </div>
                            <div class="row hidden-xs"></div>
                            <!------------------------- Failed Side ------------------------------>
                            <div class="jumbotron col-xs-12 col-md-12 col-md-12" style="border-radius: 30px; box-shadow: 4px 4px 7px red;">
                                <div style="color:blue; font-size: 20px; font-weight:bold;"> Failed </div>
                                <div class="row hidden-xs"></div>
                                <!---------------------------------- Failed Dial Extension ------------------------------------------->
                                <div class="row" style="border-top: 1px dotted black; padding: 20px;">
                                    <div class="form-group col-xs-6 col-md-3">
                                        <label class="col-xs-6 col-md-5 pull-left control-label ltr">
                                            Dial Extension </label>
                                        <div class="col-xs-6 col-md-7">
                                            <select name="FDialExtension" class="FDialExtension select2" id="<?=$i + 1?>" title="">
                                                <?php foreach ($list['dialExtensionList'] as $key => $value) { ?>
                                                    <option value="<?= $value ?>" <?= $value == $list['FDialExtension'] ? 'selected' : '' ?> ><?= $value ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-6 col-md-3">
                                        <div class="col-xs-6 col-md-11" id="<?=$i + 1?>-3">
                                            <select name="FSub_dst[]" class="dialExtension select2"
                                                    id="<?=$i?>" title="" required style="display: none;">
                                                <?php
                                                if (isset($list['sub_dst_list']) and !empty($list['sub_dst_list'])) {
                                                    foreach ($list['sub_dst_list'] as $key => $value) { ?>
                                                        <option value="<?=$value['extension_id']?>" <?=$value['extension_id'] == $list['FSub_dst'][$i] ? 'selected' : '' ?> > <?=$value['extension_no']?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!---------------------------------- Failed Forward ------------------------------------------->
                                    <div class="form-group col-xs-6 col-md-3">
                                        <div class="col-xs-6 col-md-11 FForward" id='<?=$i + 1?>-1'>

                                            <?php if($list['FDialExtension'] == 'directDial') { ?>
                                                <input type='hidden' value='' name='FDSTOption'>
                                                <input type='hidden' value='' name='FForward'>
                                            <?php } elseif ($list['FDialExtension'] == 'voiceMail') { ?>
                                                <select name="FForward" class="FForward select2" title="" >
                                                    <?php foreach ($list['voiceMailList'] as $key => $value) { ?>
                                                        <option value="<?= $value ?>" <?= $value == $list['FForward'] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                    <?php } ?>
                                                </select>
                                            <?php } elseif($list['FDialExtension'] == 'forward') { ?>
                                                <select name="FForward" class="FForward select2" title="">
                                                    <?php foreach ($list['forwardList'] as $key => $value) { ?>
                                                        <option value="<?= $value ?>" <?= $value == $list['FForward'] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                    <?php } ?>
                                                </select>
                                            <?php }  elseif ($list['FDialExtension'] == 'IVR') { ?>
                                                <select name="FForward[]" class="FForward select2" title="">
                                                    <?php foreach ($list['IVRList'] as $key => $value) { ?>
                                                        <option value="<?= $value ?>" <?= $value == $list['forward'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                    <?php } ?>
                                                </select>
                                                <input type='hidden' value='' name='FDSTOption'>
                                            <?php } elseif ($list['FDialExtension'] == 'Queue') { ?>
                                                <select name="FForward[]" class="FForward select2" title="">
                                                    <?php foreach ($list['queueList'] as $key => $value) { ?>
                                                        <option value="<?= $value ?>" <?= $value == $list['forward'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                    <?php } ?>
                                                </select>
                                                <input type='hidden' value='' name='FDSTOption'>
                                            <?php } elseif ($list['FDialExtension'] == 'Announce') { ?>
                                                <select name="FForward[]" class="FForward select2" title="">
                                                    <?php foreach ($list['announceList'] as $key => $value) { ?>
                                                        <option value="<?= $value ?>" <?= $value == $list['forward'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                    <?php } ?>
                                                </select>
                                                <input type='hidden' value='' name='FDSTOption'>
                                            <?php } elseif ($list['FDialExtension'] == 'HangUp') { ?>
                                                <input type='hidden' value='' name='FForward[]'>
                                                <input type='hidden' value='' name='FDSTOption'>
                                            <?php } elseif ($list['FDialExtension'] == 'fax') { ?>
                                                <input type='text' class='form-control'
                                                       value="<?= $list['FForward'] ?>" name='FForward'
                                                       id='fax' placeholder='Enter Phone Number'>
                                                <input type='hidden' value='' name='FDSTOption'>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <!---------------------------------- Failed Dial Destination ------------------------------------------->

                                    <div class="form-group col-xs-6 col-md-3">
                                        <div class="col-xs-6 col-md-11" data-status="FDSTOption" id="<?=$i + 1?>-2">
                                            <?php if ($list['FDialExtension'] == 'forward' & $list['FForward'] == 'internal') { ?>
                                                <select name="FDSTOption" class="FDSTOption select2" id="FDSTOption" >
                                                    <?php foreach ($list['extensionList'] as $key => $value) { ?>
                                                        <option value="<?= $value ?>" <?= $value == $list['FDSTOption'] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                    <?php } ?>
                                                </select>
                                            <?php } elseif ($list['FDialExtension'] == 'forward' & $list['FForward'] == 'external') { ?>
                                                <input type='text' class='form-control'
                                                       value="<?= $list['FDSTOption'] ?>" name='FDSTOption'
                                                       id='external' placeholder='Enter Phone Number'>
                                            <?php } else { ?>
                                                <?php if ($list['FDialExtension'] == 'voiceMail' & $list['FForward'] == 'withOutMessage') { ?>
                                                    <input type="hidden" value="" name="FDSTOption">
                                                <?php } elseif ($list['FDialExtension'] == 'voiceMail' & $list['FForward'] == 'defaultMessage') { ?>
                                                    <input type="hidden" value="" name="FDSTOption">
                                                <?php } elseif ($list['FDialExtension'] == 'voiceMail' & $list['FForward'] == 'customMessageByRecord') { ?>
                                                    <div id="TCRecordVoiceLink" class="col-xs-12 col-md-12" style="text-align: center;">
                                                        <input type="text" name="voiceTitle" class="form-control" id="voiceTitle<?=$i?>" title="Input the Voice Title" placeholder="Input The Voice Title" required>
                                                        <audio controls src="" id="audio"></audio>
                                                        <div class="row">
                                                            <a class="record" id="record_<?=$i + 1?>" style="text-decoration: none" >
                                                                <i class="fa fa-circle button" aria-hidden="true"></i>
                                                            </a>
                                                            <a class="disabled one record_<?=$i + 1?>_one" id="pause" style="text-decoration: none">
                                                                <i class="fa fa-pause button" aria-hidden="true"></i>
                                                            </a>
                                                            <a class="disabled one record_<?=$i + 1?>_one" id="play" style="text-decoration: none">
                                                                <i class="fa fa-play button" aria-hidden="true"></i>
                                                            </a>
                                                            <a class="disabled one record_<?=$i + 1?>_one" id="save" style="text-decoration: none">
                                                                <i class="fa fa-upload button" aria-hidden="true"></i>
                                                            </a>
                                                        </div>

                                                        <input class="button" type="checkbox" id="live"/>
                                                        <label>Live Output</label>
                                                        <canvas id="record_<?=$i + 1?>_level" height="100" width="200"></canvas>
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
                                                <?php } elseif ($list['FDialExtension'] == 'voiceMail' & $list['FForward'] == 'customMessageByList') { ?>
                                                    <select name="FDSTOption" class="FDSTOption select2" id="FDSTOption" >
                                                        <?php foreach ($list['voiceList'] as $value) { ?>
                                                            <option value="<?=$value['upload_id']?>" <?=($value['upload_id'] == $list['FDSTOption'])?'selected':''?>><?=$value['title']?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div><!-- End of jumbotron-->

                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="pull-left">
                                            <button type="submit" name="action" id="action" class="btn btn-icon btn-success ltr">
                                                <?=IVR_28?>
                                            </button>
                                        </p>
                                    </div>
                                </div>

                                <input TYPE="hidden" name="<?=$list['token']?>" value="1">
                                <input type="hidden" name="plus" value="<?=$list['plus']?>">
                                <input type="hidden" name="error" value="<?=$list['error']?>">
                        </form>
                    </div><!-- End of Center-Block -->
                </div>
            </div>
        </div>
    </div>
</div><!----------------------- content ------------------------------------>

<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function(){
        var $body = $('body');

        $('#conflictMessage').on('click', function(){
            $('#conflictMessage').slideUp(400);
        });

        $('.menu-hidden').removeClass('hidden');

        /*
         | ------------------------------------------------------------------------------------------------
         |  Delete selected TimeTable
         | ------------------------------------------------------------------------------------------------
         */
        $(".deleteTimeTable").on("click", function(){
            var id = this.id;
            var deletedClass = ".timeTable" + id;
            $(deletedClass).slideUp(600);
            setTimeout(function () {
                $(deletedClass).remove();
            }, 600);
        });

        /*
         | ------------------------------------------------------------------------------------------------
         |  SUCCESS PART
         | ------------------------------------------------------------------------------------------------
         */
        $(".dialExtension").on('change', function(){
            var id = this.id;
            var DSTOption = "#" + id + "-2";
            var activeExtension = "#" + id + "-3";
            $(DSTOption).hide();
            var value = $(this).find('option:selected').val();
            var forwardId = "#" + id + "-1";
            if (value != 'voiceMail') {
                $(activeExtension).hide();
                $body.find("#DSTOption").hide();
            }else if (value == 'voiceMail') {
                $(activeExtension).show();
                $body.find("#DSTOption").show();
                var name = 'success';
                $.ajax({
                    url: "mainTimeCondition.php?action=extensionList",
                    data: {dialExtension: value, name: name},
                    type: 'POST',
                    success: function (response) {
                        $(activeExtension).html(response);
                        $(activeExtension).find('select').select2();
                    }
                });
            }
            $.ajax({
                url: "mainTimeCondition.php?action=TCForward",
                data: {dialExtension: value},
                type: 'POST',
                success: function (response) {

                    //var result = $.parseHTML(response, true);
                    $(forwardId).html(response);
                    $(forwardId).find('select').select2();
                }
            });
        });

        $(".forward").on('change', function(){
            debugger;
            var id = this.id;
            var res = id.replace('-1', '-2');
            var counter = id.replace('-1', '');
            var DSTOption = "#" + res;
            var timeConditionID = $('#TCID' + counter).val();
            var value = $(this).find('option:selected').val();
            $(DSTOption).show();
            $.ajax({
                url: "mainTimeCondition.php?action=TCDSTOption",
                data: {forward: value, TCID: timeConditionID, recordId: counter},
                type: 'POST',
                success: function(response){
                    $(DSTOption).html(response);
                    $(DSTOption).find('select').select2();
                }
            });
        });

        /*
         | ------------------------------------------------------------------------------------------------
         |  FAILED PART
         | ------------------------------------------------------------------------------------------------
         */
        $(".FDialExtension").on('change', function(){
            var recordID = <?=$i + 1?>;
            var id = this.id;
            var DSTOption = "#" + id + "-2";
            var activeExtension = "#" + id + "-3";
            $(DSTOption).hide();
            var value = $(this).find('option:selected').val();
            var forwardId = "#" + id + "-1";

            if (value != 'voiceMail') {
                $(activeExtension).hide();
            }

            if (value == 'voiceMail') {
                $(activeExtension).show();
                var name = 'failed';
                $.ajax({
                    url: "mainTimeCondition.php?action=extensionList",
                    data: {dialExtension: value, name: name},
                    type: 'POST',
                    success: function (response) {
                        $(activeExtension).html(response);
                        $(activeExtension).find('select').select2();
                    }
                });
            }

            $.ajax({
                url: "mainTimeCondition.php?action=FTCForward",
                data: {dialExtension: value, RecordID: recordID},
                type: 'POST',
                success: function (response) {
                    $(forwardId).html(response);
                    $(forwardId).find('select').select2();
                }
            });
        });

        $(".FForward").on('change', function(){

            var id = $(this).attr('id');
            var counter = id.replace('-1', '');
            var res = id.replace('-1', '-2');
            var DSTOption = "#" + res;
            var value = $(this).find('option:selected').val();
            $(DSTOption).show();
            $.ajax({
                url: "mainTimeCondition.php?action=FTCDSTOption",
                data: {forward: value, recordId: counter},
                type: 'POST',
                success: function (response) {
                    $(DSTOption).html(response);
                    $(DSTOption).find('select').select2();
                }
            });
        });

        /*
        | ------------------------------------------------------------------------------------------------
        |  RECORD VOICE
        | ------------------------------------------------------------------------------------------------
        */
        function restore(){
            $("#record, #live").removeClass("disabled");
            $("#pause").replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
            $(".one").addClass("disabled");
            Fr.voice.stop();
        }

        $(document).on("click", ".record:not(.disabled)", function(){
            RecordID = $(this).attr('id');
            var classValue = $(this).attr('class');
            elem = $(this);
            Fr.voice.record($("#live").is(":checked"), function(){
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
                    canvasCtx.fillStyle = 'rgb(200, 200, 200)';
                    canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);
                    canvasCtx.lineWidth = 2;
                    canvasCtx.strokeStyle = 'rgb(0, 0, 0)';

                    canvasCtx.beginPath();
                    var sliceWidth = WIDTH * 1.0 / bufferLength;
                    var x = 0;
                    for (var i = 0; i < bufferLength; i++) {
                        var v = dataArray[i] / 128.0;
                        var y = v * HEIGHT/2;

                        if(i === 0) {
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
            } else {
                Fr.voice.pause();
                $(this).replaceWith('<a class="one resume" id="pause" style="text-decoration: none"><i class="fa fa-play button" aria-hidden="true"></i></a>');
            }
        });

        $(document).on("click", "#stop:not(.disabled)", function(){
            restore();
        });

        $(document).on("click", "#play:not(.disabled)", function(){
            Fr.voice.export(function(url){
                $("#audio").attr("src", url);
                $("#audio")[0].play();
            }, "URL");
            restore();
        });

        $(document).on("click", "#save:not(.disabled)", function(e){
            e.preventDefault();
            var id = RecordID.replace('record_', '');
            var forwardID = '#' + id + '-1';
            var DSTOption = '#' + id + '-2';
            var status = $(DSTOption).data('status');
            var tag = $('<option value="customMessageByList" selected="selected">customMessageByList</option>');
            var voiceTitle = $('#voiceTitle'+id).val();
            var url = "mainTimeCondition.php?action=saveVoice&status="+status+"&voiceTitle="+voiceTitle;
            Fr.voice.export(function(blob){
                var formData = new FormData();
                formData.append('file', blob);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
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

    });
    /* end of document.ready */
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