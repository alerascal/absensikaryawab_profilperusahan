@extends('layouts.app') @section('title', 'Profil') @section('content')
<div
    class="min-h-screen bg-gradient-to-br from-sky-50 via-blue-50 to-cyan-50 py-8 px-4 sm:px-6 lg:px-8"
>
    <div class="max-w-5xl mx-auto">
        <!-- Header Section with Wave Pattern -->
        <div
            class="relative bg-gradient-to-r from-sky-600 via-blue-600 to-cyan-600 rounded-3xl shadow-2xl mb-8 overflow-hidden"
        >
            <!-- Decorative Wave SVG -->
            <div class="absolute inset-0 opacity-5">
                <svg
                    class="w-full h-full"
                    viewBox="0 0 1200 120"
                    preserveAspectRatio="none"
                >
                    <path
                        d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                        fill="currentColor"
                    ></path>
                </svg>
            </div>

            <div class="relative px-6 py-10 sm:px-10 sm:py-12">
                <div
                    class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6"
                >
                    <!-- Avatar -->
                    <div class="relative">
                        <div
                            class="w-24 h-24 bg-white rounded-2xl flex items-center justify-center shadow-2xl border-2 border-white"
                        >
                            <svg
                                class="w-14 h-14 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                ></path>
                            </svg>
                        </div>
                        <div
                            class="absolute -bottom-2 -right-2 w-9 h-9 bg-green-500 rounded-full border-4 border-white shadow-xl flex items-center justify-center"
                        >
                            <div
                                class="w-3 h-3 bg-white rounded-full animate-pulse"
                            ></div>
                        </div>
                    </div>

                    <!-- Header Text -->
                    <div class="text-center sm:text-left flex-1">
                        <h1
                            class="text-3xl sm:text-4xl font-bold text-black mb-2 tracking-tight"
                        >
                            Profil Karyawan
                        </h1>
                        <p class="text-sky-100 text-base sm:text-lg">
                            Detail informasi akun & kepegawaian Anda
                        </p>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="mx-6 mb-6 sm:mx-10">
                <div
                    class="bg-white/95 backdrop-blur-sm border-l-4 border-green-500 rounded-xl p-4 shadow-lg"
                >
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg
                                class="w-6 h-6 text-green-600"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </div>
                        <p class="ml-3 text-green-800 font-semibold">
                            {{ session("success") }}
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Profile Information Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Personal Data Card -->
            <div
                class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-sky-200 overflow-hidden"
            >
                <div
                    class="bg-gradient-to-r from-sky-600 to-blue-600 px-6 py-5"
                >
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mr-4 shadow-lg"
                        >
                            <svg
                                class="w-7 h-7 text-sky-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-black drop-shadow-sm">
                            Data Pribadi
                        </h3>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <div
                        class="flex items-center justify-between py-3 border-b-2 border-sky-100 hover:bg-sky-50 transition-colors rounded-lg px-3 -mx-3"
                    >
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-11 h-11 bg-sky-100 rounded-xl flex items-center justify-center shadow-sm"
                            >
                                <svg
                                    class="w-6 h-6 text-sky-700"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    ></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-semibold text-base"
                                >Nama</span
                            >
                        </div>
                        <span
                            class="text-gray-900 font-bold text-right"
                            >{{ $user->name }}</span
                        >
                    </div>

                    <div
                        class="flex items-center justify-between py-3 border-b-2 border-sky-100 hover:bg-sky-50 transition-colors rounded-lg px-3 -mx-3"
                    >
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-11 h-11 bg-cyan-100 rounded-xl flex items-center justify-center shadow-sm"
                            >
                                <svg
                                    class="w-6 h-6 text-cyan-700"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    ></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-semibold text-base"
                                >Email</span
                            >
                        </div>
                        <span
                            class="text-gray-900 font-semibold text-right text-sm sm:text-base break-all"
                            >{{ $user->email }}</span
                        >
                    </div>

                    <div
                        class="flex items-center justify-between py-3 hover:bg-sky-50 transition-colors rounded-lg px-3 -mx-3"
                    >
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center shadow-sm"
                            >
                                <svg
                                    class="w-6 h-6 text-blue-700"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"
                                    ></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-semibold text-base"
                                >ID Pegawai</span
                            >
                        </div>
                        <span
                            class="text-gray-900 font-mono font-bold text-base"
                            >{{ $user->employee_id ?? '-' }}</span
                        >
                    </div>
                </div>
            </div>

            <!-- Employment Data Card -->
            <div
                class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-cyan-200 overflow-hidden"
            >
                <div
                    class="bg-gradient-to-r from-cyan-600 to-blue-600 px-6 py-5"
                >
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mr-4 shadow-lg"
                        >
                            <svg
                                class="w-7 h-7 text-cyan-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2.5"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 0h4m-4 0v2m-6 4h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-black drop-shadow-sm">
                            Data Kepegawaian
                        </h3>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <div
                        class="flex items-center justify-between py-3 border-b-2 border-cyan-100 hover:bg-cyan-50 transition-colors rounded-lg px-3 -mx-3"
                    >
                        <span class="text-gray-700 font-semibold text-base"
                            >Departemen</span
                        >
                        <span
                            class="text-gray-900 font-bold text-right"
                            >{{ $user->department->name ?? '-' }}</span
                        >
                    </div>

                    <div
                        class="flex items-center justify-between py-3 border-b-2 border-cyan-100 hover:bg-cyan-50 transition-colors rounded-lg px-3 -mx-3"
                    >
                        <span class="text-gray-700 font-semibold text-base"
                            >Jabatan</span
                        >
                        <span
                            class="text-gray-900 font-bold text-right"
                            >{{ $user->position ?? '-' }}</span
                        >
                    </div>

                    <div
                        class="flex items-center justify-between py-3 border-b-2 border-cyan-100 hover:bg-cyan-50 transition-colors rounded-lg px-3 -mx-3"
                    >
                        <span class="text-gray-700 font-semibold text-base"
                            >Status Kerja</span
                        >
                        <span
                            class="text-gray-900 font-bold text-right"
                            >{{ $user->employment_status ?? '-' }}</span
                        >
                    </div>

                    <div
                        class="flex items-center justify-between py-3 border-b-2 border-cyan-100 hover:bg-cyan-50 transition-colors rounded-lg px-3 -mx-3"
                    >
                        <span class="text-gray-700 font-semibold text-base"
                            >Tanggal Bergabung</span
                        >
                        <span
                            class="text-gray-900 font-bold text-right"
                            >{{ $user->join_date ? \Carbon\Carbon::parse($user->join_date)->format('d M Y') : '-' }}</span
                        >
                    </div>

                    <div
                        class="flex items-center justify-between py-3 hover:bg-cyan-50 transition-colors rounded-lg px-3 -mx-3"
                    >
                        <span class="text-gray-700 font-semibold text-base"
                            >Status Akun</span
                        >
                        <span
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold {{ $user->is_active ? 'bg-green-500 text-black shadow-lg' : 'bg-red-500 text-black shadow-lg' }}"
                        >
                            <div
                                class="w-2.5 h-2.5 rounded-full mr-2 bg-white animate-pulse"
                            ></div>
                            {{ $user->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6">
            <!-- Total Attendance -->
            <div
                class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-green-200 p-6 hover:-translate-y-1"
            >
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform"
                    >
                        <svg
                            class="w-9 h-9 text-black"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-700 font-semibold mb-2">
                    Total Kehadiran
                </p>
                <p class="text-4xl font-bold text-green-600">
                    {{ $user->attendances_count ?? 0 }}
                </p>
            </div>

            <!-- Late Count -->
            <div
                class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-amber-400 p-6 hover:-translate-y-1"
            >
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-16 h-16 bg-amber-100 border-2 border-amber-400 rounded-2xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform"
                    >
                        <svg
                            class="w-9 h-9 text-amber-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </div>
                </div>

                <p class="text-sm text-gray-700 font-semibold mb-2">
                    Keterlambatan
                </p>
                <p class="text-4xl font-bold text-amber-600">
                    {{ $user->late_count ?? 0 }}
                </p>
            </div>

            <!-- Leave Count -->
            <div
                class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-sky-200 p-6 hover:-translate-y-1"
            >
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-16 h-16 bg-sky-500 rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform"
                    >
                        <svg
                            class="w-9 h-9 text-black"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            ></path>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-700 font-semibold mb-2">
                    Izin / Cuti
                </p>
                <p class="text-4xl font-bold text-sky-600">
                    {{ $user->leave_count ?? 0 }}
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div
            class="bg-white rounded-2xl shadow-lg border border-sky-100 p-6 sm:p-8"
        >
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-sky-400 to-blue-500 rounded-xl flex items-center justify-center mr-3"
                >
                    <svg
                        class="w-5 h-5 text-black"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"
                        ></path>
                    </svg>
                </div>
                Aksi Cepat
            </h3>
            <div class="flex flex-col sm:flex-row gap-4">
                <a
                    href="{{ route('settings.edit') }}"
                    class="flex-1 inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-sky-500 to-blue-600 text-black font-semibold rounded-xl hover:from-sky-600 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-sky-200 transition-all duration-300 shadow-lg shadow-sky-200 hover:shadow-xl hover:-translate-y-0.5 group"
                >
                    <svg
                        class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        ></path>
                    </svg>
                    Edit Profil
                </a>

                <form
                    action="{{ route('settings.destroy') }}"
                    method="POST"
                    class="flex-1"
                    onsubmit="return confirm('Yakin ingin menghapus akun ini? Data absensi akan tetap tersimpan.')"
                >
                    @csrf @method('DELETE')
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-red-500 to-rose-600 text-black font-semibold rounded-xl hover:from-red-600 hover:to-rose-700 focus:outline-none focus:ring-4 focus:ring-red-200 transition-all duration-300 shadow-lg shadow-red-200 hover:shadow-xl hover:-translate-y-0.5 group"
                    >
                        <svg
                            class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            ></path>
                        </svg>
                        Hapus Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
