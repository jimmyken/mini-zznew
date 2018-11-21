
@extends('admin::layouts.main')

@section('content')

    @include('admin::search.members-members')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">会员列表</h3>


                    @include('admin::widgets.filter-btn-group', ['resetUrl' => route('admin::members.index')])
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>会员头像</th>
                            <th>会员名</th>
                            <th>性别</th>
                            <th>出生年月</th>
                            <th>手机号码</th>
                            <th>注册时间</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td><img src="{{ $user->avatarurl }}" width="50" height="50" alt="" class="img-circle"></td>
                                <td>{{ $user->nickname }}</td>
                                <td>@if($user->gender == 1)男@elseif($user->gender==2)女@else 未知@endif</td>
                                <td>{{ $user->birthday }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <a href="javascript:void(0);" data-id="{{ $user->id }}" class="grid-row-delete btn btn-danger btn-sm" role="button">
                                        <i class="fa fa-trash">删除</i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    {{ $users->appends($data)->links('admin::widgets.pagination') }}
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('admin::js.grid-row-delete', ['url' => route('admin::members.index')])
@endsection
