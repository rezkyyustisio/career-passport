<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Career Passport - {{ $profile->student->name }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 15px; margin-bottom: 25px; }
        .header h1 { margin: 0; color: #1e3a8a; font-size: 24px; }
        .header p { margin: 5px 0 0; color: #64748b; }
        .profile-table { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .profile-table td { padding: 10px; border: 1px solid #e2e8f0; }
        .profile-table .label { font-weight: bold; background-color: #f8fafc; width: 30%; }
        .score-box { text-align: center; background-color: #eff6ff; border: 1px solid #bfdbfe; padding: 15px; border-radius: 8px; margin-bottom: 30px; }
        .score-box h2 { margin: 0; color: #1d4ed8; font-size: 28px; }
        .score-box p { margin: 5px 0 0; font-weight: bold; color: #0f172a; }
        .job-list { width: 100%; border-collapse: collapse; }
        .job-list th, .job-list td { padding: 12px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        .job-list th { background-color: #f1f5f9; }
        .match-score { color: #16a34a; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Integrated Digital Career Passport</h1>
        <p>Smart Career Management System (SCMS)</p>
    </div>

    <table class="profile-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td>{{ $profile->student->name }}</td>
            <td class="label">NIM</td>
            <td>{{ $profile->student->nim }}</td>
        </tr>
        <tr>
            <td class="label">Program Studi</td>
            <td>{{ $profile->student->study_program }}</td>
            <td class="label">IPK</td>
            <td>{{ $profile->student->ipk }}</td>
        </tr>
    </table>

    <div class="score-box">
        <p>Employability Index</p>
        <h2>{{ $profile->employability_index ?? '0.00' }}</h2>
        <p>Status: {{ $profile->readiness_status ?? 'Not Evaluated' }}</p>
    </div>

    <h3 style="color: #1e293b; border-bottom: 1px solid #cbd5e1; padding-bottom: 5px;">Rekomendasi Karir Berbasis AI</h3>

    <table class="job-list">
        <thead>
            <tr>
                <th>Posisi & Perusahaan</th>
                <th>Kesesuaian AI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jobMatches as $match)
            <tr>
                <td>
                    <strong>{{ $match['job_title'] }}</strong><br>
                    <span style="font-size: 12px; color: #64748b;">{{ $match['company_name'] }} ({{ $match['required_field'] }})</span>
                </td>
                <td class="match-score">{{ $match['match_percentage'] }}%</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" style="text-align: center; color: #94a3b8;">Belum ada rekomendasi yang sesuai.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
