<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?= RELA_DIR ?>queue.php?action=showQueues">
                    Add Queue
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>

    <div class="content-body">
        <form name="queue" id="queue" role="form" data-validate="form" class="form-horizontal"
              autocomplete="off" novalidate="novalidate" method="post">

            <div id="panel-tablesorter" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= QUEUE_38 ?></h3>
                    <div class="panel-actions">
                        <button data-collapse="#panel-tablesorter" title="" class="btn-panel"
                                data-original-title="<?= COLLAPSE ?>">
                            <i class="fa fa-caret-down"></i>
                        </button>
                    </div><!-- /panel-actions -->
                </div><!-- /panel-heading -->
                <?php if ($message != null) { ?>
                    <?php foreach ($message as $msg) { ?>
                        <div class="col-xs-12 col-md-12 col-md-12 col-lg-12 alert alert-warning">
                            <?= $msg ?>
                        </div>
                    <?php } ?>
                <?php } ?>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12  center-block">
                            <div class="row">
                                <!-- queue name -->
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-5 pull-left control-label"
                                               for="Queue_Name"><?= QUEUE_20 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="queue_name" id="Queue_Name"
                                                   autocomplete="off" placeholder="<?= QUEUE_20 ?>" required
                                                   value="<?= $list['queue_name'] ?>">
                                        </div>
                                    </div>
                                </div> <!-- /end of queue name -->

                                <!-- queue number -->
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-5 pull-left control-label"
                                               for="queue_ext_no"><?= QUEUE_21 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="queue_ext_no"
                                                   id="Queue_Ext_Number" autocomplete="off"
                                                   placeholder="<?= QUEUE_21 ?>" required
                                                   value="<?= $list['queue_ext_number'] ?>">
                                        </div>
                                    </div>
                                </div> <!-- /end of queue number -->
                            </div>

                            <div class="row">
                                <!-- queue password -->
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-5 pull-left control-label"
                                               for="Queue_Pass"><?= QUEUE_22 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="queue_pass" id="Queue_Pass"
                                                   autocomplete="off" placeholder="<?= QUEUE_22 ?>" required
                                                   value="<?= $list['queue_pass'] ?>">
                                        </div>
                                    </div>
                                </div> <!-- /end of queue password -->
                            </div>

                            <div class="row xsmallSpace hidden-xs"></div>

                            <!-- selectable and selected extensions -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-2 pull-left control-label"
                                               for="agent"><?= QUEUE_24 ?>:</label>
                                        <div class="col-xs-12 col-sm-10 pull-left">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6 col-md-6 pull-left text-left text-bold">
                                                    <?= QUEUE_33 ?>

                                                    <span style="margin-left: 60px;"><?= QUEUE_34 ?></span>
                                                </div>
                                            </div>
                                            <select data-input="multiselect" multiple="multiple" id="Agent_No"
                                                    name="agents_no[]" class="pull-left">
                                            <?php foreach ($list['extensionList'] as $key => $value) { ?>
                                                <option value="<?= $key ?>"><?= $value ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /end of selectable and selected extensions -->

                            <div class="row">
                                <!-- left checkboxes -->
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <div class="checkbox" style="margin-left: 20px;">
                                            <label>
                                                <input name="hold_time_announcement" id="Hold_Time_Announcement"
                                                       value="1"
                                                       type="checkbox"> <?= QUEUE_27 ?>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox" style="margin-left: 20px;">
                                            <label>
                                                <input name="position_announcement" id="Position_Announcement"
                                                       value="1"
                                                       type="checkbox"> <?= QUEUE_26 ?>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox" style="margin-left: 20px;">
                                            <label>
                                                <input name="instead" id="instead"
                                                       value="1"
                                                       type="checkbox"> <?= QUEUE_36 ?>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox" style="margin-left: 20px;">
                                            <label>
                                                <input id="Recording" name="recording"
                                                       value="1"
                                                       type="checkbox"> <?= QUEUE_29 ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <!-- timeout -->
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-5 pull-left control-label"
                                               for="timeout"><?= QUEUE_37 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="timeout"
                                                   id="timeout" autocomplete="off"
                                                   placeholder="<?= QUEUE_37 ?>" required
                                                   value="<?= $list['timeout'] ?>">
                                        </div>
                                    </div> <!-- /end of timeout -->

                                    <!-- announce frequency -->
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-5 pull-left control-label"
                                               for="Frequency"><?= QUEUE_28 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <select class="select2 valid" name="frequency" id="Frequency" required>
                                                <option <?= ($list['frequency'] == '15') ? 'selected' : '' ?>>15
                                                </option>
                                                <option <?= ($list['frequency'] == '30') ? 'selected' : '' ?>>30
                                                </option>
                                                <option <?= ($list['frequency'] == '60') ? 'selected' : '' ?>>60
                                                </option>
                                            </select>
                                        </div>
                                    </div> <!-- /end of announce frequency -->

                                    <!-- maximum waiting time -->
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-5 pull-left control-label"
                                               for="Max_Wait_Time"><?= QUEUE_23 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <input type="text" class="form-control" name="max_wait_time"
                                                   id="Max_Wait_Time" autocomplete="off"
                                                   placeholder="<?= QUEUE_23 ?> (Second)" required
                                                   value="<?= $list['max_wait_time'] ?>">
                                        </div>
                                    </div> <!-- /end of maximum waiting time -->

                                    <!-- ring strategy -->
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-5 pull-left control-label" for="Ring_Strategy"><?= QUEUE_30 ?>:</label>
                                        <div class="col-xs-12 col-sm-6 pull-left">
                                            <select class="select2 valid" name="ring_strategy" id="Ring_Strategy" required>
                                                <option><?= MEMORY ?></option>
                                                <option><?= RANDOM ?></option>
                                                <option><?= RING_ALL ?></option>
                                                <option><?= FEWEST_CALL ?></option>
                                            </select>
                                        </div>
                                    </div> <!-- /end of ring strategy -->
                                </div>
                            </div>

                            <div class="row xsmallSpace hidden-xs"></div>

                            <h3 style="border-bottom: 1px dotted black;margin-bottom: 1em;">Destination Setting</h3>

                            <section>
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Failover Destination</h3>
                                    </div><!-- /panel-heading -->

                                    <div class="panel-body">
                                        <div class="row dialExtensionGroup">
                                            <div class="col-xs-12 col-sm-12 col-md-3 margin-bottom-half">
                                                <div class="form-group no-margin no-padding">
                                                    <select class="valid select2" name="dst_option_id" id="DSTOption" required>
                                                        <?php foreach ($list['DSTList'] as $key => $value) { ?>
                                                            <option <?= ($key == $list['DSTOption']) ? 'selected' : '' ?>
                                                                    value="<?= $key ?>"><?= $value ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3 margin-bottom-half">
                                                <div class="form-group no-margin no-padding" id="subDstOption"></div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3 margin-bottom-half">
                                                <div class="form-group no-margin no-padding VMForward" id="DSTOption-2"></div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3 margin-bottom-half">
                                                <div class="form-group no-margin no-padding VMDSTOption" data-status="QueueDSTOption" id="DSTOption-3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            <button name="update" id="action" type="submit" title="Submit" class="btn btn-success btn-icon">
                <i class="fa fa-download"></i><?= TIMECONDITION_03 ?>
            </button>
            <input type="hidden" name="action" id="action" value="addQueue">
            <input type="hidden" name="<?= $list['token'] ?>" value="1">
        </form>
    </div>
</div><!--/content -->

<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function () {
        var DSTOption = $('#DSTOption');

        $.ajax({
            type: 'POST',
            url: 'dstOption.php?action=dstOption',
            data: {DSTOption: DSTOption.val()},
            success: function (html) {
                $('#subDstOption').html(html);

                $('select').select2();
            }
        });

        DSTOption.click(function () {
            var VMForward = "#DSTOption-2";
            var VMDSTOption = "#DSTOption-3";
            var optionVal = DSTOption.val();

            if (optionVal != '6') {
                $(VMForward).hide();
                $(VMDSTOption).hide();
            }

            $.ajax({
                type: 'POST',
                url: 'dstOption.php?action=dstOption',
                data: {DSTOption: optionVal},
                success: function (html) {
                    $('#subDstOption').html(html);
                    $('#subDstOption').find('select').select2();
                }
            });

            /*if (optionVal == '6') {
                $(VMForward).show();
                $.ajax({
                    type: 'POST',
                    url: 'dstOption.php?action=VMForward',
                    data: {DSTOption: optionVal, name: 'forward'},
                    success: function (html) {
                        $(VMForward).html(html);
                        $(VMForward).find('select').select2();
                    }
                });
            }*/

        });

        $("body").on("change", ".VMForward select", function () {
            var DSTId = "#DSTOption-3";
            var dstOption = $(this).find("option:selected").val();
            $(DSTId).show();
            $.ajax({
                type: 'POST',
                url: 'dstOption.php?action=VMDSTOption',
                data: {dstOption: dstOption, recordId: 0, name: 'DSTOption'},
                success: function (response) {
                    $(DSTId).html(response);
                    $(DSTId).find('select').select2();
                }
            });
        });

        function restore() {
            $("#record, #live").removeClass("disabled");
            $("#pause").replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
            $(".one").addClass("disabled");
            Fr.voice.stop();
        }

        $(document).on("click", ".record:not(.disabled)", function () {
            RecordID = $(this).attr('id');
            var classValue = $(this).attr('class');
            elem = $(this);
            Fr.voice.record($("#live").is(":checked"), function () {
                elem.addClass("disabled");
                $("#live").addClass("disabled");

                $("." + RecordID + "_one").removeClass("disabled");

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
                canvasCtx = $("#" + RecordID + "_level")[0].getContext("2d");
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
                        var y = v * HEIGHT / 2;

                        if (i === 0) {
                            canvasCtx.moveTo(x, y);
                        } else {
                            canvasCtx.lineTo(x, y);
                        }

                        x += sliceWidth;
                    }
                    canvasCtx.lineTo(WIDTH, HEIGHT / 2);
                    canvasCtx.stroke();
                };
                draw();
            });
        });

        $(document).on("click", "#pause:not(.disabled)", function () {
            if ($(this).hasClass("resume")) {
                Fr.voice.resume();
                $(this).replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
            } else {
                Fr.voice.pause();
                $(this).replaceWith('<a class="one resume" id="pause" style="text-decoration: none"><i class="fa fa-play button" aria-hidden="true"></i></a>');
            }
        });

        $(document).on("click", "#stop:not(.disabled)", function () {
            restore();
        });

        $(document).on("click", "#play:not(.disabled)", function () {
            Fr.voice.export(function (url) {
                $("#audio").attr("src", url);
                $("#audio")[0].play();
            }, "URL");
            restore();
        });

        $(document).on("click", "#save:not(.disabled)", function (e) {
            e.preventDefault();
            var id = RecordID.replace('record_', '');
            var forwardID = '#DSTOption-2';
            var DSTOption = '#DSTOption-3';
            var status = $(DSTOption).data('status');
            var tag = $('<option value="customMessageByList" selected="selected">customMessageByList</option>');
            var voiceTitle = $('#voiceTitle' + id).val();
            var url = "mainTimeCondition.php?action=saveVoice&status=" + status + "&voiceTitle=" + voiceTitle;
            Fr.voice.export(function (blob) {
                var formData = new FormData();
                formData.append('file', blob);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
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
</script>

<style>
    .button {
        background: #555;
        border: 1px dotted black;
        border-radius: 50px;
        margin: auto 20px 20px auto;
        font-size: 15px;
        color: #000;
    }

    .button:hover, .button:focus {
        box-shadow: 0 5px 10px #000;
        color: #fff;
    }

    .disabled {
        box-shadow: none;
        opacity: 0.7;
    }

    canvas {
        display: block;
    }
</style>