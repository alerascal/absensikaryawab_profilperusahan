<?php

namespace App\Console\Commands;

use App\Models\Pengajuan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupOldPengajuan extends Command
{
    protected $signature = 'pengajuan:cleanup-old';
    protected $description = 'Hapus otomatis pengajuan yang dibuat lebih dari 1 bulan';

    public function handle()
    {
        $months = 1; // 1 bulan
        $cutoffDate = now()->subMonths($months);

        $oldPengajuans = Pengajuan::where('created_at', '<', $cutoffDate)->get();

        $deletedCount = 0;

        foreach ($oldPengajuans as $pengajuan) {
            // Hapus file dokumen
            if ($pengajuan->surat_dokter) {
                Storage::disk('public')->delete($pengajuan->surat_dokter);
            }
            if ($pengajuan->surat_izin) {
                Storage::disk('public')->delete($pengajuan->surat_izin);
            }

            $pengajuan->delete();
            $deletedCount++;
        }

        if ($deletedCount > 0) {
            $this->info("Berhasil menghapus {$deletedCount} pengajuan yang lebih dari {$months} bulan.");
        } else {
            $this->info('Tidak ada pengajuan lama yang perlu dihapus.');
        }
    }
}
