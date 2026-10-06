@php $filename = basename(dirname($_SERVER['PHP_SELF'])); $file = basename($_SERVER['PHP_SELF']); @endphp
@php $AccessModule = Auth::guard('admin')->user()->accountAccessModule @endphp
@php $explode_1 = explode('|',$AccessModule);@endphp
@php $lists = explode('|',Auth::guard('admin')->user()->access_list);@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    .alert{
      /* background-color: #ffffff !important;
      cursor: pointer !important;
      box-shadow: 1px 1px #888890 !important;
      border: 1px solid rgb(225, 212, 212) !important;
      border-left: 5px solid red !important;
      color: red !important;
      font-size: 16px !important;  */
      border: 0;
      position: relative;
      padding: 0.95rem 1.25rem;
      border-radius: 1px;
      color: inherit;
      background-color: #fff;
      border-left: 5px solid red !important;
      -webkit-box-shadow: 1px 1px 14px 0 rgba(18,38,63,.26);
      -moz-box-shadow: 1px 1px 14px 0 rgba(18,38,63,.26);
      box-shadow: 1px 1px 14px 0 rgba(18,38,63,.26);
      font-size: 16px;
    }
    .alert-success{
      border: 0;
      position: relative;
      padding: 0.95rem 1.25rem;
      border-radius: 1px;
      color: inherit;
      font-size: 16px;
      background-color: #fff;
      border-left: 5px solid green !important;
      -webkit-box-shadow: 1px 1px 14px 0 rgba(18,38,63,.26);
      -moz-box-shadow: 1px 1px 14px 0 rgba(18,38,63,.26);
      box-shadow: 1px 1px 14px 0 rgba(18,38,63,.26);
    }
  
