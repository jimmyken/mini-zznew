@extends('admin::layouts.main')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">轮播图列表</h3>

                    <div class="btn-group pull-right">
                        <a href="{{ route('admin::carousels.create') }}" class="btn btn-sm btn-success">
                            <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                        </a>
                    </div>

                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>轮播图</th>
                            <th>轮播图标题</th>
                            <th>栏目链接</th>
                            <th>排序</th>
                            <th>操作</th>
                        </tr>
                        @foreach($carousels as $carousel)
                            <tr>
                                <td><img src="{{ $carousel->image }}" width="150" height="80" alt="" class="img-bordered"></td>
                                <td>{{ $carousel->title }}</td>
                                <td><span class="badge bg-red">{{$carousel->category->title}}</span></td>
                                <td>{{$carousel->sort}}</td>
                                <td>
                                    <a href="{{ route('admin::carousels.edit', $carousel->id) }}" class="btn btn-info btn-sm" role="button">
                                        <i class="fa fa-edit">编辑</i>
                                    </a>
                                    <a href="javascript:void(0);" data-id="{{ $carousel->id }}" class="grid-row-delete btn btn-danger btn-sm" role="button">
                                        <i class="fa fa-trash">删除</i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {{$carousels->appends($data)->links('admin::widgets.pagination')}}
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('admin::js.grid-row-delete', ['url' => route('admin::carousels.index')])
@endsection
