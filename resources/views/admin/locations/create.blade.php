{{-- CREATE FORM --}}
@extends('layouts.app')

@section('title', 'Tambah Lokasi Absensi')

@section('content')
<div class="content-wrapper">
    <div class="page-container-form">
        <!-- Breadcrumb -->
        <nav class="breadcrumb-nav">
            <a href="{{ route('admin.locations.index') }}" class="breadcrumb-link">
                <i class="fas fa-map-marker-alt"></i> Lokasi Absensi
            </a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Tambah Lokasi</span>
        </nav>

        <!-- Form Card -->
        <div class="card card-form">
            <!-- Card Header -->
            <div class="card-header-form">
                <div class="header-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div class="header-text">
                    <h1 class="form-title">Tambah Lokasi Absensi</h1>
                    <p class="form-subtitle">Masukkan detail lokasi untuk absensi</p>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body-form">
                @if ($errors->any())
                    <div class="alert alert-error animate__animated animate__fadeIn">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="alert-content">
                            <strong>Terdapat kesalahan:</strong>
                            <ul class="error-list">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.locations.store') }}" method="POST" class="form-modern">
                    @csrf
                    
                    <!-- Nama Lokasi -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-map-marker-alt label-icon"></i>
                            Nama Lokasi
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="form-control" 
                            value="{{ old('name') }}" 
                            placeholder="Contoh: Kantor Pusat Jakarta"
                            required
                        >
                        <small class="form-hint">Masukkan nama lokasi yang mudah dikenali</small>
                    </div>

                    <!-- Link Google Maps -->
                    <div class="form-group">
                        <label for="maps_link" class="form-label">
                            <i class="fas fa-link label-icon"></i>
                            Link Google Maps
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="url" 
                            name="maps_link" 
                            id="maps_link" 
                            class="form-control" 
                            value="{{ old('maps_link') }}" 
                            placeholder="https://www.google.com/maps/@-6.8695717,109.1251033,15z"
                            required
                        >
                        <small class="form-hint">
                            <i class="fas fa-info-circle mr-1"></i>
                            Salin link dari Google Maps (klik kanan > Copy link to this location)
                        </small>
                    </div>

                    <!-- Radius -->
                    <div class="form-group">
                        <label for="radius" class="form-label">
                            <i class="fas fa-bullseye label-icon"></i>
                            Radius
                            <span class="required">*</span>
                        </label>
                        <div class="input-with-suffix">
                            <input 
                                type="number" 
                                name="radius" 
                                id="radius" 
                                class="form-control" 
                                value="{{ old('radius', 200) }}" 
                                min="50" 
                                max="1000" 
                                required
                            >
                            <span class="input-suffix">meter</span>
                        </div>
                        <small class="form-hint">Jarak maksimal dari lokasi (50 - 1000 meter)</small>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Lokasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
