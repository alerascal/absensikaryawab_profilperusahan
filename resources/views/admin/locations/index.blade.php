@extends('layouts.app')

@section('title', 'Manajemen Lokasi Absensi')

@section('content')
<div class="content-wrapper">
    <div class="page-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-text">
                    <h1 class="page-title">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Manajemen Lokasi Absensi
                    </h1>
                    <p class="page-subtitle">Kelola lokasi yang diizinkan untuk absensi</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary btn-add">
                        <i class="fas fa-plus-circle mr-2"></i>
                        <span>Tambah Lokasi</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                <div class="alert-content">
                    <i class="fas fa-check-circle alert-icon"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                <div class="alert-content">
                    <i class="fas fa-exclamation-circle alert-icon"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Content Card -->
        <div class="card card-modern">
            <div class="card-body">
                @if ($locations->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <h3 class="empty-state-title">Belum ada lokasi absensi</h3>
                        <p class="empty-state-text">Mulai dengan menambahkan lokasi pertama untuk sistem absensi</p>
                        <a href="{{ route('admin.locations.create') }}" class="btn btn-primary btn-add mt-3">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Tambah Lokasi Pertama
                        </a>
                    </div>
                @else
                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-lg-block">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <i class="fas fa-hashtag"></i>
                                    </th>
                                    <th width="35%">
                                        <i class="fas fa-map-marker-alt mr-2"></i>Nama Lokasi
                                    </th>
                                    <th width="30%">
                                        <i class="fas fa-crosshairs mr-2"></i>Koordinat
                                    </th>
                                    <th width="15%" class="text-center">
                                        <i class="fas fa-circle-notch mr-2"></i>Radius
                                    </th>
                                    <th width="15%" class="text-center">
                                        <i class="fas fa-cog mr-2"></i>Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($locations as $index => $location)
                                    <tr class="animate__animated animate__fadeIn">
                                        <td>
                                            <div class="table-number">{{ $locations->firstItem() + $index }}</div>
                                        </td>
                                        <td>
                                            <div class="location-name">
                                                <div class="location-badge"></div>
                                                <span>{{ $location->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="coordinate-text">
                                                <i class="fas fa-map-pin text-danger mr-2"></i>
                                                <span>{{ $location->latitude }}, {{ $location->longitude }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-radius">
                                                <i class="fas fa-bullseye mr-1"></i>{{ $location->radius }}m
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.locations.edit', $location->id) }}" 
                                                   class="btn btn-action btn-edit" 
                                                   title="Edit Lokasi">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.locations.destroy', $location->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus lokasi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-action btn-delete" 
                                                            title="Hapus Lokasi">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="d-lg-none">
                        <div class="mobile-cards">
                            @foreach ($locations as $index => $location)
                                <div class="location-card animate__animated animate__fadeIn">
                                    <div class="card-header-mobile">
                                        <div class="card-title-mobile">
                                            <div class="location-badge-mobile"></div>
                                            <h4>{{ $location->name }}</h4>
                                        </div>
                                        <span class="badge badge-radius-mobile">
                                            <i class="fas fa-bullseye mr-1"></i>{{ $location->radius }}m
                                        </span>
                                    </div>
                                    
                                    <div class="card-body-mobile">
                                        <div class="info-row">
                                            <div class="info-label">
                                                <i class="fas fa-map-pin"></i>
                                                Koordinat
                                            </div>
                                            <div class="info-value coordinate-text-mobile">
                                                {{ $location->latitude }}, {{ $location->longitude }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer-mobile">
                                        <a href="{{ route('admin.locations.edit', $location->id) }}" 
                                           class="btn btn-action-mobile btn-edit-mobile">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.locations.destroy', $location->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus lokasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-action-mobile btn-delete-mobile">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if($locations->hasPages())
                        <div class="pagination-wrapper">
                            {{ $locations->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection