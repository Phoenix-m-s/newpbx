<?

?>
<div class="content active">
    <!-- content-control -->
    <div class="content-control">
        <!--control-nav-->
        <ul class="control-nav pull-left">
            <li>
                <a class="text-20"><?= QUEUE_35 ?></a>
            </li>
        </ul><!--/control-nav-->
    </div><!-- /content-control -->
    <div class="content-body">
        <div class="container">
            <div class="queue-container">

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let wsUri = "ws://sean.pbx.local:9000/Chat-Using-WebSocket-and-PHP-Socket-master(1)/server.php",
        //let wsUri = "ws://dabapbx.dabacenter.ir:9000/Chat-Using-WebSocket-and-PHP-Socket-master(1)/server.php",
            $tblBody = $('.table-body'),
            times = [],
            timersInterval,
            detailOnlinesTimer,
            websocket = new WebSocket(wsUri),
            activeQueue,
            activeIndex = -1;

        startSocket();

        function startSocket() {
            websocket.onmessage = function (callback) {
                try {
                    let result = JSON.parse(callback.data),
                        html = '';

                    activeQueue = result.message;

                    getData(activeQueue, activeIndex);

                    $.each(activeQueue, function (i, v) {
                        let active = v.countOnline ? " active" : "";

                        html += '<div class="panel panel-default box-items theme-blue show-open" data-name="'+ v.queue_ext_no +'" data-id="'+ i +'" data-queue="' + v.queue_id + '">' +
                            '<a class="link-block">' +
                            '<i class="fa fa-list-ol item-center text-24"></i>' +
                            '<div class="blink ' + active + '"></div>' +
                            '<div class="panel-body">' +
                            '<label class="margin-top text-normal text-gray">Queue name : </label>' +
                            '<h3 class="text-normal text-midnight no-margin">' + v.queue_name + '</h3>' +
                            '<label class="margin-top text-normal text-gray">Number of people on queue :</label>' +
                            '<h4 class="text-normal text-midnight no-margin">' + v.countOnline + '</h4>' +
                            '</div>' +
                            '</a>' +
                            '</div>';
                    });

                    $('.queue-container').html(html);
                } catch (e) {
                    console.log(e);
                }
            };

            websocket.onerror = function (ev) {
                swal({
                    title: '',
                    html: 'Connection refused',
                    type: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonClass: 'btn btn-danger btn-block'
                }).then(function() {
                    window.location.replace('<?php echo RELA_DIR; ?>queue.php');
                });

                $('#message_box').append("<div class=\"system_error\">Error Occurred - " + ev.data + "</div>");
            };

            websocket.onclose = function (ev) {
                $('#message_box').append("<div class=\"system_msg\">Connection Closed</div>");
            };
        }

        function getData(queue) {
            clearInterval(timersInterval);

            times = [];

            $.each(queue, function (i, v) {
                if (v.onlineList.length) {

                    let tmp = [];

                    $.each(v.onlineList, function (j, k) {
                        let objTime = {
                            position: k.position,
                            calleridnum: k.calleridnum,
                            waitingTime: k.waitingTime,
                            totalTime: secondToStandardTime(parseInt(k.waitingTime))
                        };

                        tmp.push(objTime);
                    });

                    times['queue_' + v.queue_id] = tmp;
                }
            });

            timeProcessor();
        }// end of getData

        $('body').on('click', '.show-open', function () {
            activeIndex = $(this).data('id');

            let queueId = $(this).data('queue');

            $('.modal-title').html('Queue - ' + $(this).data('name'));

            // show agents in top of modal
            let agents = activeQueue[activeIndex].agents_no.split(','),
                html1 = '';

            $.each(agents, function (i, v) {
                if (v === '') {
                    $('.agent_holder').css('display', 'none');
                } else {
                    $('.agent_holder').css('display', 'block');
                }

                html1 +=
                    '<li>' +
                    '<i class="fa fa-user" aria-hidden="true"></i>' +
                    '<p>' + v + '</p>' +
                    '</li>';
            });

            $('.agent_holder').html(html1);

            detailOnlinesTimer = setInterval(function() {
                if (times['queue_'+queueId] !== undefined && times['queue_'+queueId].length) {
                    $tblBody.html('');

                    let html = '';
                    $.each(times['queue_'+queueId], function(i,  v) {
                        html += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td class="calleridnum">'+ v.calleridnum +'</td>' +
                            '<td>' + v.position + '</td>' +
                            '<td class="time"></td>' +
                            '</tr>';
                    });

                    $tblBody.html(html);

                    $.each(times['queue_'+queueId], function(i, v) {
                        $tblBody.find('tr:nth-child('+(i+1)+') td:nth-child(4)').html(v.totalTime);
                    });
                } else {
                    let html = '<tr>' +
                        '<td class="text-center" colspan="4"> Nobody is online </td>' +
                        '</tr>';

                    $tblBody.html(html);
                }
            }, 1000);

            $('#exampleModal').modal('show');
        });

        $("#exampleModal").on("hidden.bs.modal", function () {
            $tblBody.html('');

            clearInterval(detailOnlinesTimer);
        });

        function timeProcessor() {
            timersInterval = setInterval(function() {
                $.each(Object.keys(times), function(i, v) {
                    if (times[v].length) {
                        $.each(times[v], function(j, k) {
                            times[v][j]['waitingTime'] = parseInt(times[v][j]['waitingTime']) + 1;
                            times[v][j]['totalTime'] = secondToStandardTime(times[v][j]['waitingTime']);
                        });
                    }
                });
            }, 1000);
        }

        function secondToStandardTime(sec) {
            let minutes = Math.floor(sec / 60),
                seconds = sec - minutes * 60;

            return (minutes ? (minutes < 10 ? '0' + minutes : minutes) + ':' : '00:') + (seconds < 10 ? '0' + seconds : seconds);
        }
    });

</script>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body box-online">
                <ul class="agent_holder">

                </ul>

                <table class="table table-striped user-online">
                    <thead>
                    <tr>
                        <th>number</th>
                        <th>callerId</th>
                        <th>position</th>
                        <th>time</th>
                    </tr>
                    </thead>
                    <tbody class="table-body">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>