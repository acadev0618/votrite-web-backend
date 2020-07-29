<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            
            <li class="sidebar-toggler-wrapper" style="margin-bottom: 10px;">
                <div class="sidebar-toggler"></div>
            </li>

            @if($sliderAction == "dashboard")
            <li class="active open">
            @else
            <li>
            @endif
                <a href="{{ asset('/dashboard') }}" class="active">
                    <i class="icon-briefcase"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                </a>
            </li>
            
            @if($sliderAction == "manage")
            <li class="active open">
            @else
            <li>
            @endif
                <a href="javascript:;">
                    <i class="icon-briefcase"></i>
                    <span class="title">Manage</span>
                    <span class="arrow open"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu manage_ul">
                    @if($subAction == "ballot")
                    <li class="active">
                    @else
                    <li>
                    @endif
                        <a href="{{ asset('/manage/ballot') }}">Ballot</a>
                    </li>
                    
                    @if($subAction == "race")
                    <li class="active">
                    @else
                    <li>    
                    @endif
                        <a href="{{ asset('/manage/race') }}">Race</a>
                    </li>
                    
                    @if($subAction == "candidate")
                    <li class="active">
                    @else
                    <li>
                    @endif
                        <a href="{{ asset('/manage/candidate') }}">Candidate</a>
                    </li>

                    @if($subAction == "proposition")
                    <li class="active">
                    @else
                    <li>
                    @endif
                        <a href="{{ asset('/manage/proposition') }}">Propositions</a>
                    </li>

                    @if($subAction == "mass_proposition")
                    <li class="active">
                    @else
                    <li>
                    @endif
                        <a href="{{ asset('/manage/mass_proposition') }}">Mass Propositions</a>
                    </li>

                    @if($subAction == "voter")
                    <li class="active">
                    @else
                    <li>
                    @endif
                        <a href="{{ asset('/manage/voter') }}">Voters</a>
                    </li>

                    @if($subAction == "party")
                    <li class="active">
                    @else
                    <li>
                    @endif
                        <a href="{{ asset('/manage/party') }}">Parties</a>
                    </li>

                    @if($subAction == "county")
                    <li class="active">
                    @else
                    <li>
                    @endif
                        <a href="{{ asset('/manage/county') }}">Counties</a>
                    </li>

                    @if($subAction == "language")
                    <li class="active">
                    @else
                    <li>
                    @endif
                        <a href="{{ asset('/manage/language') }}">Languages</a>
                    </li>

                    @if($subAction == "location")
                    <li class="active">
                    @else
                    <li>
                    @endif
                        <a href="{{ asset('/manage/location') }}">Locations</a>
                    </li>
                </ul>
            </li>

            @if($sliderAction == "users")
            <li class="active open">
            @else
            <li>
            @endif
                <a href="{{ asset('/users') }}">
                    <i class="icon-briefcase"></i>
                    <span class="title">Users</span>
                    <span class="selected"></span>
                </a>
            </li>

            @if($sliderAction == "result")
            <li class="active open">
            @else
            <li>
            @endif
                <a href="#">
                    <i class="icon-briefcase"></i>
                    <span class="title">Result</span>
                    <span class="arrow open"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu manage_ul">
                    @if($subAction == "candidate")
                    <li class="active">
                    @else
                    <li>
                    @endif
                        <a href="{{ asset('/result/candidate') }}">
                        Ballot Result</a>
                    </li>

                    @if($subAction == "voter")
                    <li class="active">
                    @else
                    <li>
                    @endif
                        <a href="{{ asset('/result/voter') }}">
                        Voter Result</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<script>
    
</script>