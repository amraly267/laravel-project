@extends('layouts.dashboard.app')
@section('content')

    <section class="content-header">
        <h1>@lang('site.categories')</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">@lang('site.categories')</h3>
                        <form action="{{route('dashboard.categories.index')}}" method="get" style="margin-top:2%">
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
                                    @if(Auth::user()->hasPermission('create-categories'))
                                        <a class="btn btn-success" href="{{route('dashboard.categories.create')}}">
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
                                            <th>@lang('site.name_en')</th>
                                            <th>@lang('site.name_ar')</th>
                                            <th>@lang('site.actions')</th>
                                        </thead>
                                        <tbody>
                                        @foreach($categories as $index=>$category)
                                            <tr>
                                                <td>{{$index + 1}}</td>
                                                <td>{{$category->name_en}}</td>
                                                <td>{{$category->name_ar}}</td>
                                                <td>
                                                    @if(Auth::user()->hasPermission('update-categories'))
                                                        <a href="{{route('dashboard.categories.edit',$category->id)}}"
                                                           class="btn btn-primary">@lang('site.edit')
                                                        </a>
                                                    @endif
                                                    @if(Auth::user()->hasPermission('delete-categories'))
                                                        <form
                                                            action="{{route('dashboard.categories.destroy',$category->id)}}"
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
                                    {{$categories->appends(request()->query())->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
