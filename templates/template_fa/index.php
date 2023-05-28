<?php
global $member_info, $admin_info;
?>
<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-right">
            <li>
                <a class="text-20 margin-bottom dashboard-heading"><?= INDEX_002; ?></a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->

    <div class="content-body" >

        <div class="row xsmallSpace"></div>

        <div class="row margin-bottom">
            <?php if ($admin_info != -1) { ?>
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="panel panel-default box-items main-page theme-teal full-width">
                        <a class="link-block"
                                rel="tooltip" data-original-title="<?= MORE ?>" data-placement="bottom"
                                href="<?= RELA_DIR . 'announce.php?action=showAnnounce' ?>">
                            <i class="fa fa-gear item-center text-32"></i>
                            <div class="panel-body">
                                <h2 class="text-center text-normal text-midnight no-margin"><?= INDEX_011 ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="panel panel-default box-items main-page theme-midnight full-width">
                        <a class="link-block"
                                rel="tooltip" data-original-title="<?= MORE ?>" data-placement="bottom"
                                href="<?php echo RELA_DIR . 'mainTimeCondition.php' ?>">
                            <i class="fa fa-clock-o item-center text-32"></i>
                            <div class="panel-body">
                                <h2 class="text-center text-normal text-midnight no-margin"><?= RIGHTMENU_36 ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="panel panel-default box-items main-page theme-pink full-width">
                        <a class="link-block"
                                rel="tooltip" data-original-title="<?= MORE ?>" data-placement="bottom"
                                href="<?= (isset($member_info) and is_array($member_info)) ? RELA_DIR . 'extension.php?action=editExtension&id=' . $member_info['extension_id'] : RELA_DIR . 'extension.php?action=showExtensions'; ?>">
                            <i class="fa fa-phone item-center text-32"></i>
                            <div class="panel-body">
                                <h2 class="text-center text-normal text-midnight no-margin"><?= RIGHTMENU_05 ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="panel panel-default box-items main-page theme-light-green full-width">
                        <a class="link-block"
                                rel="tooltip" data-original-title="<?= MORE ?>" data-placement="bottom"
                                href="<?= RELA_DIR . 'upload.php?action=showUploads' ?>">
                            <i class="fa fa-play-circle-o item-center text-32"></i>
                            <div class="panel-body">
                                <h2 class="text-center text-normal text-midnight no-margin"><?= RIGHTMENU_06 ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="panel panel-default box-items main-page theme-purple full-width">
                        <a class="link-block"
                                rel="tooltip" data-original-title="<?= MORE ?>" data-placement="bottom"
                                href="<?= RELA_DIR . 'ivr.php?action=showIvr' ?>">
                            <i class="fa fa-list-ol item-center text-32"></i>
                            <div class="panel-body">
                                <h2 class="text-center text-normal text-midnight no-margin"><?= RIGHTMENU_07 ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="panel panel-default box-items main-page theme-dark-red full-width">
                        <a class="link-block"
                                rel="tooltip" data-original-title="<?= MORE ?>" data-placement="bottom"
                                href="<?= RELA_DIR . 'queue.php?action=showQueues' ?>">
                            <i class="fa fa-sort-amount-desc item-center text-32"></i>
                            <div class="panel-body">
                                <h2 class="text-center text-normal text-midnight no-margin"><?= RIGHTMENU_08 ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="panel panel-default box-items main-page theme-orange full-width">
                        <a class="link-block"
                                rel="tooltip" data-original-title="<?= MORE ?>" data-placement="bottom"
                                href="<?= RELA_DIR . 'sip.php?action=showSip' ?>">
                            <i class="fa fa-gear item-center text-32"></i>
                            <div class="panel-body">
                                <h2 class="text-center text-normal text-midnight no-margin"><?= OUTBOUND_05 ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="panel panel-default box-items main-page theme-brown full-width">
                        <a class="link-block"
                                rel="tooltip" data-original-title="<?= MORE ?>" data-placement="bottom"
                                href="<?= RELA_DIR . 'inbound.php?action=showInbound' ?>">
                            <i class="fa fa-sign-in fa-rotate-180 item-center text-32"></i>
                            <div class="panel-body">
                                <h2 class="text-center text-normal text-midnight no-margin"><?= RIGHTMENU_09 ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="panel panel-default box-items main-page theme-green full-width">
                        <a class="link-block"
                                rel="tooltip" data-original-title="<?= MORE ?>" data-placement="bottom"
                                href="<?= RELA_DIR . 'outbound.php?action=showOutbound' ?>">
                            <i class="fa fa-sign-in item-center text-32"></i>
                            <div class="panel-body">
                                <h2 class="text-center text-normal text-midnight no-margin"><?= RIGHTMENU_10 ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="panel panel-default box-items main-page theme-light-blue full-width">
                        <a class="link-block"
                                rel="tooltip" data-original-title="<?= MORE ?>" data-placement="bottom"
                                href="<?= RELA_DIR . 'conference.php?action=showConference' ?>">
                            <i class="fa fa-users item-center text-32"></i>
                            <div class="panel-body">
                                <h2 class="text-center text-normal text-midnight no-margin"><?= RIGHTMENU_38 ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } elseif ($member_info != -1) { ?>
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="panel panel-default box-items main-page theme-pink full-width">
                        <a class="link-block"
                                rel="tooltip" data-original-title="<?= MORE ?>" data-placement="bottom"
                                href="<?= RELA_DIR . 'extension.php';?>">
                            <i class="fa fa-gear item-center text-32"></i>
                            <div class="panel-body">
                                <h2 class="text-center text-normal text-midnight no-margin"><?= RIGHTMENU_05 ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php /*
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                <!-- Tables  -->
                <div id="panel-table1" class="panel panel-default">
                    <div class="panel-heading bg-default">
                        <h3 class="panel-title"><?= INDEX_003 ?></h3>
                    </div><!-- /panel-heading -->

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="column-drillDown2" style="min-width: 310px; height: 300px; margin: 0 auto; direction: ltr !important;"></div>
                            </div>
                        </div>

                    </div><!-- /panel-body -->
                </div><!--/panel-table-->
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                <!-- Tables  -->
                <div id="panel-table" class="panel panel-default">
                    <div class="panel-heading bg-default">
                        <h3 class="panel-title"><?= INDEX_004 ?></h3>
                    </div><!-- /panel-heading -->

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="pie" style="min-width: 310px; height: 300px; max-width: 600px; margin: 0 auto;direction:ltr !important"></div>
                            </div>
                        </div>

                    </div><!-- /panel-body -->
                </div><!--/panel-table-->
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                <!-- Tables  -->
                <div id="panel-table" class="panel panel-default">
                    <div class="panel-heading bg-default">
                        <h3 class="panel-title"><?= INDEX_003 ?></h3>
                    </div><!-- /panel-heading -->

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="column-drillDown" style="min-width: 310px; height: 300px; margin: 0 auto; direction: ltr !important;"></div>
                            </div>
                        </div>

                    </div><!-- /panel-body -->
                </div><!--/panel-table-->
            </div>
        </div>
        */?>
        <?php //print_r_debug($list) ?>
        <?php /*
        <a class="text-20 dashboard-heading margin-bottom"><?=INDEX_007?></a>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <!-- Tables  -->
                <div id="panel-table" class="panel panel-default">
                    <div class="panel-heading bg-default">
                        <h3 class="panel-title"><?=INDEX_008?></h3>
                    </div><!-- /panel-heading -->

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Camp1</a></li>
                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Camp2</a></li>
                                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Camp3</a></li>
                                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Camp4</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home"> <div id="pie2" style="min-width: 310px; height: 300px; max-width: 600px; margin: 0 auto;direction:ltr !important"></div></div>
                                    <div role="tabpanel" class="tab-pane" id="profile">...</div>
                                    <div role="tabpanel" class="tab-pane" id="messages">...</div>
                                    <div role="tabpanel" class="tab-pane" id="settings">...</div>
                                </div>

                            </div>
                        </div>
                    </div><!-- /panel-body -->
                </div><!--/panel-table-->
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <!-- Tables  -->
                <div id="panel-table" class="panel panel-default">
                    <div class="panel-heading bg-default">
                        <h3 class="panel-title"><?=INDEX_008?></h3>
                    </div><!-- /panel-heading -->

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="line-labels" style="min-width: 310px; height: 300px; margin: 0 auto;direction:ltr !important"></div>
                            </div>
                        </div>
                        <div class="row smallSpace"></div>

                    </div><!-- /panel-body -->
                </div><!--/panel-table-->
            </div>
        </div> */ ?>
    </div><!--/content-body -->
</div>

<script>
    $(function () {
        // Build the chart
        $('#pie').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [
                    <?php if($list['cdr']['ANSWERED'] != ''){?>
                    {
                        color: '#1DCCC0',
                        name: 'ANSWERED',
                        y: <?php echo $list['cdr']['ANSWERED']?>,
                        sliced: true,
                        selected: true
                    },
                    <?php }?>
                    <?php if($list['cdr']['ANSWERED'] != ''){?>
                    {
                        color: '#58B9D6',
                        name: 'BUSY',
                        y: <?php echo $list['cdr']['BUSY']?>,
                        selected: true
                    },
                    <?php }?>
                    <?php if($list['cdr']['ANSWERED'] != ''){?>
                    {
                        color: '#FF9800',
                        name: 'FAILED',
                        y: <?php echo $list['cdr']['FAILED']?>,
                        selected: true
                    },
                    <?php }?>
                    <?php if($list['cdr']['ANSWERED'] != ''){?>
                    {
                        color: '#A75BB1',
                        name: 'NO ANSWER',
                        y: <?php echo $list['cdr']['NO ANSWER']?>
                    }
                    <?php }?>
                ]
            }]
        });

        // Create the chart
        $('#column-drillDown').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Number of Established Calls'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },


            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [
                    <?php if($list['extension'][0]['clid'] != ''){?>
                    {
                        color: '#1DCCC0',
                        name: '<?=$list['extension'][0]['clid']?>',
                        y:<?=$list['extension'][0]['count']?>
                    },
                    <?php }?>
                    <?php if($list['extension'][1]['clid'] != ''){?>
                    {
                        color: '#A75BB1',
                        name: '<?=$list['extension'][1]['clid']?>',
                        y:<?=$list['extension'][1]['count']?>
                    },
                    <?php }?>
                    <?php if($list['extension'][2]['clid'] != ''){?>
                    {
                        color: '#FF9800',
                        name: '<?=$list['extension'][2]['clid']?>',
                        y:<?=$list['extension'][2]['count']?>
                    },
                    <?php }?>
                    <?php if($list['extension'][3]['clid'] != ''){?>
                    {
                        name: '<?=$list['extension'][3]['clid']?>',
                        y:<?=$list['extension'][3]['count']?>
                    }
                    <?php }?>
                ]
            }],
            /*drilldown: {
             series: [{
             name: 'Microsoft Internet Explorer',
             id: 'Microsoft Internet Explorer',
             data: [
             [
             'v11.0',
             24.13
             ],
             [
             'v8.0',
             17.2
             ],
             [
             'v9.0',
             8.11
             ],
             [
             'v10.0',
             5.33
             ],
             [
             'v6.0',
             1.06
             ],
             [
             'v7.0',
             0.5
             ]
             ]
             }, {
             name: 'Chrome',
             id: 'Chrome',
             data: [
             [
             'v40.0',
             5
             ],
             [
             'v41.0',
             4.32
             ],
             [
             'v42.0',
             3.68
             ],
             [
             'v39.0',
             2.96
             ],
             [
             'v36.0',
             2.53
             ],
             [
             'v43.0',
             1.45
             ],
             [
             'v31.0',
             1.24
             ],
             [
             'v35.0',
             0.85
             ],
             [
             'v38.0',
             0.6
             ],
             [
             'v32.0',
             0.55
             ],
             [
             'v37.0',
             0.38
             ],
             [
             'v33.0',
             0.19
             ],
             [
             'v34.0',
             0.14
             ],
             [
             'v30.0',
             0.14
             ]
             ]
             }, {
             name: 'Firefox',
             id: 'Firefox',
             data: [
             [
             'v35',
             2.76
             ],
             [
             'v36',
             2.32
             ],
             [
             'v37',
             2.31
             ],
             [
             'v34',
             1.27
             ],
             [
             'v38',
             1.02
             ],
             [
             'v31',
             0.33
             ],
             [
             'v33',
             0.22
             ],
             [
             'v32',
             0.15
             ]
             ]
             }, {
             name: 'Safari',
             id: 'Safari',
             data: [
             [
             'v8.0',
             2.56
             ],
             [
             'v7.1',
             0.77
             ],
             [
             'v5.1',
             0.42
             ],
             [
             'v5.0',
             0.3
             ],
             [
             'v6.1',
             0.29
             ],
             [
             'v7.0',
             0.26
             ],
             [
             'v6.2',
             0.17
             ]
             ]
             }, {
             name: 'Opera',
             id: 'Opera',
             data: [
             [
             'v12.x',
             0.34
             ],
             [
             'v28',
             0.24
             ],
             [
             'v27',
             0.17
             ],
             [
             'v29',
             0.16
             ]
             ]
             }]
             }*/
        });

        // Create the chart
        $('#column-drillDown2').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Number of Established Calls'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,

                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
            },


            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [
                    <?php if($list['extensionTiming'][0] != ''){?>
                    {
                        color: '#FF9800',
                        name: '<?='08-16'?>',
                        y:<?=$list['extensionTiming'][0]?>
                    },
                    <?php }?>
                    <?php if($list['extensionTiming'][1] != ''){?>
                    {
                        color: '#58B9D6',
                        name: '<?='16-24'?>',
                        y:<?=$list['extensionTiming'][1]?>
                    },
                    <?php }?>
                    <?php if($list['extensionTiming'][2] != ''){?>
                    {
                        color: '#A75BB1',
                        name: '<?='00-08'?>',
                        y:<?=$list['extensionTiming'][2]?>
                    }
                    <?php }?>
                ]
            }],
            /*drilldown: {
             series: [{
             name: 'Microsoft Internet Explorer',
             id: 'Microsoft Internet Explorer',
             data: [
             [
             'v11.0',
             24.13
             ],
             [
             'v8.0',
             17.2
             ],
             [
             'v9.0',
             8.11
             ],
             [
             'v10.0',
             5.33
             ],
             [
             'v6.0',
             1.06
             ],
             [
             'v7.0',
             0.5
             ]
             ]
             }, {
             name: 'Chrome',
             id: 'Chrome',
             data: [
             [
             'v40.0',
             5
             ],
             [
             'v41.0',
             4.32
             ],
             [
             'v42.0',
             3.68
             ],
             [
             'v39.0',
             2.96
             ],
             [
             'v36.0',
             2.53
             ],
             [
             'v43.0',
             1.45
             ],
             [
             'v31.0',
             1.24
             ],
             [
             'v35.0',
             0.85
             ],
             [
             'v38.0',
             0.6
             ],
             [
             'v32.0',
             0.55
             ],
             [
             'v37.0',
             0.38
             ],
             [
             'v33.0',
             0.19
             ],
             [
             'v34.0',
             0.14
             ],
             [
             'v30.0',
             0.14
             ]
             ]
             }, {
             name: 'Firefox',
             id: 'Firefox',
             data: [
             [
             'v35',
             2.76
             ],
             [
             'v36',
             2.32
             ],
             [
             'v37',
             2.31
             ],
             [
             'v34',
             1.27
             ],
             [
             'v38',
             1.02
             ],
             [
             'v31',
             0.33
             ],
             [
             'v33',
             0.22
             ],
             [
             'v32',
             0.15
             ]
             ]
             }, {
             name: 'Safari',
             id: 'Safari',
             data: [
             [
             'v8.0',
             2.56
             ],
             [
             'v7.1',
             0.77
             ],
             [
             'v5.1',
             0.42
             ],
             [
             'v5.0',
             0.3
             ],
             [
             'v6.1',
             0.29
             ],
             [
             'v7.0',
             0.26
             ],
             [
             'v6.2',
             0.17
             ]
             ]
             }, {
             name: 'Opera',
             id: 'Opera',
             data: [
             [
             'v12.x',
             0.34
             ],
             [
             'v28',
             0.24
             ],
             [
             'v27',
             0.17
             ],
             [
             'v29',
             0.16
             ]
             ]
             }]
             }*/
        });

        /*$('#gauge1').highcharts({
         chart: {
         type: 'gauge',
         plotBackgroundColor: null,
         plotBackgroundImage: null,
         plotBorderWidth: 0,
         plotShadow: false
         },

         title: {
         text: 'CPU usage'
         },

         pane: {
         startAngle: -150,
         endAngle: 150,
         background: [{
         backgroundColor: {
         linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
         stops: [
         [0, '#FFF'],
         [1, '#333']
         ]
         },
         borderWidth: 0,
         outerRadius: '109%'
         }, {
         backgroundColor: {
         linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
         stops: [
         [0, '#333'],
         [1, '#FFF']
         ]
         },
         borderWidth: 1,
         outerRadius: '107%'
         }, {
         // default background
         }, {
         backgroundColor: '#DDD',
         borderWidth: 0,
         outerRadius: '105%',
         innerRadius: '103%'
         }]
         },

         // the value axis
         yAxis: {
         min: 0,
         max: 100,

         minorTickInterval: 'auto',
         minorTickWidth: 1,
         minorTickLength: 10,
         minorTickPosition: 'inside',
         minorTickColor: '#666',

         tickPixelInterval: 30,
         tickWidth: 2,
         tickPosition: 'inside',
         tickLength: 10,
         tickColor: '#666',
         labels: {
         step: 2,
         rotation: 'auto'
         },
         title: {
         text: '%'
         },
         plotBands: [{
         from: 0,
         to: 33,
         color: '#55BF3B' // green
         }, {
         from: 33,
         to: 66,
         color: '#DDDF0D' // yellow
         }, {
         from: 66,
         to: 100,
         color: '#DF5353' // red
         }]
         },

         series: [{
         name: 'Speed',
         data: [80],
         tooltip: {
         valueSuffix: 'percentage'
         }
         }]

         },
         // Add some life
         function (chart) {
         if (!chart.renderer.forExport) {
         setInterval(function () {
         var point = chart.series[0].points[0],
         newVal,
         inc = Math.round((Math.random() - 0.5) * 20);

         newVal = point.y + inc;
         if (newVal < 0 || newVal > 100) {
         newVal = point.y - inc;
         }

         point.update(newVal);

         }, 3000);
         }
         });


         $('#gauge2').highcharts({
         chart: {
         type: 'gauge',
         plotBackgroundColor: null,
         plotBackgroundImage: null,
         plotBorderWidth: 0,
         plotShadow: false
         },

         title: {
         text: 'RAM usage'
         },

         pane: {
         startAngle: -150,
         endAngle: 150,
         background: [{
         backgroundColor: {
         linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
         stops: [
         [0, '#FFF'],
         [1, '#333']
         ]
         },
         borderWidth: 0,
         outerRadius: '109%'
         }, {
         backgroundColor: {
         linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
         stops: [
         [0, '#333'],
         [1, '#FFF']
         ]
         },
         borderWidth: 1,
         outerRadius: '107%'
         }, {
         // default background
         }, {
         backgroundColor: '#DDD',
         borderWidth: 0,
         outerRadius: '105%',
         innerRadius: '103%'
         }]
         },

         // the value axis
         yAxis: {
         min: 0,
         max: 100,

         minorTickInterval: 'auto',
         minorTickWidth: 1,
         minorTickLength: 10,
         minorTickPosition: 'inside',
         minorTickColor: '#666',

         tickPixelInterval: 30,
         tickWidth: 2,
         tickPosition: 'inside',
         tickLength: 10,
         tickColor: '#666',
         labels: {
         step: 2,
         rotation: 'auto'
         },
         title: {
         text: '%'
         },
         plotBands: [{
         from: 0,
         to: 33,
         color: '#55BF3B' // green
         }, {
         from: 33,
         to: 66,
         color: '#DDDF0D' // yellow
         }, {
         from: 66,
         to: 100,
         color: '#DF5353' // red
         }]
         },

         series: [{
         name: 'Speed',
         data: [80],
         tooltip: {
         valueSuffix: 'percentage'
         }
         }]

         },
         // Add some life
         function (chart) {
         if (!chart.renderer.forExport) {
         setInterval(function () {
         var point = chart.series[0].points[0],
         newVal,
         inc = Math.round((Math.random() - 0.5) * 20);

         newVal = point.y + inc;
         if (newVal < 0 || newVal > 100) {
         newVal = point.y - inc;
         }

         point.update(newVal);

         }, 3000);
         }
         });*/
    });
</script>