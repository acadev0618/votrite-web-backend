<div class="page-header -i navbar navbar-fixed-top">
    <div class="page-header-inner">
        <div class="page-logo">
            <a href="{{ asset('/dashboard') }}">
                <img src="{{ asset('assets/img/favicon_white.png') }}" alt="logo" class="logo-default"/>
                <input id='userid' type="hidden" value={{$userid}} class="form-control"/>
            </a>
            <div class="menu-toggler sidebar-toggler hide"></div>
        </div>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="{{ Session::get('avatar') }}"/>
                        <span class="username username-hide-on-mobile">	{{ Session::get('display_name') }} </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="#changepwd">
                                <i class="icon-user"></i> My Profile
                            </a>
                        </li>
                        <li>
                            <a data-toggle="modal" href="#changepwd">
                                <i class="fa fa-cog"></i> Change Password
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown dropdown-quick-sidebar-toggler">
                    <a href="{{ asset('/logout') }}" class="dropdown-toggle">
                        <i class="icon-logout"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="clearfix"></div>