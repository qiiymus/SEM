<nav class="relative h-screen w-48 px-4 pt-8 pb-4 fixed left-0 top-0" style="background-color: #0C1446;">
    <ul class="space-y-3">
        <a href="{{ route('dashboard') }}">
            <x-nav-item>
                HOME
            </x-nav-item>
        </a>
        <a href="#">
            <x-nav-item>
                USER LIST
            </x-nav-item>
        </a>
        <a href="{{ route('product') }}">
            <x-nav-item>
                INVENTORY
            </x-nav-item>
        </a>
        <a href="#">
            <x-nav-item>
                PAYMENT
            </x-nav-item>
        </a>
        <a href="#">
            <x-nav-item>
                REPORT
            </x-nav-item>
        </a>
        <a href="#">
            <x-nav-item>
                DUTY ROSTER
            </x-nav-item>
        </a>
    </ul>
</nav>
