<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>SG POS!</span></a>
        </div>
        <div class="clearfix"></div>

        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ asset('asset/images/img.jpg') }}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>
                    @if(Auth::guard('admin')->check())
                        {{ Auth::guard('admin')->user()->username }}
                    @endif  
                </h2>
            </div>
        </div>
        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ url('sg-backend/index') }}"><i class="fa fa-home" href="index.html"></i> Home</a>
                    </li>
                    <li><a><i class="fa fa-history"></i> Shift <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('sg-backend/shift/') }}">list</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-list-alt"></i> Category <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('sg-backend/category') }}">Create</a></li>
                            <li><a href="{{ url('sg-backend/category/list') }}">list</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-cubes"></i> Item <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('sg-backend/item') }}">Create</a></li>
                            <li><a href="{{ url('sg-backend/item/list') }}">list</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-percent"></i> Promotion <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('sg-backend/discount/') }}">Create</a></li>
                            <li><a href="{{ url('sg-backend/discount/list') }}">list</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-users"></i> User <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('sg-backend/account/store/cashier') }}">Create</a></li>
                            <li><a href="{{ url('sg-backend/account/list/cashier') }}">list</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-cog"></i> Setting <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('sg-backend/setting/') }}">Create</a></li>
                            <li><a href="{{ url('sg-backend/setting/list') }}">list</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-table"></i> Report <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('sg-backend/daily-report/') }}">Daily Report</a></li>
                            <li><a href="{{ url('sg-backend/monthly-report') }}">Monthly Report</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-table"></i> Best Selling Products <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ url('sg-backend/best-seller/daily-report/') }}">Daily Report</a></li>
                            <li><a href="{{ url('sg-backend/best-seller/monthly-report') }}">Monthly Report</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

    </div>
</div>