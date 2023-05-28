<?php
/**
 * Created by PhpStorm.
 * User: VeRJiL, Sakha, Omidkh68
 * Date: 1/16/2017
 * Time: 11:22 AM
 */
global $i;
$i = 0;
?>
<style>
    canvas {
        display: block;
    }
</style>

<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"><?= TIMECONDITION_02 ?></a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <div class="content-body">
        <form data-validate="form" class="form-horizontal" autocomplete="off" novalidate="novalidate" method="post" style="width: 75%;  margin: 0 auto;">
            <section>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title sortable-widget-handle">Time Condition Name</h3>
                    </div><!-- /panel-heading -->

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 pull-left">
                                <input type="text" class="form-control" placeholder="Time Condition Name" name="name"
                                       id="name"
                                       required>
                            </div>
                        </div>
                    </div><!-- /panel-body -->
                </div>
            </section>

            <button type="button" class="clone-condition btn btn-primary btn-icon">
                <i class="fa fa-plus"></i>
                &nbsp; <?= TIMECONDITION_04 ?>
            </button>

            <br>
            <br>

            <section class="dial-container">
                <div id="panel-sortable" class="panel panel-default" data-boxid="1">
                    <div class="panel-heading">
                        <div class="panel-actions">
                            <button data-collapse="#panel-sortable" title="collapse" class="btn-panel collapse-panel">
                                <i class="fa fa-caret-down text-midnight text-18"></i>
                            </button>
                            <button title="delete" class="delete-condition btn-panel" data-conditionid="">
                                <i class="fa fa-trash text-red text-18"></i>
                            </button>
                        </div><!-- /panel-actions -->
                        <h3 class="panel-title sortable-widget-handle">Condition <span class="condition-no">1</span>
                        </h3>
                    </div><!-- /panel-heading -->

                    <div class="panel-body">
                        <!---------------------------------- Hour Start ------------------------------------------->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label
                                        class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                        Start time
                                    </label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <input type="text" class="form-control"
                                               value="<?= !empty( $list['fields']['hourStart'][$i] ) ? $list['fields']['hourEnd'][$i] : '' ?>"
                                               name="hourStart" id="hourStart"
                                               placeholder="<?= 'hourStart'; ?>" required
                                               data-show-meridian="false"
                                               data-template="dropdown"
                                               data-input="timepicker">
                                    </div>
                                </div>
                            </div>

                            <!---------------------------------- Hour End ------------------------------------------->
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label
                                        class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                        End time
                                    </label>
                                    <div class="col-xs-12 col-md-6 pull-left">
                                        <input type="text" class="form-control"
                                               value="<?= !empty( $list['fields']['hourEnd'][$i] ) ? $list['fields']['hourEnd'][$i] : '' ?>"
                                               name="hourEnd" id="hourEnd"
                                               placeholder="<?= 'Hour End'; ?>" required
                                               data-show-meridian="false"
                                               data-template="dropdown"
                                               data-input="timepicker">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!---------------------------------- Week Day Start ------------------------------------------->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                        Week day start
                                    </label>
                                    <div class="col-xs-12 col-md-6 col-md-6 ">
                                        <select name="weekDayStart" class="weekDayStart select2"
                                                id="weekDayStart" title="" data-name="start">
                                            <option value="">-</option>
                                            <?php foreach ($list['fields']['weekDaysName'] as $key => $value) { ?>
                                                <option value="<?= $key ?>">
                                                    <?= $value; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!---------------------------------- Week Day End ------------------------------------------->
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                        Week day finish
                                    </label>
                                    <div class="col-xs-12 col-md-6 col-md-6 ">
                                        <select name="weekDayEnd" class="weekDayEnd select2" id="weekDayEnd"
                                                title="" data-name="end">
                                            <option value="">-</option>
                                            <?php foreach ($list['fields']['weekDaysName'] as $key => $value) { ?>
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
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                        Month day start
                                    </label>
                                    <div class="col-xs-12 col-md-6 col-md-6 ">
                                        <select name="dayStart" class="dayStart select2" id="dayStart"
                                                title="" data-name="start">
                                            <option value="">-</option>
                                            <?php foreach ($list['fields']['days'] as $key => $value) { ?>
                                                <option value="<?= $key ?>">
                                                    <?= $value; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!---------------------------------- Day End ------------------------------------------->
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                        Month day finish
                                    </label>
                                    <div class="col-xs-12 col-md-6 col-md-6 ">
                                        <select name="dayEnd" class="dayEnd select2" id="dayEnd" title="" data-name="end">
                                            <option value="">-</option>
                                            <?php foreach ($list['fields']['days'] as $key => $value) { ?>
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
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                        Month start
                                    </label>
                                    <div class="col-xs-12 col-md-6 col-md-6">
                                        <select name="monthStart"
                                                class="monthStart select2"
                                                id="monthStart" title="" data-name="start">
                                            <option value="">-</option>
                                            <?php foreach ($list['fields']['monthsName'] as $key => $value) { ?>
                                                <option value="<?= $key ?>"> <?= $value; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!---------------------------------- Month End ------------------------------------------->
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 pull-left control-label ltr ">
                                        Month finish
                                    </label>
                                    <div class="col-xs-12 col-md-6 col-md-6">
                                        <select name="monthEnd" class="monthEnd select2" id="monthEnd"
                                                data-name="end"
                                                title="" >
                                            <option value="">-</option>
                                            <?php foreach ($list['fields']['monthsName'] as $key => $value) { ?>
                                                <option value="<?= $key ?>"> <?=$value?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 style="border-bottom: 1px dotted black;margin-bottom: 1em;">Destination Setting</h3>

                        <section>
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Destination if time matches</h3>
                                </div><!-- /panel-heading -->

                                <div class="panel-body">
                                    <div class="row dialExtensionGroup">
                                        <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                            <div class="form-group no-margin">
                                                <select name="dialExtension" class="dialExtension pbx-tc select2"
                                                        id="<?=$i?>" title="" required>
                                                    <option value="">-</option>
                                                    <option value="voiceMail">Voice Mail</option>
                                                    <option value="forward">Forward</option>
                                                    <option value="Announce">Announcement</option>
                                                    <option value="HangUp">HangUp</option>
                                                    <option value="ExtensionTimeCondition">Time Condition</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                            <div class="form-group no-margin forward" data-combo="activeExtension">
                                                <!----------- there will be a select box using ajax ----------->
                                            </div>
                                        </div>

                                        <!---------------------------------- Forward ------------------------------------------->
                                        <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                            <div class="form-group no-margin forward" data-combo="forward">
                                                <!----------- there will be a select box using ajax ----------->
                                            </div>
                                        </div>

                                        <!---------------------------------- Dial Destination ------------------------------------------->
                                        <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                            <div class="form-group no-margin" data-status="DSTOption" data-combo="DSTOption">
                                                <!----------- there will be a select box using ajax ----------->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div><!-- /panel-body -->
                </div>
            </section>

            <!------------------------- Failed Side ------------------------------>
            <section>
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Destination if time does not matches</h3>
                    </div><!-- /panel-heading -->

                    <div class="panel-body dialExtensionFailedGroup">
                        <!---------------------------------- Failed Dial Extension ------------------------------------------->
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                <div class="form-group no-margin">
                                    <select name="FDialExtension" class="FDialExtension pbx-tc select2" id="1" title="">
                                        <option value="">-</option>
                                        <?php foreach ($list['fields']['FDialExtension'] as $key => $value) { ?>
                                            <option value="<?= $value ?>"><?= $key ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                <div class="form-group no-margin" data-combo="activeExtension"></div>
                            </div>

                            <!---------------------------------- Failed Forward ------------------------------------------->
                            <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                <div class="form-group no-margin FForward" data-combo="forward">
                                    <?php if($list['fields']['FDialExtension'] == 'directDial') { ?>
                                        <input type='hidden' value='' name='FDSTOption'>
                                        <input type='hidden' value='' name='FForward'>
                                    <?php } elseif ($list['fields']['FDialExtension'] == 'voiceMail') { ?>
                                        <select name="FForward" class="FForward select2" title="" >
                                            <?php foreach ($list['fields']['voiceMailList'] as $key => $value) { ?>
                                                <option value="<?= $value ?>" <?= $value == $list['fields']['FForward'] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                            <?php } ?>
                                        </select>
                                    <?php } elseif($list['fields']['FDialExtension'] == 'forward') { ?>
                                        <select name="FForward" class="FForward select2" title="">
                                            <?php foreach ($list['fields']['forwardList'] as $key => $value) { ?>
                                                <option value="<?= $value ?>" <?= $value == $list['fields']['FForward'] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                            <?php } ?>
                                        </select>
                                    <?php }  elseif ($list['fields']['FDialExtension'] == 'IVR') { ?>
                                        <select name="FForward" class="FForward select2" title="">
                                            <?php foreach ($list['fields']['IVRList'] as $key => $value) { ?>
                                                <option value="<?= $value ?>" <?= $value == $list['fields']['forward'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                            <?php } ?>
                                        </select>
                                        <input type='hidden' value='' name='FDSTOption'>
                                    <?php } elseif ($list['fields']['FDialExtension'] == 'Queue') { ?>
                                        <select name="FForward" class="FForward select2" title="">
                                            <?php foreach ($list['fields']['queueList'] as $key => $value) { ?>
                                                <option value="<?= $value ?>" <?= $value == $list['fields']['forward'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                            <?php } ?>

                                        </select>
                                        <input type='hidden' value='' name='FDSTOption'>
                                    <?php } elseif ($list['fields']['FDialExtension'] == 'Announce') { ?>
                                        <select name="FForward" class="FForward select2" title="">
                                            <?php foreach ($list['fields']['announceList'] as $key => $value) { ?>
                                                <option value="<?= $value ?>" <?= $value == $list['fields']['forward'][$i] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                            <?php } ?>
                                        </select>
                                        <input type='hidden' value='' name='FDSTOption'>
                                    <?php } elseif ($list['fields']['FDialExtension'] == 'HangUp') { ?>
                                        <input type='hidden' value='' name='FForward'>
                                        <input type='hidden' value='' name='FDSTOption'>
                                    <?php } elseif ($list['fields']['FDialExtension'] == 'fax') { ?>
                                        <input type='text' class='form-control'
                                               value="<?= $list['fields']['FForward'] ?>" name='FForward'
                                               id='fax' placeholder='Enter Phone Number'>
                                        <input type='hidden' value='' name='FDSTOption'>
                                    <?php } ?>
                                </div>
                            </div>

                            <!---------------------------------- Failed Dial Destination ------------------------------------------->
                            <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                <div class="form-group no-margin" data-status="FDSTOption" data-combo="DSTOption">
                                    <?php if ($list['fields']['FDialExtension'] == 'forward' & $list['fields']['FForward'] == 'internal') { ?>
                                        <select name="FDSTOption" class="FDSTOption select2" id="FDSTOption" >
                                            <?php foreach ($list['fields']['extensionList'] as $key => $value) { ?>
                                                <option value="<?= $value ?>" <?= $value == $list['fields']['FDSTOption'] ? 'selected' : '' ?> > <?= $value; ?> </option>
                                            <?php } ?>
                                        </select>
                                    <?php } elseif ($list['fields']['FDialExtension'] == 'forward' & $list['fields']['FForward'] == 'external') { ?>
                                        <input type='text' class='form-control'
                                               value="<?= $list['fields']['FDSTOption'] ?>" name='FDSTOption'
                                               id='external' placeholder='Enter Phone Number'>
                                    <?php } else { ?>
                                        <?php if ($list['fields']['FDialExtension'] == 'voiceMail' & $list['fields']['FForward'] == 'withOutMessage') { ?>
                                            <input type="hidden" value="" name="FDSTOption">
                                        <?php } elseif ($list['fields']['FDialExtension'] == 'voiceMail' & $list['fields']['FForward'] == 'defaultMessage') { ?>
                                            <input type="hidden" value="" name="FDSTOption">
                                        <?php } elseif ($list['fields']['FDialExtension'] == 'voiceMail' & $list['fields']['FForward'] == 'customMessageByRecord') { ?>
                                            <div id="TCRecordVoiceLink" class="col-xs-12 col-md-12" style="text-align: center;">
                                                <input type="text" name="voiceTitle" class="form-control"
                                                       id="voiceTitle<?=$i?>"
                                                       title="Input the Voice Title" placeholder="Input The Voice Title"
                                                       required>
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
                                        <?php } elseif ($list['fields']['FDialExtension'] == 'voiceMail' & $list['fields']['FForward'] == 'customMessageByList') { ?>
                                            <select name="FDSTOption" class="FDSTOption select2" id="FDSTOption" >
                                                <?php foreach ($list['fields']['voiceList'] as $value) { ?>
                                                    <option value="<?=$value['upload_id']?>" <?=($value['upload_id'] == $list['fields']['FDSTOption'])?'selected':''?>><?=$value['title']?></option>
                                                <?php } ?>
                                            </select>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div><!-- /panel-body -->
                    </div>
            </section>

            <button id="submit_time_condition" type="submit" class="btn btn-success btn-icon">
                <i class="fa fa-download"></i><?= TIMECONDITION_03 ?>
            </button>
            <input type="hidden" name="<?=$list['fields']['token']?>" value="1">
            <input type="hidden" name="extension_id" value="<?=$list['extension_id']?>">
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        var $body = $('body'),
            $dialContainer = $('.dial-container'),
            RecordID;

        $body.on('click', '#conflictMessage', function () {
            $('#conflictMessage').slideUp(400);
        });

        $('.menu-hidden').removeClass('hidden');

        /*
         | ------------------------------------------------------------------------------------------------
         |  Delete selected TimeTable
         | ------------------------------------------------------------------------------------------------
         */
        $body.on('click', ".deleteTimeTable", function () {
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
        $body.on("change", ".dialExtension", function () {
            var $DSTOption = $(this).parents('.dialExtensionGroup').find('[data-combo="DSTOption"]'),
                $activeExtension = $(this).parents('.dialExtensionGroup').find('[data-combo="activeExtension"]'),
                $forward = $(this).parents('.dialExtensionGroup').find('[data-combo="forward"]'),
                value = $(this).val();

            $DSTOption.hide();

            if (value === 'voiceMail') {
                $DSTOption.hide();
                $activeExtension.show();

                var name = 'success';

                var data = {
                    dialExtension: value,
                    name: name,
                    extensionId: <?php echo strlen($list['fields']['json']['extension_id']) ? $list['fields']['json']['extension_id'] : 0; ?>
                };

                $.httpRequest("mainTimeCondition.php?action=extensionList", 'post', data)
                    .then(function (response) {
                        $activeExtension.show();
                        $DSTOption.hide();
                        $forward.hide();

                        $activeExtension.html(response);
                        $activeExtension.find('select').select2();
                });
            } else {
                $activeExtension.hide();
                $forward.show();
                $DSTOption.hide();

                var data1 = {
                    dialExtension: value,
                    id: <?php echo strlen($list['fields']['json']['extension_id']) ? $list['fields']['json']['extension_id'] : 0; ?>
                };

                $.httpRequest("mainTimeCondition.php?action=TCForward", 'post', data1)
                    .then(function (response) {
                        $forward.html(response);
                        $forward.find('select').select2();
                });
            }
        });

        $body.on("change", '[name="forward[]"]', function () {
            var id = this.id,
                $DSTOption = $(this).parents('.dialExtensionGroup').find('[data-combo="DSTOption"]'),
                timeConditionID = $('#TCID' + id).val(),
                value = $(this).val();

            $DSTOption.show();

            // var data = {forward: value, TCID: timeConditionID, recordId: id};
            var data = {forward: value, TCID: 0, recordId: 0};

            if(data.forward === '') {
                return false;
            }

            $.httpRequest("mainTimeCondition.php?action=TCDSTOption", 'post', data)
                .then(function (response) {
                    $DSTOption.html(response);
                    $DSTOption.find('select').select2();
            });
        });

        /*
         | ------------------------------------------------------------------------------------------------
         |  FAILED PART
         | ------------------------------------------------------------------------------------------------
         */
        $body.on("change", '.FDialExtension', function () {
            var DSTOption = $(this).parents('.dialExtensionFailedGroup').find('[data-combo="DSTOption"]'),
                activeExtension = $(this).parents('.dialExtensionFailedGroup').find('[data-combo="activeExtension"]'),
                forwardId = $(this).parents('.dialExtensionFailedGroup').find('[data-combo="forward"]'),
                value = $(this).find('option:selected').val();

            $(DSTOption).hide();

            if (value === 'voiceMail') {
                $(DSTOption).hide();
                $(activeExtension).show();
                var name = 'failed';

                $.httpRequest("mainTimeCondition.php?action=extensionList", 'post', {dialExtension: value, name: name})
                    .then(function (response) {
                        activeExtension.show();
                        DSTOption.hide();
                        forwardId.hide();

                        $(activeExtension).html(response);
                        $(activeExtension).find('select').select2();
                    });
            } else {
                activeExtension.hide();
                forwardId.show();
                DSTOption.hide();

                $.httpRequest("mainTimeCondition.php?action=FTCForward", 'post', {dialExtension: value, RecordID: cnt + 1})
                    .then(function (response) {
                        $(forwardId).html(response);
                        $(forwardId).find('select').select2();
                    });
            }
        });

        $body.on('change', '.FForward', function () {
            var DSTOption = $(this).parents('.dialExtensionFailedGroup').find('[data-combo="DSTOption"]'),
                value = $(this).find('option:selected').val();

            $(DSTOption).show();

            $.httpRequest("mainTimeCondition.php?action=FTCDSTOption", 'post', {forward: value, recordId: 1})
                .then(function (response) {
                    $(DSTOption).html(response);
                    $(DSTOption).find('select').select2();
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

        $body.on("click", ".record:not(.disabled)", function () {
            RecordID = $(this).attr('id');
            var classValue = $(this).attr('class');
            var elem = $(this);

            Fr.voice.record($("#live").is(":checked"), function(){
                elem.addClass("disabled");
                $("#live").addClass("disabled");

                $("."+RecordID+"_one").removeClass("disabled");

                /**
                 * The Waveform canvas
                 */
                var analyser = Fr.voice.context.createAnalyser();
                analyser.fftSize = 2048;
                analyser.minDecibels = -90;
                analyser.maxDecibels = -10;
                analyser.mdoothingTimeConstant = 0.85;
                Fr.voice.input.connect(analyser);

                var bufferLength = analyser.frequencyBinCount;
                var dataArray = new Uint8Array(bufferLength);

                var WIDTH = 200, HEIGHT = 100;
                var canvasCtx = $("#" + RecordID + "_level")[0].getContext("2d");
                canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);

                function draw() {
                    var drawVisual = requestAnimationFrame(draw);
                    analyser.getByteTimeDomainData(dataArray);
                    canvasCtx.fillStyle = 'rgb(200, 200, 200)';
                    canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);
                    canvasCtx.lineWidth = 2;
                    canvasCtx.strokeStyle = 'rgb(0, 0, 0)';

                    canvasCtx.beginPath();
                    var sliceWidth = (WIDTH * 1.0) / bufferLength;
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
                }
                draw();
            });
        });

        $body.on("click", "#pause:not(.disabled)", function () {
            if ($(this).hasClass("resume")) {
                Fr.voice.resume();
                $(this).replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
            } else {
                Fr.voice.pause();
                $(this).replaceWith('<a class="one resume" id="pause" style="text-decoration: none"><i class="fa fa-play button" aria-hidden="true"></i></a>');
            }
        });

        $body.on("click", "#stop:not(.disabled)", function () {
            restore();
        });

        $body.on("click", "#play:not(.disabled)", function () {
            var $audio = $("#audio");
            Fr.voice.export(function(url){
                $audio.attr("src", url);
                $audio[0].play();
            }, "URL");

            restore();
        });

        $body.on("click", "#save:not(.disabled)", function (e) {
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

                $.httpRequest(url, 'POST', formData, true)
                    .then(function (response) {
                        $body.find(forwardID).find('select').find('option[value="customMessageByRecord"]').attr("selected", null);
                        $body.find(forwardID).find('select').find('option[value="customMessageByList"]').remove().end().append(tag);
                        $body.find(DSTOption).find('#TCRecordVoiceLink').remove();
                        $body.find(DSTOption).html(response);
                        $body.find(DSTOption).find('select').select2();
                    });

            }, "blob");

            restore();
        });

        var cnt = 1,
            htmlClone = $dialContainer.html();
        $body.on('click', '.clone-condition', function (e) {
            e.preventDefault();

            var $clone = $($(htmlClone)[0]),
                id = $clone.attr('id'),
                data_collapse = $clone.find('.collapse-panel').attr('data-collapse');

            $clone.find('.condition-no').html(++cnt);
            $clone.attr('id', id + cnt);
            $clone.find('.collapse-panel').attr('data-collapse', data_collapse + cnt);
            $clone.attr('data-boxid', cnt);

            $clone.find('select').select2();

            $dialContainer.append($clone);

            $body.find('[data-input="timepicker"]').each(function() {
                var $this = $(this);

                $this.timepicker({
                    appendWidgetTo: $this.parent('.col-xs-12')
                });
            });

            $('html, body').animate({
                scrollTop: $clone.offset().top
            }, 'fast');

            refineConditionNumber();
        });

        $body.on('click', '.delete-condition', function (e) {
            e.preventDefault();

            var length = $('.dial-container').find('> .panel').length;

            if (length > 1) {
                if(confirm("Are you sure?")) {
                    $(this).parents('.panel').remove();

                    refineConditionNumber();
                }
            } else {
                swal({
                    title: '',
                    html: "One item required",
                    type: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonClass: 'btn btn-warning btn-block'
                });
            }
        });

        function refineConditionNumber() {
            var counter = 0;

            $dialContainer.find('> .panel').each(function () {
                $(this).find('.condition-no').html(++counter);
                $(this).attr('data-boxid', counter);
            });

            $body.find('.FDialExtension').attr('id', counter);
        }

        $('#submit_time_condition').on('click', function(e) {
            e.preventDefault();

            var data = {
                    action: 'addNewExtensionTimeConditon',
                    name: '',
                    extension_id: <?php echo $list['fields']['json']['extension_id']; ?>,
                    tc: [],
                    failTc: []
                },
            cntErr = 0;
            $body.find('.dial-container > .panel').each(function() {
                var inputs = {};
                $(this).find('select:visible, input:visible').each(function() {
                    try {
                        if($(this).attr('name') !== undefined) {
                            if($(this).prop('type') !== 'hidden') {
                                if($(this).attr('data-name') === 'start' && $(this).val().length){
                                    if(!$(this).parents('.row').find('[data-name="end"]').val().length) {
                                        cntErr++;
                                    }
                                }

                                var inputName = $(this).attr('name').replace('[]', '');
                                inputs[inputName] = $(this).val();
                            } else {
                                $(this).parents('.form-group').addClass('has-error');
                                cntErr++;
                            }
                        }
                    }
                    catch(e) {}
                });

                data.tc.push(inputs);
            });

            // fail time conditions
            var inputsFail = {};
            $('.dialExtensionFailedGroup').find('select:visible, input:visible').each(function() {
                try {
                    if($(this).attr('name') !== undefined) {
                        if($(this).val().length !== 0 && $(this).prop('type') !== 'hidden') {
                            var inputName = $(this).attr('name').replace('[]', '');
                            inputsFail[inputName] = $(this).val();
                        } else {
                            $(this).parents('.form-group').addClass('has-error');
                            cntErr++;
                        }
                    }
                }
                catch(e) {}
            });

            var name = $('#name').val();
            if(name.length !== 0) {
                data.name = name;
            } else {
                cntErr++;
            }

            data.failTc.push(inputsFail);

            <?php
            if ($list['fields']['action'] == 'editNewExtensionTimeCondition') {
            ?>
            data.id = '<?=$list['fields']['json']['comp_id']?>';
            data.action = '<?php echo $list['fields']['action']; ?>';
            data.extension_id = '<?php echo $list['fields']['json']['extension_id']; ?>';
            data.time_condtion_name_id = '<?php echo $list['fields']['json']['time_condtion_name_id']; ?>';
            <?php
            }
            ?>

            if(cntErr) {
                swal({
                    title: '',
                    html: "Please fill required items",
                    type: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonClass: 'btn btn-warning btn-block'
                });

                data = {
                    action: '<?php echo ($list['fields']['action'] == 'editNewExtensionTimeCondition' ? 'editNewExtensionTimeCondition' : 'addNewExtensionTimeConditon'); ?>',
                    name: '',
                    id: 0,
                    extension_id:0,
                    tc: [],
                    failTc: []
                };

                $body.find('.panel').find('#name, select[required], input[required]').each(function() {
                    if(!$(this).val().length) {
                        $(this).focus();

                        return false;
                    }
                });
            } else {
                $.httpRequest("extension.php?action=<?php echo ($list['fields']['action'] == 'editNewExtensionTimeCondition' ? 'editNewExtensionTimeCondition' : 'addNewExtensionTimeConditon'); ?>", 'POST', data, false, true)
                    .then(function(response) {
                        var result = JSON.parse(response);

                        if (parseInt(result.result) === 1) {
                            swal({
                                title: '',
                                html: "Successfully updated",
                                type: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonClass: 'btn btn-success btn-block'
                            }).then(function() {
                                window.location.replace('<?php echo RELA_DIR; ?>extension.php');
                            });
                        } else if (parseInt(result.result) === -1) {
                            swal({
                                title: '',
                                html: result.msg,
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
                            }).then(function() {
                                window.location.reload();
                            });
                        }
                    });
            }
        });

        <?php
        if ($list['fields']['action'] == 'editNewExtensionTimeCondition') {
        ?>
        var tsGroup = JSON.parse('<?php echo json_encode($list['fields']['json']); ?>');

        $('#name').val(tsGroup.name);

        cnt = tsGroup.tc !== null ? tsGroup.tc.length : 1;

        $('.dial-container').html('');

        if (tsGroup.tc !== null) {
            $.each(tsGroup.tc, function () {
                $('.dial-container').append($(htmlClone));
            });

            $('.dial-container').find('> .panel').each(function (i) {
                var $this = $(this);
                $this.find('.condition-no').html(i + 1);

                try {
                    $.each(Object.keys(tsGroup.tc[i]), function (j, v) {
                        if (v === 'forward') {
                            setTimeout(function () {
                                $body.find('.dial-container > .panel:nth-child('+(i+1)+') select[name="forward[]"]').val(tsGroup.tc[i][v]).trigger('change');
                            }, 800);
                        } else if (v === 'DSTOption') {
                            setTimeout(function () {
                                $body.find('.dial-container > .panel:nth-child('+(i+1)+') [name="DSTOption[]"]').val(tsGroup.tc[i][v]).trigger('change');
                            }, 1200);
                        } else if (v === 'sub_dst') {
                            setTimeout(function () {
                                $body.find('.dial-container > .panel:nth-child('+(i+1)+') [name="sub_dst[]"]').val(tsGroup.tc[i][v]).trigger('change');
                            }, 1700);
                        } else {
                            $this.find('[name="' + v + '"]').val(tsGroup.tc[i][v]).trigger('change');
                        }
                    });

                } catch (e) {}
            });
        }

        if (tsGroup.failTc !== null) {
            $.each(Object.keys(tsGroup.failTc[0]), function (j, v) {
                if (v === 'FForward') {
                    setTimeout(function () {
                        $body.find('.dialExtensionFailedGroup [name="FForward"]').val(tsGroup.failTc[0][v]).trigger('change');
                    }, 800);
                } else if (v === 'FDSTOption') {
                    setTimeout(function () {
                        $body.find('.dialExtensionFailedGroup [name="FDSTOption"]').val(tsGroup.failTc[0][v]).trigger('change');
                    }, 1200);
                } else if (v === 'FSub_dst') {
                    setTimeout(function () {
                        $body.find('.dialExtensionFailedGroup [name="FSub_dst"]').val(tsGroup.failTc[0][v]).trigger('change');
                    }, 1500);
                } else {
                    $('.dialExtensionFailedGroup').find('[name="' + v + '"]').val(tsGroup.failTc[0][v]).trigger('change');
                }
            });
        }

        <?php
        }
        ?>
    });

    // todo: audio player is required for debug
</script>
