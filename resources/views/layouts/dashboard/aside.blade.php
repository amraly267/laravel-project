<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-right image">
            <img src="{{asset('dashboard/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            {{Auth::user()->first_name .' '.Auth::user()->first_name}}
        </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="active">
            <a href="{{route('dashboard.home')}}">
                <i class="fa fa-home"></i>
                <span>@lang('site.home')</span>
            </a>
        </li>

        <li class="active">
            <a href="@if(Auth::user()->hasPermission('read-users') || Auth::user()->hasPermission('update-users')|| Auth::user()->hasPermission('delete-users')) {{route('dashboard.users.index')}} @elseif(Auth::user()->hasPermission('create-users')) {{route('dashboard.users.create')}} @endif">
                <i class="fa fa-users"></i>
                <span>@lang('site.users')</span>
            </a>
        </li>

        <li class="active">
            <a href="@if(Auth::user()->hasPermission('read-categories') || Auth::user()->hasPermission('update-categories')|| Auth::user()->hasPermission('delete-categories')) {{route('dashboard.categories.index')}} @elseif(Auth::user()->hasPermission('create-categories')) {{route('dashboard.categories.create')}} @endif">
                <i class="fa fa-server"></i>
                <span>@lang('site.categories')</span>
            </a>
        </li>

        <li class="active">
            <a href="@if(Auth::user()->hasPermission('read-products') || Auth::user()->hasPermission('update-products')|| Auth::user()->hasPermission('delete-products')) {{route('dashboard.products.index')}} @elseif(Auth::user()->hasPermission('create-products')) {{route('dashboard.products.create')}} @endif">
                <i class="fa fa-tags"></i>
                <span>@lang('site.products')</span>
            </a>
        </li>

        <li class="active">
            <a href="@if(Auth::user()->hasPermission('read-clients') || Auth::user()->hasPermission('update-clients')|| Auth::user()->hasPermission('delete-clients')) {{route('dashboard.clients.index')}} @elseif(Auth::user()->hasPermission('create-clients')) {{route('dashboard.clients.create')}} @endif">
                <i class="fa fa-tags"></i>
                <span>@lang('site.clients')</span>
            </a>
        </li>

    </ul>
</section>
<!-- /.sidebar -->
