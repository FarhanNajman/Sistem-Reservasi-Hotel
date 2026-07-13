@extends('layouts.admin')

@section('title', 'Daftar Pengguna - N★JM Hotel')

@section('content')
<div class="section">
    <div class="section-header">
        <h2>Daftar Pengguna Terdaftar</h2>
        <p>Kelola semua akun pengguna dan administrator yang terdaftar dalam sistem hotel.</p>
    </div>
 
    <div style="background: white; border-radius: var(--radius-lg); overflow: hidden; padding: 20px;">
        @if($users->isEmpty())
            <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                <i data-lucide="users" style="width: 48px; height: 48px; margin-bottom: 16px;"></i>
                <h3>Belum Ada Pengguna</h3>
                <p>Saat ini belum ada data pengguna.</p>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background-color: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Nama Lengkap</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Username</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Email</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Tipe Akun (Role)</th>
                            <th style="padding: 12px 16px; font-weight: 600; color: var(--text-dark);">Bergabung Sejak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: background-color 0.2s;">
                            <td style="padding: 12px 16px; font-weight: 500;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background-color: var(--primary-color); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td style="padding: 12px 16px; color: var(--text-muted);">{{ $user->username }}</td>
                            <td style="padding: 12px 16px; color: var(--text-muted);">{{ $user->email }}</td>
                            <td style="padding: 12px 16px;">
                                @if($user->role === 'admin')
                                    <span style="display:inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 600; background-color: #fef08a; color: #854d0e;">
                                        <i data-lucide="shield" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle;"></i> Admin
                                    </span>
                                @else
                                    <span style="display:inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 600; background-color: #e0f2fe; color: #075985;">
                                        <i data-lucide="user" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle;"></i> User Biasa
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 12px 16px; color: var(--text-muted);">
                                {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
