<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
   <table style="width: 100%; border-bottom: 2px solid #222; padding-bottom: 10px;">
      <tr>
         <td style="width: 55%;">
            <strong style="font-size: 16px; color: #111;">IDMETAFORA / CI3 METAFORA</strong><br>
            <span style="font-size: 11px; color: #555;">Sistem Penjualan, Pembelian &amp; Inventory</span><br>
            <span style="font-size: 10px; color: #666;">Telp: (0274) 123456 | Email: info@idmetafora.com</span>
         </td>
         <td style="width: 45%; text-align: right; vertical-align: top;">
            <strong style="font-size: 16px; color: #0056b3;">PURCHASE ORDER</strong><br>
            <table style="width: 100%; border-collapse: collapse; font-size: 11px; margin-top: 3px;">
               <tr>
                  <td style="width: 50%; text-align: right; padding: 1px 0; color: #1e293b;"><strong>No PO</strong></td>
                  <td style="width: 5%; text-align: center; padding: 1px 0; color: #1e293b;">:</td>
                  <td style="width: 45%; text-align: left; padding: 1px 0; color: #1e293b;"><strong><?= _ent($po->nomor_po ?? '-'); ?></strong></td>
               </tr>
               <tr>
                  <td style="text-align: right; padding: 1px 0; color: #475569;"><strong>Tanggal</strong></td>
                  <td style="text-align: center; padding: 1px 0; color: #475569;">:</td>
                  <td style="text-align: left; padding: 1px 0; color: #475569;"><?= isset($po->tanggal_po) ? date('d/m/Y', strtotime($po->tanggal_po)) : '-'; ?></td>
               </tr>
            </table>
         </td>
      </tr>
   </table>

   <br>

   <?php 
      $alamat_full = trim(($po->alamat_supplier ?? $po->alamat ?? '') . (!empty($po->kota) ? ', ' . $po->kota : ''));
      $alamat_disp = !empty($alamat_full) ? $alamat_full : '-';
      $telp_disp   = !empty($po->telp_supplier) ? $po->telp_supplier : (!empty($po->no_telp) ? $po->no_telp : (!empty($po->telepon) ? $po->telepon : '-'));
      $tgl_est     = (!empty($po->tanggal_estimasi) && $po->tanggal_estimasi != '0000-00-00') ? date('d/m/Y', strtotime($po->tanggal_estimasi)) : '-';
   ?>
   <table style="width: 100%; font-size: 11px; border-collapse: collapse; table-layout: fixed;">
      <tr>
         <td style="width: 13%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Supplier</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 12px 3px 0; vertical-align: top; word-wrap: break-word;"><strong><?= _ent($po->nama_supplier ?? '-'); ?></strong></td>
         <td style="width: 15%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Est. Terima</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 0; vertical-align: top;"><?= _ent($tgl_est); ?></td>
      </tr>
      <tr>
         <td style="width: 13%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Alamat</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 12px 3px 0; vertical-align: top; line-height: 1.35; word-wrap: break-word;"><?= nl2br(_ent($alamat_disp)); ?></td>
         <td style="width: 15%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Mata Uang</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 0; vertical-align: top;"><?= _ent($po->mata_uang ?? 'IDR'); ?> (Kurs: <?= number_format((float)($po->kurs ?? 1), 0, ',', '.'); ?>)</td>
      </tr>
      <tr>
         <td style="width: 13%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>No Telp</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 12px 3px 0; vertical-align: top; word-wrap: break-word;"><?= _ent($telp_disp); ?></td>
         <td style="width: 15%; padding: 3px 0; color: #475569; vertical-align: top;"><strong>Petugas</strong></td>
         <td style="width: 2%; padding: 3px 0; text-align: center; color: #475569; vertical-align: top;">:</td>
         <td style="width: 34%; padding: 3px 0; vertical-align: top;"><?= _ent($po->created_by ?? '-'); ?></td>
      </tr>
   </table>

   <br>

   <table style="width: 100%; border: 1px solid #ccc; border-collapse: collapse; font-size: 10px; table-layout: fixed;">
      <thead>
         <tr style="background: #f0f0f0;">
            <th style="width: 5%; border: 1px solid #ccc; padding: 5px; text-align: center;">No</th>
            <th style="width: 37%; border: 1px solid #ccc; padding: 5px; text-align: left;">Produk</th>
            <th style="width: 12%; border: 1px solid #ccc; padding: 5px; text-align: right;">Qty Pesan</th>
            <th style="width: 10%; border: 1px solid #ccc; padding: 5px; text-align: center;">Satuan</th>
            <th style="width: 18%; border: 1px solid #ccc; padding: 5px; text-align: right;">Harga Satuan</th>
            <th style="width: 18%; border: 1px solid #ccc; padding: 5px; text-align: right;">Subtotal</th>
         </tr>
      </thead>
      <?php 
         $curr = $po->mata_uang ?? 'IDR';
         $rate = (float)($po->kurs ?? 1);
         $fmt_curr = function($val) use ($curr) {
            if ($curr === 'IDR') {
               return 'Rp ' . number_format((float)$val, 0, ',', '.');
            } else {
               return $curr . ' ' . number_format((float)$val, 2, '.', ',');
            }
         };
      ?>
      <tbody>
         <?php if (!empty($items)): ?>
            <?php $no = 1; foreach ($items as $it): ?>
               <tr>
                  <td style="border: 1px solid #ccc; padding: 5px; text-align: center;"><?= $no++; ?></td>
                  <td style="border: 1px solid #ccc; padding: 5px;"><?= _ent($it->nama_produk ?? '-'); ?></td>
                  <td style="border: 1px solid #ccc; padding: 5px; text-align: right;"><?= number_format((float)$it->qty_pesan ?? 0, 0, ',', '.'); ?></td>
                  <td style="border: 1px solid #ccc; padding: 5px; text-align: center;"><?= _ent($it->satuan ?? '-'); ?></td>
                  <td style="border: 1px solid #ccc; padding: 5px; text-align: right;"><?= $fmt_curr($it->harga_satuan); ?></td>
                  <td style="border: 1px solid #ccc; padding: 5px; text-align: right;"><?= $fmt_curr($it->subtotal); ?></td>
               </tr>
            <?php endforeach; ?>
         <?php else: ?>
            <tr><td colspan="6" style="border: 1px solid #ccc; padding: 5px; text-align: center;">Tidak ada item.</td></tr>
         <?php endif; ?>
      </tbody>
      <tfoot>
         <tr style="background: #eef7ff;">
            <td colspan="5" style="border: 1px solid #ccc; padding: 5px; text-align: right;"><strong>TOTAL (<?= $curr; ?>):</strong></td>
            <td style="border: 1px solid #ccc; padding: 5px; text-align: right;"><strong style="color:#0056b3;"><?= $fmt_curr($po->total); ?></strong></td>
         </tr>
         <?php if($curr !== 'IDR'): ?>
         <tr style="background: #e0f2fe;">
            <td colspan="5" style="border: 1px solid #ccc; padding: 5px; text-align: right;"><strong>Estimasi Harga IDR:</strong></td>
            <td style="border: 1px solid #ccc; padding: 5px; text-align: right;"><strong style="color:#0369a1;">Rp <?= number_format($po->total * $rate, 0, ',', '.'); ?></strong></td>
         </tr>
         <?php endif; ?>
      </tfoot>
   </table>

   <br><br><br>

   <table style="width: 100%; text-align: center; font-size: 11px;">
      <tr>
         <td style="width: 33%;">
            Dibuat Oleh,<br><br><br><br>
            ( ____________________ )
         </td>
         <td style="width: 33%;">
            Disetujui Oleh,<br><br><br><br>
            ( ____________________ )
         </td>
         <td style="width: 34%;">
            Supplier,<br><br><br><br>
            ( ____________________ )
         </td>
      </tr>
   </table>
</page>