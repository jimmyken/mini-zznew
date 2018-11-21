@extends('admin::layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">创建</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="{{ route('admin::programs.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;列表</a>
                        </div> <div class="btn-group pull-right" style="margin-right: 10px">
                            <a class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>
                <form id="post-form" class="form-horizontal" action="{{ route('admin::programs.store') }}" method="post" enctype="multipart/form-data" pjax-container>
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="fields-group">
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">节目名字</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="title" name="title" value="" class="form-control" placeholder="输入 节目名">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">节目发布时间</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" id="created_at" placeholder="发布时间" name="created_at" value="">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="covers" class="col-sm-2 control-label">节目图片</label>
                                <div class="col-sm-8">
                                    <input type="file" class="image" name="image" id="image" multiple accept="image/*">
                                    <label class="col-sm-3 control-label text-muted">建议使用等比例的图片</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="covers" class="col-sm-2 control-label">节目内容</label>
                                <div class="col-sm-8">
                                    <input type="file" class="content" name="content" id="content" multiple accept="audio/*">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="label" class="col-sm-2 control-label">节目时长</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="lasttime" name="lasttime" value="" class="form-control" readonly="true">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="category_id" class="col-sm-2 control-label">栏目</label>
                                <div class="col-sm-8">
                                    <select class="form-control category" style="width: 100%;" name="category_id" data-placeholder="选择 栏目"  >
                                        <option value="">请选择</option>
                                        @foreach($categorys as $category)
                                            <option value="{{ $category->id }}" >{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="btn-group pull-left">
                            <button type="reset" class="btn btn-warning">重置</button>
                        </div>
                        <div class="btn-group pull-right">
                            <input type="button" value="提交" id="submit-btn" class="btn btn-info pull-right"  data-loading-text="<i class='fa fa-spinner fa-spin'></i> 提交">
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
                history.back();
            });

            $(".image").fileinput({
                overwriteInitial: false,
                initialPreviewAsData: true,
                browseLabel: "浏览",
                showRemove: false,
                showUpload: false,
                allowedFileTypes: [
                    "image"
                ]
            });

            $(".content").fileinput({
                overwriteInitial: false,
                initialPreviewAsData: true,
                browseLabel: "浏览",
                showRemove: false,
                showUpload: false,
               // maxFileSize: 2048,
                allowedFileTypes: [
                    "audio"
                ]
            });


            $("#submit-btn").click(function () {
                clearTimeout(t);

                var $form = $("#post-form");

                $form.bootstrapValidator('validate');
                if ($form.data('bootstrapValidator').isValid()) {
                    $form.submit();
                }
            })

            $('#created_at').datetimepicker({"format":"YYYY-MM-DD ","locale":"zh-CN"});
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