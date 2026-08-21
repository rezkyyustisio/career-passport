<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Passport - {{ $profile->student->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 p-8">
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative">
            <a href="{{ route('passport.download', $profile->student_id) }}"
               class="absolute top-6 right-6 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-semibold shadow-sm transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export PDF
            </a>
            <div>
                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-full border border-indigo-100">
                    Integrated Digital Career Passport
                </span>
                <h1 class="text-2xl font-bold text-slate-900 mt-2">{{ $profile->student->name }}</h1>
                <p class="text-sm text-slate-500">{{ $profile->student->nim }} • {{ $profile->student->study_program }}</p>
            </div>
            <div class="text-right bg-slate-50 p-4 rounded-xl border border-slate-100">
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Employability Index</div>
                <div class="text-3xl font-extrabold text-blue-600 my-1">{{ $profile->employability_index ?? '0.00' }}</div>
                <span class="text-xs font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">
                    {{ $profile->readiness_status ?? 'Not Evaluated' }}
                </span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h2 class="text-base font-bold text-slate-900 mb-4">Rekomendasi Karir (AI Match Engine)</h2>
            <div class="space-y-4">
                @forelse($jobMatches as $match)
                <div class="p-5 rounded-xl border border-slate-100 bg-slate-50 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-slate-900">{{ $match['job_title'] }}</h3>
                        <p class="text-sm font-medium text-slate-500">{{ $match['company_name'] }}</p>
                        <div class="flex flex-wrap gap-1 mt-2">
                            @foreach($match['matched_skills'] as $skill)
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-md">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-base font-extrabold text-emerald-600">{{ $match['match_percentage'] }}% Kesesuaian</span>
                        <button class="px-4 py-2 bg-slate-900 text-white rounded-lg text-xs font-semibold">Ajukan Lamaran</button>
                    </div>
                </div>
                @empty
                <p class="text-sm text-slate-400 py-4 text-center">Belum ada kesesuaian lowongan kerja.</p>
                @endforelse
            </div>
        </div>

    </div>
</body>
</html>
