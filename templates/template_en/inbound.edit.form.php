<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?=RELA_DIR?>inbound.php?action=showInbound">
                    Edit Inbound
                </a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <div class="content-body">
        <form name="inbound" id="inbound" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
            <div id="panel-tablesorter" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=INBOUND_22?></h3>
                    <div class="panel-actions">
                        <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?=COLLAPSE?>">
                            <i class="fa fa-caret-down text-midnight text-18"></i>
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
                    <input name="inbound_id" id="inbound_id" type="hidden" value="<?=$list['inbound_id'];?>"/>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-md-6">
                            <div class="form-group">
                                <label class="col-xs-12 col-md-6 pull-left control-label" for="name"><?=INBOUND_14?>:</label>
                                <div class="col-xs-12 col-md-6 pull-left">
                                    <input type="text" class="form-control" name="inbound_name" id="inbound_name" value="<?=$list['inbound_name']?>" autocomplete="off" placeholder="<?=INBOUND_14?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row hidden-xs"></div>
                    <!--checkbox-->
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label class="col-xs-12 col-md-4 pull-left control-label" for="Type"><?=INBOUND_15?>:</label>
                                <div class="col-xs-12 col-md-2 pull-left">
                                    <div class="checkbox">
                                        <label>
                                            <input id="check_did_name" name="check_did_name" <?=($list['did_name'] == '') ? 'checked="checked"' : ''?> type="checkbox"> Any
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 pull-left">
                                    <input type="text" class="form-control ltr" name="did_name" id="did_name"  value="<?=$list['did_name']?>" autocomplete="off" placeholder="<?=INBOUND_15?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row hidden-xs"></div>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <!--DIDName-->
                                <label class="col-xs-12 col-md-4 pull-left control-label" for="Type"><?=INBOUND_16?>:</label>
                                <div class="col-xs-12 col-md-2 pull-left">
                                    <div class="checkbox">
                                        <label>
                                            <input id="check_cid_name" name="check_cid_name" type="checkbox" <?=($list['cid_name'] == '') ? 'checked="checked"' : ''?>> Any
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 pull-left">
                                    <input type="text" class="form-control ltr" name="cid_name" id="cid_name" value="<?=$list['cid_name']?>"  autocomplete="off" placeholder="<?=INBOUND_16?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row hidden-xs"></div>

                    <div class="row">
                        <!--FaxExt-->
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label class="col-xs-12 col-md-4 pull-left control-label" for="Type"><?=INBOUND_17?>:</label>
                                <div class="col-xs-12 col-md-2 pull-left">
                                    <div class="checkbox">
                                        <label>
                                            <input id="check_fax_ext" name="check_fax_ext" type="checkbox" <?=($list['fax_email'] != '') ? 'checked="checked"' : ''?>> <?=INBOUND_24?>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 pull-left">
                                    <input type="email" class="form-control" name="fax_email" id="fax_email" value="<?=$list['fax_email']?>"  autocomplete="off" placeholder="<?=INBOUND_18?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 style="border-bottom: 1px dotted black;margin-bottom: 1em;">Destination Setting</h3>

                    <section>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Dial destination</h3>
                            </div><!-- /panel-heading -->

                            <div class="panel-body">
                                <!--DstOption-->
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                        <div class="form-group no-margin no-padding">
                                            <select class="valid select2" name="dst_option_id" id="DSTOption" required>
                                                <?php foreach($list['DSTList'] as $key => $value) { ?>
                                                    <option <?=($key == $list['dst_option_id']) ? 'selected' : '' ?> value="<?=$key?>"><?=$value?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--subDstOption-->
                                    <?php //print_r_debug($list['DstSub']);?>

                                    <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                        <div class="form-group no-margin no-padding" id="subDstOption">
                                            <?php if ($list['dst_option_id'] == '100'):?>
                                                <input type="text" class="form-control ltr" name="dst_option_sub_id" value="<?=$list['DstSub']['1'];?>" id="dst_option_sub_id" autocomplete="off" placeholder="email">
                                            <?php else:?>
                                                <select name="dst_option_sub_id" class="valid select2"
                                                        id="dst_option_sub_id" >
                                                    <?php foreach ($list['DstSub'] as $key => $value) :?>
                                                        <option value="<?=$key?>" <?=($key == $list['dst_option_sub_id']) ? 'selected' : ''?>><?=$value?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <!-------------------------------- VoiceMail Part ----------------------------------->
                                    <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                        <div class="form-group no-margin no-padding VMForward" id="DSTOption-2">
                                            <?php if ($list['dst_option_id'] == 6): ?>
                                                <select name="forward" class="select2">
                                                    <?php foreach ($list['forwardList'] as $key => $value): ?>
                                                        <option value="<?=$key?>" <?=($list['forward'] == $key) ? 'selected' : ''?>><?=$value?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <!-------------------------------- VoiceMail Part ----------------------------------->


                                    <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                        <div class="form-group no-margin no-padding VMDSTOption" data-status="InboundDSTOption" id="DSTOption-3">
                                            <?php if ($list['forward'] == 'defaultMessage') { ?>
                                                <input type="hidden" value="" name="DSTOption">
                                            <?php } elseif ($list['forward'] == 'customMessage') { ?>
                                                <input type="hidden" value="" name="DSTOption">
                                            <?php } elseif ($list['forward'] == 'customMessageByList') { ?>
                                                <select name="DSTOption" class="select2">
                                                    <?php foreach ($list['uploadList'] as $key => $value) { ?>
                                                        <option value="<?=$key?>" <?=($list['DSTOption'] == $key) ? 'selected' : ''?>><?=$value?></option>
                                                    <?php } ?>
                                                </select>
                                            <?php } elseif ($list['forward'] == 'customMessageByRecord') { ?>
                                                <div id="TCRecordVoiceLink" class="col-xs-12 col-md-12" style="text-align: center;">
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

                                                    <input class="button" type="checkbox" id="live" title="">
                                                    <label>Live Output</label>
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
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="row hidden-xs"></div>
                <!--btn-->

                <input type="hidden" name="action" id="action" value="update">
            </div>

            <div class="row">
                <div class="col-md-12">
                    <p class="pull-left">
                        <button title="Submit" type="submit" name="update" id="submit"  class="btn btn-success btn-icon">
                            <i class="fa fa-download"></i> Submit
                        </button>
                    </p>
                </div>
            </div>
        </div>
        </form>
    </div>
</div><!--/content -->

<script>
    $(document).ready(function() {

        var checkDID = $('#check_did_name');
        var checkCID = $('#check_cid_name');
        var checkFAX = $('#check_fax_ext');

        if (checkDID.is(':checked')) {
            $("#did_name").attr({
                'disabled': 'disabled'
            });
        }

        if (checkCID.is(':checked')) {
            $("#cid_name").attr({
                'disabled': 'disabled'
            });
        }

        if (checkFAX.is(':checked')) {
            $("#fax_email").removeAttr('disabled');
        } else {
            $("#fax_email").attr({
                'disabled': 'disabled'
            });
        }

        checkFAX.bind('change', function () {

            if ($(this).is(':checked')) {
                $("#fax_email").removeAttr('disabled');
            } else {
                $("#fax_email").attr({
                    'disabled': 'disabled'
                });
            }
        });

        checkDID.bind('change', function () {

            if ($(this).is(':checked')) {
                $("#did_name").attr({
                    'disabled': 'disabled'
                });
            } else {
                $("#did_name").removeAttr('disabled');
            }
        });

        checkCID.bind('change', function () {

            if ($(this).is(':checked')) {
                $("#cid_name").attr({
                    'disabled': 'disabled'
                });
            } else {
                $("#cid_name").removeAttr('disabled');
            }
        });

        $('.menu-hidden').removeClass('hidden');

        var DSTOption = $('#DSTOption');

        DSTOption.click(function() {
            var VMForward = "#DSTOption-2";
            var VMDSTOption = "#DSTOption-3";
            var optionVal = DSTOption.val();

            if (optionVal != '6') {
                $(VMForward).hide();
                $(VMDSTOption).hide();
            }

            $.ajax ({
                type:'POST',
                url:'dstOption.php?action=dstOption',
                data:{DSTOption: optionVal},
                success: function (html) {
                    $('#subDstOption').html(html);
                    $('#subDstOption').find('select').select2();
                }
            });

            /*if (optionVal == '6') {
                $(VMForward).show();
                $(VMDSTOption).show();
                $.ajax ({
                    type:'POST',
                    url:'dstOption.php?action=VMForward',
                    data:{DSTOption:optionVal, name: 'forward'},
                    success: function (html) {
                        $(VMForward).html(html);
                        $(VMForward).find('select').select2();
                    }
                });
            }*/

        });

        $("body").on("change", ".VMForward select", function(){
            var DSTId = "#DSTOption-3";
            var dstOption = $(this).find("option:selected").val();
            $(DSTId).show();
            $.ajax({
                type: 'POST',
                url: 'dstOption.php?action=VMDSTOption',
                data: {dstOption: dstOption, recordId: 0},
                success: function(response){
                    $(DSTId).html(response);
                    $(DSTId).find('select').select2();
                }
            });
        });

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

                function draw(){
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
            var forwardID = '#DSTOption-2';
            var DSTOption = '#DSTOption-3';
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