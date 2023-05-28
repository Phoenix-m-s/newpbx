<style type="text/css">
    .custom-grid {
        padding-left: 30px;
        padding-right: 30px;
    }

    .prepend:before, .prepend:after,
    .prefix:before, .prefix:after,
    .match-pattern:before, .match-pattern:after,
    .caller-id:before, .caller-id:after {
        position: absolute;
        font-size: 1.5em;
        top: 0;
        color: #000;
    }

    .prepend:before {
        color: #5BB75B;
        content: '(' !important;
        left: 0;
    }

    .prepend:after {
        color: #5BB75B;
        content: ')' !important;
        right: 0;
    }

    .prefix:before {
        content: '+' !important;
        left: -15px;
    }

    .prefix:after {
        content: '|' !important;
        right: -8px;
        font-size: 1.8em !important;
    }

    .match-pattern:before {
        color: #5BB75B;
        content: '[' !important;
        left: 0;
    }

    .match-pattern:after {
        content: '/' !important;
        right: -15px;
    }

    .caller-id:after {
        color: #5BB75B;
        content: ']' !important;
        right: -5px;
    }

    @media screen and (max-width: 768px) {
        .destination-holder {
            border: solid 1px #dadada;
            border-radius: 5px;
            margin-bottom: 2em !important;
            padding: 1em;
        }

        .destination-holder .delete-condition {
            top: -20px !important;
            left: -10px !important;
            z-index: 10 !important;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background: #FFF;
            border: solid 1px #c30;
            border-radius: 5px;
        }
    }
</style>

<div class="content active">
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20" href="<?=RELA_DIR?>outbound.php?action=showOutbound"></a>
            </li>
        </ul><!--/control-nav-->
    </div>
    <!--/content-header -->
    <div class="content-body contentOutbound">
        <form name="outbound" id="outbound" role="form" data-validate="form" class="form-horizontal form-bordered" autocomplete="off" novalidate="novalidate" method="post">
            <div id="panel-tablesorter" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=OUTBOUND_14;?></h3>
                    <div class="panel-actions">
                        <button data-collapse="#panel-tablesorter" title="" class="btn-panel" data-original-title="<?= COLLAPSE ?>">
                            <i class="fa fa-caret-down text-midnight text-18"></i>
                        </button>
                    </div><!-- /panel-actions -->
                </div><!-- /panel-heading -->

                <div class="panel-body">
                    <!--outbound-->
                    <div class="normal-data">
                        <input name="outbound_id" id=outbound_id type="hidden">
                        <input type="hidden" name="action" id="action" value="update">

                        <div class="row margin-bottom">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 col-md-5 pull-left control-label" for="outbound_name"><?=OUTBOUND_11?>:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-7 pull-left">
                                        <input type="text" class="form-control" name="outbound_name" id="outbound_name" autocomplete="off" placeholder="<?=OUTBOUND_11?>" required tabindex="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <label class="col-xs-12 col-sm-4 col-md-4 pull-left control-label" for="caller_id_name"><?=OUTBOUND_19?>:</label>
                                <div class="col-xs-12 col-sm-4 col-md-4 pull-left margin-bottom-half">
                                    <input type="text" class="form-control" name="caller_id_name" id="caller_id_name" autocomplete="off" placeholder="<?=OUTBOUND_20?>" tabindex="2">
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 pull-left">
                                    <input type="text" class="form-control" name="caller_id_number" id="caller_id_name" autocomplete="off" placeholder="<?=OUTBOUND_21?>" tabindex="3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="outboundList_holder">
                        <div class="row destination-holder pull-left no-margin pos-rel" style="max-width: 1000px;">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6 custom-grid">
                                        <div class="form-group prepend pos-rel">
                                            <input type="text" class="form-control" name="prepend" id="prepend" autocomplete="off" placeholder="<?=OUTBOUND_12?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 custom-grid">
                                        <div class="form-group prefix pos-rel">
                                            <input type="text" class="form-control" name="prefix" id="prefix" autocomplete="off" placeholder="<?=OUTBOUND_13?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6 custom-grid">
                                        <div class="form-group match-pattern pos-rel">
                                            <input type="text" class="form-control" name="match_pattern" id="match_pattern" autocomplete="off" required placeholder="<?=OUTBOUND_15?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 custom-grid">
                                        <div class="form-group caller-id pos-rel">
                                            <input type="text" class="form-control" name="caller_id" id="caller_id" autocomplete="off" placeholder="<?=OUTBOUND_19?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="delete-condition" style="position:absolute; top:8px;left: -10px;float: right;"><i class="fa fa-trash text-red text-18"></i></a>
                        </div>

                        <!-- Dynamic generate menu -->
                        <div class="appendAdsPeriod" style="margin-top:10px;"></div>
                    </div>

                    <div class="row no-margin">
                        <div class="col-xs-12 col-md-12 col-md-6">
                            <ul class="pull-left push-to-bottom plus-outbound no-padding" style="margin-top:10px;">
                                <li>
                                    <button type="button" class="clone-condition btn btn-primary btn-icon">
                                        <i class="fa fa-plus"></i><?= OUTBOUND_22?>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <hr>

                    <div class="normal-data">
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-4 col-md-5 pull-left control-label" for="priority"><?=OUTBOUND_17?>:</label>
                                    <div class="col-xs-12 col-sm-8 col-md-7 pull-left">
                                        <select class="select2" name="priority" id="priority" required>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row xsmallSpace hidden-xs"></div>

                    <div class="sip-data">
                        <div class="sipTrunk_holder">
                            <div class="row">
                                <div class="col-xs-12 col-md-12 col-md-6">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-4 col-md-5 pull-left control-label" for="sip_id"><?=OUTBOUND_16?>:</label>
                                        <div class="col-xs-12 col-sm-8 col-md-7 pull-left">
                                            <select class="select2" name="sip_id" id="sip_id" required></select>
                                        </div>

                                        <a class="delete-condition" style="position:absolute; top:8px;right: -10px;float: right;"><i class="fa fa-trash text-red text-18"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row no-margin">
                            <div class="col-xs-12 col-md-12 col-md-6">
                                <ul class="pull-left push-to-bottom plus-outbound no-padding" style="margin-top:10px;">
                                    <li>
                                        <button type="button" class="clone-condition2 btn btn-primary btn-icon">
                                            <i class="fa fa-plus"></i><?= OUTBOUND_26?>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p class="pull-left">
                        <button type="submit" name="add" id="submit" class="btn btn-icon btn-success">
                            <i class="fa fa-download"></i>Submit
                        </button>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div><!--/content -->


