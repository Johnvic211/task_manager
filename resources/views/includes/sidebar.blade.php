<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <ul class="sidebar-nav" style="font-family: 'Kanit', sans-serif; font-size:16px;">
            @if(Auth::user()->type == 'Manager')
            <li class="sidebar-item">
                <a class="sidebar-link"  href="{{ route('tasks.index') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="align-middle fw-bold ">My Tasks</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('published-tasks.index') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="align-middle fw-bold">Published Tasks</span>
                </a>
            </li>
            @elseif(Auth::user()->type == 'Employee')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('published-tasks.index') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="align-middle fw-bold">My Tasks</span>
                </a>
            </li>
            @endif
            <li class="sidebar-item">
                <form action="{{ route('sign-out') }}" method="POST">
                    @csrf
                    <button class="sidebar-link" type="submit" style="border: 0; width: 100%; text-align:left">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="align-middle fw-bold">Sign out</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</nav>
