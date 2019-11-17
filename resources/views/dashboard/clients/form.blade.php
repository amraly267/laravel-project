@extends('layouts.dashboard.app')
@section('content')

    @php
        if(Route::currentRouteName() == 'dashboard.clients.create')
        {
          $headerTitle =  __('site.add');
          $addNewFormMode = 1;
          $btnTitle = '<i class="fa fa-plus"></i> '.__('site.save');
          $fields = ['name' => old('name'), 'address' => old('address'), 'phone' => old('phone')];
          $method = 'post';
        }
        else
        {
          $headerTitle =  __('site.edit');
          $addNewFormMode = 0;
          $btnTitle = '<i class="fa fa-edit"></i> '.__('site.update');
          if($errors->any())
          {
            $fields = ['name' => old('name'), 'address' => old('address'), 'phone' => old('phone')];
          }
          else
          {
            $fields = ['name' => $client->name, 'phone' => $client->phone, 'address' => $client->address];
          }
          $method = 'put';
        }
    @endphp

    <section class="content-header">
        <h1>@lang('site.clients')</h1>
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
                        action="@if($addNewFormMode == 1) {{route('dashboard.clients.store')}} @else {{route('dashboard.clients.update', $client->id)}} @endif"
                        method="post" enctype="multipart/form-data" id="clientForm">
                        @csrf()
                        @method($method)
                        <div class="box-body">
                            <div class="form-group">
                                <label>@lang('site.name')</label>
                                <input type="text" class="form-control" name="name" required
                                       value="{{$fields['name']}}" placeholder="@lang('site.name')">
                            </div>
                            @for($i=0; $i<2; $i++)
                            <div class="form-group col-md-6">
                                <label>@lang('site.phone')</label>
                                <input type="text" class="form-control" name="phone[]"
                                       value="{{isset($fields['phone'][$i])? $fields['phone'][$i]: ''}}" placeholder="@lang('site.phone')">
                            </div>
                            @endfor
                            <div class="form-group">
                                <label>@lang('site.address')</label>
                                <input type="text" class="form-control" name="address" required
                                       value="{{$fields['address']}}" placeholder="@lang('site.address')">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">@php echo $btnTitle; @endphp</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection
