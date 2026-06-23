<x-filament-panels::page>
    <div class="space-y-8">
        <div class="text-center">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Pilih Mode Management
            </h2>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Pilih mode management yang ingin Anda akses
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ $userModeUrl }}" 
               class="relative block p-8 bg-white dark:bg-gray-800 rounded-xl border-2 border-blue-500 hover:border-blue-600 transition-all duration-200 hover:shadow-lg hover:-translate-y-1">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="p-4 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <x-filament::icon icon="heroicon-o-users" class="w-12 h-12 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">USER</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">
                            Kelola pengguna & hak akses role
                        </p>
                        <div class="mt-4 space-y-1 text-sm text-gray-400 dark:text-gray-500">
                            <p>• Tambah/Ubah/Hapus pengguna</p>
                            <p>• Atur Role & Permission</p>
                            <p>• Manajemen hak akses berbasis Shield</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{ $roleModeUrl ?? '#' }}" 
               class="relative block p-8 bg-white dark:bg-gray-800 rounded-xl border-2 border-emerald-500 hover:border-emerald-600 transition-all duration-200 hover:shadow-lg hover:-translate-y-1">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="p-4 bg-emerald-100 dark:bg-emerald-900/30 rounded-full">
                        <x-filament::icon icon="heroicon-o-lock-closed" class="w-12 h-12 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">ROLE & PERMISSION</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">
                            Kelola Role & Hak Akses (Shield)
                        </p>
                        <div class="mt-4 space-y-1 text-sm text-gray-400 dark:text-gray-500">
                            <p>• Atur permission per role</p>
                            <p>• Kelola hak akses modul & fitur</p>
                            <p>• RBAC dengan Laravel Shield</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-filament-panels::page>
