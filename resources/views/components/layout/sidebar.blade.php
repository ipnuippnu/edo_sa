<div class="logo-header position-fixed" data-background-color="blue">
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('assets/images/edo-bw.png') }}" alt="Logo EDO" class="navbar-brand h-100 p-2">
    </a>
    <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
            <i class="icon-menu"></i>
        </span>
    </button>
    <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
    <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
            <i class="icon-menu"></i>
        </button>
    </div>
</div>

<div class="sidebar sidebar-style-2" data-background-color="blue">	
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">

            {{-- <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ auth()->user()->profile_picture }}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ auth()->user()->name }}
                            <span class="user-level">{{ auth()->user()->personal->phone }}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#profile">
                                    <span class="link-collapse">Edit Pimpinan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> --}}

            <ul class="nav">
                <li class="nav-item @active("home")">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        <p>Beranda</p>
                    </a>
                </li>
                
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Data Diri</h4>
                </li>

                <li class="nav-item @active("educations")">
                    <a href="{{ route('educations') }}">
                        <i class="fas fa-graduation-cap"></i>
                        <p>Pendidikan</p>
                    </a>
                </li>

                <li class="nav-item @active("trainings")">
                    <a href="{{ route('trainings') }}">
                        <i class="fas fa-certificate"></i>
                        <p>Pengkaderan</p>
                    </a>
                </li>

                <li class="nav-item @active("roles")">
                    <a href="{{ route('roles') }}">
                        <i class="fas fa-level-up-alt"></i>
                        <p>Jabatan Pimpinan</p>
                    </a>
                </li>

                {{-- <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Finance</h4>
                </li>
                <li class="nav-item">
                    <a href="starter-template.html">
                        <i class="far fa-file-excel"></i>
                        <p>Annual Report</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="starter-template.html">
                        <i class="fas fa-file-contract"></i>
                        <p>HR Report</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="starter-template.html">
                        <i class="fas fa-chart-bar"></i>
                        <p>Finance Report</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="starter-template.html">
                        <i class="icon-briefcase"></i>
                        <p>Revenue Report</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="starter-template.html">
                        <i class="fas fa-print"></i>
                        <p>IPO Report</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Snippets</h4>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#email-nav">
                        <i class="far fa-envelope"></i>
                        <p>Email</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="email-nav">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="email-inbox.html">
                                    <span class="sub-item">Inbox</span>
                                </a>
                            </li>
                            <li>
                                <a href="email-compose.html">
                                    <span class="sub-item">Email Compose</span>
                                </a>
                            </li>
                            <li>
                                <a href="email-detail.html">
                                    <span class="sub-item">Email Detail</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#messages-app-nav">
                        <i class="far fa-paper-plane"></i>
                        <p>Messages App</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="messages-app-nav">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="messages.html">
                                    <span class="sub-item">Messages</span>
                                </a>
                            </li>
                            <li>
                                <a href="conversations.html">
                                    <span class="sub-item">Conversations</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="projects.html">
                        <i class="fas fa-file-signature"></i>
                        <p>Projects</p>
                        <span class="badge badge-count">5</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="boards.html">
                        <i class="fas fa-th-list"></i>
                        <p>Boards</p>
                        <span class="badge badge-count">4</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="invoice.html">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <p>Invoices</p>
                        <span class="badge badge-count">6</span>
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
</div>