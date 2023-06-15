<aside>
    <div
    class="hidden lg:block sticky top-0 left lg:max-w-[295px] w-full overflow-y-auto h-full bg-white z-0"
    id="sidebarHRIS"
  >
    <div class="px-6 py-[50px] gap-y-[50px] flex flex-col">
      <div class="flex items-center justify-between">
        <a href="#" class="flex justify-center">
          <img src="/assets/images/perkantas.png" alt="" class="hover:scale-110"/>
        </a>
        <a href="#" id="toggleCloseSidebar" class="lg:hidden">
          <svg
            class="w-6 h-6 text-dark"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            ></path>
          </svg>
        </a>
      </div>
      <nav>
        <div class="flex flex-col gap-4">
            <div class="text-lg font-bold text-secondary">Daily Use</div>
            <a href="{{route('user.dashboard')}}" class="rounded-lg nav-link hover:bg-slate-100 hover:text-xl">
                <img src="/assets/svgs/ic-home.svg" alt="" />
                Overview
              </a>
            <a :to="{ name: 'Loan' }" class="rounded-lg nav-link hover:bg-slate-100 hover:text-xl">
              <img src="/assets/svgs/ic-grid.svg" alt="" />
              Peminjaman
            </a>
            <a :to="{ name: 'Procurement' }" class="rounded-lg nav-link hover:bg-slate-100 hover:text-xl">
              <img src="/assets/svgs/ic-box.svg" alt="" />
              Form Pengadaan
            </a>
            <a :to="{ name: 'Good' }" class="rounded-lg nav-link hover:bg-slate-100 hover:text-xl">
              <img src="/assets/svgs/ic-briefcase.svg" alt="" />
              Daftar Barang
            </a>
          </div>
      </nav>
      <div class="flex flex-col gap-4">
        <div class="text-lg font-bold text-secondary">Others</div>
        <!-- <button :to="{name: 'Profile'}" class="nav-link hover:bg-slate-100">
          <img src="/assets/svgs/ic-users.svg" alt="" />
          Profile
        </button> -->
        <a href="{{ route('user.logout') }}" class="rounded-lg nav-link hover:bg-slate-100 hover:text-xl">
          <img src="assets/svgs/ic-signout.svg" alt="" />
          Logout
        </a>
        {{-- <button :to="{name: '/'}" class="cursor-default nav-link disabled:true">
          <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
          Profile -->
        </button>

        <button :to="{name: '/'}" class="cursor-default nav-link disabled:true">
          <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
          Profile -->
        </button>
        <button :to="{name: '/'}" class="cursor-default nav-link disabled:true">
          <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
          Profile -->
        </button>
        <button :to="{name: '/'}" class="cursor-default nav-link disabled:true">
          <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
          Profile -->
        </button>
        <button :to="{name: '/'}" class="cursor-default nav-link disabled:true">
          <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
          Profile -->
        </button>
        <button :to="{name: '/'}" class="cursor-default nav-link disabled:true">
          <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
          Profile -->
        </button>
        <button :to="{name: '/'}" class="cursor-default nav-link disabled:true">
          <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
          Profile -->
        </button>
        <button :to="{name: '/'}" class="cursor-default nav-link disabled:true">
          <!-- <img src="/assets/svgs/ic-users.svg" alt="" />
          Profile -->
        </button> --}}
      </div>
    </div>
  </div>
</aside>