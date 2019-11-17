@extends('layouts.dashboard.app')
@section('content')

    @php
        if(Route::currentRouteName() == 'dashboard.users.create')
        {
          $headerTitle =  __('site.add');
          $addNewFormMode = 1;
          $btnTitle = '<i class="fa fa-plus"></i> '.__('site.save');
          $fields = ['first_name' => old('first_name'), 'last_name' => old('last_name'), 'email' => old('email'), 'image' => asset('uploads/users/default.png'), 'permissions' => old('permissions')];
          $method = 'post';
        }
        else
        {
          $headerTitle =  __('site.edit');
          $addNewFormMode = 0;
          $btnTitle = '<i class="fa fa-edit"></i> '.__('site.update');
          if($errors->any())
          {
            $fields = ['first_name' => old('first_name'), 'last_name' => old('last_name'), 'email' => old('email'), 'image' => old('image'), 'permissions' => old('permissions')];
          }
          else
          {
            $fields = ['first_name' => $user->first_name, 'last_name' => $user->last_name, 'email' => $user->email, 'image' => $user->imagePath, 'permissions' => ''];
          }

          $method = 'put';
        }
    @endphp

    <section class="content-header">
        <h1>@lang('site.users')</h1>
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
                        action="@if($addNewFormMode == 1) {{route('dashboard.users.store')}} @else {{route('dashboard.users.update', $user->id)}} @endif"
                        method="post" enctype="multipart/form-data">
                        @csrf()
                        @method($method)
                        <div class="box-body">
                            <div class="form-group">
                                <label>@lang('site.first_name')</label>
                                <input type="text" class="form-control" name="first_name"
                                       value="{{$fields['first_name']}}" placeholder="@lang('site.first_name')">
                            </div>
                            <div class="form-group">
                                <label>@lang('site.last_name')</label>
                                <input type="text" class="form-control" name="last_name"
                                       value="{{$fields['last_name']}}" placeholder="@lang('site.last_name')">
                            </div>
                            <div class="form-group">
                                <label>@lang('site.email')</label>
                                <input type="email" class="form-control" name="email"
                                       value="{{$fields['email']}}" placeholder="@lang('site.email')">
                            </div>
                            <div class="form-group">
                                <label>@lang('site.image')</label>
                                <input type="file" class="form-control image" name="image"
                                       placeholder="@lang('site.image')">
                                <img src="{{$fields['image']}}" class="preview img-thumbnail" width="200" height="200"/>
                            </div>
                            @if($addNewFormMode == 1)
                                <div class="form-group">
                                    <label>@lang('site.password')</label>
                                    <input type="password" class="form-control" name="password"
                                           placeholder="@lang('site.password')">
                                </div>
                                <div class="form-group">
                                    <label>@lang('site.confirm_password')</label>
                                    <input type="password" class="form-control" name="confirm_password"
                                           placeholder="@lang('site.confirm_password')">
                                </div>
                            @endif

                            <div class="form-group">
                                <label>@lang('site.permissions')</label>
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        @foreach($models as $index => $model)
                                            <li class="{{$index == 0? 'active' : ''}}"><a href="#{{$model}}"
                                                                                          data-toggle="tab">@lang('site.'.$model)</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach($models as $index => $model)
                                            <div class="tab-pane {{ $index == 0? 'active': ''}}" id="{{$model}}">
                                                @foreach($permissions as $permission)
                                                    <label>
                                                        <input type="checkbox" name="permissions[]"
                                                               value="{{$permission .'-'. $model}}"
                                                            @php
                                                                if($addNewFormMode == 0 && !is_array($fields['permissions']))
                                                                {
                                                                  if($user->hasPermission($permission .'-'. $model))
                                                                  {
                                                                    echo 'checked';
                                                                  }
                                                                }
                                                                else
                                                                {
                                                                  if(is_array($fields['permissions']) &&
                                                                      in_array($permission .'-'. $model,$fields['permissions']))
                                                                  {
                                                                    echo 'checked';
                                                                  }
                                                                }
                                                            @endphp >
                                                        @lang('site.'.$permission)
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">@php echo $btnTitle @endphp</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
