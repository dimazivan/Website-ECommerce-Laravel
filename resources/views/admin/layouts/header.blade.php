<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                        data-toggle="dropdown" aria-expanded="false">
                        @if(auth()->user()->pict == null)
                        <img src="{{asset('toko/production/images/user.png')}}" alt="">{{ auth()->user()->username }}
                        @else
                        <img src="{{ url('/data_file/'.auth()->user()->pict) }}" alt="{{ auth()->user()->pict }}"
                            width="20%" height="40%">{{ auth()->user()->username }}
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        @if(auth()->user()->role == "admin" || auth()->user()->role == "super")
                        <a class="dropdown-item" href="{{route('user.show', [auth()->user()->id])}}"> Profile</a>
                        @endif
                        <a class="dropdown-item" href="/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->