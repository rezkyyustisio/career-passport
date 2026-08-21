<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCMS - Dashboard Manajerial</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
    <header class="bg-white border-b border-slate-200 px-8 py-4 flex justify-between items-center sticky top-0 z-10">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Smart Career Management System (SCMS)</h1>
            <p class="text-xs text-slate-500">UPA Pengembangan Karir & Kewirausahaan</p>
        </div>
        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-full border border-blue-200">
            Smart Campus Ecosystem
        </span>
    </header>

    <main class="p-8 max-w-7xl mx-auto space-y-6">
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Mahasiswa Terdata</p>
                <h3 class="text-3xl font-extrabold mt-2 text-slate-800">{{ $totalEvaluated }}</h3>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Rata-rata Index</p>
                <h3 class="text-3xl font-extrabold mt-2 text-blue-600">{{ number_format($avgScore, 1) }}</h3>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Kategori Siap Kerja</p>
                <h3 class="text-3xl font-extrabold mt-2 text-emerald-600">{{ $highReadinessCount }}</h3>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Mitra Industri Aktif</p>
                <h3 class="text-3xl font-extrabold mt-2 text-indigo-600">{{ $totalJobs }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
                <h2 class="font-bold text-slate-800">Distribusi Skor Employability Mahasiswa</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-xs font-semibold text-slate-500 bg-slate-50">
                            <th class="px-6 py-4">Mahasiswa</th>
                            <th class="px-6 py-4 text-center">Employability Index</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($profiles as $item)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $item->student->name }}</div>
                                <div class="text-xs text-slate-400">{{ $item->student->nim }} • {{ $item->student->study_program }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-bold {{ ($item->employability_index >= 80) ? 'text-emerald-600' : (($item->employability_index >= 65) ? 'text-blue-600' : 'text-amber-600') }}">
                                {{ $item->employability_index ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 text-xs rounded-md font-medium {{ ($item->employability_index >= 80) ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $item->readiness_status ?? 'Pending' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <form method="POST" action="{{ route('upa.score', $item->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition">Hitung</button>
                                </form>
                                <a href="{{ route('passport.show', $item->student_id) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition">Passport</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100">
                {{ $profiles->links() }}
            </div>
        </div>
    </main>
</body>
</html>
