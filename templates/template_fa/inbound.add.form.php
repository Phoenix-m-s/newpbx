<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?=RELA_DIR?>inbound.php?action=showInbound">
                    Add Inbound
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
                        <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="Collapse-Expand">
                            <i class="fa fa-caret-down text-midnight text-18"></i>
                        </button>
                    </div><!-- /panel-actions -->
                </div><!-- /panel-heading -->
                <?php //print_r_debug($message)?>
                <?php if ($message != null) { ?>
                    <?php foreach ($message as $msg) { ?>
                        <div class="col-xs-12 col-md-12 col-md-12 col-lg-12 alert alert-warning">
                            <?= $msg ?>
                        </div>
                    <?php } ?>
                <?php } ?>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-md-6">
                            <div class="form-group">
                                <label class="col-xs-12 col-md-6 pull-left control-label" for="name"><?=INBOUND_14?>:</label>
                                <div class="col-xs-12 col-md-6 pull-left">
                                    <input type="text" class="form-control" name="inbound_name" id="inbound_name" value="<?=$list['inbound_name']?>" autocomplete="off" placeholder="<?=INBOUND_14?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 col-md-6">

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
                                            <input id="check_did_name" name="check_did_name" type="checkbox" value="1" <?=($list['check_did_name'] == 1) ? 'checked="checked"' : ''?>> Any
                                        </label>
                                    </div>
                                </div>

                                <!--    <label class="col-xs-12 col-md-4 pull-left control-label" for="DIDName"></label>-->
                                <div class="col-xs-12 col-md-6 pull-left">
                                    <input type="text" class="form-control ltr" name="did_name" id="did_name" value="<?=$list['did_name'];?>" autocomplete="off" placeholder="<?=INBOUND_15?>">
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
                                            <input id="check_cid_name" name="check_cid_name" type="checkbox" value="1" <?=($list['check_cid_name'] == 1) ? 'checked="checked"' : ''?>> Any
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 pull-left">
                                    <input type="text" class="form-control ltr" name="cid_name" value="<?=$list['cid_name']?>" id="cid_name" autocomplete="off" placeholder="<?=INBOUND_16?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row hidden-xs"></div>

                    <div class="row">
                        <!--FaxExt-->
                        <div class="col-xs-12 col-md-12 col-md-6">
                            <div class="form-group">
                                <label class="col-xs-12 col-md-4 pull-left control-label" for="Type"><?=INBOUND_17?>:</label>
                                <div class="col-xs-12 col-md-2 pull-left">
                                    <div class="checkbox">
                                        <label>
                                            <input id="check_fax_ext" name="check_fax_ext" type="checkbox" value="1" <?=($list['check_fax_ext'] == 1) ? 'checked="checked"' : ''?>> <?=INBOUND_24?>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 pull-left">
                                    <input type="email" class="form-control" name="fax_email" id="fax_email" value="<?=$list['fax_email']?>" autocomplete="off" placeholder="<?=INBOUND_18?>">
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
                                                    <option <?=($key == $list['DSTOption']) ? 'selected' : '' ?> value="<?=$key?>"><?=$value?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!--subDstOption-->
                                    <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                        <div class="form-group no-margin no-padding" id="subDstOption"></div>
                                    </div>


                                    <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                        <div class="form-group no-margin no-padding VMForward" id="DSTOption-2"></div>
                                    </div>

                                    <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                        <div class="form-group no-margin no-padding VMDSTOption" data-status="InboundDSTOption" id="DSTOption-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <input TYPE="hidden" NAME="<?=$list['token']?>" VALUE="1">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p class="pull-left">
                        <button type="submit" name="update" id="submit" class="btn btn-icon btn-success">
                            <input type="hidden" name="action" id="action" value="addInbound">
                            <i class="fa fa-download"></i> Submit
                        </button>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div><!--/content -->

<script>
    $(document).ready(function() {

        $("#fax_email").attr({
            'disabled': 'disabled'
        });

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
        }

        checkFAX.bind('change', function () {

            if ($(this).is(':checked'))
                $("#fax_email").removeAttr('disabled');
            else
                $("#fax_email").attr({
                    'disabled': 'disabled'
                });

        });

        checkDID.bind('change', function () {

            if ($(this).is(':checked'))
                $("#did_name").attr({
                    'disabled': 'disabled'
                });
            else
                $("#did_name").removeAttr('disabled');
        });

        checkCID.bind('change', function () {

            if ($(this).is(':checked'))
                $("#cid_name").attr({
                    'disabled': 'disabled'
                });
            else
                $("#cid_name").removeAttr('disabled');
        });

        /*
        | ------------------------------------------------------------------------------------------------------
        | displays the telephone systems menu
        | ------------------------------------------------------------------------------------------------------
        */
        $('.menu-hidden').removeClass('hidden');


        var DSTOption = $('#DSTOption');
        $.ajax ({
            type:'POST',
            url:'dstOption.php?action=dstOption',
            data:{"DSTOption":DSTOption.val()},
            success: function (html) {
                $('#subDstOption').html(html);
                $('#subDstOption').find('select').select2();
            }
        });

        /*
         | ------------------------------------------------------------------------------------------------------
         | returns dst_option values using AJAX and PHP method
         | and if the voice mail get chosed then the will
         | extra selects.
         | ------------------------------------------------------------------------------------------------------
         */
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

        /*
         | ------------------------------------------------------------------------------------------------------
         | returns if voice mail get chosed then the destination
         | of the voice mail will be displayed in the next
         | select using this method.
         | ------------------------------------------------------------------------------------------------------
         */
        $("body").on("change", ".VMForward select", function(){
            var DSTId = "#DSTOption-3";
            var dstOption = $(this).find("option:selected").val();
            $(DSTId).show();
            $.ajax({
                type: 'POST',
                url: 'dstOption.php?action=VMDSTOption',
                data: {dstOption: dstOption, recordId: 0, name: 'DSTOption'},
                success: function(response){
                    $(DSTId).html(response);
                    $(DSTId).find('select').select2();
                }
            });
        });

        /*
         | ------------------------------------------------------------------------------------------------------
         | Record Sound.
         | Record Sound.
         | Record Sound.
         | ------------------------------------------------------------------------------------------------------
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