<div class="page-header -i navbar navbar-fixed-top">
    <div class="page-header-inner">
        <div class="page-logo">
            <a href="{{ asset('/dashboard') }}">
                <img src="{{ asset('assets/img/old_logo.png') }}" alt="logo" class="logo-default"/>
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
                        <!-- <li>
                            <a href="#changepwd">
                                <i class="icon-user"></i> My Profile
                            </a>
                        </li> -->
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
<div id="changepwd" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Change Password</h4>
    </div>
    <div class="modal-body">
        <form action="#">
            <div class="form-group">
                <label class="control-label">New Password</label>
                <input id='newpwd' type="password" class="form-control"/>
            </div>
            <div class="form-group">
                <label class="control-label">Re-type New Password</label>
                <input id='rnewpwd' type="password" class="form-control"/>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a id="changebtn" class="btn green-haze">Change Password </a>
        <a id="reset" class="btn default"> Cancel </a>
    </div>
</div>