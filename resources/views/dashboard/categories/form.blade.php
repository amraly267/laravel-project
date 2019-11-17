@extends('layouts.dashboard.app')
@section('content')

    @php
        if(Route::currentRouteName() == 'dashboard.categories.create')
        {
          $headerTitle =  __('site.add');
          $addNewFormMode = 1;
          $btnTitle = '<i class="fa fa-plus"></i> '.__('site.save');
          $fields = ['name_en' => old('name_en'), 'name_ar' => old('name_ar')];
          $method = 'post';
        }
        else
        {
          $headerTitle =  __('site.edit');
          $addNewFormMode = 0;
          $btnTitle = '<i class="fa fa-edit"></i> '.__('site.update');
          if($errors->any())
          {
            $fields = ['name_en' => old('name_en'), 'name_ar' => old('name_ar')];
          }
          else
          {
            $fields = ['name_en' => $category->name_en, 'name_ar' => $category->name_ar];
          }
          $method = 'put';
        }
    @endphp

    <section class="content-header">
        <h1>@lang('site.categories')</h1>
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
                        action="@if($addNewFormMode == 1) {{route('dashboard.categories.store')}} @else {{route('dashboard.categories.update', $category->id)}} @endif"
                        method="post" enctype="multipart/form-data" id="categoryForm">
                        @csrf()
                        @method($method)
                        <div class="box-body">
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
                        </div>
                        <div class="box-footer">
                            <button type="submit" id="addCategory"
                                    class="btn btn-primary">@php echo $btnTitle @endphp</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection
