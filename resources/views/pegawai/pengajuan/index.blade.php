@extends('layouts.app')

@section('content')
<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">Pengajuan Saya</h2>

    <a href="{{ route('pegawai.pengajuan.create') }}" class="btn btn-primary mb-4">
        <i class="fas fa-plus"></i> Buat Pengajuan
    </a>

    @if($pengajuans->count())
        <table class="table-auto w-full border border-gray-200 rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Tanggal</th>
                    <th class="px-4 py-2 border">Tipe</th>
                    <th class="px-4 py-2 border">Judul</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuans as $p)
                <tr class="text-center">
                    <td class="px-4 py-2 border">{{ $p->created_at->format('d-m-Y') }}</td>
                    <td class="px-4 py-2 border capitalize">{{ $p->type }}</td>
                    <td class="px-4 py-2 border">{{ $p->title }}</td>
                    <td class="px-4 py-2 border capitalize">{{ $p->status }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('pegawai.pengajuan.show', $p->id) }}" class="text-blue-600 hover:underline">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $pengajuans->links() }}
        </div>
    @else
        <div class="text-gray-500">Belum ada pengajuan.</div>
    @endif
</div>
@endsection
