@extends('layouts.dashboard.app')
@section('content')

    <section class="content-header">
        <h1>@lang('site.clients')</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">@lang('site.clients')</h3>
                        <form action="{{route('dashboard.clients.index')}}" method="get" style="margin-top:2%">
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
                                    @if(Auth::user()->hasPermission('create-clients'))
                                        <a class="btn btn-success" href="{{route('dashboard.clients.create')}}">
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
                                            <th>@lang('site.name')</th>
                                            <th>@lang('site.address')</th>
                                            <th>@lang('site.phone')</th>
                                            <th>@lang('site.add_order')</th>
                                            <th>@lang('site.actions')</th>
                                        </thead>
                                        <tbody>
                                        @foreach($clients as $index=>$client)
                                            <tr>
                                                <td>{{$index + 1}}</td>
                                                <td>{{$client->name}}</td>
                                                <td>{{$client->address}}</td>
                                                <td>{{$client->allPhones}}</td>
                                                <td>
                                                    <a href="{{HTML::link_to_location('dashboardCtrl@index')}}">ok</a>
                                                        <i class="fa fa-plus"></i>
                                                        @lang('site.add_order')
                                                    </a>
                                                </td>

                                                <td>
                                                    @if(Auth::user()->hasPermission('update-clients'))
                                                        <a href="{{route('dashboard.clients.edit',$client->id)}}"
                                                           class="btn btn-primary">@lang('site.edit')
                                                        </a>
                                                    @endif
                                                    @if(Auth::user()->hasPermission('delete-clients'))
                                                        <form
                                                            action="{{route('dashboard.clients.destroy',$client->id)}}"
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
                                    {{$clients->appends(request()->query())->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
