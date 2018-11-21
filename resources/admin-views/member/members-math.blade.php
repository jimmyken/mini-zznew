@extends('admin::layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">会员概述</h3>

                </div>
                <form id="post-form" class="form-horizontal" action="#" method="post" enctype="multipart/form-data" pjax-container>
                    <div class="box-body">
                        <div class="fields-group">
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">昨日新增会员</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="yesterday" name="yesterday" value="{{$yesterdaycount}} "  readonly="value"  >

                                    </div>
                                    <canvas id="my_chart-sex"  width="5" height="5"></canvas>
                                </div>

                                <label for="title" class="col-sm-2 control-label">今日新增会员</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="today" name="today" value="{{$todaycount}} "  readonly="value"  >

                                    </div>
                                    <canvas id="my_chart-age"  width="5" height="5"></canvas>
                                </div>

                                <label for="title" class="col-sm-2 control-label">过去七天新增会员</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="past" name="past" value="{{$pastcount}} "  readonly="value"  >

                                    </div>
                                </div>

                                          <canvas id="my_chart"  width="5" height="5"></canvas>



                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var sex = document.getElementById("my_chart-sex").getContext("2d");
        var age = document.getElementById("my_chart-age").getContext("2d");
        window.chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)'
        };

        var my_chart = new Chart(sex,{
            type: 'pie',
            data: {
                labels: [
                    "男",
                    "女",
                    "未知",
                ],
                datasets: [{
                    data:{{$charsex }},
                    backgroundColor: [
                        window.chartColors.blue,
                        window.chartColors.red,
                        window.chartColors.orange,

                    ],
                }]
            },
            options: {
                responsive: true,
            }
        });

        var my_chart2 = new Chart(age,{
            type: 'pie',
            data: {
                labels: [
                    "10-20",
                    "20-30",
                    '30-40',
                    '40-50',
                    '50-60',
                    "未知",
                ],
                datasets: [{
                    data: {{$charage }},
                    backgroundColor: [
                        window.chartColors.red,
                        window.chartColors.orange,
                        window.chartColors.purple,
                        window.chartColors.green,
                        window.chartColors.grey,
                        window.chartColors.yellow,

                    ],
                }]
            },
            options: {
                responsive: true,
            }
        });

    </script>
@endsection
