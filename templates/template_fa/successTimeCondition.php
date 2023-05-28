<?php
global $i;
$i = 0;
$style = '';
?>

<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>

                <a class="text-20" aria-hidden="true" id="homePage" style="cursor: pointer">Extension</a>
            </li>
        </ul><!--/control-nav-->
    </div>

   <!-- <div class="content-header">
        <h2 class="content-title"><i class="fa fa-user"></i><?/*=EXTENSION_25*/?></h2>
    </div>--><!-- content-header -->

    <div class="content-body">

        <form name="addExtension" id="addExtension" role="form" data-validate="form"
              class="form-horizontal form-bordered TCForm" autocomplete="off" novalidate="novalidate"
              method="post">
    <div id="panel-tablesorter" class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title"><?=EXTENSION_25?></h3>
                <div class="panel-actions">
                    <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?=COLLAPSE?>"><i class="fa fa-caret-down text-midnight text-18"></i>
                    </button>
                </div><!-- panel-actions -->
            </div><!-- panel-heading -->
            <?php if ($msg != null) { ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-warning">
                    <?=$msg?>
                </div>
                <?php
            }
            ?>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 center-block">
                            <input name="id" id=id type="hidden" value="<?=$list['extension_id']?>"/>

                            <!------------------------------------------------------------ The Time Condition Part ----------------------------------------------------------------------->

                            <?php
                            if (!empty($list['monthStart'])) {
                                for ($i = 0; $i < count ($list[ 'monthStart' ]); $i++) {
                                    if ($list['error'][$i] == 1) {
                                        $style = 'style="background:linear-gradient(to bottom, rgba(255,0,0,0.5), rgba(255,0,0,0.5));"';
                                        echo "<p id='conflictMessage' style='background:#777; font-size: 20px; color:black; font-weight: bold; height:50px; padding-top: 10px; text-align: center; border-radius: 20px; cursor: pointer; '>
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
                                    <div class=" jumbotron timeTable timeTable<?=$i?>" <?=($list['error'][$i] == 1 or $list['error'][$i] == 2)?$style:''?> >
                                        <div style="cursor: pointer; font-size: 20px; height:60px;">
                                            <i style="color:red;" class="fa fa-times deleteTimeTable" aria-hidden="true"
                                               id="<?=$i?>"></i>
                                        </div>

                                        <input type="hidden" id="TCID" name="TCID" value="<?=$list['id'][ $i ]?>">

                                        <!---------------------------------- Hour Start ------------------------------------------->
                                        <div class="row ">
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                        Start Time </label>
                                                    <div class="col-xs-12 col-sm-6 pull-left">
                                                        <input type="text" class="form-control"
                                                               value="<?=!empty($list['hourStart'][$i]) ? $list['hourStart'][$i] : ''?>"
                                                               name="hourStart[]" id="hourStart"
                                                               data-show-meridian="false"
                                                               data-template="dropdown"
                                                               data-input="timepicker" title="" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <!---------------------------------- Hour End ------------------------------------------->
                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-4 pull-left control-label ltr "> End Time </label>
                                                    <div class="col-xs-12 col-sm-6 pull-left">
                                                        <input type="text" class="form-control"
                                                               value="<?=!empty($list['hourEnd'][$i]) ? $list['hourEnd'][$i] : ''?>"
                                                               name="hourEnd[]" id="hourEnd"
                                                               data-show-meridian="false"
                                                               data-template="dropdown"
                                                               data-input="timepicker" required title="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!---------------------------------- Week Day Start ------------------------------------------->
                                        <div class="row ">
                                            <div class="col-xs-6 col-sm-12 col-md-6 ">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                        Days </label>
                                                    <div class="col-xs-6 col-sm-6 col-md-6 ">
                                                        <select name="weekDayStart[]" class="weekDayStart select2"
                                                                id="weekDayStart" required title="">
                                                            <?php foreach ($list['weekDaysName'] as $key => $value) { ?>
                                                                <option value="<?=$key?>" <?=$key == $list['weekDayStart'][$i] ? 'selected' : ''?> >
                                                                    <?=$value?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!---------------------------------- Week Day End ------------------------------------------->
                                            <div class="col-xs-6 col-sm-12 col-md-6 ">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                        Days </label>
                                                    <div class="col-xs-6 col-sm-6 col-md-6 ">
                                                        <select name="weekDayEnd[]" class="weekDayEnd select2"
                                                                id="weekDayEnd" required title="">
                                                            <?php foreach ($list['weekDaysName'] as $key => $value) { ?>
                                                                <option value="<?= $key ?>" <?= $key == $list['weekDayEnd'][$i] ? 'selected' : '' ?> >
                                                                    <?=$value?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!---------------------------------- Day Start ------------------------------------------->
                                        <div class="row ">
                                            <div class="col-xs-6 col-sm-12 col-md-6 ">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                        Days </label>
                                                    <div class="col-xs-6 col-sm-6 col-md-6 ">
                                                        <select name="dayStart[]" class="dayStart select2" id="dayStart"
                                                                required title="">
                                                            <?php foreach ($list['days'] as $key => $value) { ?>
                                                                <option value="<?=$key?>" <?=$key == $list['dayStart'][$i] ? 'selected' : ''?> >
                                                                    <?=$value?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!---------------------------------- Day End ------------------------------------------->
                                            <div class="col-xs-6 col-sm-12 col-md-6 ">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                        Days </label>
                                                    <div class="col-xs-6 col-sm-6 col-md-6 ">
                                                        <select name="dayEnd[]" class="dayEnd select2" id="dayEnd"
                                                                required title="">
                                                            <?php foreach ($list['days'] as $key => $value) { ?>
                                                                <option value="<?=$key?>" <?=$key == $list['dayEnd'][$i] ? 'selected' : ''?> >
                                                                    <?=$value?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!---------------------------------- Month Start ------------------------------------------->
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 ">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                        Month </label>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <select name="monthStart[]"
                                                                class="monthStart select2"
                                                                id="monthStart" required title="">
                                                            <?php foreach ($list['monthsName'] as $key => $value) { ?>
                                                                <option value="<?=$key?>" <?=$key == $list['monthStart'][$i] ? 'selected' : ''?> > <?=$value?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!---------------------------------- Month End ------------------------------------------->
                                            <div class="col-xs-12 col-sm-12 col-md-6 ">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                        Month </label>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <select name="monthEnd[]" class="monthEnd select2"
                                                                id="monthEnd" required title="">
                                                            <?php foreach ($list['monthsName'] as $key => $value) { ?>
                                                                <option value="<?=$key?>" <?=$key == $list['monthEnd'][$i] ? 'selected' : ''?> > <?=$value?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--------------------------------------------- Dial Destination Part --------------------------------------------->
                                        <!------------------------- Left Side ------------------------------>
                                        <div class="row xsmallSpace hidden-xs"></div>
                                        <!---------------------------------- Success Dial Extension ------------------------------------------->
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-3">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-12 pull-left control-label ltr">
                                                        <!--Dial Extension--> </label>
                                                    <div class="col-xs-6 col-sm-5 col-md-12">
                                                        <select name="dialExtension[]" class="dialExtension select2"
                                                                id="<?=$i?>" required title="">
                                                            <?php foreach ($list['dialExtensionList'] as $key => $value) { ?>
                                                                <option value="<?=$value?>" <?=$value == $list['dialExtension'][$i] ? 'selected' : ''?> > <?=$value?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-12 pull-left control-label ltr ">
                                                        <!--Forward--> </label>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 forward" data-TCID="<?=$list['id'][$i]?>" id='<?=$i?>-1'>
                                                        <?php if ($list['dialExtension'][$i] == 'directDial') { ?>
                                                            <input type='hidden' value='' name='DSTOption[]'>
                                                            <input type='hidden' value='' name='forward[]'>
                                                        <?php } elseif ($list['dialExtension'][$i] == 'voiceMail') { ?>
                                                            <select name="forward[]" class="forward select2" required title="">
                                                                <?php foreach ($list['voiceMailList'] as $key => $value) { ?>
                                                                    <option value="<?= $value ?>" <?=$value == $list['forward'][$i] ? 'selected' : ''?> > <?=$value?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } elseif ($list['dialExtension'][$i] == 'forward') { ?>
                                                            <select name="forward[]" class="forward select2" required title="">
                                                                <?php foreach ($list['forwardList'] as $key => $value) { ?>
                                                                    <option value="<?= $value ?>" <?=$value == $list['forward'][$i] ? 'selected' : ''?> > <?=$value?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-xs-12 col-sm-3">
                                                <div class="form-group">
                                                    <label class="col-xs-6 col-sm-12 pull-left control-label ltr "> <!--Destination--> </label>
                                                    <div class="col-xs-6 col-sm-12 col-md-12 DSTOption" data-status="DSTOption" id="<?=$i?>-2">

                                                        <?php if ($list['dialExtension'][$i] == 'forward' & $list['forward'][$i] == 'internal') { ?>
                                                            <select name="DSTOption[]" class="DSTOption select2"
                                                                    id="DSTOption" title="" required>
                                                                <?php foreach ($list[ 'extensionList' ] as $key => $value) { ?>
                                                                    <option value="<?= $value ?>" <?= $value == $list['DSTOption'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php } elseif ($list['dialExtension'][$i] == 'forward' & $list['forward'][$i] == 'external' ) { ?>
                                                            <input type='text' class='form-control'
                                                                   value="<?= $list[ 'DSTOption' ][ $i ] ?>"
                                                                   name='DSTOption[]' id='external'
                                                                   placeholder='Enter Phone Number'>
                                                        <?php } else { ?>
                                                            <?php if ($list['dialExtension'][$i] == 'voiceMail' & $list['forward'][$i] == 'withOutMessage') { ?>
                                                                <input type="hidden" value="" name="DSTOption[]">
                                                            <?php } elseif ($list['dialExtension'][$i] == 'voiceMail' & $list['forward'][$i] == 'defaultMessage' ) { ?>
                                                                <input type="hidden" value="" name="DSTOption[]">
                                                            <?php } elseif ($list['dialExtension'][$i] == 'voiceMail' & $list['forward'][$i] == 'customMessageByRecord' ) { ?>
                                                                <div id="TCRecordVoiceLink" class="col-xs-12 col-sm-12" style="text-align: center;">
                                                                    <input type="text" name="voiceTitle" class="form-control" id="voiceTitle<?=$i?>" title="Input the Voice Title" placeholder="Input The Voice Title" required>
                                                                    <audio class="record_<?=$i?>_level" controls src="" id="audio"></audio>
                                                                    <div class="row">
                                                                        <a class="record" id="record_<?=$i?>" style="text-decoration: none">
                                                                            <i class="fa fa-circle button" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a class="disabled one record_<?=$i?>_one" id="pause" style="text-decoration: none">
                                                                            <i class="fa fa-pause button" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a class="disabled one record_<?=$i?>_one" id="play" style="text-decoration: none">
                                                                            <i class="fa fa-play button" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a class="disabled one  record_<?=$i?>_one" id="save" style="text-decoration: none">
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
                                                                                    <button type="button" class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close"><span
                                                                                                aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                    <h4 class="modal-title"></h4>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 col-sm-12 col-md-12">
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
                                                                        <option value="<?=$value['file_name']?>" <?=($value['file_name'] == $list['DSTOption'][$i])?'selected':''?>><?=$value['title']?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                    </div><!-- End of jumbotron-->
                                    <?php
                                }
                            }
                            $counter = count($list['monthStart']) - 1;
                            $deleteCounter = count($list['monthStart']);
                            $arrayCounter = $dayCount = 0;

                            if ($list['plus'] == 1) { ?>
                                <div class="no-bg jumbotron row timeTable timeTable<?= $deleteCounter ?>">
                                    <div style="cursor: pointer; font-size: 20px; height:60px;">
                                        <i style="color:red;" class="fa fa-times deleteTimeTable" aria-hidden="true"
                                           id="<?= $deleteCounter ?>"></i>
                                    </div>

                                    <!---------------------------------- Hour Start ------------------------------------------->
                                    <div class="row ">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                    Start Time </label>
                                                <div class="col-xs-12 col-sm-6 pull-left">
                                                    <input type="text" class="form-control"
                                                           value="<?= !empty($list['hourStart'][$counter]) ? $list['hourEnd'][$counter] : '' ?>"
                                                           name="hourStart[]" id="hourStart"
                                                           placeholder="<?= 'hourStart'; ?>" required
                                                           data-show-meridian="false"
                                                           data-template="dropdown"
                                                           data-input="timepicker">
                                                </div>
                                            </div>
                                        </div>

                                        <!---------------------------------- Hour End ------------------------------------------->
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                    End Time </label>
                                                <div class="col-xs-12 col-sm-6 pull-left">
                                                    <input type="text" class="form-control"
                                                           value="<?= !empty($list['hourEnd'][$counter]) ? $list['hourEnd'][$counter] : '' ?>"
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
                                        <div class="col-xs-6 col-sm-12 col-md-6 ">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                    Days </label>
                                                <div class="col-xs-6 col-sm-6 col-md-6 ">
                                                    <select name="weekDayStart[]" class="weekDayStart select2"
                                                            id="weekDayStart" required title="">
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
                                        <div class="col-xs-6 col-sm-12 col-md-6 ">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                    Days </label>
                                                <div class="col-xs-6 col-sm-6 col-md-6 ">
                                                    <select name="weekDayEnd[]" class="weekDayEnd select2" id="weekDayEnd"
                                                            required title="">
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
                                        <div class="col-xs-6 col-sm-12 col-md-6 ">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                    Days </label>
                                                <div class="col-xs-6 col-sm-6 col-md-6 ">
                                                    <select name="dayStart[]" class="dayStart select2" id="dayStart"
                                                            required title="">
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
                                        <div class="col-xs-6 col-sm-12 col-md-6 ">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                    Days
                                                </label>
                                                <div class="col-xs-6 col-sm-6 col-md-6 ">
                                                    <select name="dayEnd[]" class="dayEnd select2" id="dayEnd" required title="">
                                                        <?php foreach ($list['days'] as $key => $value) { ?>
                                                            <option value="<?=$key?>">
                                                                <?=$value?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!---------------------------------- Month Start ------------------------------------------->
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 ">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                    Month </label>
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <select name="monthStart[]"
                                                            class="monthStart select2"
                                                            id="monthStart" required title="">
                                                        <?php foreach ($list['monthsName'] as $key => $value) { ?>
                                                            <option value="<?= $key ?>"> <?= $value; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!---------------------------------- Month End ------------------------------------------->
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-4 pull-left control-label ltr ">
                                                    Month </label>
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <select name="monthEnd[]" class="monthEnd select2" id="monthEnd"
                                                            required title="">
                                                        <?php foreach ($list['monthsName'] as $key => $value) { ?>
                                                            <option value="<?= $key ?>"> <?= $value; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--------------------------------------------- Dial Destination Part --------------------------------------------->
                                    <div class="row smallSpace hidden-xs"></div>
                                    <!---------------------------------- Dial Extension ------------------------------------------->
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-3">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-12 pull-left control-label ltr ">
                                                    <!--Dial Extension-->
                                                </label>
                                                <div class="col-xs-6 col-sm-12">
                                                    <select name="dialExtension[]" class="dialExtension select2"
                                                            id="<?=$counter + 1?>" required title="">
                                                        <option value="directDial">Direct Dial</option>
                                                        <option value="voiceMail">Voice Mail</option>
                                                        <option value="forward">Forward</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-3">
                                            <div class="form-group">
                                                <label class="col-xs-6 col-sm-12 pull-left control-label ltr ">
                                                    <!--Forward --></label>
                                                <div class="col-xs-6 col-sm-12 forward" data-TCID="<?=$list['id'][$i]?>" id='<?= $counter + 1 ?>-1'>
                                                    <!----------- there will be a select box using ajax ----------->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-3">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-12 pull-left control-label ltr">
                                                    <!--Destination--> </label>
                                                <div class="col-xs-6 col-sm-12 DSTOption" data-status="DSTOption" id="<?= $counter + 1 ?>-2">
                                                    <!----------- there will be a select box using ajax ----------->
                                                </div>
                                            </div>
                                        </div>

                                    </div>




                                </div><!-- End of jumbotron -->
                                <?php
                                $deleteCounter++;
                                $arrayCounter++;
                                $dayCount++;
                                $counter++;
                                $counter = $i;
                                $i++;
                            }
                            ?>
                            <!----------------------------- Submit Section (Buttons) --------------------------------->
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="pull-left">
                                        <button type="submit" name="edit" id="edit" class="btn btn-primary btn-icon ltr">
                                            <i class="fa fa-plus"></i> 
                                            submit Extension
                                        </button>
                                    </p>
                                </div>
                            </div>
                            <div class="row xsmallSpace hidden-xs"></div>
                            <!------------------------- Failed Side ------------------------------>
                            <div class="jumbotron no-bg col-xs-12 col-sm-12 col-md-12"">
                                <div style="color:blue; font-size: 20px; font-weight:bold;">
                                    Failed
                                </div>
                                <div class="row xsmallSpace hidden-xs"></div>
                                <!---------------------------------- Failed Dial Extension ------------------------------------------->
                                <div class="row">
                                    <div class="col-xs-6 col-sm-3">
                                        <div class="form-group">
                                            <label class="col-xs-6 col-sm-12 pull-left control-label ltr">
                                                <!--Dial Extension--> </label>
                                            <div class="col-xs-6 col-sm-12">
                                                <select name="FDialExtension" class="FDialExtension select2" id="<?=$i?>" title="" required>
                                                    <?php foreach ($list[ 'dialExtensionList' ] as $key => $value) { ?>
                                                        <option value="<?= $value ?>" <?= $value == $list[ 'FDialExtension' ] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-3">
                                        <div class="form-group">
                                            <label class="col-xs-6 col-sm-12 pull-left control-label ltr ">
                                                <!--Forward--> </label>
                                            <div class="col-xs-6 col-sm-12 FForward" id='<?=$i?>-1'>

                                                <?php if ($list[ 'FDialExtension' ] == 'directDial') { ?>
                                                    <input type='hidden' value='' name='FDSTOption'>
                                                    <input type='hidden' value='' name='FForward'>
                                                <?php } elseif ($list[ 'FDialExtension' ] == 'voiceMail') { ?>
                                                    <select name="FForward" class="FForward select2" title="" required>
                                                        <?php foreach ($list[ 'voiceMailList' ] as $key => $value) { ?>
                                                            <option value="<?= $value ?>" <?= $value == $list[ 'FForward' ] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                <?php } elseif ($list[ 'FDialExtension' ] == 'forward') { ?>
                                                    <select name="FForward" class="FForward select2" title="" required>
                                                        <?php foreach ($list[ 'forwardList' ] as $key => $value) { ?>
                                                            <option value="<?= $value ?>" <?= $value == $list[ 'FForward' ] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-3">
                                        <div class="form-group">
                                            <label class="col-xs-6 col-sm-12 pull-left control-label ltr">
                                                <!--Destination--> </label>
                                            <div class="col-xs-6 col-sm-12 FDSTOption" data-status="FDSTOption" id="<?=$i?>-2">

                                                <?php if ($list[ 'FDialExtension' ] == 'forward' & $list[ 'FForward' ] == 'internal') { ?>
                                                    <select name="FDSTOption" class="FDSTOption select2" id="FDSTOption" title="" required>
                                                        <?php foreach ($list[ 'extensionList' ] as $key => $value) { ?>
                                                            <option value="<?= $value ?>" <?= $value == $list[ 'FDSTOption' ] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                <?php } elseif ($list[ 'FDialExtension' ] == 'forward' & $list[ 'FForward' ] == 'external') { ?>
                                                    <input type='text' class='form-control'
                                                           value="<?= $list[ 'FDSTOption' ] ?>" name='FDSTOption'
                                                           id='external' placeholder='Enter Phone Number'>
                                                <?php } else { ?>
                                                    <?php if ($list[ 'FDialExtension' ] == 'voiceMail' & $list[ 'FForward' ] == 'withOutMessage') { ?>
                                                        <input type="hidden" value="" name="FDSTOption">
                                                    <?php } elseif ($list[ 'FDialExtension' ] == 'voiceMail' & $list[ 'FForward' ] == 'defaultMessage') { ?>
                                                        <input type="hidden" value="" name="FDSTOption">
                                                    <?php } elseif ($list[ 'FDialExtension' ] == 'voiceMail' & $list[ 'FForward' ] == 'customMessageByRecord') { ?>
                                                        <div id="TCRecordVoiceLink" class="col-xs-12 col-sm-12" style="text-align: center;">
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
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                            <h4 class="modal-title"></h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                    <img src="" alt="" class="img-responsive center-block">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
                                                        </div>
                                                    <?php } elseif ($list[ 'FDialExtension' ] == 'voiceMail' & $list[ 'FForward' ] == 'customMessageByList') { ?>
                                                        <select name="FDSTOption" class="FDSTOption select2" id="FDSTOption" title="" required>
                                                            <?php foreach ($list[ 'voiceList' ] as $value) { ?>
                                                                <option value="<?=$value['file_name']?>"<?=($value['file_name'] == $list[ 'FDSTOption' ])?'selected':''?>><?=$value['title']?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!---------------------------------- Failed DSTOption ------------------------------------------->

                            </div><!-- End of jumbotron-->
                            <input TYPE="hidden" NAME="<?= $list['token']; ?>" VALUE="1">
                            <input type="hidden" name="extension_id" value="<?= $list['extension_id'] ?>">
                            <input type="hidden" name="plus" value="<?= $list['plus'] ?>">
                            <input type="hidden" name="error" value="<?= $list['error'] ?>">

                    </div><!-- End of Center-Block -->
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-md-12">
            <p class="pull-left">
                <button type="submit" name="action" id="action" class="btn btn-icon btn-success ltr">
                    <?= IVR_28 ?>
                    <i class="fa fa-download"></i>Extension
                </button>
            </p>
        </div>
    </div>
    </form>
    </div>
</div><!----------------------- content ------------------------------------>

<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function(){

        $('.menu-hidden').removeClass('hidden');

        $(document).on('click','#homePage',function(){
            var form = $('.TCForm')[0];
            var formData = new FormData(form);
            $.ajax({
                url: 'extension.php?action=sendFormAjax?status=TC',
                type: 'post',
                data: formData,
                cash: false,
                contentType: false,
                processData: false,
                success: function(){
                    window.location = "extension.php?action=editExtension&id=<?=$list['extension_id']?>";
                }
            });
        });

        $('#conflictMessage').on('click', function(){
            $('#conflictMessage').slideUp(400);
        });

        $(".deleteTimeTable").on("click", function(){
            var id = this.id;
            var deletedClass = ".timeTable" + id;
            $(deletedClass).slideUp(600);
            setTimeout(function () {
                $(deletedClass).remove();
            }, 600);

        });

        $('.menu-hidden').removeClass('hidden');

//----------------------------------------- FAILED PART -----------------------------------------//

        $(document).on('change', ".dialExtension", function(){

            var id = this.id;
            var DSTOption = "#" + id + "-2";
            $(DSTOption).hide();
            var value = $(this).find('option:selected').val();
            var forwardId = "#" + id + "-1";
            $.ajax({
                url: "extension.php?action=successTCForward",
                data: {dialExtension: value},
                type: 'POST',
                success: function (response) {
//                    var result = $.parseHTML(response, true);
                    $(forwardId).html(response);
                    $(forwardId).find('select').select2();
                }
            });
        });

        $(document).on('change', ".forward", function(){

            var id = this.id;
            var res = id.replace('-1', '-2');
            var counter = id.replace('-1', '');
            var DSTOption = "#" + res;
            var timeConditionID = $('#TCID' + counter).val();
            var value = $(this).find('option:selected').val();
            $(DSTOption).show();
            $.ajax({
                url: "extension.php?action=successTCDSTOption",
                data: {forward: value, TCID: timeConditionID, eID: <?=$list['extension_id']?>, recordId: counter},
                type: 'POST',
                success: function (response){
                    $(DSTOption).html(response);
                    $(DSTOption).find('select').select2();
                }
            });
        });

//----------------------------------------- FAILED PART -----------------------------------------//

        $(document).on('change',".FDialExtension", function(){

            var id = this.id;
            var DSTOption = "#" + id + "-2";
            $(DSTOption).hide();
            var value = $(this).find('option:selected').val();
            var forwardId = "#" + id + "-1";
            $.ajax({
                url: "extension.php?action=FTCForward",
                data: {dialExtension: value},
                type: 'POST',
                success: function (response) {
//                    var result = $.parseHTML(response, true);
                    $(forwardId).html(response);
                    $(forwardId).find('select').select2();
                }
            });
        });

        $(document).on('change', ".FForward", function(){
            var recordID = <?=$i?>;
            var id = this.id;
            var res = id.replace('-1', '-2');
            var DSTOption = "#" + res;
            var value = $(this).find('option:selected').val();
            $(DSTOption).show();
            $.ajax({
                url: "extension.php?action=FTCDSTOption",
                data: {forward: value, eID: <?=$list['extension_id']?>,recordId: recordID},
                type: 'POST',
                success: function (response){
                    $(DSTOption).html(response);
                    $(DSTOption).find('select').select2();
                }
            });
        });

//----------------------------------------- Recording Voice Section -----------------------------------------//

        function restore(){
            $("#record, #live").removeClass("disabled");
            $("#pause").replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
            $(".one").addClass("disabled");
            Fr.voice.stop();
        }

        $(document).on("click", ".record:not(.disabled)", function(){

            RecordID = $(this).attr('id');
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
                analyser.smoothingTimeConstant = 0.85;
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
            if($(this).hasClass("resume")){
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
                    success: function(response){
                        $(document).find(forwardID).find('select').find('option[value="customMessageByRecord"]').attr("selected", null);
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

    .button:hover, .button:focus {
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