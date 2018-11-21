
@extends('admin::layouts.main')

@section('content')

       @include('admin::search.programs-programs')

       <div class="row">
           <div class="col-md-12">
               <div class="box box-info">
                   <div class="box-header with-border">
                       <h3 class="box-title">节目列表</h3>

                       <div class="btn-group pull-right">
                           <a href="{{ route('admin::programs.create') }}" class="btn btn-sm btn-success">
                               <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                           </a>
                       </div>

                       @include('admin::widgets.filter-btn-group', ['resetUrl' => route('admin::programs.index')])
                   </div>

                   <div class="box-body table-responsive no-padding">
                       <table class="table">
                           <tbody>
                           <tr>
                               <th>封面图</th>
                               <th>节目名</th>
                               <th>节目时长</th>
                               <th>栏目名</th>
                               <th>播放量</th>
                               <th>发布时间</th>
                               <th>操作</th>
                           </tr>
                           @foreach($programs as $program)
                               <tr>
                                   <td><img src ="{{ $program->image }}" height="50" width="50" class="img-rounded"/></td>
                                   <td>{{ $program->title }}</td>
                                   <td>{{ $program->lasttime }}分钟</td>
                                   <td>{{ $program->category->title }}</td>
                                   <td><span class="badge bg-red">{{ $program->payvolume }}</span></td>
                                   <td>{{date('Y-m-d',strtotime($program->created_at))}}</td>
                                   <td>
                                       <a href="{{ route('admin::programs.edit',$program->id)}}"  class="btn btn-info btn-sm" role="button">
                                           <i class="fa fa-edit">编辑</i>
                                       </a>
                                       <a href="javascript:void(0);" data-id="{{ $program->id }}" class="grid-row-delete btn btn-danger btn-sm"   role="button">
                                           <i class="fa fa-trash">删除</i>
                                       </a>

                                   </td>
                               </tr>
                           @endforeach
                           </tbody>
                       </table>
                   </div>
                   <div class="box-footer">
                       {{ $programs->appends($data)->links('admin::widgets.pagination') }}
                   </div>

               </div>
           </div>
       </div>
@endsection
@section('script')
    @include('admin::js.grid-row-delete', ['url' => route('admin::programs.index')])
@endsection
