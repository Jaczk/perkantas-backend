<aside>
    <div class="hidden lg:block top-0 left lg:w-[300px] w-full overflow-y-auto h-full bg-white z-0 md:z-10" id="sidebarHRIS">
        <div class="px-6 py-[50px] gap-y-[50px] flex flex-col">
            <div class="flex items-center justify-between">
                <a href="{{ route('user.dashboard') }}" class="flex justify-center">
                    <img src="/assets/images/perkantas.png" alt="" class="scale-100 hover:opacity-75" />
                </a>
                {{-- <a href="#" id="toggleCloseSidebar" class="z-20 lg:hidden">
                    <svg class="w-6 h-6 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                    </svg>
                </a> --}}
            </div>
            <nav>
                <div class="flex flex-col gap-4">
                    <div class="text-lg font-bold text-secondary">Sehari-hari</div>
                    <a href="{{ route('user.dashboard') }}"
                        class="flex flex-row p-2 text-base rounded-lg nav-link hover:bg-slate-100 hover:text-[18px] md:hover:text-lg">
                        <img src="/assets/svgs/ic-home.svg" alt="" />
                        <p class="px-3 font-normal">Dasbor</p>
                    </a>
                    <a href="{{ route('user.loan') }}"
                        class="flex flex-row p-2 text-base rounded-lg nav-link hover:bg-slate-100 hover:text-[18px] md:hover:text-lg">
                        <img src="/assets/svgs/ic-grid.svg" alt="" />
                        <p class="px-3 font-normal">Peminjaman</p>
                    </a>
                    <a href="{{ route('user.procurement') }}"
                        class="flex flex-row p-2 text-base rounded-lg nav-link hover:bg-slate-100 text-[18px] hover:text-[20px] md:hover:text-lg">
                        <img src="/assets/svgs/ic-box.svg" alt="" />
                        <p class="px-3 font-normal">Form Pengadaan</p>
                    </a>
                    <a href="{{ route('user.good') }}"
                        class="flex flex-row p-2 text-[15px] rounded-lg nav-link hover:text-[16px] hover:bg-slate-100 md:hover:text-lg">
                        <img src="/assets/svgs/ic-briefcase.svg" alt="" />
                        <p class="px-3 font-normal">Daftar Barang</p>
                    </a>
                    <a href="{{ route('user.loan.history') }}"
                        class="flex flex-row p-2 text-base rounded-lg nav-link hover:bg-slate-100 text-base hover:text-[18px] md:hover:text-lg">
                        <img src="/assets/svgs/ic-flag.svg" alt="" />
                        <p class="px-3 font-normal">Riwayat Peminjaman</p>
                    </a>
                </div>
            </nav>
            <div class="flex flex-col gap-4">
                <div class="text-lg font-bold text-secondary">Aksi</div>
                
                <a href="{{ route('user.logout') }}"
                    class="flex flex-row p-2 text-base rounded-lg nav-link hover:bg-slate-100 hover:text-lg">
                    <img src="/assets/svgs/ic-signout.svg" alt="" />
                    <p class="px-3">Keluar</p>
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

@section('sidebar-styles')
<style>
    /* Style for the sidebar when it should fly over the content */
    @media (max-width: 767px) {
        #sidebarHRIS {
            /* ... Other styles ... */
            transition: left 0.3s ease, opacity 0.3s ease; /* Add opacity transition */
            opacity: 0; /* Start with 0 opacity */
        }

        #sidebarHRIS.with-transition {
            opacity: 1; /* Change opacity to 1 to show the sidebar with a fade-in effect */
        }
    }
</style>
@endsection
