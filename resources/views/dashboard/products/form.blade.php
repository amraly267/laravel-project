@extends('layouts.dashboard.app')
@section('content')

    @php
        if(Route::currentRouteName() == 'dashboard.products.create')
        {
          $headerTitle =  __('site.add');
          $addNewFormMode = 1;
          $btnTitle = '<i class="fa fa-plus"></i> '.__('site.save');
          $fields = ['name_en' => old('name_en'), 'name_ar' => old('name_ar'), 'description_en' => old('description_en'),
                        'description_ar' => old('description_ar'), 'category_id' => old('category_id'), 'image' => old('image'),
                        'purchasing_price' => old('purchasing_price'), 'selling_price' => old('selling_price'), 'stock_count' => old('stock_count')];
          $method = 'post';
        }
        else
        {
          $headerTitle =  __('site.edit');
          $addNewFormMode = 0;
          $btnTitle = '<i class="fa fa-edit"></i> '.__('site.update');
          if($errors->any())
          {
            $fields = ['name_en' => old('name_en'), 'name_ar' => old('name_ar'), 'description_en' => old('description_en'),
                        'description_ar' => old('description_ar'), 'category_id' => old('category_id'), 'image' => old('image'),
                        'purchasing_price' => old('purchasing_price'), 'selling_price' => old('selling_price'), 'stock_count' => old('stock_count')];
          }
          else
          {
            $fields = ['name_en' => $product->name_en, 'name_ar' => $product->name_ar, 'description_en' => $product->description_en,
                        'description_ar' => $product->description_ar, 'category_id' => $product->category_id, 'image' => $product->imagePath,
                        'purchasing_price' => $product->purchasing_price, 'selling_price' => $product->selling_price, 'stock_count' => $product->stock_count];
          }
          $method = 'put';
        }
    @endphp

    <section class="content-header">
        <h1>@lang('site.products')</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{$headerTitle}}</h3>
                    </div>
                    @include('partial.error')
                    <form
                        action="@if($addNewFormMode == 1) {{route('dashboard.products.store')}} @else {{route('dashboard.products.update', $product->id)}} @endif"
                        method="post" enctype="multipart/form-data" id="productForm">
                        @csrf()
                        @method($method)
                        <div class="box-body">
                            <div class="form-group">
                                <label>@lang('site.image')</label>
                                <input type="file" class="form-control image" name="image"
                                       placeholder="@lang('site.image')">
                                <img src="{{$fields['image']}}" class="preview img-thumbnail" width="200" height="200"/>
                            </div>
                            <div class="form-group">
                                <label>@lang('site.category')</label>
                                <select class="form-control" name="category_id">
                                    @foreach($categories as $category)
                                        <option
                                            value="{{$category->id}}">{{$category['name_'.config('app.locale')]}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('site.name_en')</label>
                                <input type="text" class="form-control" name="name_en" required
                                       value="{{$fields['name_en']}}" placeholder="@lang('site.name_en')">
                            </div>
                            <div class="form-group">
                                <label>@lang('site.name_ar')</label>
                                <input type="text" class="form-control" name="name_ar" required
                                       value="{{$fields['name_ar']}}" placeholder="@lang('site.name_ar')">
                            </div>
                            <div class="form-group">
                                <label>@lang('site.description_en')</label>
                                <textarea class="form-control" name="description_en" required
                                          placeholder="@lang('site.description_en')">{{$fields['description_en']}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>@lang('site.description_ar')</label>
                                <textarea class="form-control" name="description_ar" required
                                          placeholder="@lang('site.description_ar')">{{$fields['description_ar']}}</textarea>
                            </div>

                            <div class="form-group">
                                <label>@lang('site.purchasing_price')</label>
                                <input type="text" class="form-control" name="purchasing_price" required
                                       value="{{$fields['purchasing_price']}}"
                                       placeholder="@lang('site.purchasing_price')">

                            </div>
                            <div class="form-group">
                                <label>@lang('site.selling_price')</label>
                                <input type="text" class="form-control" name="selling_price" required
                                       value="{{$fields['selling_price']}}" placeholder="@lang('site.selling_price')">

                            </div>
                            <div class="form-group">
                                <label>@lang('site.stock_count')</label>
                                <input type="text" class="form-control" name="stock_count" required
                                       value="{{$fields['stock_count']}}" placeholder="@lang('site.stock_count')">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"
                                    id="addProduct">@php echo $btnTitle @endphp</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



@endsection