<script>
    $(function () {
        let $body = $('body'),
            $outboundList_holder = $('.outboundList_holder'),
            $sipTrunk_holder = $('.sipTrunk_holder'),
            htmlClone = $outboundList_holder.html(),
            htmlClone2 = $sipTrunk_holder.html(),
            result = JSON.parse('<?php echo json_encode(json_decode($list)); ?>');

        $('.clone-condition').on('click', function () {
            let counter = $('.row input[name="caller_id"]').length;

            if (counter < 10) {
                $outboundList_holder.append($(htmlClone));
            } else {
                swal({
                    title: '',
                    html: "Maximum item is added",
                    type: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonClass: 'btn btn-warning btn-block'
                });
            }
        });

        $('.clone-condition2').on('click', function() {
            let counter = $sipTrunk_holder.find('.row').length;

            if (counter < result['sip_id'].length - 1) {
                $sipTrunk_holder.append($(htmlClone2));

                getList({
                    el: $sipTrunk_holder.find('.row:last-child [name="sip_id"]'),
                    list: result['sip_id'],
                    itemVal: '',
                    id: 'id',
                    name: 'name'
                });

                $sipTrunk_holder.find('select').select2();
            } else {
                swal({
                    title: '',
                    html: "Maximum item is added",
                    type: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonClass: 'btn btn-warning btn-block'
                });
            }
        });

        $body.on('click', '.delete-condition', function (e) {
            e.preventDefault();

            $(this).parents('.row').remove();
        });

        // change title and action of form by action in json object
        $body.find('.control-nav a').text(result['action'] === 'editOutbound' ? '<?=OUTBOUND_25?>' : '<?=OUTBOUND_24?>');

        // fill sip_id select box
        getList({
            el: $body.find('[name="sip_id"]'),
            list: result['sip_id'],
            itemVal: result['sip_id_selected'],
            id: 'id',
            name: 'name'
        });

        // fill priority select box
        getList({
            el: $body.find('[name="priority"]'),
            list: result['priority'],
            itemVal: result['priority_id_selected'],
            id: 'id',
            name: 'name'
        });

        // fill all inputs values
        $('.panel-body').find('input').each(function() {
            let itemVal = result[$(this).attr('name')];

            $(this).val(itemVal).trigger('change');
        });

        function getList(obj) {
            return new Promise(function(resolve) {
                try {
                    if (obj.el.prop('tagName') === 'SELECT') {
                        let html = '';

                        if (obj.list !== undefined && obj.list.length) {
                            $.each(obj.list, function(i, v) {

                                if (obj.el.attr('name') === 'priority') {
                                    if (v['isUsed'] !== undefined) {
                                        html += '<option '+(parseInt(v[obj.id]) === parseInt(obj.itemVal) ? 'selected' : '') + (v['isUsed'] !== '0' ? ' disabled ' : '') +' value="'+ v[obj.id] +'">'+ v[obj.name] + (v['isUsed'] !== '0' ? ' - used by : ' + v['isUsed'] : '') +'</option>';
                                    } else {
                                        html += '<option value="">'+ v[obj.name] +'</option>';
                                    }

                                } else {

                                    html += '<option '+(parseInt(v[obj.id]) === parseInt(obj.itemVal) ? 'selected' : '')+' value="'+ v[obj.id] +'">'+ v[obj.name] +'</option>';

                                }

                            });

                            obj.el.html(html).trigger('change');

                        } else {
                            obj.el.val(obj.itemVal).trigger('change');
                        }
                    } else {
                        obj.el.val(obj.itemVal);

                        if (obj.itemVal === 'Invalid' || obj.itemVal === 'TimeOut') {
                            obj.el.prop({
                                'readonly': true,
                                'type': 'text',
                                'pattern': '',
                                'maxlength': '',
                                'min': '',
                                'max': ''
                            });

                            obj.el.parents('[data-target]').find('.delete-condition').remove();
                        }
                    }

                    resolve(true);
                } catch(e) {
                    console.log('error in put list in ', obj.el, e);
                }
            });
        }

        if (result['outbound_list'] !== undefined && result['outbound_list'].length) {
            $outboundList_holder.html('');

            $.each(result['outbound_list'], function(i, v) {
                $outboundList_holder.append($(htmlClone));

                $.each(Object.keys(v), function(j, k) {
                    $body.find('[name="'+ k +'"]:eq('+ i +')').val(v[k]);
                })
            });
        }

        if (result['action'] === 'editOutbound' && result['sip_id'] !== undefined && result['sip_id'].length) {
            try {
                if ($('[name="sip_id"]').length) {
                    $sipTrunk_holder.html('');
                }

                $.each(result['sip_id_selected'], function(i, v) {
                    $sipTrunk_holder.append($(htmlClone2));

                    getList({
                        el: $body.find('[name="sip_id"]:eq('+ i +')'),
                        list: result['sip_id'],
                        itemVal: result['sip_id_selected'][i],
                        id: 'id',
                        name: 'name'
                    });
                });
            }  catch (e) {}
        }

        $outboundList_holder.find('.row:first-child .delete-condition').remove();
        $sipTrunk_holder.find('.row:first-child .delete-condition').remove();

        $('#outbound').on('submit', function(e) {
            e.preventDefault();

            let cnt = 0,
                data = {
                    outbound_list: [],
                    sip_id: []
                };

            try {
                $('.normal-data').find('[name]').each(function() {
                    if ($(this).val() !== null && $(this).prop('required') && !$(this).val().length) {
                        cnt++;
                    }

                    if ($(this).prop('tagName') === 'SELECT') {
                        data[$(this).attr('name') + '_selected'] = $(this).val();
                    } else {
                        data[$(this).attr('name')] = $(this).val();
                    }
                });

                $outboundList_holder.find('.row.destination-holder').each(function() {
                    let dataTmp = {};

                    $(this).find('[name]').each(function() {
                        if ($(this).attr('name') !== undefined) {
                            if ($(this).prop('required') && !$(this).val().length) {
                                cnt++;
                            }

                            dataTmp[$(this).attr('name')] = $(this).val();
                        }
                    });

                    data.outbound_list.push(dataTmp);
                });

                $sipTrunk_holder.find('.row').each(function() {
                    let dataTmp = [];

                    $(this).find('[name]').each(function() {
                        if ($(this).attr('name') !== undefined) {
                            if ($(this).prop('required') && !$(this).val().length) {
                                cnt++;
                            }

                            data.sip_id.push($(this).val());
                        }
                    });


                });

                if (cnt) {
                    swal({
                        title: '',
                        html: "Please fill required items",
                        type: 'warning',
                        confirmButtonText: 'OK',
                        confirmButtonClass: 'btn btn-warning btn-block'
                    });
                } else {
                    $.httpRequest("outbound.php?action="+result['action'], 'post', data)
                        .then(function (response) {
                            let result = JSON.parse(response);

                            swal({
                                title: '',
                                html: result.msg,
                                type: result.result === 1 ? 'success' : 'error',
                                confirmButtonText: 'OK',
                                confirmButtonClass: 'btn '+(result.result === 1 ? 'btn-success' : 'btn-danger')+' btn-block'
                            }).then(function() {
                                if (result.result === 1) {
                                    window.location.replace('<?php echo RELA_DIR; ?>outbound.php');
                                }
                            });
                        });
                }
            } catch(e) {
                console.log('error in sending form: ', e);
            }
        });


    });

</script>