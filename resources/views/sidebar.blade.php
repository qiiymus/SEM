<nav class="relative h-screen w-48 px-4 pt-8 pb-4 fixed left-0 top-0" style="background-color: #0C1446;">
    <ul class="space-y-3">
        <x-nav-item>
            <a href="{{ route('dashboard') }}">HOME</a>
        </x-nav-item>
        <x-nav-item>
            <a href="#">USER LIST</a>
        </x-nav-item>
        <x-nav-item>
            <a href="{{ route('product') }}">INVENTORY</a>
        </x-nav-item>
        <x-nav-item>
            <a href="#">PAYMENT</a>
        </x-nav-item>
        <x-nav-item>
            <a href="#">REPORT</a>
        </x-nav-item>
        <x-nav-item>
            <a href="#">DUTY ROSTER</a> 
        </x-nav-item>
    </ul>
</nav>