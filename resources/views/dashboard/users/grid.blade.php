@extends('layouts.dashboard.app')

@section('content')
    <section class="content-header">
        <h1>@lang('site.users')</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">@lang('site.users')</h3>
                        <form action="{{route('dashboard.users.index')}}" method="get" style="margin-top:2%">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="search"
                                           value="{{ request()->search }}" placeholder="@lang('site.search')">
                                </div>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                        @lang('site.search')
                                    </button>
                                    @if(Auth::user()->hasPermission('create-users'))
                                        <a class="btn btn-success" href="{{route('dashboard.users.create')}}">
                                            <i class="fa fa-plus"></i>
                                            @lang('site.add_new')
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example2" class="table table-bordered table-hover dataTable">
                                        <thead>
                                        <tr role="row">
                                            <th>#</th>
                                            <th>@lang('site.first_name')</th>
                                            <th>@lang('site.last_name')</th>
                                            <th>@lang('site.email')</th>
                                            <th>@lang('site.image')</th>
                                            <th>@lang('site.actions')</th>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $index=>$user)
                                            <tr>
                                                <td>{{$index + 1}}</td>
                                                <td>{{$user->first_name}}</td>
                                                <td>{{$user->last_name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>
                                                    <img src="{{$user->imagePath}}" class="img-thumbnail" width="100"
                                                         height="100"/>
                                                </td>
                                                <td>
                                                    @if(Auth::user()->hasPermission('update-users'))
                                                        <a href="{{route('dashboard.users.edit',$user->id)}}"
                                                           class="btn btn-primary">@lang('site.edit')
                                                        </a>
                                                    @endif
                                                    @if(Auth::user()->hasPermission('delete-users'))
                                                        <form action="{{route('dashboard.users.destroy',$user->id)}}"
                                                              method="post" style="display:inline">
                                                            @csrf()
                                                            @method('DELETE')
                                                            <button
                                                                class="btn btn-danger delete">@lang('site.delete')</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{$users->appends(request()->query())->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
