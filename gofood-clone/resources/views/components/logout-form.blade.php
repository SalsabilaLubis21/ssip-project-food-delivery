<div>
    <form method="POST" action="{{ route('logout') }}" style="display: inline-block;">
        @csrf
        <button type="submit" class="btn-logout">
            Logout
        </button>
    </form>
</div>
