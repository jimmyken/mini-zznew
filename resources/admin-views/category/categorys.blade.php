@extends('admin::layouts.main')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">栏目列表</h3>

                    <div class="btn-group pull-right">
                        <a href="{{ route('admin::categorys.create') }}" class="btn btn-sm btn-success">
                            <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                        </a>
                    </div>

                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>栏目封面图</th>
                            <th>栏目名</th>
                            <th>标签名</th>
                            <th>操作</th>
                        </tr>
                        @inject('CategoryPresenter', "App\Admin\Presenters\CategoryPresenter")
                        @foreach($categorys as $category)
                            <tr>
                                <td><img src="{{ $category->image }}" width="100" height="50" alt="" class="img-thumbnail"></td>
                                <td>{{ $category->title }}</td>
                                <td>{!! $CategoryPresenter->showLabel($category) !!}</td>
                                <td>
                                    <a href="{{ route('admin::categorys.edit', $category->id) }}" class="btn btn-info btn-sm" role="button">
                                        <i class="fa fa-edit">编辑</i>
                                    </a>
                                    <a href="javascript:void(0);" data-id="{{ $category->id }}" class="grid-category-delete btn btn-danger btn-sm" role="button">
                                        <i class="fa fa-trash">删除</i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {{$categorys->appends($data)->links('admin::widgets.pagination')}}
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('admin::js.grid-row-delete', ['url' => route('admin::categorys.index')])
@endsection
