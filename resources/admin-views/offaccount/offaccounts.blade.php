@extends('admin::layouts.main')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">公众号列表</h3>

                    <div class="btn-group pull-right">
                        <a href="{{ route('admin::offaccounts.create') }}" class="btn btn-sm btn-success">
                            <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                        </a>
                    </div>

                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>公众号封面图</th>
                            <th>公众号名称</th>
                            <th>公众号描述</th>
                            <th>操作</th>
                        </tr>
                        @foreach($offaccounts as $offaccount)
                            <tr>
                                <td><img src="{{ $offaccount->image }}" width="80" height="50" alt="" class="img-bordered"></td>
                                <td>{{ $offaccount->title }}</td>
                                <td>{{ $offaccount->description }}</td>
                                <td>
                                    <a href="{{ route('admin::offaccounts.edit', $offaccount->id) }}" class="btn btn-info btn-sm" role="button">
                                        <i class="fa fa-edit">编辑</i>
                                    </a>
                                    <a href="javascript:void(0);" data-id="{{ $offaccount->id }}" class="grid-row-delete btn btn-danger btn-sm" role="button">
                                        <i class="fa fa-trash">删除</i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {{$offaccounts->appends($data)->links('admin::widgets.pagination')}}
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('admin::js.grid-row-delete', ['url' => route('admin::offaccounts.index')])
@endsection
