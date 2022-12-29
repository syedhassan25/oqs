 <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" title="Admin Dashboard" class="nav-link">
                        <i class="nav-icon fas fa-tachometer"></i>
                        <p>
                            Dashboard
                           
                        </p>
                    </a>
                </li>
              
                <li class="nav-item">
                    <a href="{{route('admin.parent.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Parents
                           
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Teachers
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">6</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.teacher.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Teachers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.teacher.student.weekly.schedule')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Student Weekly Schdule</p>
                            </a>
                        </li>
                      
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Students
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.student.schdule')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Students Schdules</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.student.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Students Details</p>
                            </a>
                        </li>
                      
                    </ul>
                </li>
                
            </ul>