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
        <form id="timeCondition" data-validate="form" class="form-horizontal" autocomplete="off" novalidate="novalidate" method="post" style="width: 75%;  margin: 0 auto;">
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
                        <div class="normal-data">
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
                                                   name="hourStart" id="hourStart"
                                                   placeholder="Hour start" required
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
                                                   name="hourEnd" id="hourEnd"
                                                   placeholder="Hour end" required
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
                                            <select name="weekDayStart" class="weekDayStart select2" id="weekDayStart" title="" data-name="start"></select>
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
                                            <select name="weekDayEnd" class="weekDayEnd select2" id="weekDayEnd" title="" data-name="end"></select>
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
                                            <select name="dayStart" class="dayStart select2" id="dayStart" title="" data-name="start"></select>
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
                                            <select name="dayEnd" class="dayEnd select2" id="dayEnd" title="" data-name="end"></select>
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
                                            <select name="monthStart" class="monthStart select2" id="monthStart" title="" data-name="start"></select>
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
                                            <select name="monthEnd" class="monthEnd select2" id="monthEnd" data-name="end" title=""></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 style="border-bottom: 1px dotted black;margin-bottom: 1em;">Destination Setting</h3>

                        <section class="destination-holder">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Destination if time matches</h3>
                                </div><!-- /panel-heading -->

                                <div class="panel-body">
                                    <div class="row dialExtensionGroup">
                                        <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                            <div class="form-group no-padding no-margin">
                                                <select name="dst_option_id" class="select2" required></select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                            <div class="form-group no-padding no-margin">
                                                <select name="dst_option_sub_id" class="select2" required></select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                            <div class="form-group no-padding no-margin">
                                                <select name="DSTOption" class="select2"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div><!-- /panel-body -->
                </div>
            </section>

            <button type="button" class="clone-condition btn btn-primary btn-icon">
                <i class="fa fa-plus"></i> &nbsp; <?= TIMECONDITION_04 ?>
            </button>

            <br>
            <br>

            <!------------------------- Failed Side ------------------------------>
            <section class="fdestination-holder">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Destination if time doesn't matches</h3>
                    </div><!-- /panel-heading -->

                    <div class="panel-body">
                        <!---------------------------------- Failed Dial Extension ------------------------------------------->
                        <div class="row dialExtensionFailedGroup">
                            <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                <div class="form-group no-padding no-margin">
                                    <select name="fdst_option_id" class="select2" required></select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                <div class="form-group no-padding no-margin">
                                    <select name="fdst_option_sub_id" class="select2" required></select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-3 col-md-3 margin-bottom-half">
                                <div class="form-group no-padding no-margin">
                                    <select name="fDSTOption" class="select2"></select>
                                </div>
                            </div>
                        </div><!-- /panel-body -->
                    </div>
            </section>

            <input type="hidden" name="action">
            <input type="hidden" name="is_extension" value="0">
            <input type="hidden" name="extension_id" value="0">
            <input type="hidden" name="timeConditionID" value="0">
            <input type="hidden" name="comp_id" value="0">

            <button id="submit_time_condition" type="submit" class="btn btn-success btn-icon">
                <i class="fa fa-download"></i><?= TIMECONDITION_03 ?>
            </button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        let $body = $('body'),
            $destination = $('.destination-holder'),
            $fdestination = $('.fdestination-holder'),
            $dialContainer = $('.dial-container'),
            RecordID,
            htmlClone;

        let result = JSON.parse('<?php echo json_encode($list['fields']); ?>');

        if (result.form_action === 'add') {

            // change title and action of form by action in json object
            $body.find('.control-nav a').text('<?=TIMECONDITION_02?>');

            $body.find('[type="hidden"]').each(function() {
                let name = $(this).attr('name');

                $(this).val(result[name]);
            });

            fillDestinations('dst_option_id', false).then(function() {
                htmlClone = $dialContainer.html();
            });

            getList({el: $body.find('[name="dayStart"]:eq(0)'), list: result['dayStart'], itemVal: '', id: 'id', name: 'name'});
            getList({el: $body.find('[name="dayEnd"]:eq(0)'), list: result['dayStart'], itemVal: '', id: 'id', name: 'name'});
            getList({el: $body.find('[name="monthStart"]:eq(0)'), list: result['monthStart'], itemVal: '', id: 'id', name: 'name'});
            getList({el: $body.find('[name="monthEnd"]:eq(0)'), list: result['monthStart'], itemVal: '', id: 'id', name: 'name'});
            getList({el: $body.find('[name="weekDayStart"]:eq(0)'), list: result['weekDayStart'], itemVal: '', id: 'id', name: 'name'});
            getList({el: $body.find('[name="weekDayEnd"]:eq(0)'), list: result['weekDayStart'], itemVal: '', id: 'id', name: 'name'});

        }  else {

            // change title and action of form by action in json object
            $body.find('.control-nav a').text('<?=TIMECONDITION_05?>');

            $body.find('[type="hidden"]').each(function() {
                let name = $(this).attr('name');

                $(this).val(result[name]);
            });

            $body.find('[name="name"]').val(result['name']);

            htmlClone = $dialContainer.html();

            $dialContainer.html('');

            $.each(result.tc, function(i, v) {

                $dialContainer.append($(htmlClone));

                $body.find('.condition-no:eq('+ i +')').html(i + 1);

                getList({el: $body.find('[name="hourStart"]:eq('+ i +')'), list: [], itemVal: v['hourStart']});
                getList({el: $body.find('[name="hourEnd"]:eq('+ i +')'), list: [], itemVal: v['hourEnd']});
                getList({el: $body.find('[name="dayStart"]:eq('+ i +')'), list: result['dayStart'], itemVal: v['dayStart'], id: 'id', name: 'name'});
                getList({el: $body.find('[name="dayEnd"]:eq('+ i +')'), list: result['dayStart'], itemVal: v['dayEnd'], id: 'id', name: 'name'});
                getList({el: $body.find('[name="monthStart"]:eq('+ i +')'), list: result['monthStart'], itemVal: v['monthStart'], id: 'id', name: 'name'});
                getList({el: $body.find('[name="monthEnd"]:eq('+ i +')'), list: result['monthStart'], itemVal: v['monthEnd'], id: 'id', name: 'name'});
                getList({el: $body.find('[name="weekDayStart"]:eq('+ i +')'), list: result['weekDayStart'], itemVal: v['weekDayStart'], id: 'id', name: 'name'});
                getList({el: $body.find('[name="weekDayEnd"]:eq('+ i +')'), list: result['weekDayStart'], itemVal: v['weekDayEnd'], id: 'id', name: 'name'});

                fillDestinations({
                    list: result.tc[i],
                    elNo: i,
                    dst_option_id: 'dst_option_id',
                    dst_option_sub_id: 'dst_option_sub_id',
                    DSTOption: 'DSTOption',
                    selected: 'dst_option_id_selected'
                });
            });
        }

        if (result.failTc !== undefined) {
            fillDestinations({
                list: result.failTc[0],
                elNo: 0,
                dst_option_id: 'fdst_option_id',
                dst_option_sub_id: 'fdst_option_sub_id',
                DSTOption: 'fDSTOption',
                selected: 'fdst_option_id_selected'
            }).then(function() {
                htmlClone = $dialContainer.html();
            });
        }

        function fillDestinations(obj) {
            return new Promise(async function(resolve, reject) {
                try {
                    if (obj.list !== undefined && obj.list[obj.selected] !== undefined) {

                        // dst_option_id
                        await getList({
                            el: $body.find('[name="'+ obj.dst_option_id +'"]:eq(' + obj.elNo + ')'),
                            list: result['dst_option_id'],
                            itemVal: obj.list[obj.selected][obj.dst_option_id],
                            id: 'dst_option_id',
                            name: 'name'
                        });

                        // dst_option_sub_id -> if value of dst_option_sub_id is not null
                        if (obj.list[obj.selected][obj.dst_option_sub_id] !== undefined && obj.list[obj.selected][obj.dst_option_sub_id] !== '') {
                            await getList({
                                el: $body.find('[name="'+ obj.dst_option_sub_id +'"]:eq(' + obj.elNo + ')'),
                                list: $.grep(result['dst_option_id'], function(v) {
                                    return v['dst_option_id'] === $body.find('[name="'+ obj.dst_option_id +'"]:eq(' + obj.elNo + ')').val();
                                }).pop().child,
                                itemVal: obj.list[obj.selected][obj.dst_option_sub_id],
                                id: 'id',
                                name: 'name'
                            });
                        } else {
                            $body.find('[name="'+ obj.dst_option_sub_id +'"]:eq(' + obj.elNo + ')').html('');
                            $body.find('[name="'+ obj.dst_option_sub_id +'"]:eq(' + obj.elNo + ')').parent().hide();
                        }

                        // DSTOption -> if value of DSTOption is not null
                        if (obj.list[obj.selected][obj.DSTOption] !== null && obj.list[obj.selected][obj.DSTOption] !== "") {
                            let DSTOption_dst_option_sub_id = $.grep(result['dst_option_id'], function(v) {
                                return v.dst_option_id === $body.find('[name="'+obj.dst_option_id+'"]:eq(' + obj.elNo + ')').val();
                            }).pop().child;

                            let DSTOption = $.grep(DSTOption_dst_option_sub_id, function(v) {
                                return v.id === $body.find('[name="'+ obj.dst_option_sub_id +'"]:eq(' + obj.elNo + ')').val();
                            }).pop();

                            if (DSTOption !== undefined) {
                                await getList({
                                    el: $body.find('[name="'+ obj.DSTOption +'"]:eq(' + obj.elNo + ')'),
                                    list: DSTOption.child,
                                    itemVal: obj.list[obj.selected][obj.DSTOption],
                                    id: 'id',
                                    name: 'name'
                                });
                            }
                        } else {
                            $body.find('[name="'+ obj.DSTOption +'"]:eq(' + obj.elNo + ')').html('');
                            $body.find('[name="'+ obj.DSTOption +'"]:eq(' + obj.elNo + ')').parent().hide();
                        }

                        resolve(true);

                    } else {
                        getList({
                            el: $body.find('[name="dst_option_id"]'),
                            list: result['dst_option_id'],
                            itemVal: '',
                            id: 'dst_option_id',
                            name: 'name'
                        }).then(function() {
                            $body.find('[name="dst_option_sub_id"]').parent('.form-group').hide();
                            $body.find('[name="DSTOption"]').parent('.form-group').hide();
                        });

                        getList({
                            el: $body.find('[name="fdst_option_id"]'),
                            list: result['dst_option_id'],
                            itemVal: '',
                            id: 'dst_option_id',
                            name: 'name'
                        }).then(function() {
                            $body.find('[name="fdst_option_sub_id"]').parent('.form-group').hide();
                            $body.find('[name="fDSTOption"]').parent('.form-group').hide();
                        });

                        resolve(true);
                    }
                } catch(e) {
                    reject(true);
                }
            });
        }

        function getList(obj) {
            return new Promise(function(resolve) {
                try {
                    if (obj.el.prop('tagName') === 'SELECT') {
                        let html = '';

                        if (obj.list !== undefined && obj.list.length) {
                            $.each(obj.list, function(i, v) {
                                html += '<option '+(parseInt(v[obj.id]) === parseInt(obj.itemVal) ? 'selected' : '')+' value="'+ v[obj.id] +'">'+ v[obj.name] +'</option>';
                            });

                            obj.el.html(html).trigger('change');

                        } else {
                            obj.el.val(obj.itemVal).trigger('change');
                        }
                    } else {
                        obj.el.val(obj.itemVal);
                    }

                    resolve(true);
                } catch(e) {
                    console.log('error in put list in ', obj.el, e);
                }
            });
        }

        $body.on('change', '[name="dst_option_id"]', function() {
            let $this = $(this),
                itemVal = $this.val(),
                $selectContainer = $this.parents('.row.dialExtensionGroup'),
                $el = $selectContainer.find('[name="dst_option_sub_id"]'),
                $elDstOptionFormGroup = $selectContainer.find('[name="DSTOption"]').parent(),
                $elFormGroup = $el.parent('.form-group');

            try {
                let list = $.grep(result['dst_option_id'], function (v) {
                    return v.dst_option_id === itemVal;
                }).pop().child;

                if (list !== null && list !== undefined && list.length) {
                    let html = '';
                    $.each(list, function(i, v) {
                        html += '<option value="'+ v.id +'" '+(v.id === itemVal ? 'selected' : '')+'>'+ v.name + '</option>'
                    });

                    $elFormGroup.show();
                    $elDstOptionFormGroup.hide();
                    $selectContainer.find('[name="DSTOption"]').html('');
                    $el.html(html).trigger('change');
                } else {
                    $selectContainer.find('[name="DSTOption"]').html('');
                    $el.html('');
                    $elDstOptionFormGroup.hide();
                    $elFormGroup.hide();
                }
            } catch(e) {
                console.log('error in change dst_option_sub_id: ', e);
            }
        });

        $body.on('change', '[name="dst_option_sub_id"]', function() {
            let $this = $(this),
                itemVal = $this.val(),
                $selectContainer = $this.parents('.row.dialExtensionGroup'),
                destinationVal = $selectContainer.find('[name="dst_option_id"]').val(),
                $el = $selectContainer.find('[name="DSTOption"]'),
                $elFormGroup = $el.parent('.form-group');

            try {
                let parentList = $.grep(result['dst_option_id'], function(v) {
                    return v.dst_option_id === destinationVal;
                }).pop().child;

                if (!parentList.length) {
                    $el.html('');
                    $elFormGroup.hide();
                } else {
                    let list = $.grep(parentList, function(v) {
                        return v.id === itemVal;
                    }).pop().child;

                    let html = '';
                    if (list !== null && list !== undefined && list.length) {
                        $.each(list, function(i, v) {
                            html += '<option value="'+ v.id +'" '+(v.id === itemVal ? 'selected' : '')+'>'+ v.name +'</option>'
                        });

                        $elFormGroup.html('');
                        $elFormGroup.html('<select class="select2" name="DSTOption"></select>');
                        $elFormGroup.show();
                        $selectContainer.find('[name="DSTOption"]').html(html).trigger('change').select2();
                    } else if (destinationVal === '9' && itemVal === '2') {
                        html = '<input class="form-control" name="DSTOption" required>';
                        $elFormGroup.html(html);
                        $elFormGroup.show();
                    } else {
                        $elFormGroup.hide();
                    }
                }
            } catch(e) {
                console.log('error in change DSTOption: ', e);
            }
        });

        $body.on('change', '[name="fdst_option_id"]', function() {
            let $this = $(this),
                itemVal = $this.val(),
                $selectContainer = $this.parents('.row.dialExtensionFailedGroup'),
                $el = $selectContainer.find('[name="fdst_option_sub_id"]'),
                $elDstOptionFormGroup = $selectContainer.find('[name="fDSTOption"]').parent(),
                $elFormGroup = $el.parent('.form-group');

            try {
                let list = $.grep(result['fdst_option_id'], function (v) {
                    return v.dst_option_id === itemVal;
                }).pop().child;

                if (list !== null && list !== undefined && list.length) {
                    let html = '';
                    $.each(list, function(i, v) {
                        html += '<option value="'+ v.id +'" '+(v.id === itemVal ? 'selected' : '')+'>'+ v.name + '</option>'
                    });

                    $elFormGroup.show();
                    $elDstOptionFormGroup.hide();
                    $selectContainer.find('[name="fDSTOption"]').html('');
                    $el.html(html).trigger('change');
                } else {
                    $selectContainer.find('[name="fDSTOption"]').html('');
                    $el.html('');
                    $elDstOptionFormGroup.hide();
                    $elFormGroup.hide();
                }
            } catch(e) {
                console.log('error in change fdst_option_sub_id: ', e);
            }
        });

        $body.on('change', '[name="fdst_option_sub_id"]', function() {
            let $this = $(this),
                itemVal = $this.val(),
                $selectContainer = $this.parents('.row.dialExtensionFailedGroup'),
                destinationVal = $selectContainer.find('[name="fdst_option_id"]').val(),
                $el = $selectContainer.find('[name="fDSTOption"]'),
                $elFormGroup = $el.parent('.form-group');

            try {
                let parentList = $.grep(result['fdst_option_id'], function(v) {
                    return v.dst_option_id === destinationVal;
                }).pop().child;

                if (!parentList.length) {
                    $el.html('');
                    $elFormGroup.hide();
                } else {
                    let list = $.grep(parentList, function(v) {
                        return v.id === itemVal;
                    }).pop().child;

                    let html = '';
                    if (list !== null && list !== undefined && list.length) {
                        $.each(list, function(i, v) {
                            html += '<option value="'+ v.id +'" '+(v.id === itemVal ? 'selected' : '')+'>'+ v.name +'</option>'
                        });

                        $elFormGroup.html('');
                        $elFormGroup.html('<select class="select2" name="fDSTOption"></select>');
                        $elFormGroup.show();
                        $selectContainer.find('[name="fDSTOption"]').html(html).trigger('change').select2();
                    } else if (destinationVal === '9' && itemVal === '2') {
                        html = '<input class="form-control" name="fDSTOption">';
                        $elFormGroup.html(html);
                        $elFormGroup.show();
                    } else {
                        $elFormGroup.hide();
                    }
                }
            } catch(e) {
                console.log('error in change fDSTOption: ', e);
            }
        });

        let cnt = 1;
        $body.on('click', '.clone-condition', function (e) {
            e.preventDefault();

            let $clone = $($(htmlClone)[0]),
                id = $clone.attr('id'),
                data_collapse = $clone.find('.collapse-panel').attr('data-collapse');

            $clone.find('.condition-no').html(++cnt);
            $clone.attr('id', id + cnt);
            $clone.find('.collapse-panel').attr('data-collapse', data_collapse + cnt);
            $clone.attr('data-boxid', cnt);

            $dialContainer.append($clone);

            $body.find('.select2-container.select2').remove();
            $body.find('.select2-offscreen').removeClass('select2-offscreen');
            $body.find('select').select2();

            $body.find('[data-input="timepicker"]').each(function() {
                let $this = $(this);

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

            let length = $('.dial-container').find('> .panel').length;

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
            let counter = 0;

            $dialContainer.find('> .panel').each(function () {
                $(this).find('.condition-no').html(++counter);
                $(this).attr('data-boxid', counter);
            });

            $body.find('.FDialExtension').attr('id', counter);
        }

        $('#timeCondition').on('submit', function(e) {
            e.preventDefault();

            let cntErr = 0,
                data = {
                    name: '',
                    tc: [],
                    failTc: []
                };

            if (!$body.find('[name="name"]').val().length) {
                cntErr++;
            } else {
                data.name = $body.find('[name="name"]').val();
            }

            // all elements in each panel for success time condition and destination
            $body.find('.dial-container > .panel').each(function() {
                let inputs = {
                    dst_option_id_selected: {}
                };

                $(this).find('.normal-data [name]').each(function() {
                    if ($(this).val() !== null && $(this).prop('required') && !$(this).val().length) {
                        cntErr++;
                    } else if($(this).attr('data-name') === 'start' && $(this).val().length){
                        if(!$(this).parents('.row').find('[data-name="end"]').val().length) {
                            cntErr++;
                        }
                    }

                    inputs[$(this).attr('name')] = $(this).val();
                });

                $(this).find('.destination-holder').each(function() {
                    let dataTmp = {};

                    $(this).find('input, select').each(function() {
                        if ($(this).attr('name') !== undefined) {
                            if ($(this).val() !== null && $(this).prop('required') && !$(this).val().length) {
                                cntErr++;
                            }

                            dataTmp[$(this).attr('name')] = $(this).val();
                        }
                    });

                    inputs.dst_option_id_selected = dataTmp;
                });

                data.tc.push(inputs);
            });

            // fail destination information
            $body.find('.fdestination-holder .row').each(function() {
                let dataTmp = {};

                $(this).find('input, select').each(function() {
                    if ($(this).attr('name') !== undefined) {
                        if ($(this).val() !== null && $(this).prop('required') && !$(this).val().length) {
                            cntErr++;
                        }

                        dataTmp[$(this).attr('name')] = $(this).val();
                    }
                });

                data.failTc.push(dataTmp);
            });

            // fetch all hidden fields
            $body.find('[type="hidden"]').each(function() {
                if ($(this).val().length) {
                    data[$(this).attr('name')] = $(this).val();
                }
            });

            if(cntErr) {
                swal({
                    title: '',
                    html: "Please fill required items",
                    type: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonClass: 'btn btn-warning btn-block'
                });
            } else {
                $.httpRequest(result['url'] + '?action=' + result['action'], 'POST', data, false, true)
                    .then(function(response) {
                        let resp = JSON.parse(response);

                        if (parseInt(resp.result) === 1) {
                            swal({
                                title: '',
                                html: resp.msg,
                                type: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonClass: 'btn btn-success btn-block'
                            }).then(function() {
                                if (result['is_extension']) {
                                    window.location.replace('<?php echo RELA_DIR; ?>extension.php?action=showTimeCondition&id='+result['extension_id']);
                                } else {
                                    window.location.replace('<?php echo RELA_DIR; ?>'+result['url']);
                                }
                            });
                        } else if (parseInt(resp.result) === -1) {
                            swal({
                                title: '',
                                html: resp.msg,
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

        /*
         | ------------------------------------------------------------------------------------------------
         |  RECORD VOICE
         | ------------------------------------------------------------------------------------------------
         */
        /*function restore(){
            $("#record, #live").removeClass("disabled");
            $("#pause").replaceWith('<a class="one" id="pause" style="text-decoration: none"><i class="fa fa-pause button" aria-hidden="true"></i></a>');
            $(".one").addClass("disabled");
            Fr.voice.stop();
        }

        $body.on("click", ".record:not(.disabled)", function () {
            RecordID = $(this).attr('id');
            let classValue = $(this).attr('class');
            let elem = $(this);

            Fr.voice.record($("#live").is(":checked"), function(){
                elem.addClass("disabled");
                $("#live").addClass("disabled");

                $("."+RecordID+"_one").removeClass("disabled");

                let analyser = Fr.voice.context.createAnalyser();
                analyser.fftSize = 2048;
                analyser.minDecibels = -90;
                analyser.maxDecibels = -10;
                analyser.mdoothingTimeConstant = 0.85;
                Fr.voice.input.connect(analyser);

                let bufferLength = analyser.frequencyBinCount;
                let dataArray = new Uint8Array(bufferLength);

                let WIDTH = 200, HEIGHT = 100;
                let canvasCtx = $("#" + RecordID + "_level")[0].getContext("2d");
                canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);

                function draw() {
                    let drawVisual = requestAnimationFrame(draw);
                    analyser.getByteTimeDomainData(dataArray);
                    canvasCtx.fillStyle = 'rgb(200, 200, 200)';
                    canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);
                    canvasCtx.lineWidth = 2;
                    canvasCtx.strokeStyle = 'rgb(0, 0, 0)';

                    canvasCtx.beginPath();
                    let sliceWidth = (WIDTH * 1.0) / bufferLength;
                    let x = 0;
                    for (let i = 0; i < bufferLength; i++) {
                        let v = dataArray[i] / 128.0;
                        let y = v * HEIGHT/2;

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
            let $audio = $("#audio");
            Fr.voice.export(function(url){
                $audio.attr("src", url);
                $audio[0].play();
            }, "URL");

            restore();
        });

        $body.on("click", "#save:not(.disabled)", function (e) {
            e.preventDefault();

            let id = RecordID.replace('record_', '');
            let forwardID = '#' + id + '-1';
            let DSTOption = '#' + id + '-2';
            let status = $(DSTOption).data('status');
            let tag = $('<option value="customMessageByList" selected="selected">customMessageByList</option>');
            let voiceTitle = $('#voiceTitle'+id).val();
            let url = "mainTimeCondition.php?action=saveVoice&status="+status+"&voiceTitle="+voiceTitle;

            Fr.voice.export(function(blob){
                let formData = new FormData();
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

        */
    });
</script>
