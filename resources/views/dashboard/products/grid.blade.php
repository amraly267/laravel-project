@extends('layouts.dashboard.app')
@section('content')

    <section class="content-header">
        <h1>@lang('site.products')</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">@lang('site.products')</h3>
                        <form action="{{route('dashboard.products.index')}}" method="get" style="margin-top:2%">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="search"
                                           value="{{ request()->search }}" placeholder="@lang('site.search')">
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" name="category">
                                        <option value="all">@lang('site.all_categories')</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}"
                                                    @if(request()->category == $category->id) selected @endif>
                                                {{$category->name_en}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                        @lang('site.search')
                                    </button>
                                    @if(Auth::user()->hasPermission('create-products'))
                                        <a class="btn btn-success" href="{{route('dashboard.products.create')}}">
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
                                            <th>@lang('site.category')</th>
                                            <th>@lang('site.stock_count')</th>
                                            <th>@lang('site.purchasing_price')</th>
                                            <th>@lang('site.selling_price')</th>
                                            <th>@lang('site.total_profit') (%)</th>
                                            <th>@lang('site.image')</th>
                                            <th>@lang('site.actions')</th>
                                        </thead>
                                        <tbody>
                                        @foreach($products as $index=>$product)
                                            <tr>
                                                <td>{{$index + 1}}</td>
                                                <td>{{$product->name_en}}</td>
                                                <td>{{$product->name_ar}}</td>
                                                <td>{{$product->categories->{'name_'.app()->getLocale()} }}</td>
                                                <td>{{$product->stock_count}}</td>
                                                <td>{{$product->purchasing_price}}</td>
                                                <td>{{$product->selling_price}}</td>
                                                <td>{{$product->totalProfit}}</td>
                                                <td><img src="{{$product->imagePath}}" class="img-thumbnail" width="100"
                                                         height="100"/></td>
                                                <td>
                                                    @if(Auth::user()->hasPermission('update-products'))
                                                        <a href="{{route('dashboard.products.edit',$product->id)}}"
                                                           class="btn btn-primary">@lang('site.edit')
                                                        </a>
                                                    @endif
                                                    @if(Auth::user()->hasPermission('delete-products'))
                                                        <form
                                                            action="{{route('dashboard.products.destroy',$product->id)}}"
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
                                    {{$products->appends(request()->query())->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