</style>
<aside class="sidebar-wrapper">
    <div class="sidebar sidebar-collapse" id="sidebar">
        <div class="sidebar__menu-group">
            <ul class="sidebar_nav">
                <li class="menu-title">
                    <span>Applications</span>
                </li>
                <li>
                    <a href="{{url('admin/dashboard')}}" class="{{ (Route::currentRouteName() == 'admin/dashboard') ? 'active':'' }}">
                        <span data-feather="home" class="nav-icon"></span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                @if((Auth::guard('admin')->user()->role == 'SuperAdmin') || (in_array('set_1',$lists)))
                    <li class="has-child @if((Route::currentRouteName() == 'admin.applist') || (Route::currentRouteName() == 'admin.add_app') || (Route::currentRouteName() == 'admin.edit') || (Route::currentRouteName() == 'admin.mapping')) {{'open'}} @endif @if((Route::currentRouteName() == 'category.list') || (Route::currentRouteName() == 'admin.add_category') || (Route::currentRouteName() == 'admin.edit_category') ) {{'open'}} @endif @if((Route::currentRouteName() == 'admin.Quiz') || (Route::currentRouteName() == 'admin.add_Quiz') || (Route::currentRouteName() == 'admin.edit.Quiz') ) {{'open'}} @endif">
                        <a href="{{url('admin/app_list')}}" class="@if((Route::currentRouteName() == 'admin.applist') || (Route::currentRouteName() == 'admin.add_app') || (Route::currentRouteName() == 'admin.edit') || (Route::currentRouteName() == 'admin.mapping')) {{'active'}} @endif @if((Route::currentRouteName() == 'category.list') || (Route::currentRouteName() == 'admin.add_category') || (Route::currentRouteName() == 'admin.edit_category')) {{'active'}} @endif @if((Route::currentRouteName() == 'admin.Quiz') || (Route::currentRouteName() == 'admin.add_Quiz') || (Route::currentRouteName() == 'admin.edit.Quiz') ) {{'active'}} @endif">
                            <span data-feather="list" class="nav-icon"></span>
                            <span class="menu-text">Quiz Set 1</span>
                            <span class="toggle-icon"></span>
                        </a>
                        <ul>
                            <li>
                                <a class="{{ (Route::currentRouteName() == 'admin.applist') ? 'active':'' }}" href="{{url( 'admin/app_list')}}"> Apps List</a>
                            </li>
                            <li>
                                <a class="{{ (Route::currentRouteName() == 'admin.add_app') ? 'active':'' }}" href="{{url('admin/admin_add_app')}}"> Add App</a>
                            </li>
                            @if((Route::currentRouteName() == 'admin.edit'))
                            <li>
                                <a class="{{ (Route::currentRouteName() == 'admin.edit') ? 'active':'' }}" href="{{Request::segment(3)}}">Apps Manage</a>
                            </li>
                            @endif
                            @if((Route::currentRouteName() == 'admin.mapping'))
                            <li>
                                <a class="{{ (Route::currentRouteName() == 'admin.mapping') ? 'active':'' }}" href="{{Request::segment(3)}}">Mapping Category</a>
                            </li>
                            @endif
                            <li>
                                <a class="{{ (Route::currentRouteName() == 'category.list') ? 'active':'' }}" href="{{url('admin/category_list')}}">Category List</a>
                            </li>
                            <li>
                                <a class="{{ (Route::currentRouteName() == 'admin.add_category') ? 'active':'' }}" href="{{url('admin/add_category')}}"> Add Category</a>
                            </li>
                            @if((Route::currentRouteName() == 'admin.edit_category'))
                                <li>
                                    <a class="{{ (Route::currentRouteName() == 'admin.edit_category') ? 'active':'' }}" href="{{Request::segment(3)}}">Category Manage</a>
                                </li>
                            @endif
                            <li>
                                <a class="{{ (Route::currentRouteName() == 'admin.Quiz') ? 'active':'' }}" href="{{url('admin/Quiz')}}">Quiz List</a>
                            </li>
                            <li>
                                <a class="{{ (Route::currentRouteName() == 'admin.add_Quiz') ? 'active':'' }}" href="{{url('admin/add_Quiz')}}">Add Quiz</a>
                            </li>
                            @if((Route::currentRouteName() == 'admin.edit.Quiz'))
                            <li>
                                <a class="{{ (Route::currentRouteName() == 'admin.edit.Quiz') ? 'active':'' }}" href="{{Request::segment(3)}}">Quiz Manage</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                
               
                @if((Auth::guard('admin')->user()->role == 'SuperAdmin') || (in_array('set_2',$lists)))
                <li class="has-child @if((Route::currentRouteName() == 'Quiz.applist') || (Route::currentRouteName() == 'Quiz.add_app') || (Route::currentRouteName() == 'Quiz.edit') || (Route::currentRouteName() == 'Quiz.mapping')) {{'open'}} @endif @if((Route::currentRouteName() == 'Quiz.categorylist') || (Route::currentRouteName() == 'Quiz.add_category') || (Route::currentRouteName() == 'Quiz.edit_category') ) {{'open'}} @endif @if((Route::currentRouteName() == 'Quiz.Quiz_list') || (Route::currentRouteName() == 'Quiz.add_Quiz') || (Route::currentRouteName() == 'Quiz.edit.Quiz') ) {{'open'}} @endif  @if((Route::currentRouteName() == 'Quiz.sub_categorylist') || (Route::currentRouteName() == 'Quiz.add_sub_category') || (Route::currentRouteName() == 'Quiz.edit_sub_category' || (Route::currentRouteName() == 'Quiz.bulk_Quiz')) ) {{'open'}} @endif">
                    <a href="{{url('Quiz/app_list')}}" class="@if((Route::currentRouteName() == 'Quiz.applist') || (Route::currentRouteName() == 'Quiz.add_app') || (Route::currentRouteName() == 'Quiz.edit') || (Route::currentRouteName() == 'Quiz.mapping')) {{'active'}} @endif @if((Route::currentRouteName() == 'Quiz.categorylist') || (Route::currentRouteName() == 'Quiz.add_category') || (Route::currentRouteName() == 'Quiz.edit_category')) {{'active'}} @endif @if((Route::currentRouteName() == 'Quiz.Quiz_list') || (Route::currentRouteName() == 'Quiz.add_Quiz') || (Route::currentRouteName() == 'Quiz.edit.Quiz') ) {{'active'}} @endif @if((Route::currentRouteName() == 'Quiz.sub_categorylist') || (Route::currentRouteName() == 'Quiz.add_sub_category') || (Route::currentRouteName() == 'Quiz.edit_sub_category') || (Route::currentRouteName() == 'Quiz.bulk_Quiz') ) {{'active'}} @endif">
                        <span data-feather="check" class="nav-icon"></span>
                        <span class="menu-text">Quiz Set 2</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'Quiz.applist') ? 'active':'' }}" href="{{url( 'Quiz/app_list')}}"> Apps List</a>
                        </li>
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'Quiz.add_app') ? 'active':'' }}" href="{{url('Quiz/admin_add_app')}}"> Add App</a>
                        </li>
                        @if((Route::currentRouteName() == 'Quiz.edit'))
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'Quiz.edit') ? 'active':'' }}" href="{{Request::segment(3)}}">Apps Manage</a>
                        </li>
                        @endif
                        @if((Route::currentRouteName() == 'Quiz.mapping'))
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'Quiz.mapping') ? 'active':'' }}" href="{{Request::segment(3)}}">Mapping Category</a>
                        </li>
                        @endif
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'Quiz.categorylist') ? 'active':'' }}" href="{{url('Quiz/category_list')}}">Category List</a>
                        </li>
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'Quiz.add_category') ? 'active':'' }}" href="{{url('Quiz/add_category')}}"> Add Category</a>
                        </li>
                        @if((Route::currentRouteName() == 'Quiz.edit_category'))
                            <li>
                                <a class="{{ (Route::currentRouteName() == 'Quiz.edit_category') ? 'active':'' }}" href="{{Request::segment(3)}}">Category Manage</a>
                            </li>
                        @endif

                        <li>
                            <a class="{{ (Route::currentRouteName() == 'Quiz.sub_categorylist') ? 'active':'' }}" href="{{url('Quiz/sub_category_list')}}">Sub Category List</a>
                        </li>
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'Quiz.add_sub_category') ? 'active':'' }}" href="{{url('Quiz/add_sub_category')}}"> Add New Sub Category</a>
                        </li>
                        @if((Route::currentRouteName() == 'Quiz.edit_sub_category'))
                            <li>
                                <a class="{{ (Route::currentRouteName() == 'Quiz.edit_sub_category') ? 'active':'' }}" href="{{Request::segment(3)}}">Sub Category Manage</a>
                            </li>
                        @endif


                        <li>
                            <a class="{{ (Route::currentRouteName() == 'Quiz.Quiz_list') ? 'active':'' }}" href="{{url('Quiz/Quizs')}}">Quiz List</a>
                        </li>
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'Quiz.add_Quiz') ? 'active':'' }}" href="{{url('Quiz/add_Quizs')}}">Add Quiz</a>
                        </li>
                        @if((Route::currentRouteName() == 'Quiz.edit.Quiz'))
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'Quiz.edit.Quiz') ? 'active':'' }}" href="{{Request::segment(3)}}">Quiz Manage</a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if((Auth::guard('admin')->user()->role == 'SuperAdmin') || (in_array('set_3',$lists)))
                <li class="has-child @if((Route::currentRouteName() == 'QuizSet3.applist') || (Route::currentRouteName() == 'QuizSet3.add_app') || (Route::currentRouteName() == 'QuizSet3.edit') || (Route::currentRouteName() == 'QuizSet3.mapping') || (Route::currentRouteName() == 'QuizSet3.category_app')) {{'open'}} @endif @if((Route::currentRouteName() == 'QuizSet3.categorylist') || (Route::currentRouteName() == 'QuizSet3.add_category') || (Route::currentRouteName() == 'QuizSet3.edit_category') ) {{'open'}} @endif @if((Route::currentRouteName() == 'QuizSet3.QuizSet3_list') || (Route::currentRouteName() == 'QuizSet3.add_QuizSet3') || (Route::currentRouteName() == 'QuizSet3.edit.QuizSet3') ) {{'open'}} @endif @if((Route::currentRouteName() == 'QuizSet3.sub_categorylist') || (Route::currentRouteName() == 'QuizSet3.add_sub_category') || (Route::currentRouteName() == 'QuizSet3.edit_sub_category') ) {{'open'}} @endif">
                    <a href="{{url('QuizSet3/app_list')}}" class="@if((Route::currentRouteName() == 'QuizSet3.applist') || (Route::currentRouteName() == 'QuizSet3.add_app') || (Route::currentRouteName() == 'QuizSet3.edit') || (Route::currentRouteName() == 'QuizSet3.mapping') || (Route::currentRouteName() == 'QuizSet3.category_app')) {{'active'}} @endif @if((Route::currentRouteName() == 'QuizSet3.categorylist') || (Route::currentRouteName() == 'QuizSet3.add_category') || (Route::currentRouteName() == 'QuizSet3.edit_category')) {{'active'}} @endif @if((Route::currentRouteName() == 'QuizSet3.QuizSet3_list') || (Route::currentRouteName() == 'QuizSet3.add_QuizSet3') || (Route::currentRouteName() == 'QuizSet3.edit.QuizSet3') ) {{'active'}} @endif @if((Route::currentRouteName() == 'QuizSet3.sub_categorylist') || (Route::currentRouteName() == 'QuizSet3.add_sub_category') || (Route::currentRouteName() == 'QuizSet3.edit_sub_category') ) {{'active'}} @endif">
                        <span data-feather="menu" class="nav-icon"></span>
                        <span class="menu-text">Quiz Set 3</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet3.applist') ? 'active':'' }}" href="{{url( 'QuizSet3/app_list')}}"> Apps List</a>
                        </li>
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet3.add_app') ? 'active':'' }}" href="{{url('QuizSet3/admin_add_app')}}"> Add App</a>
                        </li>
                        @if((Route::currentRouteName() == 'QuizSet3.edit'))
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet3.edit') ? 'active':'' }}" href="{{Request::segment(3)}}">Apps Manage</a>
                        </li>
                        @endif
                        @if((Route::currentRouteName() == 'QuizSet3.mapping'))
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet3.mapping') ? 'active':'' }}" href="{{Request::segment(3)}}">Mapping Category</a>
                        </li> 
                        @endif
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet3.categorylist') ? 'active':'' }}" href="{{url('QuizSet3/category_list')}}">Category List</a>
                        </li>
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet3.add_category') ? 'active':'' }}" href="{{url('QuizSet3/add_category')}}"> Add Category</a>
                        </li>
                        @if((Route::currentRouteName() == 'QuizSet3.edit_category'))
                            <li>
                                <a class="{{ (Route::currentRouteName() == 'QuizSet3.edit_category') ? 'active':'' }}" href="{{Request::segment(3)}}">Category Manage</a>
                            </li>
                        @endif

                        @if((Route::currentRouteName() == 'QuizSet3.category_app'))
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet3.category_app') ? 'active':'' }}" href="{{Request::segment(3)}}">Mapping Sub Category</a>
                        </li> 
                        @endif

                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet3.sub_categorylist') ? 'active':'' }}" href="{{url('QuizSet3/sub_category_list')}}">Sub Category List</a>
                        </li>
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet3.add_sub_category') ? 'active':'' }}" href="{{url('QuizSet3/add_sub_category')}}"> Add New Sub Category</a>
                        </li>
                        @if((Route::currentRouteName() == 'QuizSet3.edit_sub_category'))
                            <li>
                                <a class="{{ (Route::currentRouteName() == 'QuizSet3.edit_sub_category') ? 'active':'' }}" href="{{Request::segment(3)}}">Sub Category Manage</a>
                            </li>
                        @endif
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet3.QuizSet3_list') ? 'active':'' }}" href="{{url('QuizSet3/fetch_QuizSet3')}}">Quiz List</a>
                        </li>
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet3.add_QuizSet3') ? 'active':'' }}" href="{{url('QuizSet3/add_QuizSet3s')}}">Add Quiz</a>
                        </li>
                        @if((Route::currentRouteName() == 'QuizSet3.edit.QuizSet3'))
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet3.edit.QuizSet3') ? 'active':'' }}" href="{{Request::segment(3)}}">Quiz Manage</a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                @if((Auth::guard('admin')->user()->role == 'SuperAdmin') || (in_array('set_4',$lists)))
                <li class="has-child @if((Route::currentRouteName() == 'QuizSet4.applist') || (Route::currentRouteName() == 'QuizSet4.add_app') || (Route::currentRouteName() == 'QuizSet4.edit') || (Route::currentRouteName() == 'QuizSet4.mapping')) {{'open'}} @endif @if((Route::currentRouteName() == 'QuizSet4.categorylist') || (Route::currentRouteName() == 'QuizSet4.add_category') || (Route::currentRouteName() == 'QuizSet4.edit_category') ) {{'open'}} @endif @if((Route::currentRouteName() == 'QuizSet4.QuizSet4') || (Route::currentRouteName() == 'QuizSet4.add_QuizSet4s') || (Route::currentRouteName() == 'QuizSet4.edit_QuizSet4s') ) {{'open'}} @endif">
                    <a href="{{url('QuizSet4/app_list')}}" class="@if((Route::currentRouteName() == 'QuizSet4.applist') || (Route::currentRouteName() == 'QuizSet4.add_app') || (Route::currentRouteName() == 'QuizSet4.edit') || (Route::currentRouteName() == 'QuizSet4.mapping')) {{'active'}} @endif @if((Route::currentRouteName() == 'QuizSet4.categorylist') || (Route::currentRouteName() == 'QuizSet4.add_category') || (Route::currentRouteName() == 'QuizSet4.edit_category')) {{'active'}} @endif @if((Route::currentRouteName() == 'QuizSet4.QuizSet4') || (Route::currentRouteName() == 'QuizSet4.add_QuizSet4s') || (Route::currentRouteName() == 'QuizSet4.edit_QuizSet4s') ) {{'active'}} @endif">
                        <span data-feather="grid" class="nav-icon"></span>
                        <span class="menu-text">Quiz Set 4</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet4.applist') ? 'active':'' }}" href="{{url( 'QuizSet4/app_list')}}"> Apps List</a>
                        </li>
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet4.add_app') ? 'active':'' }}" href="{{url('QuizSet4/admin_add_app')}}"> Add App</a>
                        </li>
                        @if((Route::currentRouteName() == 'QuizSet4.edit'))
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet4.edit') ? 'active':'' }}" href="{{Request::segment(3)}}">Apps Manage</a>
                        </li>
                        @endif
                        @if((Route::currentRouteName() == 'QuizSet4.mapping'))
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet4.mapping') ? 'active':'' }}" href="{{Request::segment(3)}}">Mapping Category</a>
                        </li>
                        @endif
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet4.QuizSet4') ? 'active':'' }}" href="{{url('QuizSet4/QuizSet4s_list')}}">Quiz List</a>
                        </li>
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet4.add_QuizSet4s') ? 'active':'' }}" href="{{url('QuizSet4/add_QuizSet4s')}}">Add Quiz</a>
                        </li>
                        @if((Route::currentRouteName() == 'QuizSet4.edit_QuizSet4s'))
                        <li>
                            <a class="{{ (Route::currentRouteName() == 'QuizSet4.edit_QuizSet4s') ? 'active':'' }}" href="{{Request::segment(3)}}">Quiz Manage</a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif


                @if((Auth::guard('admin')->user()->role == 'SuperAdmin') ||(in_array('admin',$explode_1)))
                <li class="has-child @if((Route::currentRouteName() == 'superadmin.list') || (Route::currentRouteName() == 'add_superadmin') || (Route::currentRouteName() == 'edit_superadmin') ) {{'open'}} @endif">
                  <a href="{{url('admin/superadmin')}}" class="@if((Route::currentRouteName() == 'superadmin.list') || (Route::currentRouteName() == 'add_superadmin') || (Route::currentRouteName() == 'edit_superadmin')) {{'active'}} @endif">
                      <span data-feather="user" class="nav-icon"></span>
                      <span class="menu-text">Administrator</span>
                      <span class="toggle-icon"></span>
                  </a>
                  <ul>
                      <li>
                          <a class="{{ (Route::currentRouteName() == 'superadmin.list') ? 'active':'' }}" href="{{url('admin/superadmin')}}">List</a>
                      </li>
                      <li>
                          <a class="{{ (Route::currentRouteName() == 'add_superadmin') ? 'active':'' }}" href="{{url('admin/admin_add_sub_admin')}}"> Add</a>
                      </li>
                      @if((Route::currentRouteName() == 'edit_superadmin'))
                      <li>
                          <a href="{{Request::segment(3)}}" class="{{ (Route::currentRouteName() == 'edit_superadmin') ? 'active':'' }}">
                              <i class="bi bi-circle"></i><span>Manage</span>
                          </a>
                      </li>
                      @endif
                  </ul>
                </li>
                @endif


                <li class="menu-title m-top-30">
                    <span>PROFILE</span>
                </li>
  
                <li class="has-child @if((Route::currentRouteName() == 'admin.profile_update')) {{'open'}} @endif">
                    <a href="{{url('admin/profile_update')}}" class="{{ (Route::currentRouteName() == 'admin.profile_update') ? 'active':'' }}">
                        <span data-feather="list" class="nav-icon"></span>
                        <span class="menu-text">Profile</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li class="nav-item">
                            <a href="{{url('admin/profile_update')}}" class="{{ (Route::currentRouteName() == 'admin.profile_update') ? 'active':'' }}">My Profile</a>
                        </li>
                        <li>
                            <a href="" class="">Profile Settings <span class="badge badge-success menuItem">New</span></a>
                        </li>
                    </ul>
                </li>
  
                {{-- <li class="has-child">
                    <a href="#" class="">
                        <span data-feather="folder" class="nav-icon"></span>
                        <span class="menu-text">Users</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="" class="">Team</a>
                        </li>
                        <li>
                            <a href="" class="">Users List</a>
                        </li>
                    </ul>
                </li>
                <li class="has-child">
                    <a href="#" class="">
                        <span data-feather="user-check" class="nav-icon"></span>
                        <span class="menu-text">Contact</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li>
                            <a class="" href="">Contact Grid</a>
                        </li>
                        <li>
                            <a class="" href="">Contact List</a>
                        </li>
                        <li>
                            <a class="" href="">Contact
                                Create</a>
                        </li>
                    </ul>
                </li> --}}
                <li class="menu-title m-top-30">
                    <span>Sessions</span>
                </li>
                <li>
                    <a href="{{ route('admin.logout')}}" class="">
                    <span data-feather="log-out"></span> &nbsp; Sign Out</a>
                </li>
            </ul>
        </div>
    </div>
  </aside>