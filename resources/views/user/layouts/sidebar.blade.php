<aside>
    <div class="hidden lg:block sticky top-0 left lg:max-w-[300px] w-full overflow-y-auto h-full bg-white z-0"
        id="sidebarHRIS">
        <div class="px-6 py-[50px] gap-y-[50px] flex flex-col">
            <div class="flex items-center justify-between">
                <a href="#" class="flex justify-center">
                    <img src="/assets/images/perkantas.png" alt="" class="scale-95 hover:scale-110" />
                </a>
                <a href="#" id="toggleCloseSidebar" class="lg:hidden">
                    <svg class="w-6 h-6 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </a>
            </div>
            <nav>
                <div class="flex flex-col gap-4">
                    <div class="text-lg font-bold text-secondary">Daily Use</div>
                    <a href="{{ route('user.dashboard') }}"
                        class="flex flex-row p-2 text-base rounded-lg nav-link hover:bg-slate-100 hover:text-lg">
                        <img src="/assets/svgs/ic-home.svg" alt="" />
                        <p class="px-3 font-normal">Overview</p>
                    </a>
                    <a href="{{ route('user.dashboard') }}"
                        class="flex flex-row p-2 text-base rounded-lg nav-link hover:bg-slate-100 hover:text-lg">
                        <img src="/assets/svgs/ic-grid.svg" alt="" />
                        <p class="px-3 font-normal">Peminjaman</p>
                    </a>
                    <a href="{{ route('user.dashboard') }}"
                        class="flex flex-row p-2 text-base rounded-lg nav-link hover:bg-slate-100 hover:text-lg">
                        <img src="/assets/svgs/ic-box.svg" alt="" />
                        <p class="px-3 font-normal">Form Pengadaan</p>
                    </a>
                    <a href="{{ route('user.dashboard') }}"
                        class="flex flex-row p-2 text-base rounded-lg nav-link hover:bg-slate-100 hover:text-lg">
                        <img src="/assets/svgs/ic-briefcase.svg" alt="" />
                        <p class="px-3 font-normal">Daftar Barang</p>
                    </a>
                </div>
            </nav>
            <div class="flex flex-col gap-4">
                <div class="text-lg font-bold text-secondary">Others</div>
                <!-- <button :to="{ name: 'Profile' }" class="nav-link hover:bg-slate-100">
          <img src="/assets/svgs/ic-users.svg" alt="" />
          Profile
        </button> -->
                <a href="{{ route('user.logout') }}"
                    class="flex flex-row p-2 text-base rounded-lg nav-link hover:bg-slate-100 hover:text-lg">
                    <img src="assets/svgs/ic-signout.svg" alt="" />
                    <p class="px-3">Logout</p>
                </a>
                <a href="#" class="cursor-default nav-link disabled:true">
                    <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
                    Profile -->
                </a>
                <a href="#" class="cursor-default nav-link disabled:true">
                    <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
                    Profile -->
                </a>
                <a href="#" class="cursor-default nav-link disabled:true">
                    <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
                    Profile -->
                </a>
                <a href="#" class="cursor-default nav-link disabled:true">
                    <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
                    Profile -->
                </a>
                <a href="#" class="cursor-default nav-link disabled:true">
                    <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
                    Profile -->
                </a>
                <a href="#" class="cursor-default nav-link disabled:true">
                    <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
                    Profile -->
                </a>
                <a href="#" class="cursor-default nav-link disabled:true">
                    <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
                    Profile -->
                </a>
                <a href="#" class="cursor-default nav-link disabled:true">
                    <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
                    Profile -->
                </a>
            </div>
        </div>
    </div>
</aside>
