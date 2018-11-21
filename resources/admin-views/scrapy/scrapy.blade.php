@extends('admin::layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">设置新闻获取时间</h3>
                    <div class="box-tools">

                    </div>
                </div>
                <form id="post-form" class="form-horizontal" action="{{ route('admin::scrapy.store') }}" method="post" enctype="multipart/form-data" pjax-container>
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="fields-group">
                            <div class="form-group">
                                <label for="name" class="col-sm-1 control-label">设置每天获取新闻时间</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" id="time" placeholder="设置时间" name="time" value="{{getenv('SCRAPY_TIME')}}">
                                    </div>
                                </div>
                                <label for="name" class="col-sm-1 control-label">设置删除新闻的时间间隔（天）</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" id="day" placeholder="设置天数" name="day" value="{{getenv('SCRAPY_DAY')}}">
                                    </div>
                                </div>
                                <label for="name" class="col-sm-1 control-label">设置时间间隔获取新闻（分钟）</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" id="hour" placeholder="设置分钟" name="hour" value="{{getenv('SCRAPY_HOUR')}}">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <a href="#"  class="btn btn-yahoo btn-sm" id="refresh" role="button">
                                            <i class="fa fa-adn">获取最新新闻</i>
                                        </a>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="covers" class="col-sm-2 control-label">首页封面图</label>
                                <div class="col-sm-8">
                                    <input type="file" class="image" name="image" id="image" multiple accept="image/*">
                                    <label class="col-sm-3 control-label text-muted">建议使用750*150的图片</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="btn-group pull-left">
                            <button type="reset" class="btn btn-warning">重置</button>
                        </div>
                        <div class="btn-group pull-right">
                            <span id="prompt-info" style="color:#f00;"></span>
                            <button type="button" id="submit-btn"  class="btn btn-info pull-right" data-loading-text="<i class='fa fa-spinner fa-spin'></i> 提交">提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $('.form-history-back').on('click', function (event) {
                event.preventDefault();
                location.reload();
            });

            $('#refresh').click(function(){
                swal(
                    {
                        title: "是否爬取最新数据?爬取过程时间较长,请稍等！",
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonText: "取消",
                        cancelButtonColor: "#B9B9B9",

                        showConfirmButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "确认",
                        closeOnConfirm: false,
                        closeOnCancel: true,
                        showLoaderOnConfirm: true,
                    },
                    function () {
                        $.ajax({
                            method: 'get',
                            url: '/admin/scrapy',
                            data: {
                                _token: LA.token,
                            },
                            success: function (data) {
                                $.pjax.reload('#pjax-container');

                                if (typeof data === 'object') {
                                    if (data.status) {
                                        swal(data.message, '', 'success');
                                    } else {
                                        swal(data.message, '', 'error');
                                    }
                                }
                            }
                        });
                    }
                )
            });

            var previewConfigs = [];
            var urls = [];
            var j = {};
            j.downloadUrl = "{{  getenv('BANNER_URL')}}";
            urls.push(j.downloadUrl);


            $(".image").fileinput({
                overwriteInitial: false,
                initialPreviewAsData: true,
                browseLabel: "浏览",
                initialPreview: urls,
                showRemove: false,
                showUpload: false,
                allowedFileTypes: [
                    "image"
                ]
            });

            $("#post-form").bootstrapValidator({
                live: 'enable',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    day:{
                        validators:{
                            notEmpty:{
                                message: '请输入天数'
                            },
                            numeric:{
                                message:'天数必须是整数'
                            }
                        }
                    }
                }
            });


            $('#submit-btn').on('click', function (event) {
                var $form = $("#post-form");

                $form.bootstrapValidator('validate');
                if ($form.data('bootstrapValidator').isValid()) {
                    $form.submit();
                    swal("提交成功！","请继续操作！","success");
                }
            });

            $('#time').datetimepicker({"format":"HH:mm","locale":"zh-CN"});
            var t =setInterval(function (){
                var time= document.getElementsByTagName("audio")[0];
                if(typeof(time)!="undefined") {
                    time = time.duration;
                    time = parseInt(time);
                    var m = parseInt(time / 60);
                    var s = parseInt(time % 60);
                    if (s < 10)
                        s = '0' + s;
                    if (m < 10)
                        m = '0'+m;
                    time = m + ":" + s;
                    $('#lasttime').val(time);
                }
                else{
                    $('#lasttime').val('');
                }

            },1000);

        });
    </script>
@endsection