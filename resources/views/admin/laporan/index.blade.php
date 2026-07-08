<x-admin-layout>
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Laporan Kerusakan</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola dan pantau semua laporan kerusakan.</p>
        </div>
        <div class="flex items-center gap-3 mt-4 md:mt-0">
            <button type="button" id="btnBulkDelete" onclick="submitBulkDelete()"
               class="hidden inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg shadow hover:bg-red-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Hapus Terpilih (<span id="selectedCount">0</span>)
            </button>
            <a href="{{ route('laporan.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Laporan
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 rounded-r shadow-sm">
        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="text-green-800 font-medium text-sm">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Filter Status --}}
    <div class="mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Filter Status</p>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('laporan.index') }}" 
                   class="px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200
                   {{ !request('status') 
                      ? 'bg-blue-600 text-white shadow-md' 
                      : 'bg-gray-50 text-gray-600 border border-gray-200 hover:bg-gray-100' }}">
                    Semua
                </a>
                <a href="{{ route('laporan.index', ['status' => 'menunggu']) }}" 
                   class="px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200
                   {{ request('status') == 'menunggu' 
                      ? 'bg-gray-600 text-white shadow-md' 
                      : 'bg-gray-50 text-gray-600 border border-gray-200 hover:bg-gray-100' }}">
                    Menunggu
                </a>
                <a href="{{ route('laporan.index', ['status' => 'diverifikasi']) }}" 
                   class="px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200
                   {{ request('status') == 'diverifikasi' 
                      ? 'bg-blue-500 text-white shadow-md' 
                      : 'bg-gray-50 text-gray-600 border border-gray-200 hover:bg-gray-100' }}">
                    Diverifikasi
                </a>
                <a href="{{ route('laporan.index', ['status' => 'ditugaskan']) }}" 
                   class="px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200
                   {{ request('status') == 'ditugaskan' 
                      ? 'bg-yellow-500 text-white shadow-md' 
                      : 'bg-gray-50 text-gray-600 border border-gray-200 hover:bg-gray-100' }}">
                    Ditugaskan
                </a>
                <a href="{{ route('laporan.index', ['status' => 'selesai']) }}" 
                   class="px-4 py-2 rounded-lg font-medium text-sm transition-all duration-200
                   {{ request('status') == 'selesai' 
                      ? 'bg-green-500 text-white shadow-md' 
                      : 'bg-gray-50 text-gray-600 border border-gray-200 hover:bg-gray-100' }}">
                    Selesai
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="p-4 w-12 text-center">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        </th>
                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelapor</th>
                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Foto</th>
                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Petugas</th>
                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Tugas</th>
                        <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($laporans as $l)
                    <tr class="hover:bg-blue-50/50 transition duration-150 group">
                        <td class="p-4 text-center">
                            <input type="checkbox" value="{{ $l->id }}" class="row-checkbox w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold shadow-sm">
                                    {{ strtoupper(substr($l->nama_pelapor, 0, 1)) }}
                                </div>
                                <div class="font-medium text-gray-900">{{ $l->nama_pelapor }}</div>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            @if($l->foto)
                                <img src="{{ $l->foto }}" alt="Foto Kerusakan" class="w-16 h-12 object-cover rounded-md shadow-sm border border-gray-200 mx-auto hover:scale-125 transition-transform duration-300">
                            @else
                                <div class="w-16 h-12 bg-gray-50 rounded-md flex items-center justify-center border border-gray-200 mx-auto">
                                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </td>
                        <td class="p-4">
                            <p class="font-medium text-gray-900">{{ $l->judul }}</p>
                        </td>

                        <td class="p-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                            {{ $l->status == 'menunggu' ? 'bg-gray-50 text-gray-700 border-gray-200' :
                               ($l->status == 'diverifikasi' ? 'bg-blue-50 text-blue-700 border-blue-200' :
                               ($l->status == 'ditolak' ? 'bg-red-50 text-red-700 border-red-200' :
                               ($l->status == 'ditugaskan' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' :
                               ($l->status == 'proses' ? 'bg-purple-50 text-purple-700 border-purple-200' :
                               'bg-green-50 text-green-700 border-green-200')))) }}">
                                {{ ucfirst($l->status) }}
                            </span>
                        </td>

                        <td class="p-4">
                            @if($l->petugas)
                                <div class="flex items-center gap-2 text-sm text-gray-900">
                                    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold shadow-sm">
                                        {{ strtoupper(substr($l->petugas->nama, 0, 1)) }}
                                    </div>
                                    <span class="font-medium">{{ $l->petugas->nama }}</span>
                                </div>
                            @else
                                <span class="text-sm text-gray-400 italic">Belum ditugaskan</span>
                            @endif
                        </td>

                        <td class="p-4">
                            @if($l->penugasan)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $l->penugasan->tanggal_tugas->format('d/m/Y') }}
                                </div>
                            @else
                                <span class="text-sm text-gray-400 italic">-</span>
                            @endif
                        </td>

                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Detail --}}
                                <a href="{{ route('laporan.show', $l->id) }}"
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition tooltip"
                                   title="Detail Laporan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('laporan.edit', $l->id) }}"
                                   class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition tooltip"
                                   title="Edit Laporan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                {{-- Hapus --}}
                                <form method="POST" action="{{ route('laporan.destroy', $l->id) }}" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus laporan ini?')"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition tooltip"
                                            title="Hapus Laporan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p>Belum ada data laporan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if(method_exists($laporans, 'hasPages') && $laporans->hasPages())
    <div class="mt-6">
        {{ $laporans->links() }}
    </div>
    @elseif(!method_exists($laporans, 'hasPages'))
    <div class="mt-6">
        {{ $laporans->links() }}
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const btnBulkDelete = document.getElementById('btnBulkDelete');
            const selectedCountSpan = document.getElementById('selectedCount');
            
            function updateBulkDeleteButton() {
                const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
                selectedCountSpan.textContent = checkedCount;
                if (checkedCount > 0) {
                    btnBulkDelete.classList.remove('hidden');
                } else {
                    btnBulkDelete.classList.add('hidden');
                    if (selectAll) selectAll.checked = false;
                }
            }

            if(selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                    updateBulkDeleteButton();
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (selectAll) {
                        const allChecked = document.querySelectorAll('.row-checkbox:checked').length === checkboxes.length;
                        selectAll.checked = allChecked && checkboxes.length > 0;
                    }
                    updateBulkDeleteButton();
                });
            });
        });

        function submitBulkDelete() {
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            if (checkedBoxes.length === 0) return;

            if (confirm('Yakin ingin menghapus ' + checkedBoxes.length + ' data yang dipilih?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("laporan.bulk-destroy") }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                checkedBoxes.forEach(cb => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = cb.value;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-admin-layout>