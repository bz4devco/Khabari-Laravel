<!-- main sibebar -->
<aside id="main-sidebar" class="sidebar">
    <section class="sidebar-container">
        <section class="sidebar-wrapper">


            <!-- start section home link -->
            <a href="{{ route('admin.home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>خانه</span>
            </a>
            <!-- end section home link -->


            <!-- start content section managment -->
            <section id="contents-section" class="sidebar-part-title">بخش محتوی</section>
            @can('view-report-categories-list')
            <a href="{{ route('admin.content.reports.category.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>دسته بندی</span>
            </a>
            @endcan
            @can('view-reports-list')
            <a href="{{ route('admin.content.reports.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>اخبار</span>
            </a>
            @endcan
            @can('view-content-comments-list')
            <a href="{{ route('admin.content.comment.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>نظرات</span>
            </a>
            @endcan
            @can('view-menus-list')
            <a href="{{ route('admin.content.menu.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>منو</span>
            </a>
            @endcan
            @can('view-menus-list')
            <a href="{{ route('admin.content.banner.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>بنرها</span>
            </a>
            @endcan
            @can('view-pages-list')
            <a href="{{ route('admin.content.page.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>پیج ساز</span>
            </a>
            @endcan
            <!-- end content section managment -->


            <!-- ///////////////////////////////////////////////////////////// -->


            <!-- start users section managment -->
            <section id="users-section" class="sidebar-part-title">بخش کاربران</section>
            @can('view-admins-list')
            <a href="{{ route('admin.user.admin-user.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>کاربران ادمین</span>
            </a>
            @endcan
            @can('view-users-list')
            <a href="{{ route('admin.user.user.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>کاربران</span>
            </a>
            @endcan

            <section id="roles-section" class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>سطوح دسترسی</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    @can('view-roles-list')
                    <a href="{{ route('admin.user.role.index') }}">مدیریت نقش ها</a>
                    @endcan
                    @can('view-permissions')
                    <a href="{{ route('admin.user.permission.index') }}">مدیریت دسترسی ها</a>
                    @endcan
                </section>
            </section>
            <!-- end users section managment -->


            <!-- ///////////////////////////////////////////////////////////// -->


            <!-- start settings section managment -->
            <section id="settings-section" class="sidebar-part-title">تنظیمات</section>
            @can('view-settings-list')
            <a href="{{ route('admin.setting.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>تنظیمات سایت</span>
            </a>
            @endcan
            @can('view-provinces-list')
            <a href="{{ route('admin.setting.province.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>مدیریت استان و شهرستان</span>
            </a>
            @endcan
            <!-- end settings section managment -->
        </section>
    </section>
</aside>
<!-- main sibebar -->