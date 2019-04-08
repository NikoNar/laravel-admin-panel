<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li >
                <a href="{!! url('admin/dashboard') !!}">
                    <i class="fa fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
            </li>
            {{-- <li class="">
                <a href="{!! route('admin-home') !!}">
                    <i class="fa fa-dashboard"></i> <span>Home Page</span>
                </a>
            </li> --}}
            <li class="treeview @if(Request::is('admin/pages*')) active @endif">
                <a href="#">
                    <i class="fa fa-window-restore"></i>
                    <span>Pages</span>
                </a>    
                <ul class="treeview-menu">
                    <li class="@if(Request::is('admin/pages')) active @endif">
                        <a href="{!! route('page-index') !!}">
                            <i class="fa fa-circle-notch fz-12"></i> View All
                        </a>
                    </li>
                    <li class="@if(Request::is('admin/pages/create')) active @endif">
                        <a href="{!! route('page-create') !!}">
                            <i class="fa fa-circle-notch fz-12"></i> Add New
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview @if(Request::is('admin/programs*')) active @endif">
                <a href="#">
                    <i class="fas fa-book"></i>
                    <span>Programs</span>
                </a>
                <ul class="treeview-menu">
                    <li class="@if(Request::is('admin/programs')) active @endif">
                        <a href="{!! route('program-index') !!}">
                            <i class="fa fa-circle-notch fz-12"></i> View All
                        </a>
                    </li>
                    <li class="@if(Request::is('admin/programs/create')) active @endif">
                        <a href="{!! route('program-create') !!}">
                            <i class="fa fa-circle-notch fz-12"></i> Add New
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview @if(Request::is('admin/portfolio*')) active @endif">
                <a href="#">
                    <i class="fas fa-briefcase"></i>
                    <span>Portfolio</span>
                </a>
                <ul class="treeview-menu">
                    <li class="@if(Request::is('admin/portfolio')) active @endif">
                        <a href="{!! route('portfolio-index') !!}">
                            <i class="fa fa-circle-notch fz-12"></i> View All
                        </a>
                    </li>
                    <li class="@if(Request::is('admin/portfolio/create')) active @endif">
                        <a href="{!! route('portfolio-create') !!}">
                            <i class="fa fa-circle-notch fz-12"></i> Add New
                        </a>
                    </li>
                    <li class="@if(Request::is('admin/portfolio/categories')) active @endif">
                        <a href="{!! route('portfolio-categories') !!}">
                            <i class="fa fa-circle-o"></i> Categories
                        </a>
                    </li>
                </ul>  
            </li>
            
            <li class="@if(Request::is('admin/menus*')) active @endif">
                <a href="{!! route('menu-index') !!}">
                    <i class="fa fa-th"></i> <span>Menus</span>
                </a>
                <ul class="treeview-menu">
                    <li class="@if(Request::is('admin/menus')) active @endif">
                        <a href="{!! route('menu-index') !!}">
                            <i class="fa fa-circle-notch fz-12"></i> View All Menus
                        </a>
                    </li>
                    <li class="@if(Request::is('admin/menus/create')) active @endif">
                        <a href="{!! route('menu-create') !!}">
                            <i class="fa fa-circle-notch fz-12"></i> Create New Menu
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="treeview @if(Request::is('admin/lecturer*')) active @endif">
               <a href="#">
                   <i class="fas fa-chalkboard-teacher"></i>
                   <span>lecturers</span>
               </a>
               <ul class="treeview-menu">
                   <li class="@if(Request::is('admin/lecturer')) active @endif">
                       <a href="{!! route('lecturer-index') !!}">
                           <i class="fa fa-circle-notch fz-12"></i> View All 
                       </a>
                   </li>
                   <li class="@if(Request::is('admin/lecturer/create')) active @endif">
                       <a href="{!! route('lecturer-create') !!}">
                           <i class="fa fa-circle-notch fz-12"></i> Add New 
                       </a>
                   </li>
                   <li class="@if(Request::is('admin/lecturers/categories')) active @endif">
                        <a href="{!! route('lecturer-categories') !!}">
                            <i class="fa fa-circle-o"></i> Categories
                        </a>
                    </li>
               </ul>
           </li>
           <li class="treeview @if(Request::is('admin/review*')) active @endif">
               <a href="#">
                   <i class="fas fa-comments"></i>
                   <span>Reviews</span>
               </a>
               <ul class="treeview-menu">
                   <li class="@if(Request::is('admin/review')) active @endif">
                       <a href="{!! route('reviews-index') !!}">
                           <i class="fa fa-circle-notch fz-12"></i> View All 
                       </a>
                   </li>
                   <li class="@if(Request::is('admin/review/create')) active @endif">
                       <a href="{!! route('review-create') !!}">
                           <i class="fa fa-circle-notch fz-12"></i> Add New 
                       </a>
                   </li>
                   
               </ul>
           </li>
           <li class="treeview @if(Request::is('admin/users*')) active @endif">
                <a href="#">
                    <i class="fas fa-user"></i>
                    <span>Users</span>
                </a>
                <ul class="treeview-menu">
                    <li class="@if(Request::is('admin/users')) active @endif">
                        <a href="{!! route('user.index') !!}">
                            <i class="fa fa-circle-notch fz-12"></i> View All
                        </a>
                    </li>
                    <li class="@if(Request::is('admin/users/create')) active @endif">
                        <a href="{!! route('user.create') !!}">
                            <i class="fa fa-circle-notch fz-12"></i> Add New
                        </a>
                    </li>
                    <li class="@if(Request::is('admin/users/roles')) active @endif">
                        <a href="{!! route('roles.index') !!}">
                            <i class="fa fa-user-tag"></i> Roles
                        </a>
                    </li>
                </ul>  
            </li>
            <hr>
            <li class="treeview @if(Request::is('admin/media*')) active @endif">
                <a href="#">
                    <i class="fa fa-image"></i> <span>Media</span>
                </a>
                <ul class="treeview-menu">
                    <li class="@if(Request::is('admin/media')) active @endif">
                        <a href="{!! route('image-index') !!}">
                            <i class="fa fa-circle-notch fz-12"></i> Files
                        </a>
                    </li>
                    <li class="@if(Request::is('admin/media/upload')) active @endif">
                        <a href="{!! route('image-upload') !!}">
                            <i class="fa fa-circle-notch fz-12"></i> Upload
                        </a>
                    </li>
                </ul>
            </li>
            <li class="@if(Request::is('admin/translations*')) active @endif">
                <a href="{!! url('admin/translations/view/translate') !!}" target="_blank">
                    <i class="fa fa-language"></i> Translations 
                </a>
            </li>
            <li class="@if(Request::is('admin/applications*')) active @endif">
                <a href="{!! route('applications-index') !!}">
                    <i class="fa fa-address-card"></i> Applications 
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>