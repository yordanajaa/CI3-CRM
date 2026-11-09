<page backtop="12mm" backbottom="14mm" backleft="10mm" backright="10mm" orientation="landscape">
   <page_footer>
      <table style="width: 100%; font-size: 8pt; color: #64748b; border-top: 1px solid #cbd5e1; padding-top: 4px;">
         <tr>
            <td style="width: 50%; text-align: left;">
               Dicetak oleh: <strong><?= _ent(get_user_data('username') ?: 'Admin'); ?></strong> pada <?= date('d/m/Y H:i:s'); ?> | Dokumen Resmi Perusahaan
            </td>
            <td style="width: 50%; text-align: right;">
               Halaman [[page_cu]] dari [[page_nb]]
            </td>
         </tr>
      </table>
   </page_footer>

   <!-- Kop Surat / Header Laporan -->
   <table style="width: 100%; border-bottom: 2px solid #1e3a8a; padding-bottom: 8px; margin-bottom: 10px;">
      <tr>
         <td style="width: 60%; vertical-align: middle;">
            <span style="font-size: 16pt; font-weight: bold; color: #1e3a8a; letter-spacing: 0.5px;"><?= strtoupper(get_option('site_name', 'IDMETAFORA')); ?></span><br>
            <span style="font-size: 9pt; color: #475569;"><?= _ent(get_option('site_description', 'Sistem Informasi Manajemen & Akuntansi Perusahaan Terpadu')); ?></span>
         </td>
         <td style="width: 40%; text-align: right; vertical-align: middle;">
            <span style="font-size: 13pt; font-weight: bold; color: #0f172a;">LAPORAN BUKU BESAR</span><br>
            <span style="font-size: 8.5pt; color: #64748b; font-weight: bold;">(GENERAL LEDGER &amp; AUDIT TRAIL)</span><br>
            <span style="font-size: 8.5pt; color: #334155;">Periode: <strong><?= _ent($periode_label); ?></strong></span>
         </td>
      </tr>
   </table>

   <!-- Ringkasan KPI Finansial -->
   <table style="width: 100%; margin-bottom: 12px; font-size: 8.5pt;">
      <tr>
         <td style="width: 25%; padding: 6px 10px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 4px;">
            <span style="color: #166534; font-size: 7.5pt; font-weight: bold; text-transform: uppercase;">Total Masuk (Debit)</span><br>
            <strong style="font-size: 11pt; color: #15803d;">Rp <?= number_format($summary['total_debit'], 0, ',', '.'); ?></strong>
         </td>
         <td style="width: 4%;"></td>
         <td style="width: 25%; padding: 6px 10px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 4px;">
            <span style="color: #991b1b; font-size: 7.5pt; font-weight: bold; text-transform: uppercase;">Total Keluar (Kredit)</span><br>
            <strong style="font-size: 11pt; color: #b91c1c;">Rp <?= number_format($summary['total_kredit'], 0, ',', '.'); ?></strong>
         </td>
         <td style="width: 4%;"></td>
         <td style="width: 25%; padding: 6px 10px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 4px;">
            <span style="color: #1e40af; font-size: 7.5pt; font-weight: bold; text-transform: uppercase;">Saldo Bersih (Net Balance)</span><br>
            <strong style="font-size: 11pt; color: <?= $summary['net_balance'] >= 0 ? '#1d4ed8' : '#b91c1c'; ?>;">Rp <?= number_format($summary['net_balance'], 0, ',', '.'); ?></strong>
         </td>
         <td style="width: 4%;"></td>
         <td style="width: 18%; padding: 6px 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px; text-align: center;">
            <span style="color: #475569; font-size: 7.5pt; font-weight: bold; text-transform: uppercase;">Catatan Transaksi</span><br>
            <strong style="font-size: 11pt; color: #0f172a;"><?= number_format($summary['total_transaksi'], 0, ',', '.'); ?></strong> <small style="font-size: 7.5pt; color: #64748b;">Item</small>
         </td>
      </tr>
   </table>

   <!-- Tabel Transaksi Buku Besar -->
   <table style="width: 100%; border-collapse: collapse; font-size: 8pt; table-layout: fixed;" cellpadding="0" cellspacing="0">
      <thead>
         <tr style="background-color: #1e3a8a; color: #ffffff;">
            <th style="width: 4%; border: 1px solid #1e3a8a; padding: 6px 4px; text-align: center; font-weight: bold;">NO</th>
            <th style="width: 9%; border: 1px solid #1e3a8a; padding: 6px 4px; text-align: center; font-weight: bold;">TANGGAL</th>
            <th style="width: 14%; border: 1px solid #1e3a8a; padding: 6px 4px; text-align: center; font-weight: bold;">NO. REFERENSI</th>
            <th style="width: 13%; border: 1px solid #1e3a8a; padding: 6px 4px; text-align: center; font-weight: bold;">KATEGORI MODUL</th>
            <th style="width: 17%; border: 1px solid #1e3a8a; padding: 6px 6px; text-align: left; font-weight: bold;">ENTITAS / PIHAK TERKAIT</th>
            <th style="width: 25%; border: 1px solid #1e3a8a; padding: 6px 6px; text-align: left; font-weight: bold;">DESKRIPSI / URAIAN TRANSAKSI</th>
            <th style="width: 9%; border: 1px solid #1e3a8a; padding: 6px 4px; text-align: right; font-weight: bold;">DEBIT (RP)</th>
            <th style="width: 9%; border: 1px solid #1e3a8a; padding: 6px 4px; text-align: right; font-weight: bold;">KREDIT (RP)</th>
         </tr>
      </thead>
      <tbody>
         <?php if (!empty($entries)): ?>
            <?php 
               $no = 1;
               $tot_debit = 0;
               $tot_kredit = 0;
               foreach ($entries as $row): 
                  $tot_debit += (float)$row->debit;
                  $tot_kredit += (float)$row->kredit;
                  $bg = ($no % 2 == 0) ? '#f8fafc' : '#ffffff';

                  // Format deskripsi agar rapi tanpa raw slug
                  $deskripsi = $row->deskripsi;
                  $deskripsi = str_replace('bank_transfer', 'Transfer Bank', $deskripsi);
                  $deskripsi = str_replace('cash', 'Tunai', $deskripsi);
            ?>
               <tr style="background-color: <?= $bg; ?>;">
                  <td style="border: 1px solid #cbd5e1; padding: 5px 4px; text-align: center;"><?= $no++; ?></td>
                  <td style="border: 1px solid #cbd5e1; padding: 5px 4px; text-align: center;"><?= date('d/m/Y', strtotime($row->tanggal)); ?></td>
                  <td style="border: 1px solid #cbd5e1; padding: 5px 4px; text-align: center; font-weight: bold; color: #0f172a;"><?= _ent($row->nomor_ref); ?></td>
                  <td style="border: 1px solid #cbd5e1; padding: 5px 4px; text-align: center;"><?= _ent($row->modul_label); ?></td>
                  <td style="border: 1px solid #cbd5e1; padding: 5px 6px; text-align: left;"><?= _ent($row->entitas); ?></td>
                  <td style="border: 1px solid #cbd5e1; padding: 5px 6px; text-align: left; color: #334155;"><?= _ent($deskripsi); ?></td>
                  <td style="border: 1px solid #cbd5e1; padding: 5px 4px; text-align: right; color: <?= $row->debit > 0 ? '#15803d' : '#64748b'; ?>; font-weight: <?= $row->debit > 0 ? 'bold' : 'normal'; ?>;">
                     <?= $row->debit > 0 ? number_format($row->debit, 0, ',', '.') : '-'; ?>
                  </td>
                  <td style="border: 1px solid #cbd5e1; padding: 5px 4px; text-align: right; color: <?= $row->kredit > 0 ? '#b91c1c' : '#64748b'; ?>; font-weight: <?= $row->kredit > 0 ? 'bold' : 'normal'; ?>;">
                     <?= $row->kredit > 0 ? number_format($row->kredit, 0, ',', '.') : '-'; ?>
                  </td>
               </tr>
            <?php endforeach; ?>
         <?php else: ?>
            <tr>
               <td colspan="8" style="border: 1px solid #cbd5e1; padding: 25px; text-align: center; color: #94a8ba;">
                  Tidak ada catatan transaksi buku besar pada periode / filter yang dipilih.
               </td>
            </tr>
         <?php endif; ?>
      </tbody>
      <tfoot>
         <tr style="background-color: #f1f5f9; font-weight: bold;">
            <td colspan="6" style="border: 1px solid #94a8ba; border-bottom: 2px solid #0f172a; padding: 6px 8px; text-align: right; font-size: 8.5pt;">
               TOTAL KESELURUHAN (DEBIT &amp; KREDIT):
            </td>
            <td style="border: 1px solid #94a8ba; border-bottom: 2px solid #0f172a; padding: 6px 4px; text-align: right; color: #15803d; font-size: 8.5pt;">
               Rp <?= number_format($summary['total_debit'], 0, ',', '.'); ?>
            </td>
            <td style="border: 1px solid #94a8ba; border-bottom: 2px solid #0f172a; padding: 6px 4px; text-align: right; color: #b91c1c; font-size: 8.5pt;">
               Rp <?= number_format($summary['total_kredit'], 0, ',', '.'); ?>
            </td>
         </tr>
      </tfoot>
   </table>

   <br><br>

   <!-- Bagian Pengesahan / Tanda Tangan -->
   <table style="width: 100%; text-align: center; font-size: 8.5pt;" cellpadding="0" cellspacing="0">
      <tr>
         <td style="width: 30%;">
            Disiapkan Oleh,<br>
            <strong>Staf Akuntansi &amp; Keuangan</strong><br><br><br><br><br>
            ( ________________________ )
         </td>
         <td style="width: 40%;"></td>
         <td style="width: 30%;">
            Disetujui Oleh,<br>
            <strong>Manajer Keuangan / Direktur</strong><br><br><br><br><br>
            ( ________________________ )
         </td>
      </tr>
   </table>
</page>
